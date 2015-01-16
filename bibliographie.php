<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Bibliographie</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Bibliographie">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="bibliographie">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";
?>

<?php
$page="bibliographie";
include("verification_droit.php");	// test si on a les droits sur la page si non deconnexion	
	
include("sql/recup_bibliographie.php");			
?> 

<h1> Bibliographie </h1>		
<div class="panel panel-info">
	<div class="panel-heading">
		<h2 class="panel-title">Saisir une nouvelle publication</h2>	
	</div>
	<div class="panel-body">	
		<form name="formulaire_choix_publication" id="formulaire_choix_publication" method="post" action="formulaire_modifier_bibliographie.php?type_modif=ajout">	
		<label for='id_type_publi'> Type de publications : </label> 
		<select name='id_type_publi' id="id_type_publi" onchange='submit()'>";
		<?php
			$result_type_publication = pg_query("SELECT  id, libelle  FROM type_publication WHERE id <> 0 ORDER BY id");			
			echo "<option value='' selected='selected' > </option> ";				
			while ($row_type_publication = pg_fetch_row($result_type_publication)) 
			{
				$id_type_publi = $row_type_publication[0];
				$libelle_type_publi = $row_type_publication[1];
				
				echo "<option value='". $id_type_publi ."'> ". $libelle_type_publi ." </option>";		
			}
		?>
		</select>	
	</form>	
</div>
</div>		
	<br><br>
	<?php
		// affichage des publications 
		$nb_publications_afficher=10;
		if (isset($_GET['nb_publications'])) {
			$nb_publications_afficher = $_GET['nb_publications'];
		}
		affichage_publications($_SESSION['id_personne'], $nb_publications_afficher);				
	?>
	
<?php
	include "templates/footer.php";
?>