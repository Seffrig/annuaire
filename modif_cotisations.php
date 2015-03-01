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

	$annee_actuel = date ('Y');


	$val = ""; 
	$annee = 0;
	$idP = 0;
	$rev = "false";
	$typePai = 1;

	if(isset($_POST['valeur'] ))
		$val = $_POST['valeur'];
	if(isset($_POST['id_personne'] ))
		$idP = $_POST['id_personne'];
	if(isset($_POST['annee'] ))
		$annee = $_POST['annee'];
	if(isset($_POST['typePai'] ))
		$typePai = $_POST['typePai'];

		//echo $val, " " , $idP, " " , $annee;
	
	if ($val != "") 
	{
		$select = pg_prepare($dbconn,"reqSel" ,"SELECT * FROM cotisations WHERE id_personne = $1 AND annee = $2;");
		$res 	= pg_execute($dbconn, "reqSel", array($idP, $annee));
		$row 	= pg_fetch_row($res);

		if($row[0] == null)
		{
			if($annee == $annee_actuel) $rev = "true";

			$query = pg_prepare($dbconn,"reqIns" ,"INSERT INTO cotisations(id_personne,valeur,annee,revue,id_type_paiement,visible) 
													values ($2, $1, $3, $4,$5,true);");
			$result = pg_execute($dbconn, "reqIns", array($val, $idP, $annee, $rev, $typePai));
		}
		elseif ($val == 0) 
		{
			$query = pg_prepare($dbconn,"reqDel" ,"UPDATE cotisations SET visible = false WHERE id_personne = $1 AND annee = $2;");
			$result = pg_execute($dbconn, "reqDel", array($idP, $annee));
		}
		else
		{
			//echo "UPDATE cotisations SET valeur = " . $val. "  WHERE id_personne = ". $idP ." AND annee = ". $annee .";";
			$query = pg_prepare($dbconn,"reqUpd" ,"UPDATE cotisations SET valeur = $1, id_type_paiement = $4  WHERE id_personne = $2 AND annee = $3;");
			$result = pg_execute($dbconn, "reqUpd", array($val, $idP, $annee, $typePai));
		}

	}

	header('Location: gestion_cotisations_total.php');  

?>