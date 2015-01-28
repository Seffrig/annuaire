<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Modification de la bibliographie</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout bibliographie">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout bibliographie">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
$old_id_personne="";
$old_titre_communication="";
$old_titre_journal="";
$old_auteur_sec="";
$old_revue_volume="";
$old_revue_fascicule="";
$old_titre_ouvrage="";
$old_editeur="";
$old_editeur_ville="";
$old_collection="";
$old_url="";
$old_page_deb="";
$old_page_fin="";
$old_nb_pages="";
$old_date_conf="";
$old_date_publi="";
$old_id_pays_conf="";
$old_id_langue="";
$old_audience="";
$old_etablissement="";
$old_directeur="";
$old_id_type_these="";
$old_observation="";
$old_selectionner_ordre="";

?>

<?php
	$id_type_publi='';
	$id_publi='';
	// ajout 
	if ($_GET['type_modif'] == 'ajout')
	{
		$id_type_publi = $_POST['id_type_publi']; 
		echo "<h1> 	Ajout d'une publication	 </h1>";
		echo "<form action='script_bibliographie.php?type_modif=ajout' onsubmit='return check_valider_bibliographie()' name='form_bibliographie' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{	
		$id_type_publi = $_GET['id_type_publi'];
		$id_publi = $_GET['id_publi'];

		echo "<h1> 	Modification d'une publication	 </h1>";
		echo "<form action='script_bibliographie.php?type_modif=modif' onsubmit='return check_valider_bibliographie()' name='form_bibliographie' method='post'  >";
		
		$result_publication = pg_query("SELECT  id, id_personne, id_type, titre_communication, titre_journal, auteur_sec , revue_volume, revue_fascicule, titre_ouvrage, editeur, editeur_ville,
											collection, url, page_deb, page_fin, nb_pages, date_conf, date_publi, id_pays_conf, id_langue, audience, etablissement, directeur, id_type_these, 
											visible, observation, selectionner_ordre
										FROM publication 
										WHERE id = ". $id_publi ."
										AND visible = 'true'  ");	
		
		$row_publications = pg_fetch_row($result_publication);
		// on stock les informations de la publication enregistrée
		$old_id_personne = $row_publications[1];
		$old_titre_communication = $row_publications[3];
		$old_titre_journal = $row_publications[4];
		$old_auteur_sec = $row_publications[5];
		$old_revue_volume = $row_publications[6];
		$old_revue_fascicule = $row_publications[7];
		$old_titre_ouvrage = $row_publications[8];
		$old_editeur = $row_publications[9];
		$old_editeur_ville = $row_publications[10];
		$old_collection = $row_publications[11];
		$old_url = $row_publications[12];
		$old_page_deb = $row_publications[13];
		$old_page_fin = $row_publications[14];
		$old_nb_pages = $row_publications[15];
		$old_date_conf = $row_publications[16];
		$old_date_publi = $row_publications[17];
		$old_id_pays_conf = $row_publications[18];
		$old_id_langue = $row_publications[19];
		$old_audience = $row_publications[20];
		$old_etablissement = $row_publications[21];
		$old_directeur = $row_publications[22];
		$old_id_type_these = $row_publications[23];
		$old_observation = $row_publications[25];		
		$old_selectionner_ordre = $row_publications[26];	
	}
	
	// affichage du type publi
	$result_type_publi = pg_query( "SELECT libelle
										FROM type_publication 
										WHERE  id = " . $id_type_publi ."  ");	
	$row_type_publi = pg_fetch_row($result_type_publi); 
	$libelle_type_publi = $row_type_publi[0];
	
	// recupère ce que l'on doit afficher suivant le type de publication 	
	$result_affichage_publi = pg_query(
		"SELECT id_type, visible_titre_communication, ordre_titre_communication, libelle_titre_communication, visible_titre_journal, ordre_titre_journal, libelle_titre_journal, visible_auteur_sec, ordre_auteur_sec, libelle_auteur_sec, 
				visible_revue_volume, ordre_revue_volume, libelle_revue_volume, visible_revue_fascicule, ordre_revue_fascicule, libelle_revue_fascicule, visible_titre_ouvrage, ordre_titre_ouvrage, libelle_titre_ouvrage, 
				visible_editeur, ordre_editeur, libelle_editeur, visible_editeur_ville, ordre_editeur_ville, libelle_editeur_ville, visible_collection, ordre_collection, libelle_collection, visible_url, ordre_url, libelle_url, 
				visible_page_deb, ordre_page_deb, libelle_page_deb, visible_page_fin, ordre_page_fin, libelle_page_fin, visible_nb_pages, ordre_nb_pages, libelle_nb_pages, visible_date_conf, ordre_date_conf, libelle_date_conf, 
				visible_date_publi, ordre_date_publi, libelle_date_publi, visible_id_pays_conf, ordre_id_pays_conf, libelle_id_pays_conf, visible_id_langue, ordre_id_langue, libelle_id_langue, 
				visible_audience, ordre_audience, libelle_audience, visible_etablissement, ordre_etablissement, libelle_etablissement, visible_directeur, ordre_directeur, libelle_directeur, 
				visible_id_type_these, ordre_id_type_these, libelle_id_type_these, visible_observation, ordre_observation, libelle_observation 
		FROM affichage_publi 
		WHERE  id_type = " . $id_type_publi . " ");
	
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
		
		$nbr_champs=67; // ne sert  a rien

		?> 
		<fieldset>
		<input  name="id_type_publi" type="HIDDEN" value=<?php echo $id_type_publi; ?> id="id_type_publi" />
		<input  name="id_publi" type="HIDDEN" value=<?php echo $id_publi; ?> id="id_publi" />	
		
		<br/><label for="libelle_type_publi">Type de publication </label>
		<input type="text" name="libelle_type_publi" size="50" value="<?php echo $libelle_type_publi; ?>" id="libelle_type_publi" readonly="readonly" />	<br/>
		</fieldset>
		
		<?php	
		
		$ordre_max = 0;
		for ($i=2; $i< count($droit_affichage_publi); $i=$i+3) 
		{
			if ($ordre_max < $droit_affichage_publi[$i]) 
				{ 
					$ordre_max = $droit_affichage_publi[$i];
				}
		}
		for ($i=1; $i <= $ordre_max; $i++) 
		{ 
		
			if ($ordre_titre_communication == $i && $visible_titre_communication) 
			{ 
				echo ' 	<fieldset><br><label for="titre_communication">' . $libelle_titre_communication . ' </label>'; 
				echo ' <TEXTAREA name="titre_communication" rows=2 COLS=49 maxlength="300 "> ';
							if ($old_titre_communication != '') { echo stripslashes($old_titre_communication); }
				echo '</TEXTAREA><br></fieldset>';
			}
			
			if ($ordre_titre_journal == $i && $visible_titre_journal) 
			{
				echo '<fieldset><br><label for="titre_journal">' . $libelle_titre_journal . ' </label>';
				echo '<input type="text" '; 
						if ($old_titre_journal != ''){echo 'value = "' . $old_titre_journal . '"';} 
				echo 'size="50" maxlength="300" name="titre_journal" id="titre_journal" /><br></fieldset>';
			}
			
			if ($ordre_auteur_sec == $i && $visible_auteur_sec) 
			{
				echo '<fieldset><br><label for="auteur_sec">' . $libelle_auteur_sec . ' </label>';
				echo '<input type="text" '; 
						if ($old_auteur_sec != ''){echo 'value = "' . $old_auteur_sec . '"';} 
				echo 'size="50" maxlength="200 "name="auteur_sec" id="auteur_sec" /><br></fieldset>';
			}
			
			if ($ordre_revue_volume == $i && $visible_revue_volume) 			
			{
				echo '<fieldset><br><label for="revue_volume">' . $libelle_revue_volume . ' </label>';
				echo '<input type="text" '; 
						if ($old_revue_volume != ''){echo 'value = "' . $old_revue_volume . '"';} 
				echo 'size="50" maxlength="200 "name="revue_volume" id="revue_volume" /><br></fieldset>';
			}
			
			if ($ordre_revue_fascicule == $i && $visible_revue_fascicule) 
			{
				echo '<fieldset><br><label for="revue_fascicule">' . $libelle_revue_fascicule . ' </label>';
				echo '<input type="text" '; 
						if ($old_revue_fascicule != ''){echo 'value = "' . $old_revue_fascicule . '"';}
				echo 'size="50" maxlength="200 "name="revue_fascicule" id="revue_fascicule" /><br></fieldset>';
			}
			
			if ($ordre_titre_ouvrage == $i && $visible_titre_ouvrage) 
			{
				echo '<fieldset><br><label for="titre_ouvrage">' . $libelle_titre_ouvrage . ' </label>';
				echo '<input type="text" '; 
						if ($old_titre_ouvrage != ''){echo 'value = "' . $old_titre_ouvrage . '"';}
				echo 'size="50" maxlength="300 "name="titre_ouvrage" id="titre_ouvrage" /><br></fieldset>';
			}
			
			if ($ordre_editeur == $i && $visible_editeur) 
			{
				echo '<fieldset><br><label for="editeur">' . $libelle_editeur . ' </label>';
				echo '<input type="text" '; 
						if ($old_editeur != ''){echo 'value = "' . $old_editeur . '"';} 
				echo 'size="50" maxlength="200 "name="editeur" id="editeur" /><br></fieldset>';
			}
			
			if ($ordre_editeur_ville == $i && $visible_editeur_ville)
			{
				echo '<fieldset><br><label for="editeur_ville">' . $libelle_editeur_ville . ' </label>';
				echo '<input type="text" '; 
						if ($old_editeur_ville != ''){echo 'value = "' . $old_editeur_ville . '"';}
				echo 'size="50" maxlength="200 "name="editeur_ville" id="editeur_ville" /><br></fieldset>';
			}
			
			if ($ordre_collection == $i && $visible_collection) 
			{
				echo '<fieldset><br><label for="collection">' . $libelle_collection . ' </label>';
				echo '<input type="text" '; 
						if ($old_collection != ''){echo 'value = "' . $old_collection . '"';}
				echo 'size="50" maxlength="200 "name="collection" id="collection" /><br></fieldset>';
			}
			
			if ($ordre_url == $i && $visible_url) 
			{
				echo '<fieldset><br><label for="url">' . $libelle_url . ' </label>';
				echo '<input type="text" '; 
						if ($old_url != ''){echo 'value = "' . $old_url . '"';}
				echo 'size="50" maxlength="200 "name="url" id="url" /><br>Ex: http://ista.univ-fcomte.fr/lien.pdf<br></fieldset>';
			}
			
			if ($ordre_page_deb == $i && $visible_page_deb) 
			{
				echo '<fieldset><br><label style="width: 150px;" for="page_deb">' . $libelle_page_deb . ' </label>';
				echo '<input type="text" '; 
						if ($old_page_deb != ''){echo 'value = "' . $old_page_deb . '"';} 
				echo 'size="10" maxlength="20 "name="page_deb" id="page_deb" /><br></fieldset>';
			}
			if ($ordre_page_fin == $i && $visible_page_fin) 
			{
				echo '<fieldset><br><label style="width: 150px;" for="page_fin">' . $libelle_page_fin . ' </label>';
				echo '<input type="text" '; 
						if ($old_page_fin != ''){echo 'value = "' . $old_page_fin . '"';} 
				echo 'size="10" maxlength="20 "name="page_fin" id="page_fin" /><br></fieldset>';
			}
			if ($ordre_nb_pages == $i && $visible_nb_pages) 
			{
				echo '<fieldset><br><label style="width: 150px;"  for="nb_pages">' . $libelle_nb_pages . ' </label>';
				echo '<input type="text" '; 
						if ($old_nb_pages != ''){echo 'value = "' . $old_nb_pages . '"';}
				echo 'size="10" maxlength="20 "name="nb_pages" id="nb_pages" /><br></fieldset>';
			}
			
			if ($ordre_date_conf == $i && $visible_date_conf) 
			{
				echo '<fieldset><br><label style="width: 150px;" for="date_conf">' . $libelle_date_conf . ' </label>';
				echo '<input type="text" onkeypress="chiffres(event)"'; 
						if ($old_date_conf != ''){echo 'value = "' . $old_date_conf . '"';}
				echo 'size="10" maxlength="4 "name="date_conf" id="date_conf" /><br></fieldset>';
			}
			if ($ordre_date_publi == $i && $visible_date_publi)
			{
				echo '<fieldset><br><label style="width: 150px;"for="date_publi">' . $libelle_date_publi . ' </label>';
				echo '<input type="text" onkeypress="chiffres(event)"'; 
						if ($old_date_publi != ''){echo 'value = "' . $old_date_publi . '"';}
				echo 'size="10" maxlength="4 "name="date_publi" id="date_publi" /><br></fieldset><br>';
			}
			
			if ($ordre_id_pays_conf == $i && $visible_id_pays_conf) 
			{
				echo"<fieldset ><br>";select_ordre($libelle_id_pays_conf , 'id_pays_conf','pays', 'libelle', $old_id_pays_conf); echo"<br></fieldset>";
			}

			if ($ordre_id_langue == $i && $visible_id_langue) 
			{ 
				echo"<fieldset>";select_ordre($libelle_id_langue, 'id_langue','langue', 'libelle', $old_id_langue); echo"</fieldset>";
			}
			
			/*if ($ordre_audience == $i && $visible_audience) 
			{
				echo '<fieldset><br><label for="audience">' . $libelle_audience . ' </label>';
				echo '<input type="text" '; 
						if ($old_audience != ''){echo 'value = "' . $old_audience . '"';}
				echo 'size="50" maxlength="200 "name="audience" id="audience" /><br></fieldset>';
			}*/
			
			if ($ordre_etablissement == $i && $visible_etablissement)
			{
				echo '<fieldset><br><label for="etablissement">' . $libelle_etablissement . ' </label>';
				echo '<input type="text" '; 
						if ($old_etablissement != ''){echo 'value = "' . $old_etablissement . '"';}
				echo 'size="50" maxlength="200 "name="etablissement" id="etablissement" /><br></fieldset>';
			}
			
			if ($ordre_directeur == $i && $visible_directeur) 
			{
				echo '<fieldset><br><label for="directeur">' . $libelle_directeur . ' </label>';
				echo '<input type="text" '; 
						if ($old_directeur != ''){echo 'value = "' . $old_directeur . '"';}
				echo 'size="50" maxlength="200 "name="directeur" id="directeur" /><br></fieldset>';
			}
			
			if ($ordre_id_type_these == $i && $visible_id_type_these) 
			{ 
				echo"<fieldset><br>";select_simple($libelle_id_type_these, 'id','type_these', 'libelle', $old_id_type_these); echo"<br></fieldset>";
			}
			
			if ($ordre_observation == $i && $visible_observation) 
			{ 
				echo '<fieldset><br><label for="observation">' . $libelle_observation . ' </label>'; 
				echo ' <TEXTAREA name="observation" rows=4 COLS=60 maxlength="300 "> ';
							if ($old_observation != '') { echo stripslashes($old_observation); }
				echo '</TEXTAREA><br></fieldset><br>';
			}				
		}

		echo '<input type="checkbox" name="selectionner_ordre" id="selectionner_ordre" '; 
			if ($old_selectionner_ordre=="1"){echo "CHECKED";} 
		echo "> Choisir pour figurer dans l'annuaire";
	}
	echo '<input  name="id_type_publi" id="id_type_publi" type="HIDDEN" value='.$id_type_publi.'  />';
	echo '<input  name="id_publi" id="id_publi" type="HIDDEN" value='.$id_publi.'  />';
?>
	<br/>
	<br/>
	<input type="submit" value="Valider"/>
	<a href='bibliographie.php'><input class='button' type='button' value='Cancel'><cancel>&nbsp;Cancel</cancel></a>
</form>	
<br>	

	
<?php
	include "templates/footer.php";
?>

