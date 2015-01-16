<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '<script type="text/javascript" src="js/fonction_annuaire.js"></script>';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />
							<link rel="stylesheet" type="text/css" href="css/div_cache.css" />';
$changements['__TITLE__'] = '<title>Cotisations personnelle</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Cotisations personnelle">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Cotisations personnelle">';
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
$id_modif_cotisation=$_GET['id'];
$id_cotisant=$_GET['id_cotisant'];
$_SESSION['id_personne']=$id_cotisant;

//nombre de cotisations afficher au depart
$nb_cotisations_afficher = 5;
if (isset($_GET['nb_cotisations'])) {$nb_cotisations_afficher = $_GET['nb_cotisations'];}

include ("sql/recup_personne.php"); 
?>	
	<div class="panel panel-info">
		<div class="panel-heading">
    		<h2 class="panel-title">Etat des cotisations de 	<?php echo "$prenom  $nom"; ?></h2>
  		</div>
  		<div class="panel-body">
	
			<?php 
			// si une personne a déjà payé
			if ($dernier_paiement) 
			{ 
				echo "<b> - Dernier paiement enregistré en	$dernier_paiement</b>";
			}
			// personne n'ayant jamais pâyé
			else 
			{ 
				echo "<b> - Aucun paiement enregistré</b>";
			}
			
			if ($abonnement_revue=='oui') 
			{ 
				echo " <br><b> - Cet adhérent est abonné à l'annuaire </b>";
			}
			else 
			{ 
				echo " <br><b> - Cet adhérent n'est pas abonné à l'annuaire  </b>";
			}			
			?>
			<a href="script_cotisations.php?type_modif=modif_abonnement_revue" >Modifier</a> <br/>				
			<?php		
				echo "<b> - Type d'adhérent : " . $libelle_type_personne . "</b>";	
			?>
			<a href="javascript:DivStatus( 'cachediv', '1' )">Modifier</a><br>
		</div>			
		
		<div id="cachediv1" name="cachediv1" class="cachediv">		
			<div class="secondaire" >	
				<div>&nbsp;</div>	
				<div>&nbsp;</div>	
				<form action="script_cotisations.php?type_modif=modif_type_adherent&id_cotisant=<?php echo $id_cotisant;?>" name="formulaire_cache1" id="formulaire_cache1" method="post">											
					<?php
						//select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
						select_ordre_validation("Type d'adhérent", "new_id_type_personne", "type_personne", "libelle", $id_type_personne);				
					?>
				</form>		
			</div>
		</div>
	</div>	

	<!-- information du contact -->
	<table>
	<th  width="350px">	
		<div class="panel panel-info">
			<div class="panel-heading">
    			<h2 class="panel-title">Contact professionnel</h2>
  			</div>
  			<div class="panel-body">
    			<b> Coordonnées: </b><br/><?php echo $complement_pro .' <br/>' .$num_rue_pro.' '.$nom_rue_pro; ?> <br>
				<?php echo $code_postal_pro.' '.$localite_pro; ?> <br>
				<b>Téléphone:  </b> <?php echo $tel_pro;?> &nbsp;	<br>
				<b>Courriel: </b><?php echo $courriel_pro; ?> <br>
				<b> Pays:</b>  &nbsp; <?php echo $libelle_pays_pro;	?> <br>	
			</div>	
  		</div>
  	</th>
	<th width="87px"></th >
  	<th  width="350px">	
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Contact personnel  </h2>	
			</div>
			<div class="panel-body">
				<b>Coordonnées: </b><br/> <?php echo $complement_perso .' <br/>' .$num_rue_perso.' ' .$nom_rue_perso; ?> <br>
				<?php echo $code_postal_perso.' '.$localite_perso; ?> <br>
				<b>Téléphone: </b><?php echo $tel_perso;?> &nbsp;	<br>
				<b>Courriel: </b> <?php echo $courriel_perso; ?> <br>
				<b> Pays: </b>  &nbsp; <?php echo $libelle_pays_perso; ?> <br>	
			</div>
		</div>	
	</th>

