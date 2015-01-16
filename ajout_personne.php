<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleAutoComplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />';
$changements['__TITLE__'] = '<title>Ajout personne</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout des personnes">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout des personnes">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
?>

	<h1> Inscription </h1>			
	<?php	
	//echo"<li><a href='ajout_perso_morale.php'>Personne morale - inscription ici</a></li><br>";  

	include("formulaire_personne.php");
	?>

<?php
	include "templates/footer.php";
?>

