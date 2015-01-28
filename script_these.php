<?php session_start(); ?>

<?php
//connection à la base
include("commun/connexion_db.php");

	$today = date("j-n-Y à H:i:s");   
	$now = time();	
	
	$id_personne = $_SESSION['id_personne'];

	// si on a posté quelque chose, on met les infos dans des variables
	// utiliser une fonction qui supprime la double apostrophe qui apparait a l affichage
	if (isset($_POST["titre_ouvrage"]))
		$titre_ouvrage = pg_escape_string($_POST["titre_ouvrage"]); 
	else 
		$titre_ouvrage = "";

	if (isset($_POST["etablissement"]))
		$etablissement = pg_escape_string($_POST["etablissement"]); 
	else 
		$etablissement = "";
	
	if (isset($_POST["directeur"]))
		$directeur = pg_escape_string($_POST["directeur"]); 
	else 
		$directeur = "";
	
	if (isset($_POST["nb_pages"]))
		$nb_pages = pg_escape_string($_POST["nb_pages"]); 
	else 
		$nb_pages = "";
	
	if (isset($_POST["date_publi"]))
		$date_publi = pg_escape_string($_POST["date_publi"]); 
	else 
		$date_publi = "";
	
	if (isset($_POST["date_conf"]))
		$date_conf = pg_escape_string($_POST["date_conf"]); 
	else 
		$date_conf = "";
	
	if (isset($_POST["url"]))
		$url = pg_escape_string($_POST["url"]); 
	else 
		$url = "";
	
	if (isset($_POST["id_pays_conf"]))
		$id_pays_conf = pg_escape_string($_POST["id_pays_conf"]); 
	else 
		$id_pays_conf = "";
	
	if (isset($_POST["id_langue"]))
		$id_langue = pg_escape_string($_POST["id_langue"]); 
	else 
		$id_langue = "";
	
	if (isset($_POST["id_type_these"]))
		$id_type_these = pg_escape_string($_POST["id_type_these"]); 
	else 
		$id_type_these = "";
	
	if (isset($_POST["observation"]))
		$observation = pg_escape_string($_POST["observation"]); 
	else 
		$observation = "";

	if (isset($_GET["type_modif"])) 
		$type_mod = $_GET["type_modif"];
	else
		$type_mod ="";
	if (isset($_GET["id_publi"])) 
		$idP = $_GET["id_publi"];
	else
		$idP ="";

	// cas de suppression d'une bibliographie
	if ($type_mod == 'supp')
	
	{	$id_publi= $idP;
		pg_query ($dbconn, "UPDATE publication SET visible='false' WHERE id=".$id_publi."");
		$type_mod = $type_mod . "_these_publi=" .$id_publi;
	}

	// cas d'ajout d'une publication
	if ($type_mod == 'ajout')
	{	
		$result = pg_query ($dbconn, "INSERT INTO publication (id_personne, id_type, titre_ouvrage, etablissement, directeur, nb_pages, date_publi, date_conf, url, id_pays_conf, id_langue, observation, id_type_these, visible) 
									VALUES (".$id_personne.", 0,'".$titre_ouvrage."','".$etablissement."','".$directeur."','".$nb_pages."','".$date_publi."', 
									'".$date_conf."','".$url."',".$id_pays_conf.",".$id_langue.",'".$observation."',".$id_type_these.",'true') RETURNING id");
				
		$insert_row = pg_fetch_row($result);
		$id_publication = $insert_row[0];
		
		$type_mod = $type_mod . "_these_publi=" .$id_publication;
	
	}
	
	// cas de modifcation d'une publication
	if ($type_mod == 'modif')
	{	

		$id_publi=$_POST['id_publi'];
		pg_query ($dbconn, "UPDATE publication SET titre_ouvrage = '".$titre_ouvrage."', etablissement = '".$etablissement."', directeur = '".$directeur."', nb_pages = '".$nb_pages."',
											date_publi = '".$date_publi."',	date_conf = '".$date_conf."', url = '".$url."', id_pays_conf = '".$id_pays_conf."', id_langue = '".$id_langue."', id_type_these = '".$id_type_these."',
											observation = '".$observation."'
											WHERE id=". $id_publi );	
							
		$type_mod = $type_mod . "_these_publi=" .$id_publi;							
	}
	

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$type_mod."', 'publication', '". $today ."' ,  now()  , '". $id_personne ."' )");			

	echo "<script language='javascript' type='text/javascript'> window.location.replace('these.php');	</script>";
								
?>
