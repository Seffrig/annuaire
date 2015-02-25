<?php session_start(); ?>


	
<?php
//connection à la base
include("commun/connexion_db.php");
	if(!isset($_GET['type'])){$_GET['type'] ="";};
	$today = date("j-n-Y à H:i:s");   
	$now = time();	

	$id_personne = "";
	$id_titre = "";
	$nom = "";
	$prenom = "";
	$id_corps = "";
	$page_pro = "";
	$code_postal_pro = "";
	$localite_pro = "";
	$num_rue_pro = "";
	$nom_rue_pro = "";
	$complement_pro = "";
	$code_postal_perso = "";
	$localite_perso = "";
	$num_rue_perso = "";
	$nom_rue_perso = "";
	$complement_perso = "";
	$tel_pro = "";
	$tel_perso = "";
	$courriel_pro = "";
	$courriel_perso = "";
	$revue = "";
	$courrier = "";
	$id_pays_pro = "";
	$id_pays_perso = "";
	$commentaire = "";
	$id_etabl_princ = "";
	$id_etabl_sec = ''; // a changer 
	$id_equipe_recherche_princ = "";

	//récup des données
	if (isset($_GET["id_personne"])) $id_personne = $_GET["id_personne"];
	if (isset($_GET["new_titre"])) $id_titre = $_GET["new_titre"];
	if (isset($_GET["new_nom"])) $nom = pg_escape_string($_GET["new_nom"]);
	if (isset($_GET["new_prenom"])) $prenom = pg_escape_string($_GET["new_prenom"]);
	if (isset($_GET["new_id_corps"])) $id_corps = $_GET["new_id_corps"];
	if (isset($_GET["new_page_pro"])) $page_pro = $_GET["new_page_pro"];
	if (isset($_GET["new_code_postal_pro"])) $code_postal_pro = pg_escape_string($_GET["new_code_postal_pro"]);
	if (isset($_GET["new_localite_pro"])) $localite_pro = pg_escape_string($_GET["new_localite_pro"]);
	if (isset($_GET["new_num_rue_pro"])) $num_rue_pro = pg_escape_string($_GET["new_num_rue_pro"]);
	if (isset($_GET["new_nom_rue_pro"])) $nom_rue_pro = pg_escape_string($_GET["new_nom_rue_pro"]);
	if (isset($_GET["new_complement_pro"])) $complement_pro = pg_escape_string($_GET["new_complement_pro"]);
	if (isset($_GET["new_code_postal_perso"])) $code_postal_perso = pg_escape_string($_GET["new_code_postal_perso"]);
	if (isset($_GET["new_localite_perso"])) $localite_perso = pg_escape_string($_GET["new_localite_perso"]);
	if (isset($_GET["new_num_rue_perso"])) $num_rue_perso = pg_escape_string($_GET["new_num_rue_perso"]);
	if (isset($_GET["new_nom_rue_perso"])) $nom_rue_perso = pg_escape_string($_GET["new_nom_rue_perso"]);
	if (isset($_GET["new_complement_perso"])) $complement_perso = pg_escape_string($_GET["new_complement_perso"]);
	if (isset($_GET["new_tel_pro"])) $tel_pro = pg_escape_string($_GET["new_tel_pro"]);
	if (isset($_GET["new_tel_perso"])) $tel_perso = pg_escape_string($_GET["new_tel_perso"]);
	if (isset($_GET["new_courriel_pro"])) $courriel_pro = pg_escape_string($_GET["new_courriel_pro"]);
	if (isset($_GET["new_courriel_perso"])) $courriel_perso = pg_escape_string($_GET["new_courriel_perso"]);
	if (isset($_GET["new_revue"])) $revue = pg_escape_string($_GET["new_revue"]);
	if (isset($_GET["new_courrier"])) $courrier = pg_escape_string($_GET["new_courrier"]);
	if (isset($_GET["new_id_pays_pro"])) $id_pays_pro = $_GET["new_id_pays_pro"];
	if (isset($_GET["new_id_pays_perso"])) $id_pays_perso = $_GET["new_id_pays_perso"];
	if (isset($_GET["new_commentaire"])) $commentaire = pg_escape_string($_GET["new_commentaire"]);
	if (isset($_GET["new_id_etabl_principal"])) $id_etabl_princ = $_GET["new_id_etabl_principal"];
	if (isset($_GET["new_id_equipe_recherche"])) $id_equipe_recherche_princ = $_GET["new_id_equipe_recherche"];
	$var =  $commentaire;


	$visible_email_perso = 'false';
	if (isset($_GET['visible_email_perso'])) 
	{
		$visible_email_perso = 'true';
	}
	
	/*debut_coti date,id_type_personne,dernier_paiement,abonnement_revue*/

	if ($id_pays_pro == ''){$id_pays_pro = 0;}
	if ($id_pays_perso == ''){$id_pays_perso = 0;}
	if ($id_etabl_princ == ''){$id_etabl_princ = 0;}
	if ($id_etabl_sec == ''){$id_etabl_sec = 0;}
	if ($id_equipe_recherche_princ == ''){$id_equipe_recherche_princ = 0;}
	if ($id_corps == ''){$id_corps = 0;}
			
	//test sur les integer qui ne peuvent etre nul
	
	/*$commentaire = pg_escape_string($commentaire);
	$nom = pg_escape_string($nom);
	$prenom = pg_escape_string($prenom);
	$localite_perso = pg_escape_string($localite_perso);
	$localite_pro = pg_escape_string($localite_pro);
	$nom_rue_perso = pg_escape_string($nom_rue_perso);
	$nom_rue_pro = pg_escape_string($nom_rue_pro);
	$complement_perso = pg_escape_string($complement_perso);
	$complement_pro = pg_escape_string($complement_pro);	
*/

	
	if ($_GET['type']=='ajout')
	{			

		// ne fonctionne pas si les integer (les id) sont vide 
		$result = pg_query ($dbconn, "INSERT INTO personne (id_titre, nom, prenom, id_corps, page_pro, 
															code_postal_pro, localite_pro, num_rue_pro, nom_rue_pro, complement_pro, id_pays_pro,
															code_postal_perso, localite_perso, num_rue_perso, nom_rue_perso, complement_perso, id_pays_perso,
															tel_pro, tel_perso, courriel_pro, courriel_perso, visible_email_perso,
															revue, courrier, commentaire, id_etabl_princ, id_etabl_sec, id_equipe_princ,
															id_type_personne, visible
															) 
									VALUES (".$id_titre.", '".$nom."', '".$prenom."', ".$id_corps.", '".$page_pro."',
									'".$code_postal_pro."', '".$localite_pro."', '".$num_rue_pro."', '".$nom_rue_pro."', '".$complement_pro."', ".$id_pays_pro.", 
									'".$code_postal_perso."', '".$localite_perso."', '".$num_rue_perso."', '".$nom_rue_perso."', '".$complement_perso."', ".$id_pays_perso.", 
									'".$tel_pro."', '".$tel_perso."', '".$courriel_pro."', '".$courriel_perso."', ". $visible_email_perso .", '".$revue."', '".$courrier."',  '".$commentaire."'," 
									. $id_etabl_princ .",". $id_etabl_sec ."," . $id_equipe_recherche_princ .",1, true
									) RETURNING id;");
		IF ($result!==false) 
		{
		  $o=pg_fetch_object($result);
		  $id_personne=$o->id;
		  pg_query("UPDATE utilisateur SET  id_personne = ".$id_personne." WHERE login = '".$_SESSION['login']."'");		
		  $_SESSION['id_personne']=$id_personne;
		}
					
		pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
								VALUES ('".$_SESSION['login']."', 'ajout', 'personne','" . $today . "', now()," . $id_personne . ")");

	}
	// modification d'un utilisateur
	else 
	{			
		pg_query ($dbconn, "INSERT INTO historique (login, type, objet, heure, timestamp2, id_objet) 
								VALUES ('".$_SESSION['login']."', 'modif', 'personne','$today',  now(), $id_personne)");	
					
		//on modifie la personne
		pg_query ($dbconn, "UPDATE personne SET id_titre='".$id_titre."',nom='".$nom."', prenom='".$prenom."', id_corps='".$id_corps."', page_pro='".$page_pro."',
														code_postal_pro='".$code_postal_pro."',localite_pro='".$localite_pro."', num_rue_pro='".$num_rue_pro."', 
														nom_rue_pro='".$nom_rue_pro."', complement_pro='".$complement_pro."', id_pays_pro='".$id_pays_pro."', 
														code_postal_perso='".$code_postal_perso."', localite_perso='".$localite_perso."', num_rue_perso='".$num_rue_perso."',
														nom_rue_perso='".$nom_rue_perso."',complement_perso='".$complement_perso."', id_pays_perso='".$id_pays_perso."', 
														tel_pro='".$tel_pro."',tel_perso='".$tel_perso."',courriel_pro='".$courriel_pro."',courriel_perso='".$courriel_perso."', visible_email_perso=".$visible_email_perso.",
														revue='".$revue."',	courrier= '".$courrier."', commentaire='".$commentaire."', id_etabl_princ= '".$id_etabl_princ."', id_etabl_sec= '".$id_etabl_sec."',
														id_equipe_princ= '".$id_equipe_recherche_princ."'
														WHERE id=".$id_personne."");	
	}	
			// $sujet='Inscription';
			// $message="truc s'est inscrit" ;
			// mail($email_comptable,$subject,$message,$headers);  

	echo "<script language='javascript' type='text/javascript'> window.location.replace('compte.php');	</script>";

?>
<script type="text/javascript">
alert("azaz");
alert("<?=$id_equipe_recherche_princ;?>");
</script>