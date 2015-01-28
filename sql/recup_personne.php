<?php
 // utilisable pour la lecteur de personne  et la modification

$id_personne=$_SESSION['id_personne'];

if ($id_personne != 0) 
{	
	$result_personne = pg_query("SELECT  id,  id_titre,  nom,  prenom,  id_corps,  localite_perso,  	
								complement_perso,  id_type_personne,  nom_rue_perso,  
								debut_coti,  courriel_perso,  courriel_pro,  	tel_perso,  
								tel_pro,  date_suppression,  code_postal_pro,  localite_pro,  
								nom_rue_pro,  complement_pro,  code_postal_perso,  	
								num_rue_pro,  num_rue_perso,  dernier_paiement,  id_pays_pro,  	
								id_pays_perso,  revue,  courrier,  abonnement_revue,  	
								commentaire,  id_etabl_princ,  	id_etabl_sec,  id_equipe_princ,  	
								visible,  visible_email_perso,  page_pro
								FROM personne 
								WHERE id='". $id_personne ."'				
								");	
		
	while ($personne = pg_fetch_row($result_personne)) 
	{ 
		$id = $personne[0];
		$id_titre = $personne[1];
		$nom = $personne[2];
		$prenom = $personne[3];
		$id_corps = $personne[4];
		$localite_perso = $personne[5];

		$complement_perso = $personne[6];
  		$id_type_personne = $personne[7];
  		$nom_rue_perso = $personne[8];
		$debut_coti = $personne[9];
  		$courriel_perso = $personne[10];

  		$courriel_pro = $personne[11];
  		$tel_perso = $personne[12];
		$tel_pro = $personne[13];
  		$date_suppression = $personne[14];
  		$code_postal_pro = $personne[15];

  		$localite_pro = $personne[16];
		$nom_rue_pro = $personne[17];
  		$complement_pro = $personne[18];
  		$code_postal_perso = $personne[19];
		$num_rue_pro = $personne[20];

  		$num_rue_perso = $personne[21];
  		$dernier_paiement = $personne[22];
  		$id_pays_pro = $personne[23];
		$id_pays_perso = $personne[24];
  		$revue = $personne[25];
  		
  		$courrier = $personne[26];
  		$abonnement_revue = $personne[27];
		$commentaire = $personne[28];
  		$id_etabl_princ = $personne[29];
  		$id_etabl_sec = $personne[30];

  		$id_equipe_princ = $personne[31];
		$visible = $personne[32];
  		$visible_email_perso = $personne[33];
  		$page_pro = $personne[34];

		// date de suppresion (sert pour savoir quand supprimé), visible par rapprot à bd
		
		// récupération du libellé du corps	
		$result_corps = pg_query("SELECT libelle FROM corps WHERE id='".$id_corps."'");			
		$libelle_corps = ""; 
		$libelle_pays_pro = ""; 
		$libelle_pays_perso = ""; 
		$id_etabl_principal = ""; 
		$nom_etabl_principal = ""; 
		$ville_etabl_principal = ""; 
		$id_etabl_secondaire = ""; 
		$nom_etabl_secondaire = ""; 
		$ville_etabl_secondaire = ""; 
		$id_equipe_princ = "";
		$num_equipe_princ = ""; 
		$accronyme_equipe_princ = ""; 
		$libelle_type_personne = ""; 

		while ($row_corps = pg_fetch_row($result_corps))
		{	
			$libelle_corps = $row_corps[0];
		}
		
		// récupération du libellé du pays professionnel
		$result_libelle_pays_pro = pg_query("SELECT libelle FROM pays WHERE id='".$id_pays_pro."'");			
		while ($row_libelle_pays_pro = pg_fetch_row($result_libelle_pays_pro))
		{	
			$libelle_pays_pro = $row_libelle_pays_pro[0];
		}
		
		// récupération du libellé du pays personnel
		$result_libelle_pays_perso = pg_query("SELECT libelle FROM pays WHERE id='".$id_pays_perso."'");			
		while ($row_libelle_pays_perso = pg_fetch_row($result_libelle_pays_perso))
		{	
			$libelle_pays_perso = $row_libelle_pays_perso[0];
		}
		
		// récupération du libellé établissement principal et nom de la ville
		$result_nom_ville_etabl_principal = pg_query("SELECT etab.id, etab.nom, v.libelle FROM etablissement etab, ville v WHERE etab.id='".$id_etabl_princ."' and etab.id_ville = v.id");		
		while ($row_nom_ville_etabl_principal = pg_fetch_row($result_nom_ville_etabl_principal))
		{	
			$id_etabl_principal = $row_nom_ville_etabl_principal[0];
			$nom_etabl_principal = $row_nom_ville_etabl_principal[1];
			$ville_etabl_principal = $row_nom_ville_etabl_principal[2];
		}
		
		// récupération du libellé établissement secondaire et nom de la ville
		if ($id_etabl_sec != '')
		{
			$result_nom_ville_etabl_secondaire = pg_query("SELECT etab.id, etab.nom, v.libelle FROM etablissement etab, ville v WHERE etab.id='".$id_etabl_sec."' and etab.id_ville = v.id");		
			while ($row_nom_ville_etabl_secondaire = pg_fetch_row($result_nom_ville_etabl_secondaire))
			{	
				$id_etabl_secondaire = $row_nom_ville_etabl_secondaire[0];
				$nom_etabl_secondaire = $row_nom_ville_etabl_secondaire[1];
				$ville_etabl_secondaire = $row_nom_ville_etabl_secondaire[2];
			}
		}
		
		// récupération du libellé equipe de recherche
		if ($id_equipe_princ != '')
		{
			$result_equipe_rech_principal = pg_query("SELECT rech.id, rech.num_equipe, rech.accronyme FROM recherche rech, ville v WHERE rech.id='".$id_equipe_princ."'");		
			while ($row_equipe_rech_principal = pg_fetch_row($result_equipe_rech_principal))
			{	
				$id_equipe_princ = $row_equipe_rech_principal[0];
				$num_equipe_princ = $row_equipe_rech_principal[1];
				$accronyme_equipe_princ = $row_equipe_rech_principal[2];
			}
		}
		
		$result_type_personne = pg_query("SELECT libelle FROM type_personne WHERE id='".$id_type_personne."'");			
		while ($row_type_personne = pg_fetch_row($result_type_personne))
		{	
			$libelle_type_personne = $row_type_personne[0];
		}
		
	}
}

?>