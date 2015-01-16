<?php
// ouverture de  la session
session_start(); 

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Connexion</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="annuaire">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="annuaire">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");
?> 

<?php

	if (isset($_GET["mode"]) && $_GET["mode"]=="erreur")
	{
		echo '<div id="centrage_hor">';
		echo '	<div id="alerte">erreur de login ou/et de mot de passe</div>';
		echo '</div> ';
	
	}
	if(isset($_GET['mode']) && ($_GET['mode'] == "deconnection")) 
	{	 		      
		echo "<span class='blue_text'>D&eacute;connexion r&eacute;ussie. A bient&ocirc;t</span>";
	}
?>	
		
	<form action="test_login.php" method="post">
		<p />
		<br><br><br>
		<div id='centrage_hor'>
			<label for="login">Nom d'utilisateur</label> : 
			<input type="text" maxlength="30" name="login" id="login"/>
		</div>
		<br>	<br>
		<div id='centrage_hor'>
			<label id="label2" for="pass">Mot de passe</label> : 
			<input  type="password" maxlength="30 "name="pass" id="pass" />
		</div>
		<br>
		<div id='centrage_hor'>
			<input type="submit" value="Valider" />
		</div>
	</form>	
	<?php echo $_session['erreur'];?>	

<?php
	include "templates/footer.php";
?>


