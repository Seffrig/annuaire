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

$annee_actuel = date ('Y');

?>	

	<h1> Etat des cotisations </h1>	
	<br>
	<span>Vous pouvez changer ou ajouter une cotisation en cliquant sur la case concerné</span>
	<br><br>
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
			$c = 0;
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
					$result_cotisations = pg_query("SELECT c.annee, c.valeur, c.revue, c.id_type_paiement
											FROM cotisations c 
											WHERE c.id_personne  = " . $id_personne . "
											AND c.annee=" . $annee . "
											AND c.visible=true   
											");
					$cotisations_row = pg_fetch_row($result_cotisations);
					$annee_cotisations = $cotisations_row[0];
					$valeur_cotisations = $cotisations_row[1];
					$revue = $cotisations_row[2];
					$type_paiement = $cotisations_row[3];
				

					$result= pg_query("SELECT id,libelle FROM type_paiement"); 
					$listTypePaiment = '';
					while ($row = pg_fetch_row($result))
					{
						if($type_paiement == $row[0])
							$listTypePaiment = $listTypePaiment."<option value=".$row[0]." selected='selected' >".$row[1]."</option>";
						else
							$listTypePaiment = $listTypePaiment."<option value=".$row[0]." >".$row[1]."</option>";
					}
												

					
					$tdId = "" . $annee . $c;
					$idInput = "Input" . $tdId;
					$idBut = "But" . $tdId;
					$idTP = "typePai" . $tdId;;
					echo '<input name="annee" id="annee" type="HIDDEN" value='.$annee.'  />';
					echo '<input name="compteur" id="compteur" type="HIDDEN" value='.$c.'  />';
					echo '<input name="valeurCoti" id="valeurCoti" type="HIDDEN" value='.$valeur_cotisations.'  />';
					echo '<input name="id_personne" id="id_personne" type="HIDDEN" value='.$id_personne.'  />';

					?>
						<td id="<?php echo $tdId; ?>"  
							onClick="showForm(<?php echo $annee . ',' . $c ; ?> )">
							<?php
							echo $valeur_cotisations;  
							echo "<form  action='modif_cotisations.php' name='formModifCoti' id='formModifCoti' method='post'>";
							echo "<input name='annee' type='HIDDEN' value=".$annee." id='annee' />";
							echo "<input name='id_personne' type='HIDDEN' value=".$id_personne." id='id_personne' />";
							echo "<input name='valeur' type='text' maxlength='5' size='4' id='" . $idInput . "' value='" . $valeur_cotisations ."' style='visibility:hidden;width: 40px;' /> ";
							
							echo "<select id='".$idTP."' name='typePai' style='visibility:hidden'>";
								echo $listTypePaiment;
							echo "</select>";
							echo "<input type='submit' id='". $idBut ."' size='3' style='visibility:hidden' value='OK'>";
							echo "</form>";
							?>
						</td>	
			
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
				$c++;
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