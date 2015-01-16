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
		<br><br><br><br>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 style ="text-align:center" class="panel-title">Connexion</h2>
			</div>
			<div class="panel-body">			
				<div id='centrage_hor' align="center">
					<label for="login">Nom d'utilisateur</label> : 
					<input type="text" maxlength="30" name="login" id="login"/><br><br>
					<label id="label2" for="pass">Mot de passe</label> : 
					<input  type="password" maxlength="30 "name="pass" id="pass" /><br><br><br>
					<div style="margin-left:28%">
						<button style="width:130px ; height : 30px" type="submit" class="btn btn-default">Valider</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
	<?php echo $_session['erreur'];?>	

<?php
	include "templates/footer.php";
?>


