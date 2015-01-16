<?php 
	session_start(); // on initalise les sessions php
	$dbconn = pg_connect("host=localhost dbname=test user=postgres password=localhost"); 
		if (!$dbconn) {  
			echo "Une erreur s'est produite au chargement de la database.\n";  
			exit; 
		}			
?>