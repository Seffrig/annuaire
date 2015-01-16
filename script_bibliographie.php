<?php session_start(); ?>

<?php
//connection à la base
include("commun/connexion_db.php");

	$today = date("j-n-Y à H:i:s");   
	$now = time();	
	
	$id_personne = $_SESSION['id_personne'];

	$id_publi="";
	$id_type_publi=$_POST['id_type_publi'];


	// si on a posté quelque chose, on met les infos dans des variables
	$titre_communication = pg_escape_string($_POST[titre_communication]);  // utiliser une fonction qui supprime la double apostrophe qui apparait a l affichage
	$titre_journal = pg_escape_string($_POST[titre_journal]);
	$auteur_sec = pg_escape_string($_POST[auteur_sec]);
	$revue_volume = pg_escape_string($_POST[revue_volume]);
	$revue_fascicule = pg_escape_string($_POST[revue_fascicule]);
	$titre_ouvrage = pg_escape_string($_POST[titre_ouvrage]);
	$editeur = pg_escape_string($_POST[editeur]);
	$editeur_ville = pg_escape_string($_POST[editeur_ville]);
	$collection = pg_escape_string($_POST[collection]);
	$url = pg_escape_string($_POST[url]);
	$page_deb = pg_escape_string($_POST[page_deb]);
	$page_fin = pg_escape_string($_POST[page_fin]);
	$nb_pages = pg_escape_string($_POST[nb_pages]);
	$date_conf = pg_escape_string($_POST[date_conf]);
	$date_publi = pg_escape_string($_POST[date_publi]);
	$id_pays_conf = pg_escape_string($_POST[id_pays_conf]);if ($_POST[id_pays_conf] == '') {$id_pays_conf = 0;}
	$id_langue = pg_escape_string($_POST[id_langue]);if ($_POST[id_langue] == '') {$id_langue = 0;}	
	$audience = pg_escape_string($_POST[audience]);
	$etablissement = pg_escape_string($_POST[etablissement]);
	$directeur = pg_escape_string($_POST[directeur]);
	$id_type_these = pg_escape_string($_POST[id_type_these]);if ($_POST[id_type_these]=='') {$id_type_these = 0;}	
	$observation = pg_escape_string($_POST[observation]);

	
	$titre_communication = trim(str_replace("\t", "", $titre_communication));  
	$titre_journal = trim(str_replace("\t", "", $titre_journal));  
	$auteur_sec = trim(str_replace("\t", "", $auteur_sec));  
	$revue_volume = trim(str_replace("\t", "", $revue_volume));  
	$revue_fascicule = trim(str_replace("\t", "", $revue_fascicule));  
	$titre_ouvrage = trim(str_replace("\t", "", $titre_ouvrage));  
	$editeur = trim(str_replace("\t", "", $editeur));  
	$editeur_ville = trim(str_replace("\t", "", $editeur_ville));  
	$url = trim(str_replace("\t", "", $url));  
	$page_deb = trim(str_replace("\t", "", $page_deb));  
	$page_fin = trim(str_replace("\t", "", $page_fin));  
	$nb_pages = trim(str_replace("\t", "", $nb_pages));  
	$date_conf = trim(str_replace("\t", "", $date_conf));
	$date_publi = trim(str_replace("\t", "", $date_publi));
	$audience = trim(str_replace("\t", "", $audience));
	$etablissement = trim(str_replace("\t", "", $etablissement));
	$directeur = trim(str_replace("\t", "", $directeur));
	$observation = trim(str_replace("\t", "", $observation));
	
	

	$selectionner_ordre	= $_POST['selectionner_ordre'];
	if ($selectionner_ordre =='on') {$selectionner_ordre=1;} else {$selectionner_ordre=0;}
	
	// cas de suppression d'une bibliographie
	if ($_GET['type_modif'] == 'supp')
	
	{	$id_publi=$_GET['id_publi'];
		pg_query ($dbconn, "UPDATE publication SET visible='false' WHERE id=".$id_publi."");
		$_GET['type_modif'] = $_GET['type_modif'] . "_publi=" .$id_publi;
	}

	// cas d'ajout d'une publication
	if ($_GET['type_modif'] == 'ajout')
	{	
		$result = pg_query ($dbconn, "INSERT INTO publication (id_personne, id_type, titre_communication, titre_journal, auteur_sec, revue_volume, revue_fascicule,
												titre_ouvrage, editeur, editeur_ville, collection, url, page_deb, page_fin, nb_pages, date_conf, date_publi, 
												id_pays_conf, id_langue, audience, etablissement, directeur, id_type_these, visible, observation, selectionner_ordre) 
					 VALUES ('". $id_personne ."','" . $id_type_publi . "','" . $titre_communication . "','" . $titre_journal . "','" . $auteur_sec . "','" . $revue_volume . "','" . $revue_fascicule . "','" . $titre_ouvrage . "','" . $editeur . "','".
					 $editeur_ville . "','" . $collection . "','" . $url . "','" . $page_deb . "','" . $page_fin . "','" . $nb_pages . "','" . $date_conf . "','" . $date_publi . "','".
					 $id_pays_conf . "','" . $id_langue . "','" . $audience . "','" . $etablissement . "','" . $directeur . "','" . $id_type_these . "',true ,'" . $observation . "', " . $selectionner_ordre . "
				)RETURNING id");
				
		$insert_row = pg_fetch_row($result);
		$id_publication = $insert_row[0];
		
		$_GET['type_modif'] = $_GET['type_modif'] . "_publi=" .$id_publication;
	
	}
	
	// cas de modifcation d'une publication
	if ($_GET['type_modif'] == 'modif')
	{	
		$id_publi=$_POST['id_publi'];
		pg_query ($dbconn, "UPDATE publication SET id_personne='".$id_personne."', id_type='".$id_type_publi . "',
							titre_communication='" . $titre_communication . "', titre_journal='" . $titre_journal . "', auteur_sec='" . $auteur_sec . "',
							revue_volume='" . $revue_volume . "', revue_fascicule='" . $revue_fascicule . "', titre_ouvrage='" . $titre_ouvrage . "', editeur='" . $editeur . "',
							editeur_ville='" . $editeur_ville . "', collection='" . $collection . "', url='" . $url . "', page_deb='" . $page_deb . "', page_fin='" . $page_fin . "',
							nb_pages='" . $nb_pages . "', date_conf='" . $date_conf . "', date_publi='" . $date_publi . "',
							id_pays_conf='" . $id_pays_conf . "', id_langue='" . $id_langue . "', audience='" . $audience . "', etablissement='" . $etablissement . "',
							directeur='" . $directeur . "', id_type_these='" . $id_type_these . "', visible=true , observation='" . $observation . "', selectionner_ordre='" . $selectionner_ordre . "'
							WHERE id='".$id_publi."'");	
							
		$_GET['type_modif'] = $_GET['type_modif'] . "_publi=" .$id_publi;							
	}
	
	// cas selectionner l'article
	if ($_GET['type_modif'] == 'choisi')
	{	
		$id_publi=$_GET['id_publi'];
		$ordre=$_GET['ordre'];
		
		pg_query ($dbconn, "UPDATE publication SET selectionner_ordre='" . $ordre . "'
							WHERE id='".$id_publi."'");	
							echo 
							
		$_GET['type_modif'] = $_GET['type_modif'] . "_publi=" .$id_publi . "_ordre=" .$ordre ;							
	}
	

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'publication', '". $today ."' ,  now()  , '". $id_personne ."' )");			

	echo "<script language='javascript' type='text/javascript'> window.location.replace('bibliographie.php');	</script>";
								
?>
