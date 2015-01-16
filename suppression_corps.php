<?php
include("connexionDB.php");		 
$corps = $_GET['objet'];
$today = date("j-n-Y à H:i:s");   
$now =time();
pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure,timestamp, id_objet) 
								VALUES ('".$_SESSION['login']."', 'suppression', 'corps',$today, $now, ".$corps." )");									
pg_query("DELETE FROM corps WHERE libelle='$corps'");
echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_corps.php');	</script>";
?>

				