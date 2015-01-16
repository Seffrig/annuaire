<?php
// ouverture de  la session
session_start(); 

//connection à la base
include("commun/connexion_db.php");
?> 

<?php

	// test si la variable existe 
	if (isset($_SESSION['login']))
	{ 
		// variable initialisée
		$login = $_SESSION['login']; 
		
		$result_utilisateur = pg_query($dbconn, "SELECT login, pass, id_type, id_personne FROM utilisateur where lower(login)=lower('$login')");

		if (pg_num_rows($result_utilisateur) == 0) 
		{  
			header('Location: ./erreur.php?erreur=intru');       
		}
		
		// enregistrement de la session
		session_register("authentification"); 
		
		while ($row_utilisateur = pg_fetch_row($result_utilisateur))
		{	
			$id_type = $row_utilisateur[2];
			
			$_SESSION['id_personne'] = $row_utilisateur[3];
			$_SESSION['login'] = $login; 						
			$_SESSION['type_user'] = $id_type;  			
			
			// récupère les droits des utilisateurs 
			$result_droit=pg_query("SELECT page_accueil, modif_corps, modif_pays, modif_personne, modif_etablissement, modif_publication, recherche, bibliographie,
									gestion_cotisation, informations_personnelles, these, reinit_pass, modif_ville, modif_recherche FROM type_user WHERE id = $id_type ");
			$infos_droit= pg_fetch_row($result_droit);
			
			$_SESSION['page_accueil']=$infos_droit[0];
			$_SESSION['modif_corps'] = $infos_droit[1]; 
			$_SESSION['modif_pays'] = $infos_droit[2]; 
			$_SESSION['modif_personne'] = $infos_droit[3]; 
			$_SESSION['modif_etablissement'] = $infos_droit[4]; 
			$_SESSION['modif_publication'] = $infos_droit[5]; 
			$_SESSION['recherche'] = $infos_droit[6]; 		
			$_SESSION['bibliographie'] = $infos_droit[7]; 		
			$_SESSION['gestion_cotisation'] = $infos_droit[8]; 		
			$_SESSION['informations_personnelles'] = $infos_droit[9]; 			
			$_SESSION['these'] = $infos_droit[10]; 		
			$_SESSION['reinit_pass'] = $infos_droit[11]; 
			$_SESSION['modif_ville'] = $infos_droit[12]; 				
			$_SESSION['modif_recherche'] = $infos_droit[13]; 		
						
			/* Charge dans le navigateur la page définie dans le paramètre page  sans l'enregistrer dans l'historique. */
			echo "<script language='javascript' type='text/javascript'> window.location.replace('".$_SESSION['page_accueil']."');	</script>";

		}
	}
	else
	{
		// redirection si utilisateur non reconnu
		session_unset("authentification");
		header('Location: ./erreur.php?erreur=intru');    
	}
		
?>

