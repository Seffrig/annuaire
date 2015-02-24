<?php
	include('test_session.php');

	// fonction entête
	include_once "commun/fonction.php";
	$changements = array();
	$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
									<script type="text/javascript" src="js/simpleautocomplete.js"></script>';
	$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
	$changements['__TITLE__'] = '<title>Modification cotisant</title>';
	$changements['__DESCRIPTION__'] = '<meta name="description" content="Modification des cotisant">';
	$changements['__KEYWORDS__'] = '<meta name="keywords" content="Modification des cotisant">';
	remplace('templates/header.php',$changements);

	//connection à la base
	include("commun/connexion_db.php");


	$val = 0; 
	$annee = 0;
	$idP = 0;

	if(isset($_GET['valeur'] ))
		$val = $_GET['valeur'];
	if(isset($_GET['id_personne'] ))
		$idP = $_GET['id_personne'];
	if(isset($_GET['annee'] ))
		$annee = $_GET['annee'];

	echo "UPDATE cotisations SET valeur = " . $val. "  WHERE id_personne = ". $idP ." AND annee = ". $annee .";";
	$query = pg_prepare($dbconn,"req" ,"UPDATE cotisations SET valeur = $1  WHERE id_personne = $2 AND annee = $3;");
	$result = pg_execute($dbconn, "req", array($val, $idP, $annee));



	header('Location: gestion_cotisations_total.php');  

?>