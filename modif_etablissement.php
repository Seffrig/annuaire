<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />
							<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification de l établissement</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Modifications établissement">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modifications établissement">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#libelle_rech').simpleAutoComplete('ajax_query.php?from="etablissement"&champ="nom"',{
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

		
	<h1>Gestion des établissements</h1>
	<a href="formulaire_modifier_etablissement.php?type_modif=ajout" >Ajouter un établissement</a>
	<br><br>
	<?php  
	$id_rech="";
	if(isset($_GET['libelle_rech'])){
	//trouve_a_modifier($table, $champ, $libelle_rech)
	$id_rech = trouve_a_modifier('etablissement','nom',$_GET['libelle_rech']);
	}
	if ($id_rech  != '')
	{
		$_GET['id_rech'] = $id_rech;
	}

	?>					
	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_etablissement.php"  method='get'>
		<label for='libelle_rech'> Nom  </label> <input type="text" name="libelle_rech"  id="libelle_rech" size="20" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  /><br />	
	</form>	
	<?php 

	// modification si id_rech existe
	if (isset ($_GET['id_rech']) && $_GET['id_rech']!='')
	{
		 header('Location: formulaire_modifier_etablissement.php?type_modif=modif&id_rech='. $_GET['id_rech'] .'');   
	}
	echo'<br/>';
	affichage_colonne_2_tables('id', 'nom', 'etablissement', 'id_ville', 'id', 'libelle', 'ville' ,'modif_etablissement.php','maj_etablissement.php');				    			
	?>	

<?php
	include "templates/footer.php";
?>  