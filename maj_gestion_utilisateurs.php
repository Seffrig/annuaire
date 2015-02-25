<?php
include('test_session.php');

include_once "commun/fonction.php";

//connection à la base
include("commun/connexion_db.php");


$today = date("j-n-Y à H:i:s");   
$now =time();

$id_rech = '';
$login_cree = '';	
$id_utilisateur = '';
$id_type = 3;
$pass_cree = '';
$nom_cree = '';
$prenom_cree = '';

// récupération du formulaire
if(isset($_GET['id_rech']))
	$id_rech = $_GET['id_rech'];

if(isset($_POST['login_cree']))
	$login_cree = pg_escape_string($_POST['login_cree']);	

if(isset($_POST['id_utilisateur']))
	$id_utilisateur = pg_escape_string($_POST['id_utilisateur']);

if(isset($_POST['id_type']))
	$id_type = pg_escape_string($_POST['id_type']);


if(isset($_POST['nom_cree']))
	$nom_cree = pg_escape_string($_POST['nom_cree']);	

if(isset($_POST['prenom_cree']))
	$prenom_cree = pg_escape_string($_POST['prenom_cree']);	


//traitement login
$login_sans_accent = removeaccents($login_cree);
$login_sans_accent_maj = strtoupper($login_sans_accent);

// traitement mot de passe
if(isset($_POST['pass_cree']))
	$pass_cree = pg_escape_string($_POST['pass_cree']);
$mdp = htmlentities($pass_cree, ENT_QUOTES);
$password_md5 = md5($mdp);

// cas de l'ajout
if ($_GET['type_modif'] == 'ajout' && $login_sans_accent_maj != '' && $pass_cree != ''  && $nom_cree != '' && $prenom_cree != '' )
{ 

	$res = pg_query ($dbconn, "INSERT INTO personne (nom, prenom, id_etabl_princ) 
								VALUES ('".$nom_cree ."', '".$prenom_cree ."','1') RETURNING id");
	$insert_row = pg_fetch_row($res);
	$idP = $insert_row[0];	


	$result = pg_query ($dbconn, "INSERT INTO utilisateur (login, pass, id_type, id_personne) 
								VALUES ('".$login_sans_accent_maj ."', '".$password_md5 ."', ".$id_type.", ". $idP.") RETURNING login");
	$insert_row = pg_fetch_row($result);
	$id_rech = $insert_row[0];	
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


				