<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Résultat Recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="résultat recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="résultat recherche">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

?>

	<h1>Résultat Rercherche </h1>
	<br><br>
	<?php					
	$condition = "visible = true ";	
	$condition=genere_test_caractere($condition, 'nom');
	$condition=genere_test_caractere($condition, 'prenom');
	
	$condition=genere_test_nombre($condition, 'id_corps');
	$condition=genere_test_nombre($condition, 'id_pays_pro');
	$condition=genere_test_nombre($condition, 'id_pays_perso');
	$condition=genere_test_nombre($condition, 'new_id_etabl_principal');
	
	$condition=genere_test_caractere($condition, 'code_postal_pro');
	$condition=genere_test_caractere($condition, 'localite_pro');
	$condition=genere_test_caractere($condition, 'num_rue_pro');
	$condition=genere_test_caractere($condition, 'nom_rue_pro');
	$condition=genere_test_caractere($condition, 'complement_pro');
	$condition=genere_test_caractere($condition, 'code_postal_perso');
	$condition=genere_test_caractere($condition, 'localite_perso');
	$condition=genere_test_caractere($condition, 'num_rue_perso');
	$condition=genere_test_caractere($condition, 'nom_rue_perso');
	$condition=genere_test_caractere($condition, 'complement_perso');
	$condition=genere_test_caractere($condition, 'tel_pro');
	$condition=genere_test_caractere($condition, 'tel_perso');
	$condition=genere_test_caractere($condition, 'courriel_pro');
	$condition=genere_test_caractere($condition, 'courriel_perso');
	$condition=genere_test_caractere($condition, 'revue');
	$condition=genere_test_caractere($condition, 'courrier');
	//echo $condition;

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

			$result = pg_query("SELECT id, nom, prenom, id_etabl_princ FROM personne WHERE ".$condition ." ORDER BY nom");			
			while ($rech = pg_fetch_row($result)) 
			{ 
				$id_rech=$rech[0];
				$nom_rech=$rech[1];
				$prenom_rech=$rech[2];	
				$etablissement_princ_rech=$rech[3];

				$result_etabl = pg_query("SELECT nom FROM etablissement WHERE id= " .$etablissement_princ_rech );		
				
				// si une seule personne
				if (pg_num_rows($result)==1)
				{ 			
					echo "<script language='javascript' type='text/javascript'> window.location.replace('compte.php?id_personne=$id_rech');	</script>";
				}
				//si plusieurs
				echo '<td>'. $nom_rech .'</td>';	
				echo '<td>'. $prenom_rech .'</td>';	
				
				if ($etablissement_princ_rech == '' || pg_num_rows($result_etabl)==0 )
				{
					echo '<td></td>';	 
				}
				else 
				{ 
					$result_etabl_champs = pg_fetch_row($result_etabl); 
					 echo '<td>'. $result_etabl_champs[0] .'</td>';	
				}
				echo '<td><a href="compte.php?id_personne='.$id_rech.'" >  Accéder à sa fiche</a></td>';
				echo "</tr>";	
			}
	
		?>

	
	
	</table>
	<br><a href='recherche.php'><input  type='button' value='Nouvelle recherche' style="margin-left: 40%;"></a><br><br><br>

<?php
	include "templates/footer.php";
?>