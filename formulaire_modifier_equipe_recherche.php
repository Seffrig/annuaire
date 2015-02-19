<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Modification équipe de recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout équipe de recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout équipe de recherche">';
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
		echo "<h1> 	Ajout une équipe de recherche	 </h1>";
		echo "<form action='maj_equipe_recherche.php?type_modif=ajout' onsubmit='return check_valider_equipe()' name='form_equipe_recherche' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		$label = "Modification";
		$id_recherche = $_GET['id_rech'];
		echo "<h1> 	Modification de l'équipe de recherche	 </h1>";
		echo "<form action='maj_equipe_recherche.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_equipe()' name='form_equipe_recherche' method='post'  >";
		

		
							
		$result_equipe_recherche = pg_query("SELECT  id, num_equipe, accronyme, num_rue, nom_rue, code_postal , ville, pays
											FROM recherche 
											WHERE id = ". $id_recherche ."");	
											
		$row_equipe_recherche = pg_fetch_row($result_equipe_recherche);

		$id_recherche = $row_equipe_recherche[0]; 
		$num_equipe = $row_equipe_recherche[1];
		$accronyme = $row_equipe_recherche[2];
		$num_rue = $row_equipe_recherche[3];
		$nom_rue = $row_equipe_recherche[4];
		$code_postal = $row_equipe_recherche[5];
		$ville = $row_equipe_recherche[6];
		$pays = $row_equipe_recherche[7];
	}
?>
			
			<br/><br/>
			<br/>	
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title"><?php echo $label ?></h2>
				</div>
				<div class="panel-body">	
			<label style="width:160px" for="num_equipe">Numéro Equipe :</label> 
			<input size="10" type="text" maxlength="10 "name="num_equipe" id="num_equipe" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($num_equipe) && $num_equipe != ''){echo 'value = "' . $num_equipe . '"';}  ?>
			/> 
			<font class='ast'>*</font> par exemple : EA4011
			<br/>
			
			<label style="width:160px" for="accronyme">Acronyme de l'équipe :</label> 
			<input size="30" type="text" maxlength="30 "name="accronyme" id="accronyme" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($accronyme) && $accronyme != ''){echo 'value = "' . $accronyme . '"';}  ?>
			/> 
			<font class='ast'>*</font> par exemple : ISTA
			
			
			<br/>
								
			<label style="width:160px" for="num_rue">Numéro de rue :</label>
			<input size="5" type="text" maxlength="5 "name="num_rue" id="num_rue" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($num_rue) && $num_rue != ''){echo 'value = "' . $num_rue . '"';}  ?>
			/> 
			<font class='ast'>*</font>
				
			
			<br/>	
								
			<label style="width:160px" for="nom_rue">Nom de la rue :</label> 
			<input size="50" type="text" maxlength="100 "name="nom_rue" id="nom_rue" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($nom_rue) && $nom_rue != ''){echo 'value = "' . $nom_rue . '"';}  ?>
			/> 
			<font class='ast'>*</font>
				
			
			<br/>	
								
			<label style="width:160px" for="code_postal">Code postal :</label> 
			<input size="5" type="text" maxlength="5 "name="code_postal" id="code_postal" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($code_postal) && $code_postal != ''){echo 'value = "' . $code_postal . '"';}  ?>
			/> 
			<font class='ast'>*</font>
				
			
			<br/>	
								
			<label style="width:160px" for="ville">Ville :</label> 
			<input size="50" type="text" maxlength="50 "name="ville" id="ville" onKeyUp="javascript:couleur(this);"
				<?php  if (isset($ville) && $ville != ''){echo 'value = "' . $ville . '"';}  ?>
			/> 
			<font class='ast'>*</font>
			
			
			<br/>	
				
			<?php
			// select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
			$pays ="";
			select_ordre ('Pays ', 'id_pays','pays', 'libelle', $pays,"158px" );	 
			?>
			<font class='ast'>*</font>
				
			<br/><br/>
			<input type="submit" value="Valider" style="margin-left: 40%;"/>
			<a href="modif_equipe_recherche.php"> <input type="button" value="Annuler"> </a>
		</form>	
		<br>
		</div></div>	
		<?php 
		//affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
		affichage_colonne('num_equipe', 'accronyme', 'recherche','modif_equipe_recherche.php','maj_equipe_recherche.php',"champ");	
		?>			
	
<?php
	include "templates/footer.php";
?>

