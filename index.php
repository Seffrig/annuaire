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


		
	<form action="test_login.php" method="post">
		<p />
		<br><br><br><br>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 style ="text-align:center" class="panel-title">Connexion</h2>
			</div>
			<div class="panel-body">			
				<div id='centrage_hor' align="center">
					<?php
					if (isset($_GET["mode"]) && $_GET["mode"]=="erreur")
					{
						echo '	<span id="alerte" style="margin-left: 10%;">Erreur de login ou/et de mot de passe</span>';
					}
					if(isset($_GET['mode']) && ($_GET['mode'] == "deconnection")) 
					{	 		      
						echo "<span style='margin-left: 10%;'>D&eacute;connexion r&eacute;ussie. A bient&ocirc;t</span>";
					}
					?>
					<br>
					<br>
					<label for="login">Nom d'utilisateur</label> : 
					<input type="text" maxlength="30" name="login" id="login"/><br><br>
					<label id="label2" for="pass">Mot de passe</label> : 
					<input  type="password" maxlength="30 "name="pass" id="pass" /><br><br><br>
					<div style="margin-left:28%">
						<button style="width:130px ; height : 30px" type="submit" class="btn btn-default">Valider</button>
					</div>
				</div>
			</div>
			
			
		<br>
		</div>
	</form>	
	<?php
		if (isset($_SESSION['erreur'])) echo $_SESSION['erreur'];
	?>	

<?php
	include "templates/footer.php";
?>


