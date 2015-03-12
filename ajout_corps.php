<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="fonction.js"></script><script type="text/javascript" src="autocomplete-3-2.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/design.css" />';
$changements['__TITLE__'] = '<title>Ajout corps</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout corps">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout corps">';
remplace('templates/header.php',$changements);

include "templates/menu.php";
include("Commun/connexionDB.php");
?> 
<div id="global">	
	<h1> 	Ajout corps	 </h1>	<?php					
		if(isset($_POST['nom'])) {				
			$result = pg_query ($dbconn, "INSERT INTO corps (libelle) 
										VALUES ('".$_POST[nom]."')");
		}								 
		?>	
		<form action="ajout_corps.php" name="form_comp" method="post">			
			<br>				
			<label for="nom">Nom</label> : <input type="text" maxlength="30 "name="nom" id="nom" />				
			<br>	
			<input type="submit" name="bonton_submit" value="Valider" />
		</form>	
		<br>	
		<?php affichage_colonne('libelle', 'corps','corps', 'corps');	?>			
</div>	
<?php
include "templates/footer.php";
?>

