<?php 
include('test_session.php');
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Modification des pays</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Modifications pays">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modifications pays">';
remplace('templates/header.php',$changements);

include("commun/connexion_db.php");
// modification si id_rech existe
if (isset ($_GET['id_rech']) && $_GET['id_rech']!='')
{
	header('Location: formulaire_modifier_pays.php?type_modif=modif&id_rech='. $_GET['id_rech'] .'');   
}
include "templates/menu.php";


?> 

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#libelle_rech').simpleAutoComplete('ajax_query.php?from="pays"&champ="libelle"',{
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




<h1>Gestion des pays</h1>
	
	<br><br>
	<?php  
	$id_rech="";
	if(isset($_GET['libelle_rech'])){
		//trouve_a_modifier($table, $champ, $libelle_rech)
		$id_rech = trouve_a_modifier('pays','libelle',$_GET['libelle_rech']);
	}
	if ($id_rech  != '')
	{
		$_GET['id_rech'] = $id_rech;
	}

	?>					
	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_pays.php"  method='get'>
		<label for='libelle_rech'> Nom : </label> <input type="text" name="libelle_rech"  id="libelle_rech" size="20" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  />
		<a href="formulaire_modifier_pays.php?type_modif=ajout" ><input style="float: right;" type='button' value='Ajouter un pays'></a>
		<br />	
	</form>	
	<?php 

	
	echo'<br/>';
	affichage_colonne('id', 'libelle', 'pays', 'modif_pays.php','maj_pays.php',"libelle");
	?>	

<?php
	include "templates/footer.php";
?>  




	   
	   