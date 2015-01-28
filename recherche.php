<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="recherche">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";


// vérifie les droits pour la page
$page="recherche";
include("verification_droit.php");	

include ("sql/recup_personne.php"); 

?>


<form action="recherche_resultat.php" name="formulaire" id="formulaire" method="post">
	<div class="panelRecherche">
	<div class="panel panel-info">
		<div class="panel-heading">
    		<h2 class="panel-title">Rechercher</h2>
  		</div>
  		<div class="panel-body">
			<label for="nom">Nom :</label>  <input type="text" maxlength="30" name="nom" id="nom" /><br>
			<label for="nom">Prénom :</label> <input type="text" maxlength="30 "name="prenom" id="prenom" /><br>
			<?php
			//select_ordre ('Corps', 'id_corps','corps', 'libelle', $old_id_corps );	
			select_ordre ('Corps', 'id_corps','corps', 'libelle', "unused" );	
			?>
			&nbsp; 
			<?php  
			if($_SESSION['modif_corps']=='t') 
			{
				echo"<a href='modif_corps.php'><img src='images/button_edit.png' ></a>";
			}

		?>
		</div>
	</div>
	</div>
	<table>
		<th width="350px">
	<div class="panel panel-info">
		<div class="panel-heading">
    		<h2 class="panel-title">Contact professionnel</h2>
  		</div>
  		<div class="panel-body">
    		<label for="Code postal :">Nom :</label> <input type="text" maxlength="30 "name="code_postal_pro" id="code_postal_pro" /><br>
    		<label for="Ville">Ville :</label> <input type="text" maxlength="30 "name="localite_pro" id="localite_pro" /><br>
  			<?php 
			select_ordre ('Pays', 'id_pays_pro','pays', 'libelle','xxxx');	
			?>
			&nbsp;
			<?php  
			if($_SESSION['modif_pays']=='t') 
			{
				echo"<a href='modif_pays.php'><img src='images/button_edit.png' ></a>";
			}
			?>
		</div>	
  	</div>
  </th>
<th width="50px"></th >
  <th >
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Contact personnel  </h2>	
		</div>
		<div class="panel-body">
			<label for="nom">Code postal :</label> <input type="text" maxlength="30 "name="code_postal_perso" id="code_postal_perso" /><br>	
			<label for="nom">Ville :</label><input type="text" maxlength="30 "name="localite_perso"  id="localite_perso" /><br>
			<?php 
			select_ordre ('Pays', 'id_pays_perso','pays', 'libelle','xxxx');	
			?>
			&nbsp;
			<?php  
			if($_SESSION['modif_pays']=='t') 
			{
				echo"<a href='modif_pays.php'><img src='images/button_edit.png' ></a>";
			}
			?>
		</div>
	</div>	
</th>
	</table>
	
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Un etablissement</h2>			
		</div>
		<div class="panel-body">
			<?php 
			//$nom_etabl_principal!= '';
			include("formulaire_personne_etablissement.php"); 
			?>
		</div>	
	</div>
	<table >
		<th width = "330px">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Preférence d'envoi pour l'annuaire</h2>
			</div>
			<div class="panel-body">			
				<input type="radio" name="revue" value="pro" id="pro" /> Adresse professionnelle<br>
				<input type="radio" name="revue" value="perso" id="perso" /> Adresse personnelle <br>
			</div>
		</div>
	</th>
	<th width = "87px"></th>
	<th width = "330px">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Préférence d'envoi pour les courriers</h2>
			</div>
			<div class="panel-body">			
				<input type="radio" name="courrier" value="pro" id="pro" /> Adresse professionnelle<br>
				<input type="radio" name="courrier" value="perso" id="perso" /> Adresse personnelle <br>
		</div>
	</th>	
	</table>
</br>
	<div class='position_submit'>
		<button style="width:130px ; height : 50px;margin-left:41%" type="submit" class="btn btn-default">Valider</button>
	</div>			
</div>
</form>	
</br>
<?php
	include "templates/footer.php";
?>

