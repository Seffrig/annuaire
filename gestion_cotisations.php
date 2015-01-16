<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Gestion cotisation</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="gestion des cotisations">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="gestion cotisations">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

// vérifie les droits pour la page
$page="gestion_cotisation";
include("verification_droit.php");	
?>


 <script type="text/javascript">
	$(document).ready(function()
	{
		$('#nom').simpleAutoComplete('ajax_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'nom'
		},majnom);
		});
	
	function majnom( par )
	{
		$("#nom").val( par[1] );
	}

	
</script>   
	
	<h1> Rechercher un adhérent </h1>	
	<br><br>	
	<form action="gestion_cotisation_resultat.php"  name="formulaire_cotisation" id="formulaire_cotisation" method='post'>
		<label style='width: 50px;'for='nom'> Nom  </label> <input type="text" name="nom"  id="nom" size="50" maxlength="100" />
		<INPUT type="submit"  id="bouton-submit" value="Rechercher" >
		
	</form>
	<br>
	<br>	
	<br>
	<a href="gestion_cotisations_total.php" >Voir tous les adhérents</a> <br/>
	<br>			
<!--<a href="testpdf.php?type=courrier" >Publipostage du courrier</a> <br/>
<a href="testpdf.php?type=revue" >Publipostage de la revue</a>-->

<?php
	include "templates/footer.php";
?>
