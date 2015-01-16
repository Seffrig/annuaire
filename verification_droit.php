<?php

	$result_droit=pg_query($dbconn, "SELECT ".$page." FROM type_user WHERE id=".$_SESSION['type_user']." ");
	$infos_droit= pg_fetch_row($result_droit);			
	$droit=$infos_droit[0];
	// droit non autorisé
	if ($droit=='f') 
	{ 		
		echo'<script language="javascript" type="text/javascript"> window.location.replace("deconnexion.php");	</script>';
	}	
?>