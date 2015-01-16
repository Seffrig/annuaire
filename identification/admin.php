<?php require_once('connexion.php'); ?>

<?php

// ouverture de  la session
session_start(); 

if (session_is_registered("authentification") && $_SESSION['privilege'] == "admin")
{
	// cas de réussite 	 
}
else 
{
	// redirection en cas d'echec
	header("Location:index.php?erreur=intru"); 
}
?>

<?php 

// ------ AJOUT D'UN UTILISATEUR --------
if(isset($_POST['login']))
{ 
	// on vérifie la présence des variables de formulaire (si le formulaire a été envoyé)
	if(($_POST['login'] == "") || ($_POST['pass'] == ""))
	{ 
		// si login ou mot de passe non spécifiés >> message d'erreur
		header("Location:admin.php?erreur=empty");
	}
	else if($_POST['pass'] == $_POST['pass2']){ // on vérifie si le mot de passe et le mot de passe confirmé ont la même valeur
		// on passe toutes les variables $POST en variables
		$login = $_POST['login'];
		$pass = md5($_POST['pass']); // ici, on crypte le mot de passe à l'aide de MD5 (c'est tout simple non ? :)
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$privilege = $_POST['privilege'];
		// on fait l'INSERT dans la base de données
		$add_user = sprintf("INSERT INTO users (login, pass, nom, prenom, privilege) VALUES ('$login', '$pass', '$nom', '$prenom', '$privilege')");
  		mysql_select_db($database_dbprotect, cnxMysqlAdmin());
  		$result = mysql_query($add_user, cnxMysqlAdmin()) or die(mysql_error());
		header("Location:admin.php?add=ok"); // redirection si création réussie
	}
	else{
	header("Location:admin.php?erreur=pass"); // redirection si le pass1 est différent du pass2
	}
}
// requête sur tous les utilisateurs recensés dans la base (on fait un tri par nom)



// ------ SUPPRESSION D'UN UTILISATEUR --------
// on fait la requête sur tous les utilisateurs de la base
mysql_select_db($database_dbprotect, cnxMysqlAdmin());
$query_users = "SELECT * FROM users ORDER BY nom ASC"; // ORDER BY renvoi les données triées (ici par nom croissant)
$users = mysql_query($query_users, cnxMysqlAdmin()) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);

if(isset($_POST['suppr'])){ // on vérifie la présence des variables de formulaire (si le formulaire a été envoyé)
	$id = $_POST['suppr'];
    $delete_user = sprintf("DELETE FROM users WHERE id_user='$id'");

  mysql_select_db($database_dbprotect, cnxMysqlAdmin());
  $result = mysql_query($delete_user, cnxMysqlAdmin()) or die(mysql_error());
  header("Location:admin.php?delete=ok");
}
?>
<html>
<head>
<title>Document sans titre</title>
<style type="text/css">
<!--
.Style2 {color: #0000FF}
.Style5 {color: #FF0000}
.Style6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Style8 {font-size: 12px}
.Style9 {font-size: 14px}
-->
</style>
</head>

<body>
<form action="" method="post" name="add" class="Style6">
  <p align="center">
  <em>Administration</em></p>
  <p align="center"><strong>
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "pass")) { // Affiche l'erreur  ?><span class="Style5">Veuillez entrer deux fois votre mot de passe SVP</span><?php } ?>
    <?php if(isset($_GET['add']) && ($_GET['add'] == "ok")) { // Affiche l'erreur ?><span class="Style2">L'utilisateur a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s !</span><?php } ?>
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "empty")) { // Affiche l'erreur  ?><span class="Style5">Un petit oubli non ? Veuillez renseigner au moins un login et un mot de passe SVP</span><?php } ?>
  </strong></p>
  <p align="center"><strong><u>Cr&eacute;er un utilisateur</u></strong></p>
  <table width="350" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
    <tr>
      <td width="40"><span class="Style8">Login</span></td>
      <td width="144"><input name="login" type="text" id="login"></td>
    </tr>
    <tr>
      <td><span class="Style8">Mot de passe </span></td>
      <td><input name="pass" type="text" id="pass"></td>
    </tr>
    <tr>
      <td><span class="Style8">R&eacute;p&eacute;ter mot de passe </span></td>
      <td><input name="pass2" type="text" id="pass2"></td>
    </tr>
    <tr>
      <td><span class="Style8">NOM</span></td>
      <td><input name="nom" type="text" id="nom"></td>
    </tr>
    <tr>
      <td><span class="Style8">Pr&eacute;nom</span></td>
      <td><input name="prenom" type="text" id="prenom"></td>
    </tr>
    <tr>
      <td><span class="Style8">Privil&egrave;ge</span></td>
      <td><select name="privilege" id="privilege">
	    <option value="user">Utilisateur</option>
        <option value="admin">Administrateur</option>
      </select></td>
    </tr>
    <tr>
      <td height="50" colspan="2"><div align="center">
        <input type="submit" name="Submit" value="Cr&eacute;er cet utilisateur">
      </div></td>
    </tr>
  </table>
  </form>
  <p align="center" class="Style6"><strong>
  <?php if(isset($_GET['delete']) && ($_GET['delete'] == "ok")) { // Affiche l'erreur  ?><span class="Style2">L'utilisateur a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s</span><?php } ?></strong> </p>
    <form action="" method="post" name="suppr" class="Style6">
      <p align="center"><strong><u>Supprimer un utilisateur</u></strong></p>
      <div align="center">
        <table width="500" border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td width="240"><div align="center">
                <select name="suppr" size="5" class="textform" id="select2">
                  <?php
do {  
?>
                  <option value="<?php echo $row_users['id_user']?>">
                  <?php if($row_users['privilege']== "admin") echo ">> ";echo $row_users['nom']; echo " "; echo $row_users['prenom']; echo " ("; echo $row_users['login']; echo ")"; if($row_users['privilege']== "admin") echo " <<"?>
                  </option>
                  <?php
} while ($row_users = mysql_fetch_assoc($users));
  $rows = mysql_num_rows($users);
  if($rows > 0) {
      mysql_data_seek($users, 0);
	  $row_users = mysql_fetch_assoc($users);
  }
?>
                </select>
            </div></td>
            <td width="157"><input type="submit" name="Submit2" value="Supprimer cet utilisateur"></td>
          </tr>
              </table>
        <p>&nbsp;</p>
        <p><a href="accueil.php"><strong>&lt; Retour accueil</strong></a></p>
      </div>
    </form>
</body>
</html>
