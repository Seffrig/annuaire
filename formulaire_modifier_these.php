<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Modification des thèses</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout these">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout these">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

$page='these';
include("verification_droit.php");	// test si on a les droits sur la page si non deconnexion

include("sql/recup_theses.php");			



$id_personne = $_SESSION['id_personne'];

	// affichage des thèses 
affichage_theses($id_personne);	
	

	$id_publi='';

	$old_id_publi = "";		
	$old_titre_ouvrage = "";
	$old_etablissement = "";
	$old_directeur = "";
	$old_nb_pages = "";
	$old_date_publi = "";	
	$old_date_conf = "";	
	$old_url = "";	
	$old_id_pays_conf = "";	
	$old_id_langue = "";	
	$old_observation = "";	
	$old_id_type_these = "";
	$old_libelle_these = "";
	if (isset($_GET['type_modif'])) 
	{
		// ajout 
		if ($_GET['type_modif'] == 'ajout')
		{
		?>
			<div class="panel panel-info">
			<div class="panel-heading">
    		<h2 class="panel-title">Ajout d'une thèse</h2>
  			</div>
  			<div class="panel-body">
  			<?php
			echo "<form action='script_these.php?type_modif=ajout' onsubmit='return check_valider_these()' name='form_these' method='post'  >";
		}
		// modification
		else if ($_GET['type_modif'] == 'modif')
		{	
			$id_publi = $_GET['id_publi'];

		?>
			<div class="panel panel-info">
			<div class="panel-heading">
    			<h2 class="panel-title">Modification d'une thèse</h2>
  			</div>
  			<div class="panel-body">
  		<?php
			echo "<form action='script_these.php?type_modif=modif' onsubmit='return check_valider_these()' name='form_these' method='post'  >";

			$result_these = pg_query("SELECT  id, titre_ouvrage, etablissement, directeur, nb_pages, date_publi, 
											date_conf, url, id_pays_conf, id_langue, observation, id_type_these
										FROM publication 
										WHERE  id_personne = ".$id_personne."
										AND id = ". $id_publi ."
										AND visible='true' 
										AND id_type = 0 ");	
										
		
			$row_publications_theses = pg_fetch_row($result_these);
			// on stock les informations de la publication enregistrée
		
			$old_id_publi = $row_publications_theses[0];		
			$old_titre_ouvrage = $row_publications_theses[1];
			$old_etablissement = $row_publications_theses[2];
			$old_directeur = $row_publications_theses[3];
			$old_nb_pages = $row_publications_theses[4];
			$old_date_publi = $row_publications_theses[5];	
			$old_date_conf = $row_publications_theses[6];	
			$old_url = $row_publications_theses[7];	
			$old_id_pays_conf = $row_publications_theses[8];	
			$old_id_langue = $row_publications_theses[9];	
			$old_observation = $row_publications_theses[10];	
			$old_id_type_these = $row_publications_theses[11];
			$old_libelle_these = $row_publications_theses[12];
		}

	}
	//echo "la".$old_titre_ouvrage."ic";
	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="titre_ouvrage :">Intitulé de la thèse :</label><br>'; 
	echo ' 		<TEXTAREA name="titre_ouvrage" rows=2 COLS=60 maxlength="300 ">';
				if ($old_titre_ouvrage != ' ') { echo stripslashes($old_titre_ouvrage); }
	echo '</TEXTAREA><br> ';
	echo '</fieldset>';
	
	echo"<fieldset><br>";selection_menu_der('Type de thèse :' , 'id_type_these','type_these', 'libelle', $old_id_type_these,"218px"); echo"<font class='ast'>*</font><br></fieldset>";

	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel"  for="directeur">Directeur de recherche :</label>'; 
	echo '<input type="text" '; 
				if ($old_directeur != ''){echo 'value = "' . $old_directeur . '"';}
	echo 'size="50" maxlength="200" name="directeur" id="directeur" /><br>';
	echo '</fieldset>';		
	
	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="etablissement">Etablissement de soutenance :</label>'; 
	echo '<input type="text" '; 
				if ($old_etablissement != ''){echo 'value = "' . $old_etablissement . '"';}
	echo 'size="50" maxlength="200" name="etablissement" id="etablissement" /><br>';
	echo '</fieldset>';		
	
	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="date_conf">Date de soutenance :<br> (Année)</label>'; 
	echo '<input type="text" onkeypress="chiffres(event)"';  
				if ($old_date_conf != ''){echo 'value = "' . $old_date_conf . '"';}
	echo 'size="50" maxlength="4" name="date_conf" id="date_conf" /><br>';
	echo '</fieldset>';		
			
	
	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="date_publi">Date de publication :<br> (Année)</label>'; 
	echo '<input type="text" onkeypress="chiffres(event)"'; 
				if ($old_date_publi != ''){echo 'value = "' . $old_date_publi . '"';}
	echo 'size="10" maxlength="4" name="date_publi" id="date_publi" /><br>';
	echo '</fieldset>';		

	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="nb_pages">Nombre de pages :</label>'; 
	echo '<input type="text" '; 
				if ($old_nb_pages != ''){echo 'value = "' . $old_nb_pages . '"';}
	echo 'size="10" maxlength="20" name="nb_pages" id="nb_pages" /><br>';
	echo '</fieldset>';				
		
	echo '<fieldset>';
	echo '		<br><label class="tresgrandlabel" for="url">Lien vers le texte intégral :</label>'; 
	echo '<input type="text" '; 
				if ($old_url != ''){echo 'value = "' . $old_url . '"';}
	echo 'size="50" maxlength="200" name="url" id="url" /><br><label class="indication_form" style="margin-left:220px">Ex: http://ista.univ-fcomte.fr/lien.pdf</label><br>';
	echo '</fieldset>';				
	
	echo"<fieldset><br>";select_ordre('Pays de soutenance', 'id_pays_conf','pays', 'libelle', $old_id_pays_conf,"220px"); echo"<font class='ast'>*</font><br></fieldset>";
	echo"<fieldset><br>";select_ordre('Langue du texte intégral', 'id_langue','langue', 'libelle', $old_id_langue,"220px"); echo"<font class='ast'>*</font><br></fieldset>";
	

	echo '<fieldset>';
	echo '		<br><label style="width: 150px;" for="observation">Commentaires</label></br>'; 
	echo ' 		<TEXTAREA name="observation" rows=4 COLS=60 maxlength="300 "> ';
					if ($old_observation != '') { echo stripslashes($old_observation); }
	echo '		</TEXTAREA><br> ';
	echo '</fieldset>';


	echo '<input  name="id_publi" id="id_publi" type="HIDDEN" value='.$id_publi.'  />';
?>
	<br/>
	<br/>
	<input style="width:130px ; height : 50px;margin-left:30%" type="submit" value="Valider"/>
	<a style="position:absolute ;" href='these.php'><input class='button' type='button' value='Annuler' style="width:130px ; height : 50px;margin-left:25%"></a>
</form>	
</div></div>
<br>	

	
<?php
	include "templates/footer.php";
?>

