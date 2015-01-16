<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="fonction.js"></script><script type="text/javascript" src="autocomplete-3-2.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/design.css" />';
$changements['__TITLE__'] = '<title>Modification pays</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="osef">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="osef">';
remplace('templates/header.php',$changements);
include "templates/bandeau.php";
include("connexionDB.php");
?> 
<div id="global">		
	<h1> 	Modification pays	 </h1>
	<a href="ajout_pays.php" >Ajouter un pays</a>	<br><br>	
	<?php  
	$trouve= trouve_a_modifier('pays','libelle',$_GET['libelle_rech']);
	?>					
	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_pays.php"  method='get'>
		<label for='libelle_rech'> Nom  </label> <input type="text" name="libelle_rech"  id="libelle_rech" size="20" onkeydown ="autocompletion('libelle','pays','libelle')" autocomplete="off" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  /><br />	
	</form>	
	<?php 
	modifie_un_champ ('pays', 'libelle', $_GET['pays'] ); 	
	formulaire_modif_un_champ ($trouve, 'libelle', 'pays', 'modif_pays.php','Pays ');
	affichage_colonne('libelle', 'pays','modif_pays.php', 'pays');				    			
	?>	
</div>	
<?php
include "templates/footer.php";
?>
	   
	   