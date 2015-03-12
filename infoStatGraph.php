<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/fonction.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>
								<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    							';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="recherche">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
include "sql/recup_infoStatPubli.php";

$annee_actuel = date ('Y');


// vérifie les droits pour la page
$page="recherche";
include("verification_droit.php");	
include ("sql/recup_personne.php"); 

//on selectionne toute les dates de publication
$result= pg_query("SELECT DISTINCT date_publi
		FROM publication
		ORDER BY date_publi"); 


//On test si on à déjà selectionné des dates dans les liste déoulante
//Si c'est la cas on met ces valeurs selectionner dans les listes	
if(isset($_GET["dateDebut"]) && $_GET["dateDebut"] != ""){
	if(isset($_GET["dateFin"]) && $_GET["dateFin"] != ""){
		$listeOptionDeb ="<option selected>".$_GET["dateDebut"]."</option>";
		$listeOptionFin ="<option selected>".$_GET["dateFin"]."</option>";
	}
}
else{
	$listeOptionDeb ="";
	$listeOptionFin ="";
}

while ($row = pg_fetch_row($result))
{
	$elemListe = substr($row[0], 0, 4); //on ne sélectionne que les 4 premiers caractere
	//On vérifie que l'élement selectionné ne soit pas vide, soit numérique
	if($elemListe == "" || !is_numeric($elemListe) || strlen($elemListe) < 4 || $elemListe == "0000" ){
		$elemListe = "Non renseigné";
	}
	else{
		//liste debut : si l'élèment n'existe pas, on l'ajoute à la liste
		if(substr_count ($listeOptionDeb,$elemListe) >= 1){
			$listeOptionDeb = $listeOptionDeb;
		}
		else{
			$listeOptionDeb = $listeOptionDeb."<option>".$elemListe."</option>";	
		}
		//liste fin : si l'élèment n'existe pas, on l'ajoute à la liste
		if(substr_count ($listeOptionFin,$elemListe) >= 1){
			$listeOptionFin = $listeOptionFin;
		}
		else{
			if($elemListe == $annee_actuel)
				$listeOptionFin = $listeOptionFin."<option selected='selected' >".$elemListe."</option>";	
			else
				$listeOptionFin = $listeOptionFin."<option >".$elemListe."</option>";	
		}
	}


}

	


?>
<FORM action="infoStatGraph.php" method="GET">
	<br/><br/><br/>
	<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Choix de la période de publication</h2>	
			</div>
			<div class="panel-body">
Choisissez la période sur laquelle vous souhaitez voir les statistiques des publications : <br/>
Début :
<Select name="dateDebut" size="1">
<?php echo $listeOptionDeb ?>
</Select>
&nbsp&nbsp&nbsp&nbsp&nbsp
Fin : 

<Select name="dateFin" size="1">
<?php echo $listeOptionFin ?>
</Select>
&nbsp&nbsp&nbsp
<input type="submit" value=	"Valider"/>
</FORM>
</div></div>
<?php

//On vérifie qu'on à une date de fin et de début 
//On verifie que la date de fin > que la date de début
if(isset($_GET["dateDebut"]) && $_GET["dateDebut"] != ""){
	if(isset($_GET["dateFin"]) && $_GET["dateFin"] != ""){
		if($_GET["dateDebut"] <= $_GET["dateFin"]){
			//on récupere les comptes de publications par type pour une période donné
			statPubli("",$_GET["dateDebut"],$_GET["dateFin"]);
		}
		else{
			echo "Entrez une date de début inférieur à la date de fin ";
		}
		
	}
}
else{
	//on récupere les comptes de publications par type depuis le début
	statPubli("global");
}


?>
<br/><br/>



<script type="text/javascript">
	//sert a stocker chaque compte de publication par type(récupéré précedement) dans des variables javascript
	var c0 =parseInt(document.getElementById("c0").value);
 	var c1 =parseInt(document.getElementById("c1").value); 
 	var c3 =parseInt(document.getElementById("c3").value);
 	var c4 =parseInt(document.getElementById("c4").value);
 	var c5 =parseInt(document.getElementById("c5").value);
 	var c6 =parseInt(document.getElementById("c6").value);
 	var c7 =parseInt(document.getElementById("c7").value);
 	var c8 =parseInt(document.getElementById("c8").value);
 	var c9 =parseInt(document.getElementById("c9").value);
 	

 	google.load('visualization', '1.0', {'packages':['corechart']});

 	google.setOnLoadCallback(drawChart);

 	//dessine le graphique
 	drawChart();
</script>

<div id="chart_div"></div>
<br/><br/><br/><br/>

<?php

    include ("templates/footer.php");
    ?>
