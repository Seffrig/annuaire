<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification équipe de recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout établissement">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout établissement">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

?>

<?php
	// ajout 
	if ($_GET['type_modif'] == 'ajout')
	{
		echo "<h1> 	Ajout un établissement	 </h1>";
		echo "<form action='maj_etablissement.php?type_modif=ajout' onsubmit='return check_valider_etablissement()' name='form_etablissement' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		$id_recherche = $_GET['id_rech'];
		echo "<h1> 	Modification de l'établissement	 </h1>";
		echo "<form action='maj_etablissement.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_etablissement()' name='form_etablissement' method='post'  >";
		

		
							
		$result_etablissement = pg_query("SELECT  id, nom, id_ville
											FROM etablissement
											WHERE id = ". $id_recherche ." ");	
											
		$row_etablissement = pg_fetch_row($result_etablissement);

		$id_recherche = $row_etablissement[0]; 
		$nom_etablissement = $row_etablissement[1];
		$id_ville = $row_etablissement[2];

	}
?>
			<a href="formulaire_modifier_etablissement.php?type_modif=ajout" >Ajouter un établissement</a>
			<br/><br/>
			<br/>	

			<fieldset>		
			<label for="nom_etablissement">Nom de l'établissement</label> : 
			<input size="50" type="text" maxlength="100 "name="nom_etablissement" id="nom_etablissement" onKeyUp="javascript:couleur(this);"
				<?php  if ($nom_etablissement != ''){echo 'value = "' . $nom_etablissement . '"';}  ?>
			/> 
			<font class='ast'>*</font>
			</fieldset>	
		
			<br/>	
			<fieldset>	
			<?php
			//selection_menu_der($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
			selection_menu_der ('Ville ', 'id_ville','ville', 'libelle', $id_ville );	 
			?>
			<font class='ast'>*</font>
			</fieldset>	
			<br/>
			<input type="submit" value="Valider"/>
		</form>	
		<br>
		
		<?php 
		//affichage_colonne_2_tables($id1, $champ1, $table1, $rel1, $rel2, $champ2, $table2, $page_modif, $page_sup) 
		affichage_colonne_2_tables('id', 'nom', 'etablissement', 'id_ville', 'id', 'libelle', 'ville' ,'modif_etablissement.php','maj_etablissement.php');	
		?>			
	
<?php
	include "templates/footer.php";
?>

