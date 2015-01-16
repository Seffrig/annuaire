<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

// récupération du formulaire
$id_rech = $_GET['id_rech'];
$num_equipe = pg_escape_string($_POST[num_equipe]);
$accronyme = pg_escape_string($_POST[accronyme]);
$num_rue = pg_escape_string($_POST[num_rue]);
$nom_rue = pg_escape_string($_POST[nom_rue]);
$code_postal = pg_escape_string($_POST[code_postal]);
$ville = pg_escape_string($_POST[ville]);
$id_pays = pg_escape_string($_POST[id_pays]);if ($_POST[id_pays] == '') {$id_pays = 0;}

// cas de l'ajout
if ($_GET['type_modif'] == 'ajout')
{
	if(isset($_POST[num_equipe]) && isset($_POST[num_rue]) && isset($_POST[id_pays])) 
	{				
		$result = pg_query ($dbconn, "INSERT INTO recherche (num_equipe, accronyme, num_rue, nom_rue, code_postal, ville, pays) 
									VALUES ('".$num_equipe ."', '".$accronyme."', '".$num_rue."', '".$nom_rue."', '".$code_postal."', '".$ville."', ".$id_pays.") RETURNING id");
		$insert_row = pg_fetch_row($result);
		$id_rech = $insert_row[0];
	}	
}

// cas de suppression
if ($_GET['type_modif'] == 'supp')
{				
	pg_query("DELETE FROM recherche WHERE id=$id_rech");
}

// cas de modification
if ($_GET['type_modif'] == 'modif')
{
	if(isset($_POST)) 
	{		
		pg_query ($dbconn, "UPDATE recherche SET num_equipe='".$num_equipe."', accronyme='".$accronyme. "',
							num_rue='" . $num_rue . "', nom_rue='" . $nom_rue . "', code_postal='" . $code_postal . "', ville='" . $ville . "', pays='" . $id_pays . "'
							WHERE id=".$id_rech."");	
	}	
}

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'equipe_recherche', '". $today ."' ,  now()  , '". $id_rech ."' )");					

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_equipe_recherche.php');	</script>";
?>


				