<?php
session_start(); // on initalise les sessions php
	$dbconn = pg_connect("host=localhost dbname=test user=postgres password=localhost"); 
	if (!$dbconn) {
		echo "Une erreur s'est produite au chargement de la database.\n";  
		exit; 
	}	
// affiche bien la liste 
 header('Content-Type: text/xml;charset=utf-8');
echo(utf8_encode("<?xml version='1.0' encoding='UTF-8' ?><options>"));
if (isset($_GET['debut'])) {
    $debut = utf8_decode($_GET['debut']);
}
else {
    $debut = "";
}	
$champ = $_GET['champ'];
$table = $_GET['table'];
$champ2 = $_GET['champ2'];

$MAX_RETURN = 10;
$i = 0;		

$suggest_query = pg_query("SELECT $champ FROM $table WHERE $champ2 ILIKE '%".$debut."%' LIMIT 10");	
$id=0;
while($suggest = pg_fetch_row($suggest_query)) {
	$liste[$id]= $suggest[0];		 
	$id++;
}	

foreach ($liste as $element) {
  //if ($i<$MAX_RETURN && substr($element, 0, strlen($debut))==$debut) {		
   if ($i<$MAX_RETURN && (strcasecmp(substr($element, 0, strlen($debut)),$debut)==0) )  {	// strcasecmp compare en binaire des chaînes de caractères insensiblement à la casse.	           
		echo("<option>".$element."</option>"); 
		$i++;
	}
}
echo("</options>");
?>

