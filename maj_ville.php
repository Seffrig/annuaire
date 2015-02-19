<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

$id_rech = "";
$nom_ville = "";

if(isset($_GET['id_rech'])){
	$id_rech = $_GET['id_rech'];	
}
if(isset($_POST["nom_ville"])){
	$nom_ville = pg_escape_string($_POST["nom_ville"]);	
}


// cas de l'ajout
if (isset($_GET['type_modif']))
{
	if ($_GET['type_modif'] == 'supp' && $id_rech !=""){				
		pg_query("DELETE FROM ville WHERE id=$id_rech");
	}
	if($_GET['type_modif'] == 'ajout'){
		if($nom_ville != "") {				
			$result = pg_query ($dbconn, "INSERT INTO ville (libelle) 
										  VALUES ('".$nom_ville ."') RETURNING id");
			$insert_row = pg_fetch_row($result);
			$id_rech = $insert_row[0];
		}	
	}	
	
	if ($_GET['type_modif'] == 'modif'){
		if($nom_ville != "") {		
			pg_query ($dbconn, "UPDATE ville SET libelle='".$nom_ville."'
							WHERE id=".$id_rech."");	
		}	
	}
	pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'ville', '". $today ."' ,  now()  , '". $id_rech ."' )");	
}







				

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_ville.php');	</script>";
?>


				