<?php

//affichage publications
function affichage_theses($id_personne) 
{
	
	if ($id_personne==''){$id_personne=0;}
	?>
	<div class="panel panel-info">
		<div class="panel-heading">
    		<h2 class="panel-title">Mes thèses </h2>
  		</div>
  		<div class="panel-body">

  			<?php
	// récupération de la thèse (pub.id_type = 0 )
	$requete_these = pg_query("SELECT  pub.id, pub.titre_ouvrage, pub.etablissement, pub.directeur, pub.nb_pages, pub.date_publi, 
									pub.date_conf, pub.url, pub.id_pays_conf, pub.id_langue, pub.observation, pub.id_type_these, type.libelle
								FROM publication pub, type_these type
								WHERE  pub.id_personne = ". $id_personne ."
								AND pub.visible='true' 
								AND pub.id_type = 0 
								AND type.id = pub.id_type_these
								ORDER BY pub.date_publi ");	
			

	while ($publi_these = pg_fetch_row($requete_these)) 
	{	
		$id_publi = $publi_these[0];		
		$titre_ouvrage = $publi_these[1];
		$etablissement = $publi_these[2];
		$directeur = $publi_these[3];
		$nb_pages = $publi_these[4];
		$date_publi = $publi_these[5];	
		$date_conf = $publi_these[6];	
		$url = $publi_these[7];	
		$id_pays_conf = $publi_these[8];	
		$id_langue = $publi_these[9];	
		$observation = $publi_these[10];	
		$id_type_these = $publi_these[11];
		$libelle_these = $publi_these[12];
		
		// traitement sur variable
		$id_publi = trim ( $id_publi );
		$titre_ouvrage = trim ( $titre_ouvrage );
		$etablissement = trim ( $etablissement );
		$directeur = trim ( $directeur );
		$nb_pages = trim ( $nb_pages );
		$date_publi = trim ( $date_publi );
		$date_conf = trim ( $date_conf );
		$url = trim ( $url );
		$observation = trim ( $observation );
		
		echo '<p>';
		
		echo "" . $libelle_these . " : " . $titre_ouvrage . ", " . $date_publi . " " ;
		
		
		echo " <a href='formulaire_modifier_these.php?type_modif=modif&id_publi=" . $id_publi . "'><img width='12px' src='images/button_edit.png' ></a> -  ";
		echo " <a href=\"javascript: if (confirm('Cette suppression est définitive. Confirmez-vous?')) { window.location.href='script_these.php?type_modif=supp&id_publi=" . $id_publi . "' } else { void('') }; \"> <img width='16px' src='images/croixsupprimer.gif' ></a> ";

		echo '<br><br>';	
		
		echo '</p>';
		echo '</div>';
		
		
	}	
	echo '</div>';
	echo '</div>';
}	
?>