<?php 
	// connexion à la base
//$dbconn = pg_connect("host=localhost dbname=annuaire user=postgres password=localhost"); 
//$dbconn = pg_connect("host=localhost dbname=annuaire user=elodie password=once-123"); 
$dbconn = pg_connect("host=localhost dbname=annuaire user=benoit password=postgresql"); 
if (!$dbconn) 
{  
	echo "Une erreur s'est produite au chargement de la database.\n";  
	exit; 
}

date_default_timezone_set( 'Europe/Paris' ) ;
?>