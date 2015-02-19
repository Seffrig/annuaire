<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Reinitilialisation du mot de passe</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="reinitier mon mot de passe">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="reinitier mon mot de passe">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
?>

<?php
$mdp_bool=true;

// modification du mot de passe
if($_POST && !empty($_POST['ancien_mot_pass']) && !empty($_POST['new_mot_pass']) && !empty($_POST['new_mot_pass_2'])  )	
{ 
	$login= $_SESSION['login'];	
	$mdp_old = htmlentities($_POST['ancien_mot_pass'], ENT_QUOTES);	
	$mdp_old = md5($mdp_old);	 	// on crypte le mot de passe envoyé par le formulaire
	
	$mdp_new = htmlentities($_POST['new_mot_pass'], ENT_QUOTES);	
	$mdp_new = md5($mdp_new);	 	// on crypte le mot de passe envoyé par le formulaire
	
	$mdp_new2 = htmlentities($_POST['new_mot_pass_2'], ENT_QUOTES);	
	$mdp_new2 = md5($mdp_new2);	 	// on crypte le mot de passe envoyé par le formulaire
	
	$result_sup_utilisateur = pg_query ($dbconn, "SELECT pass FROM utilisateur WHERE login='".$login."'");	
	$row_sup_utilisateur = pg_fetch_row($result_sup_utilisateur);	
	if(!empty($row_sup_utilisateur)) 
	{
		if ($row_sup_utilisateur[0] == $mdp_old && $mdp_new==$mdp_new2)
		{
			$result = pg_query("UPDATE utilisateur SET pass ='".$mdp_new."'
								WHERE login = '".$login."'");
			
			$today = date("j-n-Y à H:i:s");   
			pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
								VALUES ('".$_SESSION['login']."', 'modif', 'mdp','$today',  now(), '".$login."')");	
			
			echo "<script language='javascript' type='text/javascript'> window.location.replace('compte.php');	</script>";
		}
		else
		{
			$mdp_bool=false;
		}
	}
	
}	

?>	
<div id="global">	
	<h1> Gestion du mot de passe</h1>		
	<br>

	<form action="reinit_mon_pass.php"  method='post'>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Modification</h2>
			</div>
			<div class="panel-body">
				<label style="width:250px" for='login_cree'> Ancien mot de passe : </label> <input type="password" name="ancien_mot_pass" id="ancien_mot_pass" size="50"/>
				<br>
				<br>	
				<label style="width:250px" for='new_mot_pass'> Nouveau mot de passe :  </label> <input type="password" name="new_mot_pass" id="new_mot_pass" size="50" />		
				<br>
				<br>
				<label style="width:250px" for='new_mot_pass_2'> Confirmer le nouveau mot de passe :  </label> <input type="password" name="new_mot_pass_2" id="new_mot_pass_2" size="50" />
				<br>
				<br>
				<?php
				if (!$mdp_bool)
				{
					echo'<div class=erreur >mauvais mot de passe recommencé svp</div>';
				}
				?>
			<div id='recherche_submit'>
				<input type="submit" id="bouton-submit"  value="Changer" style="margin-left:40%" />
				<a href="compte.php" > <input type="button" value="Annuler"> </a>
			</div>

		</div></div>
		</form>		
	<br>
	
</div>

<?php
	include "templates/footer.php";
?>