<?php
// ouverture de  la session
session_start(); 

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Connexion</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="annuaire">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="annuaire">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");
?> 

<?php

	if (isset($_GET["mode"]) && $_GET["mode"]=="erreur")
	{
		echo '<div id="centrage_hor">';
		echo '	<div id="alerte">erreur de login ou/et de mot de passe</div>';
		echo '</div> ';
	
	}
?>	
		
		
		<div id="centrage_hor">
		<div id="alerte"><h1>SITE EN MAINTENANCE</h1></div>
		</div> 

	<?php echo $_session['erreur'];?>	

<?php
	include "templates/footer.php";
?>


