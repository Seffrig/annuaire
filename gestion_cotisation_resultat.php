<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Résultat Recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="resultat de la recherches de la gestions de cotisation">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="resultat de la recherches de la gestions de cotisation">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

// vérifie les droits pour la page
$page="gestion_cotisation";
include("verification_droit.php");	
?>
	
	<h1> Rechercher un adhérent </h1>
	<br>
	<br>
	<?php					
		$condition = "visible = 'true' ";	
		$condition=genere_test_caractere($condition, 'nom');		
	?>	
	<table style='background-color:white' class="table table-bordered table-hover">
		<tr>
		  <th>Nom</th>
		  <th>Prénom</th>
		  <th>Etablissement</th>
		  <th>Fiche</th>
	  	</tr>
	  	<tr>
		 <?php
			$result = pg_query("SELECT id, nom, prenom, id_etabl_princ FROM personne WHERE $condition ORDER BY nom");	
			while ($rech = pg_fetch_row($result)) 
			{ 
				$id_rech=$rech[0];
				$nom_rech=$rech[1];
				$prenom_rech=$rech[2];				
				$id_etabl_princ_rech=$rech[3];
		
				$result_etabl = pg_query("SELECT nom FROM etablissement WHERE id= " .$id_etabl_princ_rech );	
				
				// si une seule personne
				if (pg_num_rows($result)==1)
				{ 			
					echo "<script language='javascript' type='text/javascript'> window.location.replace('gestion_cotisations_personne.php?id_cotisant=$id_rech');	</script>";
				}
				
				echo '<td>'. $nom_rech .'</td>';	
				echo '<td>'. $prenom_rech .'</td>';	
					
				
				if ($id_etabl_princ_rech == '' || pg_num_rows($result_etabl)==0 )
				{
					echo '<td></td>';
				}
				else 
				{ 
					$result_etabl_champs = pg_fetch_row($result_etabl); 
					 echo '<td>'. $result_etabl_champs[0] .'</td>';	
				}
				echo '<td style="text-align: center;"><a href="gestion_cotisations_personne.php?id_cotisant='.$id_rech.'" >  Accéder à sa fiche</a></td>';
				echo '<tr>';
			}
	?>
	</table>
	<br><a href='gestion_cotisations.php'><input  type='button' value='Nouvelle recherche' style="margin-left: 40%;"></a><br><br><br>

<?php
	include "templates/footer.php";
?>