<?php
require('PDF_label.php');
ob_start();
include("connexionDB.php");
/*--------------------------------------------------------------------------------
Pour créer l'objet on a 2 manières :
soit on donne les valeurs d'un format personnalisé en les passant dans un tableau
soit on donne le nom d'un format AVERY
--------------------------------------------------------------------------------*/

// Exemple avec un format personnalisé
// $pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>1, 'marginTop'=>1, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>14));
// Format standard
$pdf = new PDF_Label('L7163');
$pdf->AddPage();

$result_personne = pg_query("SELECT  titre.libelle, nom, prenom, 
										code_postal_pro,localite_pro, num_rue_pro, nom_rue_pro, complement_pro, 
										code_postal_perso, localite_perso, num_rue_perso,nom_rue_perso,complement_perso,
										revue,courrier , id_type_personne,
										id_pays_pro, id_pays_perso, abonnement_revue		
																				
							FROM personne, titre							
							WHERE titre.libelle=( select libelle from titre where personne.id_titre	=id )	");		
					
while ($personne = pg_fetch_row($result_personne)) { 
		
	$titre= $personne[0];
	$nom= utf8_decode($personne[1]);
	$prenom= utf8_decode($personne[2]);
	$code_postal_pro= $personne[3];
	$localite_pro= utf8_decode($personne[4]);
	$num_rue_pro= $personne[5];
	$nom_rue_pro= utf8_decode(utf8_decode($personne[6]));
	$complement_pro= utf8_decode($personne[7]);
	$code_postal_perso= $personne[8];
	$localite_perso= utf8_decode($personne[9]);
	$num_rue_perso= $personne[10];
	$nom_rue_perso= utf8_decode($personne[11]);
	$complement_perso= utf8_decode($personne[12]);
	$revue= $personne[13];
	$courrier= $personne[14];
	$type_personne= $personne[15]; 	// 1 normal 2 resilié 3 decedé
	$pays_pro= utf8_decode($personne[16]); 
	$pays_perso= utf8_decode($personne[17]); 
	$abonnement_revue=$personne[18];
	
	if ($pays_pro!="") {
		$result_pays_pro= pg_query("SELECT libelle	FROM pays WHERE id= ".$pays_pro."");
		$tab_pays_pro = pg_fetch_row($result_pays_pro);
		$pays_pro= $tab_pays_pro[0];
	}
	else {
		$pays_pro=0;
	}
	
	if ($pays_perso!="") {
		$result_pays_perso= pg_query("SELECT libelle FROM pays WHERE id= ".$pays_perso."");
		$tab_pays_perso = pg_fetch_row($result_pays_perso);
		$pays_perso= $tab_pays_perso[0];
	}
	else {
		$pays_perso=0;
	}
					
	
	if ($type_personne==1){			
		// On imprime les étiquettes
		if ($_GET['type']=='courrier'){				
			if ($courrier=='pro') {
				//adresse pro
				$text = sprintf("%s\n%s\n%s\n%s %s, %s", "$nom $prenom", "$complement_pro", "$num_rue_pro $nom_rue_pro", "$code_postal_pro", "$localite_pro", "$pays_pro");
				$pdf->Add_Label($text);
			}
			else if ($courrier=='perso') {					
				//adresse perso
				$text = sprintf("%s\n%s\n%s\n%s %s, %s", "$nom $prenom", "$complement_perso", "$num_rue_perso $nom_rue_perso", "$code_postal_perso", "$localite_perso", "$pays_perso");
				$pdf->Add_Label($text);
			}
		}
		else  if ($_GET['type']=='revue' && $abonnement_revue=='oui'){				
			if ($revue=='pro') {
				//adresse pro
				$text = sprintf("%s\n%s\n%s\n%s %s, %s", "$nom $prenom", "$complement_pro", "$num_rue_pro $nom_rue_pro", "$code_postal_pro", "$localite_pro", "$pays_pro");
				$pdf->Add_Label($text);
			}
			else if ($revue=='perso') {					
				//adresse perso
				$text = sprintf("%s\n%s\n%s\n%s %s, %s", "$nom $prenom", "$complement_perso", "$num_rue_perso $nom_rue_perso", "$code_postal_perso", "$localite_perso", "$pays_perso");
				$pdf->Add_Label($text);
			}	
		}
	}
}
$pdf->Output();
?>