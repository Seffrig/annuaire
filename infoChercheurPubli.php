<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
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

// vérifie les droits pour la page
$page="recherche";
include("verification_droit.php");	
include ("sql/recup_personne.php"); 

if(isset($_GET["lettre"])){
	$lettre = $_GET["lettre"];
}


$gb= pg_query("SELECT count(pu.id) as nbpubli
		FROM publication pu;"); 

$nbtotal = pg_fetch_result($gb, 0, 0);


?>
<br/><br/><br/>

<div class="panel panel-info" >
	<div class="panel-heading">
		<h2 class="panel-title">Choix des chercheurs</h2>	
	</div>
	<div class="panel-body" >
		<?php
		$i=0;
		echo "<div style='margin-left:1%'>";
		for ($i=0; $i <=25 ; $i++) { 
			$alpha = chr(65+$i);
			echo "<a href='infoChercheurPubli.php?lettre=$alpha'>$alpha</a>&nbsp;&nbsp;&nbsp;&nbsp";
		}
		echo "<a href='infoChercheurPubli.php?lettre=global'>Global</a>&nbsp;&nbsp;&nbsp;&nbsp";
		echo "</div>";

		?>
	</div>
</div>



<!--<div style='overflow-y:scroll;width:1080px;height:500px;margin-left:10%'>-->
<table style='background-color:white;width:899px;font-size:10px' class="table table-bordered table-hover">
	<tr>
		<th>Chercheur</th>
		<th>Nombre de publication<br>(Total=<?php echo $nbtotal ?>)</th>
		<th>These </th>
		<th>Article dans une revue</th>
		<th>Com. avec actes</th>
		<th>Com. sans actes</th>
		<th>Conférence invitée</th>
		<th>Ouvrage</th>
		<th>Chapitre d'ouvrage</th>
		<th>Direction d'ouvrage</th>
		<th>Autre type de publication</th>
	</tr>
<?php
if(isset($_GET["lettre"])){
	tabStatPubli($lettre);
}

		include ("templates/footer.php");
?>
