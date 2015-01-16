<?php session_start(); ?>

<?php
//connection à la base
include("commun/connexion_db.php");

	$today = date("j-n-Y à H:i:s");   
	$now = time();	
	
	$id_personne = $_SESSION['id_personne'];

	// si on a posté quelque chose, on met les infos dans des variables
	// utiliser une fonction qui supprime la double apostrophe qui apparait a l affichage
	$titre_ouvrage = pg_escape_string($_POST[titre_ouvrage]); 
	$etablissement = pg_escape_string($_POST[etablissement]); 
	$directeur = pg_escape_string($_POST[directeur]); 
	$nb_pages = pg_escape_string($_POST[nb_pages]); 
	$date_publi = pg_escape_string($_POST[date_publi]); 	
	$date_conf = pg_escape_string($_POST[date_conf]); 
	$url = pg_escape_string($_POST[url]); 
	$id_pays_conf = pg_escape_string($_POST[id_pays_conf]); 
	$id_langue = pg_escape_string($_POST[id_langue]); 
	$id_type_these = pg_escape_string($_POST[id_type_these]); 
	$observation = pg_escape_string($_POST[observation]); 

	// cas de suppression d'une bibliographie
	if ($_GET['type_modif'] == 'supp')
	
	{	$id_publi=$_GET['id_publi'];
		pg_query ($dbconn, "UPDATE publication SET visible='false' WHERE id=".$id_publi."");
		$_GET['type_modif'] = $_GET['type_modif'] . "_these_publi=" .$id_publi;
	}

	// cas d'ajout d'une publication
	if ($_GET['type_modif'] == 'ajout')
	{	
		$result = pg_query ($dbconn, "INSERT INTO publication (id_personne, id_type, titre_ouvrage, etablissement, directeur, nb_pages, date_publi, date_conf, url, id_pays_conf, id_langue, observation, id_type_these, visible) 
									VALUES (".$id_personne.", 0,'".$titre_ouvrage."','".$etablissement."','".$directeur."','".$nb_pages."','".$date_publi."', 
									'".$date_conf."','".$url."',".$id_pays_conf.",".$id_langue.",'".$observation."',".$id_type_these.",'true') RETURNING id");
				
		$insert_row = pg_fetch_row($result);
		$id_publication = $insert_row[0];
		
		$_GET['type_modif'] = $_GET['type_modif'] . "_these_publi=" .$id_publication;
	
	}
	
	// cas de modifcation d'une publication
	if ($_GET['type_modif'] == 'modif')
	{	

		$id_publi=$_POST['id_publi'];
		pg_query ($dbconn, "UPDATE publication SET titre_ouvrage = '".$titre_ouvrage."', etablissement = '".$etablissement."', directeur = '".$directeur."', nb_pages = '".$nb_pages."',
											date_publi = '".$date_publi."',	date_conf = '".$date_conf."', url = '".$url."', id_pays_conf = '".$id_pays_conf."', id_langue = '".$id_langue."', id_type_these = '".$id_type_these."',
											observation = '".$observation."'
											WHERE id=". $id_publi );	
							
		$_GET['type_modif'] = $_GET['type_modif'] . "_these_publi=" .$id_publi;							
	}
	

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'publication', '". $today ."' ,  now()  , '". $id_personne ."' )");			

	echo "<script language='javascript' type='text/javascript'> window.location.replace('these.php');	</script>";
								
?>
