<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>These</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Thèses">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Thèses">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
?>

<?php
$page='these';
include("verification_droit.php");	// test si on a les droits sur la page si non deconnexion

include("sql/recup_theses.php");			
?>

<?php
	// affichage des thèses 
	affichage_theses($_SESSION['id_personne']);	
	echo "<div id='position_submit'><a href='formulaire_modifier_these.php?type_modif=ajout'>Ajouter une HDR, thèse d'état ...</a></div>";	
?>


<?php
	include "templates/footer.php";
?>
   
