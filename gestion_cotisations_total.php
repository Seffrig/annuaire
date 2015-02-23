<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="js/fonction_annuaire.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />
							<link rel="stylesheet" type="text/css" href="css/div_cache.css" />';
$changements['__TITLE__'] = '<title>Cotisations total</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Cotisations total">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Cotisations total">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

// vérifie les droits pour la page
$page="gestion_cotisation";
include("verification_droit.php");	
?>

<?php

$annee_actuel = date ('Y');

?>	

	<h1> Etat des cotisations </h1>	
	<br>
	<table style='background-color:white' class="table table-bordered table-hover">
		<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Paiement <?php echo $annee_actuel ?></th>
				<th>Paiement <?php echo ($annee_actuel - 1 ) ?></th>
				<th>Paiement <?php echo ($annee_actuel - 2 ) ?></th>
				<th>Paiement <?php echo ($annee_actuel - 3 ) ?></th>
				<th>Etat</th>
		</tr>
	  	<tr>	
 			<?php 
			$personne_sql = pg_query("SELECT id, nom, prenom FROM personne WHERE visible=true ORDER BY nom, prenom");
			while ($personne_row = pg_fetch_row($personne_sql))
			{
				$id_personne = $personne_row[0];
				$nom_personne = $personne_row[1];
				$prenom_personne = $personne_row[2];
				if($nom_personne != ""){
				echo "<td><a href='gestion_cotisations_personne.php?id_cotisant=".$id_personne."'>". $nom_personne ."</a></td>";	
				echo '<td>'. $prenom_personne .'</td>';	
			
				$i=0;

				while ($i<4) 
				{	
					$annee = $annee_actuel - $i;
					$result_cotisations = pg_query("SELECT c.annee, c.valeur, c.revue
											FROM cotisations c 
											WHERE c.id_personne  = " . $id_personne . "
											AND c.annee=" . $annee . "
											AND c.visible=true   
											");
					$cotisations_row = pg_fetch_row($result_cotisations);
					$annee_cotisations = $cotisations_row[0];
					$valeur_cotisations = $cotisations_row[1];
					
					$revue = $cotisations_row[2];
				
					
					?>
					<td id="blabla" onDblClick="changeValue()"> <?php echo $valeur_cotisations; ?> </td>	
					
					<?php
					$i++;
					if ($i ==1) 
					{
						if ($revue == "t")
						{
							$checkbox_revue = "true_min.jpg";
						}
						else
						{
							$checkbox_revue = "false_min.jpg";
						}
						
					}
				}
				echo '<td><img src="images/' . $checkbox_revue . '"</td>';	
				echo '<tr>';	
			
				}			
			}
		?>
	</table>
	<br/>

	

<?php
	include "templates/footer.php";
?>