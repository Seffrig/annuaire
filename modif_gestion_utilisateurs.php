<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Reinitilialisation des mots de passe</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="reinitier mot de passe">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="reinitier mot de passe">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

// modification si id_rech existe
if (isset ($_GET['id_rech']) && $_GET['id_rech'] != '')
{
	header('Location: formulaire_modifier_gestion_utilisateurs.php?type_modif=modif&id_rech='. $_GET['id_rech'] .'');   
}

//menu
include "templates/menu.php";

?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('#login').simpleAutoComplete('ajax_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'login',
	    },majlogin);
        });
	
	function majlogin( par )
	{
		$("#login").val( par[0] );
	}
</script>  

	<h1>Gestion des utilisateurs </h1>
	<br>

	
	<br><br>
	<?php  
	//trouve_a_modifier($table, $champ, $libelle_rech)
	$id_rech ='';
	
	if (isset($_GET['login']))
		$id_rech = trouve_a_modifier_LIKE('utilisateur','login',$_GET['login'], 'login');
	
	if ($id_rech != '')
		$_GET['id_rech'] = $id_rech;

	?>					
	<!--- FORMULAIRE DE RECHERCHE -->
	<form action="modif_gestion_utilisateurs.php"  method='get'>
		<label for='login'> Login  </label><input type="text" name="login"  id="login" size="10" />
		<input type="submit" id="bouton-submit"  value="Rechercher"  /> <a href="formulaire_modifier_gestion_utilisateurs.php?type_modif=ajout" ><input style="float: right;" type='button' value='Creer un nouvel utilisateur'></a>
		<br />	
	</form>	
	<br>
	<?php 

	

	//function affichage_colonne($id, $champ, $table, $page_modif, $page_sup)
	affichage_colonne('login', 'login', 'utilisateur','modif_gestion_utilisateurs.php','maj_gestion_utilisateurs.php', $dbconn);				    			
	?>	

<?php
	include "templates/footer.php";
?>