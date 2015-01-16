<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

// récupération du formulaire
$id_rech = $_GET['id_rech'];
$nom_etablissement = pg_escape_string($_POST[nom_etablissement]);
$id_ville = pg_escape_string($_POST[id_ville]);if ($_POST[id_ville] == '') {$id_pays = 0;}

// cas de l'ajout
if ($_GET['type_modif'] == 'ajout')
{
	if(isset($_POST[nom_etablissement]) && isset($_POST[id_ville]) ) 
	{				
		$result = pg_query ($dbconn, "INSERT INTO etablissement (nom, id_ville) 
									VALUES ('".$nom_etablissement ."', ".$id_ville.") RETURNING id");
		$insert_row = pg_fetch_row($result);
		$id_rech = $insert_row[0];
	}	
}

// cas de suppression
if ($_GET['type_modif'] == 'supp')
{				
	pg_query("DELETE FROM etablissement WHERE id=$id_rech");
}

// cas de modification
if ($_GET['type_modif'] == 'modif')
{
	if(isset($_POST)) 
	{		
		pg_query ($dbconn, "UPDATE etablissement SET nom = '".$nom_etablissement."', id_ville='" . $id_ville . "'
							WHERE id=".$id_rech."");	
	}	
}

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'etablissement', '". $today ."' ,  now()  , '". $id_rech ."' )");					

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_etablissement.php');	</script>";
?>


				