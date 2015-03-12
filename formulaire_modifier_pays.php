<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification des pays</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout pays">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout pays">';
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
		//permet de changer le label
		$label = "Ajout";
		echo "<h1> 	Ajout d'un pays	 </h1>";
		echo "<form action='maj_pays.php?type_modif=ajout' onsubmit='return check_valider_pays()' name='form_pays' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		//permet de changer le label
		$label = "Modification";
		$id_recherche = $_GET['id_rech'];
		echo "<h1> 	Modification du pays	 </h1>";
		echo "<form action='maj_pays.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_pays()' name='form_pays' method='post'  >";
		

		
							
		$result_pays = pg_query("SELECT  id, libelle, ordre
											FROM pays
											WHERE id = ". $id_recherche ." ");	
											
		$row_pays = pg_fetch_row($result_pays);

		$id_recherche = $row_pays[0]; 
		$nom_pays = $row_pays[1];
		$ordre = $row_pays[2];

	}
?>

			
			<br/><br/>
			<br/>	

			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><?php echo $label ?></h2>
				</div>
				<div class="panel-body">
					<label style="width:90px" for="nom_pays">Nom du pays</label> : 
					<input size="30" type="text" maxlength="50 "name="nom_pays" id="nom_pays" onKeyUp="javascript:couleur(this);"
					<?php  if (isset($nom_pays) && $nom_pays != ''){echo 'value = "' . $nom_pays . '"';}  ?>/> 
					<font class='ast'>*</font>
					<br/>	
					<label style="width:98px" for="ordre">Ordre :</label> 
					<input size="30" type="text" maxlength="50 "name="ordre" id="ordre" 
					onKeyUp="javascript:couleur(this);"
					<?php  if (isset($ordre) && $ordre != ''){echo 'value = "' . $ordre . '"';}  ?>/> 
					<font class='ast'>*</font><br/></br>
					<input type="submit" value="Valider" style="margin-left: 40%;"/>
					<a href="modif_pays.php"> <input type="button" value="Annuler"> </a>
					</form>	
					<br>
				</div>
			</div>
					<?php 
					//affichage_colonne_2_tables($id1, $champ1, $table1, $rel1, $rel2, $champ2, $table2, $page_modif, $page_sup) 
					//affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
		affichage_colonne('id', 'libelle', 'pays', 'modif_pays.php','maj_pays.php',"libelle");
		?>			
	
<?php
	include "templates/footer.php";
?>

