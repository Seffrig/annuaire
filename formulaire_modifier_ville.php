<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification des ville</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout ville">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout ville">';
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
		echo "<h1> 	Ajout d'une ville	 </h1>";
		echo "<form action='maj_ville.php?type_modif=ajout' onsubmit='return check_valider_ville()' name='form_ville' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		$label = "Modification";
		$id_recherche = $_GET['id_rech'];
		echo "<h1> 	Gestion des villes	 </h1>";
		echo "<form action='maj_ville.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_ville()' name='form_ville' method='post'  >";
		

		
							
		$result_ville = pg_query("SELECT  id, libelle
											FROM ville
											WHERE id = ". $id_recherche ." ");	
											
		$row_ville = pg_fetch_row($result_ville);

		$id_recherche = $row_ville[0]; 
		$nom_ville = $row_ville[1];
		

	}
?>

			
			<br/><br/>
			<br/>	

			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><?php echo $label ?></h2>
				</div>
				<div class="panel-body">
					<label for="nom_ville">Nom de la ville</label> : 
					<input size="30" type="text" maxlength="50 "name="nom_ville" id="nom_ville" onKeyUp="javascript:couleur(this);"
					<?php  if (isset($nom_ville) && $nom_ville != ''){echo 'value = "' . $nom_ville . '"';}  ?>/> 
					<font class='ast'>*</font>
					<br/><br/>		
					<input type="submit" value="Valider" style="margin-left: 40%;"/>
					<a href="modif_ville.php"> <input type="button" value="Annuler"> </a>
					</form>	
					<br>
				</div>
			</div>
					<?php 
					//affichage_colonne_2_tables($id1, $champ1, $table1, $rel1, $rel2, $champ2, $table2, $page_modif, $page_sup) 
					//affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
		affichage_colonne('id', 'libelle', 'ville', 'modif_ville.php','maj_ville.php',"libelle");
		?>			
	
<?php
	include "templates/footer.php";
?>

