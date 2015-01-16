<?php
 // utilisable pour la lecteur de personne  et la modification

$id_personne=$_SESSION['id_personne'];

if ($id_personne != 0) 
{	
	$result_personne = pg_query("SELECT  id, id_titre, nom, prenom, id_corps,
										code_postal_pro, localite_pro, num_rue_pro, nom_rue_pro, complement_pro, 
										code_postal_perso, localite_perso, num_rue_perso, nom_rue_perso, complement_perso,
										tel_pro, tel_perso, courriel_pro, courriel_perso, revue,
										courrier ,id_pays_pro, id_pays_perso, commentaire, id_etabl_princ, id_etabl_sec, id_equipe_princ,
										dernier_paiement, id_type_personne, abonnement_revue, debut_coti, visible_email_perso, page_pro
								FROM personne 
								WHERE id='". $id_personne ."'				
								");	
		
	while ($personne = pg_fetch_row($result_personne)) 
	{ 
		$id_personne=$personne[0];
		$id_titre=$personne[1];
		$nom=$personne[2];
		$prenom=$personne[3];
		$id_corps=$personne[4];	
		$code_postal_pro=$personne[5];
		$localite_pro=$personne[6];
		$num_rue_pro=$personne[7];
		$nom_rue_pro=$personne[8];
		$complement_pro=$personne[9];	
		$code_postal_perso=$personne[10];
		$localite_perso=$personne[11];
		$num_rue_perso=$personne[12];
		$nom_rue_perso=$personne[13];
		$complement_perso=$personne[14];
		$tel_pro=$personne[15];
		$tel_perso=$personne[16];
		$courriel_pro=$personne[17];
		$courriel_perso=$personne[18];
		$revue=$personne[19];
		$courrier=$personne[20];
		$id_pays_pro=$personne[21];
		$id_pays_perso=$personne[22];
		$commentaire=$personne[23];
		$id_etabl_princ=$personne[24];
		$id_etabl_sec=$personne[25];
		$id_equipe_princ=$personne[26];
		$dernier_paiement=$personne[27];
		$id_type_personne=$personne[28];
		$abonnement_revue=$personne[29];
		$date_debut_coti=$personne[30];
		$visible_email_perso=$personne[31];
		$page_pro=$personne[32];
		
		// date de suppresion (sert pour savoir quand supprimé), visible par rapprot à bd
		
		// récupération du libellé du corps	
		$result_corps = pg_query("SELECT libelle FROM corps WHERE id='".$id_corps."'");			
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