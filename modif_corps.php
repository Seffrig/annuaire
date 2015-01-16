<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
								<script type="text/javascript" src="js/fonction_annuaire.js"></script>';
$changements['__CSS__'] =  '<link rel="stylesheet" type="text/css" href="css/design.css" />
							<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
							<link rel="stylesheet" type="text/css" href="css/div_cache.css" />';
$changements['__TITLE__'] = '<title>Modification corps</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Modifications du corps">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modifications du corps">';
remplace('templates/header.php',$changements);

include "templates/menu.php";
include("Commun/connexionDB.php");

?> 
 <script type="text/javascript">
	$(document).ready(function()
	{
		$('#libelle_rech').simpleAutoComplete('ajax_query.php?from="corps"&champ="libelle"',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		identifier: 'generique',
	    },majrecherche);
        });
	
	function majrecherche( par )
	{
		$("#libelle_rech").val( par[1] );
	}
</script>  

<div id="global">		
	<h1> 	Modification corps	 </h1>
	<a href="ajout_corps.php" >Ajouter un corps</a>
	<br><br>
	<?php  
	//trouve_a_modifier($table, $champ, $id_rech) 
	$id_corps= trouve_a_modifier('corps','libelle',$_GET['libelle_rech']);
	
	?>					
	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_corps.php"  method='get'>
		<label for='libelle_rech'> Nom  </label> <input type="text" name="libelle_rech"  id="libelle_rech" size="20" autocomplete="off" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  /><br />	
	</form>	
	<?php 
	//function modifie_un_champ ($table, $champ, $id_rech)
	modifie_un_champ ('corps', 'libelle', $_GET['corps'] ); 	
	
	//function formulaire_modif_un_champ ($trouve, $champ, $table, $page, $description)
	formulaire_modif_un_champ ($id_corps, 'libelle', 'corps', 'modif_corps.php','Corps ');
	
	//function affichage_colonne($champ, $table, $page_modif, $page_sup) 
	affichage_colonne('libelle', 'corps','modif_corps.php','corps');				    			
	?>	
</div>	
<?php
include "templates/footer.php";
?>
	   
	   
	   