<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="arrayPHP2JS.js"></script>  <script type="text/javascript" src="fonction.js"></script><script type="text/javascript" src="formulaire_lie.js"></script><script type="text/javascript" src="autocomplete-3-2.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/design.css" />';
$changements['__TITLE__'] = '<title>Modification personne morale</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="osef">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="osef">';
remplace('templates/header.php',$changements);
include "templates/bandeau.php";
include("connexionDB.php");
?> 
<div id="global">
	<h1> &nbsp; &nbsp;  Modification des informations </h1>	
	<?php	
		include("fonctions_personne_morale.php");		
		affichage_form_morale($_SESSION['id_personne']);
		
	?>
</div>	
<?php
include "templates/footer.php";
?>

