<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification des corps</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout corps">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout corps">';
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
		$label = "Ajout";
		echo "<h1> 	Ajout d'un corps	 </h1>";
		echo "<form action='maj_corps.php?type_modif=ajout' onsubmit='return check_valider_corps()' name='form_corps' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		$label = "Modification";
		$id_recherche = $_GET['id_rech'];
		echo "<h1> 	Modification du corps	 </h1>";
		echo "<form action='maj_corps.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_corps()' name='form_corps' method='post'  >";
		

		
							
		$result_corps = pg_query("SELECT  id, libelle, ordre
											FROM corps
											WHERE id = ". $id_recherche ." ");	
											
		$row_corps = pg_fetch_row($result_corps);

		$id_recherche = $row_corps[0]; 
		$nom_corps = $row_corps[1];
		$ordre = $row_corps[2];

	}
?>

			
			<br/><br/>
			<br/>	

			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><?php echo $label ?></h2>
				</div>
				<div class="panel-body">
					<label style="width:120px" for="nom_corps">Nom du corps</label> : 
					<input size="30" type="text" maxlength="50 "name="nom_corps" id="nom_corps" onKeyUp="javascript:couleur(this);"
					<?php  if (isset($nom_corps) && $nom_corps != ''){echo 'value = "' . $nom_corps . '"';}  ?>/> 
					<font class='ast'>*</font>
					<br/>	
					<label style="width:127px" for="ordre">Ordre :</label> 
					<input size="30" type="text" maxlength="50 "name="ordre" id="ordre" 
					onKeyUp="javascript:couleur(this);"
					<?php  if (isset($ordre) && $ordre != ''){echo 'value = "' . $ordre . '"';}  ?>/> 
					<font class='ast'>*</font><br/></br>
					<input type="submit" value="Valider" style="margin-left: 40%;"/>
					<a href="modif_corps.php"> <input type="button" value="Annuler"> </a>
					</form>	
					<br>
				</div>
			</div>
					<?php 
					//affichage_colonne_2_tables($id1, $champ1, $table1, $rel1, $rel2, $champ2, $table2, $page_modif, $page_sup) 
					//affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
		affichage_colonne('id', 'libelle', 'corps', 'modif_corps.php','maj_corps.php',"libelle");
		?>			
	
<?php
	include "templates/footer.php";
?>

