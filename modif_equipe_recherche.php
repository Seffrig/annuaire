<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Modification de l équipe de recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Modifications équipe de recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modifications équipe de recherche">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#libelle_rech').simpleAutoComplete('ajax_query.php?from="recherche"&champ="num_equipe"',{
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

	<h1> Gestion des équipes de recherche	 </h1>
	<a href="formulaire_modifier_equipe_recherche.php?type_modif=ajout" >Ajouter une équipe de recherche</a>
	<br><br>
	<?php  
	//trouve_a_modifier($table, $champ, $libelle_rech)
	if(!isset($_GET['libelle_rech'])){$_GET['libelle_rech'] ="";}
	$id_rech = trouve_a_modifier('recherche','num_equipe',$_GET['libelle_rech']);
	if ($id_rech != '')
	{
		$_GET['id_rech'] = $id_rech;
	}

	?>				

	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_equipe_recherche.php"  method='get'>
		<label for='libelle_rech'> Acronyme de l'équipe  </label> <input type="text" name="libelle_rech"  id="libelle_rech" size="20" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  /><br />	
	</form>	
	<?php 

	// modification si id_rech existe
	if (isset ($_GET['id_rech']) && $_GET['id_rech'] != '')
	{
		 header('Location: formulaire_modifier_equipe_recherche.php?type_modif=modif&id_rech='. $_GET['id_rech'] .'');   
	}
	echo "</br>	";
	//function affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
	affichage_colonne('num_equipe', 'accronyme', 'recherche','modif_equipe_recherche.php','maj_equipe_recherche.php',"champ","id");				    			
	?>	

<?php
	include "templates/footer.php";
?>