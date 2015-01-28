<?php

//affichage publications
function affichage_publications($id_personne, $nb_publications_afficher) 
{
	if ($id_personne==''){$id_personne=0;}
	?>
	<div class="panel panel-info">
	<div class="panel-heading">
		<h2 class="panel-title">Mes références bibliographiques </h2>	
	</div>
	<div class="panel-body">
	<?php

	$nb_publications_sql = pg_query("SELECT count(id) FROM publication WHERE id_personne=". $id_personne ." AND id_type > 0 AND visible=true");
	$nb_publications_row = pg_fetch_row($nb_publications_sql);
	$nb_publications_total = $nb_publications_row[0];
	
	// nombre de publications choisi
	$nb_publications_sql_select = pg_query("SELECT count(id) FROM publication WHERE id_personne=". $id_personne ." AND id_type > 0 AND visible=true AND selectionner_ordre=1");
	$nb_publications_row_select = pg_fetch_row($nb_publications_sql_select);
	$nb_publications_total_select = $nb_publications_row_select[0];
	
	echo "<p> vous avez choisi <b>". $nb_publications_total_select . "</b> publications pour l'annuaire papier.<p></br>";
	
	// récupération de la thèse (pub.id_type = 0 )
	$requete_rech_publi = "SELECT  pub.id, pub.id_personne, t_pub.id, t_pub.libelle, pub.titre_communication, pub.titre_journal, pub.auteur_sec, pub.revue_volume, pub.revue_fascicule, 
								pub.titre_ouvrage, pub.editeur, pub.editeur_ville, pub.collection, pub.url, pub.page_deb, pub.page_fin, pub.nb_pages, pub.date_conf, pub.date_publi, 
								pa.libelle, l.libelle, pub.audience, pub.etablissement, pub.directeur, t_these.libelle, pub.observation, pub.selectionner_ordre
						FROM publication pub
							LEFT OUTER JOIN type_publication t_pub
								ON pub.id_type = t_pub.id
							LEFT OUTER JOIN pays pa
								ON pub.id_pays_conf = pa.id
							LEFT OUTER JOIN langue l
								ON pub.id_langue = l.id
							LEFT OUTER JOIN type_these t_these
								ON pub.id_type_these = t_these.id

						WHERE pub.id_personne= " . $id_personne . "
							AND pub.id_type > 0 
							AND visible = 'true'
						ORDER BY pub.date_publi DESC, date_conf DESC, pub.id DESC
						LIMIT ".$nb_publications_afficher."";

	$result_rech_publi = pg_query($requete_rech_publi);	
	
	while ($rech_publi = pg_fetch_row($result_rech_publi)) 
	{	
		$champ_precedent_vide = true;
		echo '<p>';
		
		$id_publi = $rech_publi[0];
		$id_personne_publi = $rech_publi[1];
		$id_type_publi = $rech_publi[2];
		$type_publi_publi = $rech_publi[3];
		$titre_communication_publi = $rech_publi[4];
		$titre_journal_publi = $rech_publi[5];
		$auteur_sec_publi = $rech_publi[6];
		$revue_volume_publi = $rech_publi[7];
		$revue_fascicule_publi = $rech_publi[8];
		$titre_ouvrage_publi = $rech_publi[9];
		$editeur_publi = $rech_publi[10];
		$editeur_ville_publi = $rech_publi[11];
		$collection_publi = $rech_publi[12];
		$url_publi = $rech_publi[13];
		$page_deb_publi = $rech_publi[14];
		$page_fin_publi = $rech_publi[15];
		$nb_pages_publi = $rech_publi[16];
		$date_conf_publi = $rech_publi[17];
		$date_publi_publi = $rech_publi[18];
		$pays_conf_libelle_publi = $rech_publi[19];
		$langue_libelle_publi = $rech_publi[20];
		$audience_publi = $rech_publi[21];
		$etablissement_publi = $rech_publi[22];
		$directeur_publi = $rech_publi[23];
		$type_publi_libelle_publi = $rech_publi[24];
		$observation_publi = $rech_publi[25];
		$selectionner_ordre = $rech_publi[26];
		
		// traitement sur variable
		$id_publi = trim ( $id_publi );
		$id_personne_publi = trim (	$id_personne_publi );
		$id_type_publi = trim ( $id_type_publi );
		$type_publi_publi = trim ( $type_publi_publi );
		$titre_communication_publi = trim ( $titre_communication_publi );
		$titre_journal_publi = trim ( $titre_journal_publi );
		$auteur_sec_publi = trim ( $auteur_sec_publi );
		$revue_volume_publi = trim ( $revue_volume_publi );
		$revue_fascicule_publi = trim ( $revue_fascicule_publi );
		$titre_ouvrage_publi = trim ( $titre_ouvrage_publi );
		$editeur_publi = trim ( $editeur_publi );
		$editeur_ville_publi = trim ( $editeur_ville_publi );
		$collection_publi = trim ( $collection_publi );
		$url_publi = trim ( $url_publi );
		$page_deb_publi = trim ( $page_deb_publi );
		$page_fin_publi = trim ( $page_fin_publi );
		$nb_pages_publi = trim ( $nb_pages_publi );
		$date_conf_publi = trim ( $date_conf_publi );
		$date_publi_publi = trim ( $date_publi_publi );
		$pays_conf_libelle_publi = trim ( $pays_conf_libelle_publi );
		$langue_libelle_publi =trim ( $langue_libelle_publi );
		$audience_publi = trim ( $audience_publi );
		$etablissement_publi = trim ( $etablissement_publi );
		$directeur_publi = trim ( $directeur_publi );
		$type_publi_libelle_publi = trim ( $type_publi_libelle_publi );
		$observation_publi = trim ( $observation_publi );

		echo '<b>'. $type_publi_publi. ' : </b>';

		
		////////////////////////////////////////////////////////////
		//initialise la variable pour définir si c'est le premier champ
		$premier_champ_titre = true;
		// test si plusieurs titre
		$plusieurs_titres = (($titre_communication_publi !='' && ($titre_journal_publi != '' || $titre_ouvrage_publi !='')) || ($titre_journal_publi != '' && $titre_ouvrage_publi !=''));

		///////////////////////////////////////////////////////////
		//requete ordre affichage
		$result_affichage_publi = pg_query(
			"SELECT id_type, visible_titre_communication, ordre_titre_communication, libelle_titre_communication, visible_titre_journal, ordre_titre_journal, libelle_titre_journal, visible_auteur_sec, ordre_auteur_sec, libelle_auteur_sec, 
					visible_revue_volume, ordre_revue_volume, libelle_revue_volume, visible_revue_fascicule, ordre_revue_fascicule, libelle_revue_fascicule, visible_titre_ouvrage, ordre_titre_ouvrage, libelle_titre_ouvrage, 
					visible_editeur, ordre_editeur, libelle_editeur, visible_editeur_ville, ordre_editeur_ville, libelle_editeur_ville, visible_collection, ordre_collection, libelle_collection, visible_url, ordre_url, libelle_url, 
					visible_page_deb, ordre_page_deb, libelle_page_deb, visible_page_fin, ordre_page_fin, libelle_page_fin, visible_nb_pages, ordre_nb_pages, libelle_nb_pages, visible_date_conf, ordre_date_conf, libelle_date_conf, 
					visible_date_publi, ordre_date_publi, libelle_date_publi, visible_id_pays_conf, ordre_id_pays_conf, libelle_id_pays_conf, visible_id_langue, ordre_id_langue, libelle_id_langue, 
					visible_audience, ordre_audience, libelle_audience, visible_etablissement, ordre_etablissement, libelle_etablissement, visible_directeur, ordre_directeur, libelle_directeur, 
					visible_id_type_these, ordre_id_type_these, libelle_id_type_these, visible_observation, ordre_observation, libelle_observation 
			FROM affichage_publi 
			WHERE  id_type = " . $id_type_publi );	
			
							
		while ($droit_affichage_publi = pg_fetch_row($result_affichage_publi)) 
		{			
			$id_type_publi = $droit_affichage_publi[0];
			
			$visible_titre_communication = $droit_affichage_publi[1];
			$ordre_titre_communication = $droit_affichage_publi[2];
			$libelle_titre_communication = $droit_affichage_publi[3];
			
			$visible_titre_journal = $droit_affichage_publi[4];
			$ordre_titre_journal = $droit_affichage_publi[5];
			$libelle_titre_journal = $droit_affichage_publi[6];
			
			$visible_auteur_sec = $droit_affichage_publi[7];
			$ordre_auteur_sec = $droit_affichage_publi[8];
			$libelle_auteur_sec = $droit_affichage_publi[9];
			
			$visible_revue_volume = $droit_affichage_publi[10];
			$ordre_revue_volume = $droit_affichage_publi[11];
			$libelle_revue_volume = $droit_affichage_publi[12];
			
			$visible_revue_fascicule = $droit_affichage_publi[13];
			$ordre_revue_fascicule = $droit_affichage_publi[14];
			$libelle_revue_fascicule = $droit_affichage_publi[15];
			
			$visible_titre_ouvrage = $droit_affichage_publi[16];
			$ordre_titre_ouvrage = $droit_affichage_publi[17];
			$libelle_titre_ouvrage = $droit_affichage_publi[18];
			
			$visible_editeur = $droit_affichage_publi[19];
			$ordre_editeur = $droit_affichage_publi[20];
			$libelle_editeur = $droit_affichage_publi[21];
			
			$visible_editeur_ville = $droit_affichage_publi[22];
			$ordre_editeur_ville = $droit_affichage_publi[23];
			$libelle_editeur_ville = $droit_affichage_publi[24];
			
			$visible_collection = $droit_affichage_publi[25];
			$ordre_collection = $droit_affichage_publi[26];
			$libelle_collection = $droit_affichage_publi[27];
			
			$visible_url = $droit_affichage_publi[28];
			$ordre_url = $droit_affichage_publi[29];
			$libelle_url = $droit_affichage_publi[30];
			
			$visible_page_deb = $droit_affichage_publi[31];
			$ordre_page_deb = $droit_affichage_publi[32];
			$libelle_page_deb = $droit_affichage_publi[33];
			
			$visible_page_fin = $droit_affichage_publi[34];
			$ordre_page_fin = $droit_affichage_publi[35];
			$libelle_page_fin = $droit_affichage_publi[36];
			
			$visible_nb_pages = $droit_affichage_publi[37];
			$ordre_nb_pages = $droit_affichage_publi[38];
			$libelle_nb_pages = $droit_affichage_publi[39];
			
			$visible_date_conf = $droit_affichage_publi[40];	
			$ordre_date_conf = $droit_affichage_publi[41];
			$libelle_date_conf = $droit_affichage_publi[42];
			
			// permet d'afficher uniquement la date de publication si existe et pas celle oral ou de conf
			if (date_publi_publi != "") {$visible_date_conf = false;}	
	
			$visible_date_publi = $droit_affichage_publi[43];
			$ordre_date_publi = $droit_affichage_publi[44];
			$libelle_date_publi = $droit_affichage_publi[45];
			
			$visible_id_pays_conf = $droit_affichage_publi[46];
			$ordre_id_pays_conf = $droit_affichage_publi[47];
			$libelle_id_pays_conf = $droit_affichage_publi[48];
			
			$visible_id_langue = $droit_affichage_publi[49];
			$ordre_id_langue = $droit_affichage_publi[50];
			$libelle_id_langue = $droit_affichage_publi[51];
			
			$visible_audience = $droit_affichage_publi[52];
			$ordre_audience = $droit_affichage_publi[53];
			$libelle_audience = $droit_affichage_publi[54];
			
			$visible_etablissement = $droit_affichage_publi[55];
			$ordre_etablissement = $droit_affichage_publi[56];
			$libelle_etablissement = $droit_affichage_publi[57];
			
			$visible_directeur = $droit_affichage_publi[58];
			$ordre_directeur = $droit_affichage_publi[59];
			$libelle_directeur = $droit_affichage_publi[60];
			
			$visible_id_type_these = $droit_affichage_publi[61];
			$ordre_id_type_these = $droit_affichage_publi[62];
			$libelle_id_type_these = $droit_affichage_publi[63];
			
			$visible_observation = $droit_affichage_publi[64];
			$ordre_observation = $droit_affichage_publi[65];
			$libelle_observation = $droit_affichage_publi[66];
			
			// prend la valeur maximal de l'ordre
			$ordre_max = 0;
			for ($i=2; $i< count($droit_affichage_publi); $i=$i+3) 
			{
				if ($ordre_max < $droit_affichage_publi[$i]) 
					{ 
						$ordre_max = $droit_affichage_publi[$i];
					}
			}
			
			//affichage de la publi
			for ($i=1; $i <= $ordre_max; $i++) 
			{ 
			
				if ($ordre_titre_communication == $i && $visible_titre_communication) 
				{ 	
					if ($titre_communication_publi != '') 
					{
						if (!$plusieurs_titres) {echo "<em>";}
						echo '' . $titre_communication_publi . ' '; 
						if (!$plusieurs_titres) {echo ". </em>";}
						
						$premier_champ_titre = false;
					}
				}
				
				if ($ordre_titre_journal == $i && $visible_titre_journal) 
				{
					if (!$premier_champ_titre && $titre_journal_publi == '') echo ". ";
					if ($titre_journal_publi != '') 
					{ 
						if (!$premier_champ_titre) {echo ", ";}
						echo '<em>' . $titre_journal_publi . '.</em> '; 
						$premier_champ_titre = false;
					}
				}
				
				if ($ordre_auteur_sec == $i && $visible_auteur_sec) 
				{
					if ($auteur_sec_publi != '') { echo ' ' . $auteur_sec_publi . '. '; }
				}
				
				if ($ordre_revue_volume == $i && $visible_revue_volume) 			
				{
					if ($revue_volume_publi != '') { echo ' vol . ' . $revue_volume_publi . ''; }
				}
				
				if ($ordre_revue_fascicule == $i && $visible_revue_fascicule) 
				{
					if ($revue_fascicule_publi != '') 
					{ 
						if ($revue_volume_publi != ''){echo ', ';}
						echo ' fasc. ' . $revue_fascicule_publi . ''; 
					}
					echo '. '; 
				}
				
				if ($ordre_titre_ouvrage == $i && $visible_titre_ouvrage) 
				{
					if (!$premier_champ_titre && $titre_ouvrage_publi == '') echo ". ";
					if ($titre_ouvrage_publi != '') 
					{ 
						if (!$premier_champ_titre) {echo ", ";}
						echo '<em>' . $titre_ouvrage_publi . '.</em> '; 
						$premier_champ_titre = false;
					}
				}
				
				if ($ordre_editeur == $i && $visible_editeur) 
				{
					if ($editeur_publi != '') 
					{ 
						if ($editeur_ville_publi != '') { echo ' : '; }
						echo '' . $editeur_publi; 
					}
					 echo '. '; 
				}
				
				if ($ordre_editeur_ville == $i && $visible_editeur_ville)
				{
					if ($editeur_ville_publi != '') { echo '' . $editeur_ville_publi . ''; }
				}
				
				if ($ordre_collection == $i && $visible_collection) 
				{
					if ($collection_publi != '') { echo '' . $collection_publi . '. '; }
				}
				
				if ($ordre_url == $i && $visible_url) 
				{
					if ($url_publi != '') { echo ' <a href=" ' . $url_publi . '"> Lien Publication </a>'; }
				}
				
				if ($ordre_page_deb == $i && $visible_page_deb) 
				{
					if ($page_deb_publi != '') { echo ' p. ' . $page_deb_publi . ''; }
				}
				if ($ordre_page_fin == $i && $visible_page_fin) 
				{
					if ($page_deb_publi != '') { echo '-'; }
					if ($page_fin_publi != '') { echo '' . $page_fin_publi . '. '; }
				}
				if ($ordre_nb_pages == $i && $visible_nb_pages) 
				{
					if ($nb_pages_publi != '') { echo '' . $nb_pages_publi . ' pages. '; }
				}
				
				if ($ordre_date_conf == $i && $visible_date_conf) 
				{
					if ($date_conf_publi != '') { echo '' . $date_conf_publi . '. '; }
				}
				if ($ordre_date_publi == $i && $visible_date_publi)
				{
					if ($date_publi_publi != '') { echo '' . $date_publi_publi . '. '; }
				}
				
				if ($ordre_id_pays_conf == $i && $visible_id_pays_conf) 
				{
					//communication sans actes
					if ($id_type_publi == 4 ) {echo ' <br> /';}
					if ($pays_conf_libelle_publi != '') { echo '' . $pays_conf_libelle_publi . '. '; }
				}

				if ($ordre_id_langue == $i && $visible_id_langue) 
				{ 
					if ($langue_libelle_publi != '') { echo '<br />' . $langue_libelle_publi . ' '; }
				}
				
				if ($ordre_audience == $i && $visible_audience) 
				{
					if ($audience_publi != '') { echo '' . $audience_publi . '. '; }
				}
				
				if ($ordre_etablissement == $i && $visible_etablissement)
				{
					if ($etablissement_publi != '') { echo '' . $etablissement_publi . ' '; }
				}
				
				if ($ordre_directeur == $i && $visible_directeur) 
				{
					if ($directeur_publi != '') { echo '' . $directeur_publi . ', '; }
				}
				
				if ($ordre_id_type_these == $i && $visible_id_type_these) 
				{ 
					if ($type_publi_libelle_publi != '') { echo '' . $type_publi_libelle_publi . '. '; }
				}
				
				if ($ordre_observation == $i && $visible_observation) 
				{ 
					if ($observation_publi != '') { echo "<br />" . $observation_publi . '. '; }
				}				
			}
			
		}

		//selection
		if ($selectionner_ordre == 1)
		{
			echo " <a href='script_bibliographie.php?type_modif=choisi&id_publi=" . $id_publi . "&ordre=0'><img width='12px' src='images/accepter.png' ></a> -  ";
		}
		else
		{
			echo " <a href='script_bibliographie.php?type_modif=choisi&id_publi=" . $id_publi . "&ordre=1'><img width='12px' src='images/supprimer.png' ></a> -  ";
		}
		
		
		echo " <a href='formulaire_modifier_bibliographie.php?type_modif=modif&id_publi=" . $id_publi . "&id_type_publi=" . $id_type_publi . "'><img width='12px' src='images/button_edit.png' ></a> -  ";
		echo " <a href=\"javascript: if (confirm('Cette suppression est définitive. Confirmez-vous?')) { window.location.href='script_bibliographie.php?type_modif=supp&id_publi=" . $id_publi . "' } else { void('') }; \"> <img width='16px' src='images/croixsupprimer.gif' ></a> ";
		echo " <a href='publication_PDF.php?id_publi=" . $id_publi . "'><img width='12px' src='images/pdf_logo.jpg' ></a> -  ";
		
		if ($selectionner_ordre == 1) {echo 'Choisi';}
		echo '<br><br>';	

		
		echo '</p>';
	}
		
	if ($nb_publications_total > $nb_publications_afficher)
	{
		$nb_publications_afficher = $nb_publications_afficher + 10;
		echo '<a href="bibliographie.php?&nb_publications='. $nb_publications_afficher .'" >Voir les 10 prochaines publications</a><br>';
		
		echo'<br>';
	}
	 
}	
?>
