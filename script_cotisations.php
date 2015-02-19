<?php session_start(); ?>

<?php
//connection à la base
include("commun/connexion_db.php");

$today = date("j-n-Y à H:i:s");   
$now = time();	


$id_cotisant = "";
$new_id_type_personne="";
$id_cotisation="";
$new_annee = "";
$new_id_type_paiement = "";
$new_revue ="";
if ($new_revue=="") {$new_revue = 0;}else {$new_revue = 1;}
$new_valeur = "";
$new_id_cotisant = "";
$modif_id_cotisation = "";
$new_abonnement_revue ="";

if(isset($_SESSION['id_personne'])){
	$id_cotisant = $_SESSION['id_personne'];
}
if(isset($_POST['new_id_type_personne'])){
	$new_id_type_personne = $_POST['new_id_type_personne'];
}	
if(isset($_GET['id_cotisation'])){
	$id_cotisation = $_GET['id_cotisation'];
}	
if(isset($_POST['new_annee'])){
	$new_annee = pg_escape_string($_POST["new_annee"]);
}	
if(isset($_POST['new_id_type_paiement'])){
	$new_id_type_paiement = pg_escape_string($_POST["new_id_type_paiement"]);
}
if(isset($_POST['new_revue'])){
	$new_revue = pg_escape_string($_POST["new_revue"]);
}
if ($new_revue=="") {$new_revue = 0;}else {$new_revue = 1;}
if(isset($_POST['new_valeur'])){
	$new_valeur = pg_escape_string($_POST["new_valeur"]);
}
if(isset($_POST['new_id_cotisant'])){
	$new_id_cotisant = pg_escape_string($_POST["new_id_cotisant"]);
}
if(isset($_POST['modif_id_cotisation'])){
	$modif_id_cotisation = pg_escape_string($_POST["modif_id_cotisation"]);
}

include ("sql/recup_personne.php"); 

	// modification de l'abonnement
if (isset($_GET['type_modif'])){
	if($_GET['type_modif']=='modif_abonnement_revue')
		$new_abonnement_revue = "non";
		if ($abonnement_revue=='non') {$new_abonnement_revue = "oui";}
			pg_query ($dbconn, "UPDATE personne SET abonnement_revue='". $new_abonnement_revue . "' WHERE id=".$id_cotisant." ");
	
	if ($_GET['type_modif']=='modif_type_adherent'){
		pg_query ($dbconn, "UPDATE personne SET id_type_personne=".$new_id_type_personne." WHERE id=".$id_cotisant." ");	
	}	
	
	if ($_GET['type_modif'] == 'supp'){	
		pg_query ($dbconn, "UPDATE cotisations SET visible='false' WHERE id_personne=".$id_cotisant." AND id=".$id_cotisation);
		$_GET['type_modif'] = $_GET['type_modif'] . "_cotis=" .$id_cotisation;
		maj_personne_cotisation($dbconn, $id_cotisant) ;
	}
	
	if ($_GET['type_modif'] == 'ajout'){	
		if(isset($_POST["new_annee"]) && isset($_POST["new_valeur"]) && isset($_POST["new_id_type_paiement"])) {				
			$result = pg_query ($dbconn, "INSERT INTO cotisations (id_personne, annee, id_type_paiement, revue, valeur, visible) 
										  VALUES ('".$new_id_cotisant ."', '".$new_annee."', '".$new_id_type_paiement."', '".$new_revue."', '".$new_valeur."', 'true') RETURNING id");
			$insert_row = pg_fetch_row($result);
			$id_cotis = $insert_row[0];
			$_GET['type_modif'] = $_GET['type_modif'] . "_cotis=" .$id_cotis;
			maj_personne_cotisation($dbconn, $new_id_cotisant) ;
		}	
	}
	if ($_GET['type_modif'] == 'modif'){	
		pg_query ($dbconn, "UPDATE cotisations SET  annee='".$new_annee."', id_type_paiement='".$new_id_type_paiement."', revue='".$new_revue."', valeur='".$new_valeur."'
						    WHERE id_personne=".$id_cotisant." AND id=".$modif_id_cotisation);
		$_GET['type_modif'] = $_GET['type_modif'] . "_cotis=" .$modif_id_cotisation;
		maj_personne_cotisation($dbconn, $id_cotisant) ;
	}

	pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
				        VALUES ('".$_SESSION['login']."', '".$_GET['type_modif']."', 'cotisations', '". $today ."' ,  now()  , '". $id_cotisant ."' )");	
}	

echo "<script language='javascript' type='text/javascript'> window.location.replace('gestion_cotisations_personne.php?id_cotisant=".$id_cotisant."');	</script>";


/* mise à jour de la cotisation au niveau de la personne */
function maj_personne_cotisation($dbconn, $id_personne) 
{ 	
	$annee = "";
	$result_max_annee_coti = pg_query("SELECT max (annee)
		FROM cotisations
		WHERE id_personne =  $id_personne
		and visible = true");
	$row_max_annee_coti = pg_fetch_row($result_max_annee_coti);
	$annee = $row_max_annee_coti[0];
	pg_query ($dbconn, "UPDATE personne SET dernier_paiement='".$annee."' WHERE id = ".$id_personne. " "); 		
}	


?>
