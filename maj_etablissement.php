<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

// récupération du formulaire
$id_rech="";
$nom_etablissement="";
$id_ville="";


if(isset($_GET['id_rech']) && $_GET['id_rech'] != ""){
	$id_rech = $_GET['id_rech'];	
}
if(isset($_POST["nom_etablissement"]) && $_POST['nom_etablissement'] != "" ){
	$nom_etablissement = pg_escape_string($_POST["nom_etablissement"]);
}

if(isset($_POST["id_ville"]) && $_POST["id_ville"] != ''){
	$id_ville = pg_escape_string($_POST["id_ville"]);
}


if (isset($_GET['type_modif']))
{
	if($_GET['type_modif'] == 'ajout'){
		if($nom_etablissement != "" && $id_ville != ""  ){				
			$result = pg_query ($dbconn, "INSERT INTO etablissement (nom, id_ville) 
									VALUES ('".$nom_etablissement ."', ".$id_ville.") RETURNING id");
			$insert_row = pg_fetch_row($result);
			$id_rech = $insert_row[0];
		}	
	}
	if ($_GET['type_modif'] == 'supp' && $id_rech != ""){				
		pg_query("DELETE FROM etablissement WHERE id=$id_rech");
	}
	if ($_GET['type_modif'] == 'modif'){
		if($nom_etablissement != "" && $id_ville != "" && $id_rech != ""){		
			pg_query ($dbconn, "UPDATE etablissement SET nom = '".$nom_etablissement."', id_ville='" . $id_ville . "'
								WHERE id=".$id_rech."");	
		}	
	}

	pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'etablissement', '". $today ."' ,  now()  , '". $id_rech ."' )");	
}

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_etablissement.php');	</script>";
?>


				