</table>
	<?php	
	$nb_cotisations_sql = pg_query("SELECT count(id) FROM cotisations WHERE id_personne=". $id_cotisant ."AND visible=true");
	$nb_cotisations_row = pg_fetch_row($nb_cotisations_sql);
	$nb_cotisations = $nb_cotisations_row[0];
	$result_cotisations = pg_query("SELECT c.id, c.id_personne, tp.id, tp.libelle, c.annee, c.revue, c.valeur, p.nom, p.prenom, p.dernier_paiement, p.revue, p.abonnement_revue
								FROM cotisations c, personne p, type_paiement tp 
								WHERE p.id=c.id_personne 
								AND c.id_personne=".$id_cotisant ."
								AND c.id_type_paiement=tp.id 
								AND c.visible=true   
								ORDER BY c.annee desc , c.valeur asc
								LIMIT ".$nb_cotisations_afficher."
								");
	if (!$result_cotisations) 
	{  
		echo "Pas de cotisations\n";  						
	}
	else{
		?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Etat des cotisations  </h2>	
			</div>
			<div class="panel-body">
			<table style='background-color:white' class="table table-bordered table-hover">
			<tr>
				<th>Année</th>
				<th>Mode de paiement</th>
				<th>Annuaire</th>
				<th>Valeur</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			</tr>
			<tr>
			<?php
			$i=0; // permet de  retrouver les valeurs de la derniere cotisation 
			$dernier_id_type_paiement;
			while ($cotisation = pg_fetch_row($result_cotisations)) 
			{		
				$id_cotisation= $cotisation[0];
				$id_personne= $cotisation[1];
				$id_type_paiement= $cotisation[2]; 
				$libellle_type_paiement= $cotisation[3];	
				$annee= $cotisation[4];			
				$revue= $cotisation[5];			
				$valeur= $cotisation[6];	// Prix
				
				$nom= $cotisation[7];
				$prenom= $cotisation[8];
				$dernier_paiement= $cotisation[9];
				$abonnement_revue_personne= $cotisation[10];
				$abonne_revue= $cotisation[11];	
				
				//récupère les dernièrs informations
				if ($i==0) 
				{
					$dernier_id_type_paiement = $id_type_paiement;
					$dernier_annee = $annee;	
					$dernier_revue= $revue;
					$dernier_valeur=$valeur;
				}
				}

				if ($_GET['type']=='modification' && $_GET['id']== $id_cotisation)
				{
				?>
					<form name="formulaire_modif_cotis" id="formulaire_modif_cotis" method="post" action="script_cotisations.php?type_modif=modif">	
						<?php include("gestion_cotisations_personne_formulaire.php"); ?>			
							<span id="col5">
								<input type="submit" name="bouton_submit" value="Modifier" />
							</span>
							<span id="col6">
								<a href='gestion_cotisations_personne.php?id_cotisant=<?php echo $id_cotisant;?>'><input class='button' type='button' value='Cancel'><cancel>&nbsp;Cancel</cancel></a>
							</span>
						</li>
						
						<input type='hidden' name='new_id_cotisant' id='new_id_cotisant' <?php echo "value=".$id_cotisant;?> > 
						<input type='hidden' name='modif_id_cotisation' id='modif_id_cotisation' <?php echo "value=".$id_cotisation;?> > 
					</form>
				<?php
				}
				else
				{

					echo '<th>'. $annee .'</th>';	
					echo '<th>'. $libellle_type_paiement .'</th>';			
					echo '<th>';
					if ($revue=="t"){echo "oui";} else {echo "non";} 
					echo '</th>';		
						echo '<th>'. $valeur .'</th>';	
						echo '<th><a href="gestion_cotisations_personne.php?id_cotisant='.$id_personne.'&id=' . $id_cotisation .'&type=modification&nb_cotisations='. $nb_cotisations_afficher .' "><img width="12px" src="images/button_edit.png" ></a></th>';	
						echo '<th>';
						?>
						<a href="javascript: 
							if (confirm('Cette suppression est définitive. Confirmez-vous?')) 
							{ 
								window.location.href='script_cotisations.php?type_modif=supp&id_cotisation=<?php echo $id_cotisation;?>&id_cotisant=<?php echo $id_cotisant;?>'
							} 
							else 
							{ void('') }
							;"> 
							<img width='16px' src='images/croixsupprimer.gif'>
						</a>
							
						<?php
						echo '</th>';	
					echo "</tr>";		
				}					

				$i++;
			}		
		?>
</div></div>
	<br/>

	<?php
	if ($nb_cotisations > $nb_cotisations_afficher)
	{
		$nb_cotisations_afficher=$nb_cotisations_afficher + 5;
		echo '<a href="gestion_cotisations_personne.php?id_cotisant=' . $id_personne .'&nb_cotisations='. $nb_cotisations_afficher .'" >Voir les 5 prochaines cotisations</a><br>';
		
		echo'<br>';
	}
	?>
	
	<a href="javascript:DivStatus( 'cachediv', 'ajout' )">Ajouter une cotisation</a><br>
	
	<div id="cachedivajout" name="cachedivajout" class="cachediv">	
		<?php
				$annee = date('Y');
				$id_type_paiement = $dernier_id_type_paiement;
				$revue = $dernier_revue;
				$valeur = $dernier_valeur;
		?>
		<table  style='background-color:white' class="table table-bordered table-hover">
			<tr>
				<th>Année</th>
				<th>Mode de paiement</th>
				<th>Annuaire</th>
				<th>Valeur</th>
				<th>Valider</th>
			</tr>
			<form name="formulaire_ajout_cotis" id="formulaire_ajout_cotis" method="post" action="script_cotisations.php?type_modif=ajout">	
				<?php include("gestion_cotisations_personne_formulaire.php"); ?>			
				<th><input type="submit" name="bouton_submit" value="Ajouter" /></th>
				<input type='hidden' name='new_id_cotisant' id='new_id_cotisant' <?php echo "value=".$id_cotisant;?> > 
			</tr>
			</form>
	
		</table>
	</div>
	
	

<?php
	include "templates/footer.php";
?>