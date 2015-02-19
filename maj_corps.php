<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

$id_rech = "";
$nom_corps = "";
$ordre = "";

if(isset($_GET['id_rech'])){
	$id_rech = $_GET['id_rech'];	
}
if(isset($_POST["nom_corps"])){
	$nom_corps = pg_escape_string($_POST["nom_corps"]);	
}
if(isset($_POST["ordre"])){
	$ordre = pg_escape_string($_POST["ordre"]);	
}

// cas de l'ajout
if (isset($_GET['type_modif']))
{
	if ($_GET['type_modif'] == 'supp' && $id_rech !=""){				
		pg_query("DELETE FROM corps WHERE id=$id_rech");
	}
	if($_GET['type_modif'] == 'ajout'){
		if($nom_corps != "" && $ordre) {				
			$result = pg_query ($dbconn, "INSERT INTO corps (libelle, ordre) 
										  VALUES ('".$nom_corps ."', '".$ordre."') RETURNING id");
			$insert_row = pg_fetch_row($result);
			$id_rech = $insert_row[0];
		}	
	}	
	
	if ($_GET['type_modif'] == 'modif'){
		if($nom_corps != "" && $ordre) {		
			pg_query ($dbconn, "UPDATE corps SET libelle='".$nom_corps."', ordre='".$ordre. "'
							WHERE id=".$id_rech."");	
		}	
	}
	pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'corps', '". $today ."' ,  now()  , '". $id_rech ."' )");	
}







				

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_corps.php');	</script>";
?>


				