<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
include_once "fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="fonction.js"></script><script type="text/javascript" src="autocomplete-3-2.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/design.css" />';
$changements['__TITLE__'] = '<title>Ajout pays</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="osef">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="osef">';
remplace('templates/header.php',$changements);
include "templates/bandeau.php";
include("connexionDB.php");
?> 
<div id="global">	
	<h1> 	Ajout pays	 </h1>	<?php					
		if(isset($_POST['nom'])) {				
			$result = pg_query ($dbconn, "INSERT INTO pays (libelle) 
										VALUES ('".$_POST[nom]."')");
		}								 
		?>	
		<form action="ajout_pays.php" name="form_comp" method="post">			
			<br>				
			<label for="nom">Nom</label> : <input type="text" maxlength="30 "name="nom" id="nom" />				
			<br>	
			<input type="submit" name="bonton_submit" value="Valider" />
		</form>	
		<br>
		<?php affichage_colonne('libelle', 'pays','modif_pays.php', 'pays');				    			
	?>			
</div>	
<?php
include "templates/footer.php";
?>

