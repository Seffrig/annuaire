<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Modification compte</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Modification des personnes">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modification des personnes">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

include ("sql/recup_personne.php"); 
?> 

	<h1> Modification des informations </h1>	
	<?php	
		include("formulaire_personne.php");
	?>

<?php
	include "templates/footer.php";
?>