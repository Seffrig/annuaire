<?php
include('test_session.php');

include_once "commun/fonction.php";

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

// récupération du formulaire
$id_rech = $_GET['id_rech'];
$login_cree = pg_escape_string($_POST[login_cree]);	
$id_utilisateur = pg_escape_string($_POST[id_utilisateur]);
$id_type = pg_escape_string($_POST[id_type]);if ($_POST[id_type] == '') {$id_type = 0;}

//traitement login
$login_sans_accent = removeaccents($_POST[login_cree]);
$login_sans_accent_maj = strtoupper($login_sans_accent);

// traitement mot de passe
$pass_cree = pg_escape_string($_POST[pass_cree]);
$mdp = htmlentities($pass_cree, ENT_QUOTES);
$password_md5 = md5($mdp);

// cas de l'ajout
if ($_GET['type_modif'] == 'ajout')
{ 
	if(isset($_POST[login_cree]) && isset($_POST[pass_cree]) ) 
	{		
		$result = pg_query ($dbconn, "INSERT INTO utilisateur (login, pass, id_type) 
									VALUES ('".$login_sans_accent_maj ."', '".$password_md5 ."', ".$id_type.") RETURNING login");
		$insert_row = pg_fetch_row($result);
		$id_rech = $insert_row[0];
	}	
}

// cas de suppression
if ($_GET['type_modif'] == 'supp')
{		
	$result_sup_utilisateur = pg_query ($dbconn, "SELECT id_personne FROM utilisateur WHERE login='".$id_rech ."'");
	$row_sup_utilisateur = pg_fetch_row($result_sup_utilisateur);	 	
	if(!empty($row_sup_utilisateur)) 
	{
		pg_query("UPDATE personne SET visible ='FALSE' , date_suppression = now()
								WHERE id = '".$row_sup_utilisateur[0]."'");		
	}
	pg_query("DELETE FROM utilisateur WHERE login='".$id_rech ."'");
}

// cas de modification
if ($_GET['type_modif'] == 'modif')
{
	if(isset($_POST)) 
	{		
		$requete = "";
		if ($pass_cree != "") { $requete= "pass = '".$password_md5."',";}
		pg_query ($dbconn, "UPDATE utilisateur SET ".$requete." id_type='" . $id_type . "'
							WHERE login='".$id_rech."'");								
	}	
}

pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
							VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'utilisateur', '". $today ."' ,  now()  , '". $id_rech ."' )");					
echo "<script language='javascript' type='text/javascript'> window.location.replace('modif_gestion_utilisateurs.php');	</script>";
?>


				