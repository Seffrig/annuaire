<?php require_once('connexion.php'); ?>

<?php

// ouverture de  la session
session_start(); 

// test si la session a été enregistré 
if (session_is_registered("authentification"))
{ // cas de réussite 		
}
else 
{
	// redirection en cas d'echec
	header("Location:erreur.php?erreur=intru"); 
}
?>

<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
.Style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Style3 {font-size: 12px}
.Style4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Style8 {color: #0000FF; font-weight: bold; }
.Style11 {font-size: 10px}
.Style12 {font-size: 14px}
-->
</style>
</head>

<body>
<p class="Style2 Style3">Bienvenue &quot; &quot; dans votre espace s&eacute;curis&eacute;. </p>
<p class="Style4">Vous &ecirc;tes connect&eacute; en tant que &quot;<span class="Style8"><?php echo $_SESSION['login']; ?></span>&quot; avec le privil&egrave;ge &quot;<span class="Style8"></span>&quot;</p>

<p class="Style4">&nbsp;</p>
<p class="Style4">
<?php 
/*
--- AFFICHAGE CONDITIONNEL OU REDIRECTION EN FONCTION DU PRIVILEGE ---
	Config actuelle : le script gère un affichage conditionnel
	Pour rediriger l'utilisateur en fonction de son privilege, ajoutez les lignes suivantes aux endroits indiqués
	Dans la zone d'affichage admin : 
			header("Location:URL SI ADMIN")
	Dans la zone d'affichage admin : 
			header("Location:URL SI USER SIMPLE")
			
Note: pour ajouter des privilèges, editez ce fichier en rajoutant une condition d'affichage
et editez le fichier admin.php en ajoutant à la liste "select" un privilege.
*/
  
  
  // si l'utilisateur est connecté comme admin ...
  if($_SESSION['privilege'] == "admin") { // Affichage conditionnel : si et seulement si l'utilisateur est connecté avec le privilege administrateur ?>
<strong>En tant qu'administrateur vous pouvez effectuer les actions suivantes : </strong></p>
<p class="Style4">- <a href="admin.php">G&eacute;rer les utilisateurs</a>
  <?php } // fin de l'affichage conditionnel?></p>
<p class="Style4">
  <?php 
  // si l'utilisateur est connecté comme simple utilisateur ...
  if($_SESSION['privilege'] == "user") { // Affichage conditionnel : si et seulement si l'utilisateur est connect&eacute; avec le privilege utilisateur simple ?>
  <strong>En tant qu'utilisateur simple vous ne pouvez pas effectuer d'actions</strong>
  <?php } // fin de l'affichage conditionnel?>
</p>
<p align="left" class="Style4 Style3"><a href="login.php?erreur=logout"><strong>Vous d&eacute;connecter</strong></a></p>

</body>
</html>
