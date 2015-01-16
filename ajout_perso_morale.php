<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="fonction.js"></script><script type="text/javascript" src="autocomplete-3-2.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/design.css" />';
$changements['__TITLE__'] = '<title>Inscription personne morale</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="osef">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="osef">';
remplace('templates/header.php',$changements);
include "templates/bandeau.php";
include("connexionDB.php");
?> 
<div id="global">	
		<h1> Inscription personne morale</h1>			
		<?php	
			echo"<li><a href='ajout_personne.php'>Personne - inscription ici</a></li><br>";  
			include("fonctions_personne_morale.php");		
			affichage_form_morale(0);
		?>
</div>	
<?php
include "templates/footer.php";
?>
