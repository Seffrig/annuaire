<?php
include('test_session.php');

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

$id_rech = "";
$num_equipe = "";
$accronyme = "";
$num_rue = "";
$nom_rue = "";
$code_postal = "";
$ville = "";
$id_pays = "";

if(isset($_GET['id_rech'])){
	$id_rech = $_GET['id_rech'];	
}
if(isset($_POST["num_equipe"])){
	$num_equipe = pg_escape_string($_POST["num_equipe"]);	
}
if(isset($_POST["accronyme"])){
	$accronyme = pg_escape_string($_POST["accronyme"]);	
}
if(isset($_POST["num_rue"])){
	$num_rue = pg_escape_string($_POST["num_rue"]);	
}
if(isset($_POST["nom_rue"])){
	$nom_rue = pg_escape_string($_POST["nom_rue"]);	
}
if(isset($_POST["code_postal"])){
	$code_postal = pg_escape_string($_POST["code_postal"]);	
}
if(isset($_POST["ville"])){
	$ville = pg_escape_string($_POST["ville"]);	
}
if(isset($_POST["id_pays"])){
	$id_pays = pg_escape_string($_POST["id_pays"]);	
}


// cas de l'ajout
if (isset($_GET['type_modif']))
{
	if($_GET['type_modif'] == 'ajout'){
		if($num_equipe != "" && $num_rue != ""  && $id_pays != "") {				
			$result = pg_query ($dbconn, "INSERT INTO recherche (num_equipe, accronyme, num_rue, nom_rue, code_postal, ville, pays) 
										  VALUES ('".$num_equipe ."', '".$accronyme."', '".$num_rue."', '".$nom_rue."', '".$code_postal."', '".$ville."', ".$id_pays.") RETURNING id");
			$insert_row = pg_fetch_row($result);
			$id_rech = $insert_row[0];
		}	
	}	
	if ($_GET['type_modif'] == 'supp' && $id_rech !=""){				
		pg_query("DELETE FROM recherche WHERE id=$id_rech");
	}
	if ($_GET['type_modif'] == 'modif'){
		if($num_equipe != "" && $accronyme != "" && $num_rue != "" &&  $nom_rue != "" && $code_postal != "" && $ville != "" && $id_pays && $id_rech != "" ) {		
			pg_query ($dbconn, "UPDATE recherche SET num_equipe='".$num_equipe."', accronyme='".$accronyme. "',
							num_rue='" . $num_rue . "', nom_rue='" . $nom_rue . "', code_postal='" . $code_postal . "', ville='" . $ville . "', pays='" . $id_pays . "'
							WHERE id=".$id_rech."");	
		}	
	}
	pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'equipe_recherche', '". $today ."' ,  now()  , '". $id_rech ."' )");	
}







				

echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_equipe_recherche.php');	</script>";
?>


				