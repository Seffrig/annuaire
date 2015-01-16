<?php
include("connexionDB.php");		 
$pays = $_GET['objet'];
$today = date("j-n-Y à H:i:s");   
$now =time();
echo $pays;
pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure,timestamp, id_objet) 
								VALUES ('".$_SESSION['login']."', 'suppression', 'pays',$today, $now, '".$pays."' )");									
pg_query("DELETE FROM pays WHERE libelle='$pays'");
echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_pays.php');	</script>";
?>

				