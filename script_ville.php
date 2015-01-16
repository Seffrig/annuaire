<?php						
	include("connexionDB.php");	
///Make sure that a value was sent.
	if (isset($_GET['search']) && $_GET['search'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
		$search = addslashes($_GET['search']);
	//Get every page title for the site.		
		$suggest_query = pg_query("SELECT libelle FROM ville WHERE libelle LIKE '$search%' LIMIT 10");		
		while($suggest = pg_fetch_row($suggest_query)) {
			//Return each page title seperated by a newline.
			echo $suggest[0]."\n"; // trim enleve les espaces 
		}
     }

?>

