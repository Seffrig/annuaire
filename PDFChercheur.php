<?php 

//	include('test_session.php');
	require( 'fpdf.php' );
	

	//connection à la base
	include("commun/connexion_db.php");

	class PDFChercheur extends FPDF
	{
		// constructeur du PDF avec en paramètre les 3 requetes utilisées pour récupérer les infos de la bdd 
		function createPDF($infoChercheur, $theses, $publications)
		{	    

			// On créer un tableau de toutes les infos
			$row = pg_fetch_row($infoChercheur);
			
			// on les mets dans des variables pour se repérer plus facilement 
			$prenom 			= $row[0];
			$nom 				= $row[1];
			$corps 				= $row[2];
			$mail 				= $row[3];
			$etablPrin			= $row[4];
			$localite_perso		= $row[5];
			$complement_perso	= $row[6];
			$nom_rue_perso		= $row[7];
			$courriel_perso		= $row[8];
			$tel_perso			= $row[9];
			$code_postal_perso	= $row[10];
			$num_rue_perso		= $row[11];
			$localite_pro		= $row[12];
			$complement_pro		= $row[13];
			$nom_rue_pro		= $row[14];
			$courriel_pro		= $row[15];
			$tel_pro			= $row[16];
			$code_postal_pro	= $row[17];
			$num_rue_pro		= $row[18];

			// déclaration de différentes valeurs qui vont servir a placer nos elements
    		$x = 15;
			$y = 10;
			$border = 190;
		    $this->SetXY( $x, $y );

		    // Police d'écriture en gras (pour nom prenon)
			$this->SetFont('Arial','B',10);

			/*
				Toutes les informations sont affiches via les fonctions Cell/MultiCell
				on sautes des lignes via en incrémentatn $y 
				on change la presentation du texte (italique gras ou normal) en fonction des besoins de presentation
			*/

			$fullname =  $nom . ' ' . $prenom;
			$this->Cell(0,0, $fullname ,0,0,'L');
			$this->SetFont('Arial','I',10);
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, "Courriel: " ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, "Etablissement principal: " ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, "Contact professionnel: " ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, $complement_pro ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, $num_rue_pro .','. $nom_rue_pro ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, $code_postal_pro . ' ' .$localite_pro ,0,0,'L');
			$y += 5;
		    $this->SetXY( $x, $y );
			$this->Cell(0,0, "tel : " . $tel_pro ,0,0,'L');



			$this->SetFont('Arial','',10);
			$y = 10;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $corps ,0,0,'R');
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $mail ,0,0,'R');
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $etablPrin ,0,0,'R');
			$this->SetFont('Arial','I',10);
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, "Contact personnel: " ,0,0,'R');
			$this->SetFont('Arial','',10);
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $complement_perso ,0,0,'R');
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $num_rue_perso .','. $nom_rue_perso ,0,0,'R');
			$y += 5;
		    $this->SetXY( $border, $y );
			$this->Cell(0,0, $code_postal_perso . ' ' .$localite_perso ,0,0,'R');
			

			$y += 12;
		    $this->SetXY( $x, $y );
		
			$this->SetFont('Arial','B',10);
			$this->Cell(0,0, "Thèse : " ,0,0,'L');
			$this->SetFont('Arial','',8);

			/*
				Tableau comportant toutes les thèses on les affiches de la meme manière que précedemment 
			*/ 
			while ($row2 = pg_fetch_row($theses) )
			{
				$titreThese 	= $row2[0];
				$directeur 		= $row2[1];
				$type_these		= $row2[2];
				$date_conf	 	= $row2[3];
				$etablissement 	= $row2[4];

				$line = $type_these . " : " .$titreThese .", ". $directeur .", ". $etablissement. "  ". $date_conf."." ;
				$y += 5;
			    $this->SetXY( $x, $y );
				$this->MultiCell($border,3,$line , 0, 'L');
				$this->ln();
				$y += 5;
			    $this->SetXY( $x, $y );
			}

			$y += 10;
		    $this->SetXY( $x, $y );

			$this->SetFont('Arial','B',10);
			$this->Cell(0,0, " Publications choisies : " ,0,0,'L');
			$this->SetFont('Arial','',8);


			/*
				Tableau comportant toutes les publications on les affiches de la meme manière que précedemment 
			*/ 
			while ($row3 = pg_fetch_row($publications) )
			{

				$idType 				= $row3[0];
				$directeur				= $row3[1];
				$titre_communication 	= $row3[2];
				$titre_journal			= $row3[3];
				$revue_volume			= $row3[4];
				$page_deb				= $row3[5];
				$page_fin				= $row3[6];
				$nb_pages				= $row3[7];
				$date_publi				= $row3[8];
				$auteur_sec 			= $row3[9];
				$titre_ouvrage			= $row3[10];
				$editeur_ville 			= $row3[11]; 
				$editeur 				= $row3[12];
				$collection 			= $row3[13];
				$date_conf				= $row3[14];

				$line = "";
				if($idType == 1)
				{
					$line = $titre_communication . ", " . $titre_journal .", vol. " . $revue_volume .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, ". $date_publi.".";
					$y += 10;
				
				}
				elseif ($idType == 3)
				{
					if($auteur_sec != "")
						$line = $auteur_sec . ", " . $titre_communication . ", " . $titre_journal .", vol. " . $revue_volume . ", " .   $titre_ouvrage .", " . $editeur_ville . ", " . $editeur .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, ". $date_publi.".";
					else 
						$line =  $titre_communication . ", " . $titre_journal .", vol. " . $revue_volume . ", " .   $titre_ouvrage .", " . $editeur_ville . ", " . $editeur .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, ". $date_publi.".";

					$y += 10;
				
				}
				elseif ($idType == 4)
				{
					$line = $titre_communication . ", " .   $titre_ouvrage . ", " . $date_conf ;
					$y += 5; 
				}
				elseif ($idType == 5)
				{
					if($auteur_sec != "" && $auteur_sec != "non")
						$line = $titre_communication . ", " .   $titre_ouvrage . ", " .$auteur_sec .  ", " . $etablissement . ", " . $date_conf ;
					else
						$line = $titre_communication . ", " .   $titre_ouvrage . ", " . $etablissement . ", " . $date_conf ;
					$y += 5; 
				}
				elseif ($idType == 6)
				{
					$line = $titre_ouvrage . ", " . $editeur_ville . ", " . $editeur . ", " . $date_publi . ", " . $nb_pages . " pages, " . $collection.".";
					$y += 10;
				
				}
				elseif ($idType == 7)
				{
					if($auteur_sec != "")
						$line = $auteur_sec . ", " . $titre_communication . ", " . $directeur . ", " . $titre_ouvrage . ", " .         $editeur_ville . ", " . $editeur . ", " . $date_publi .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, " . $collection.".";
					else 
						$line =  $titre_communication . ", " . $directeur . ", " . $titre_ouvrage . ", " .         $editeur_ville . ", " . $editeur . ", " . $date_publi .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, " . $collection.".";

					$y += 10;
				}
				elseif ($idType == 8)
				{
					if($directeur != "")
						$line = $directeur . ", " . $titre_ouvrage . ", " . $editeur_ville . ", " . $editeur . ", " . $nb_pages  . " pages, " . $date_publi  . ", " . $collection.".";
					else 
						$line = $fullname . ", " . $titre_ouvrage . ", " . $editeur_ville . ", " . $editeur . ", " . $nb_pages  . " pages, " . $date_publi  . ", " . $collection.".";
					$y += 10; 
				}
				elseif ($idType == 9)
				{
					$line = $titre_ouvrage . ", " . $editeur_ville . ", " . $editeur .", p. " . $page_deb ."-" . $page_fin. ", ". $nb_pages ." pages, ". $date_publi.".";
					$y += 10;
				}

			    $this->SetXY( $x, $y );
				$this->MultiCell($border,3,$line , 0, 'L');
				$this->ln();
			    $this->SetXY( $x, $y ); 
			}

		}
	}

	$id_pers ='';
	if (isset($_GET['id_pers'])) $id_pers = $_GET['id_pers']; 

	// requetes permettant de recupérer les informations du chercheur
	$r = "SELECT p.prenom, p.nom, c.libelle, p.courriel_pro, e.nom,
				p.localite_perso, p.complement_perso, p.nom_rue_perso, p.courriel_perso, p.tel_perso, p.code_postal_perso, p.num_rue_perso,
				p.localite_pro, p.complement_pro, p.nom_rue_pro, p.courriel_pro, p.tel_pro, p.code_postal_pro, p.num_rue_pro		
			FROM personne p, corps c, etablissement e, publication pu
			WHERE p.id = $id_pers
			AND p.id_corps = c.id
			AND p.id_etabl_princ = e.id";


	$q = pg_query ($dbconn, $r);

	// requete permettant de recupérer les theses du chercheur
	$req2 = "SELECT pu.titre_ouvrage, pu.directeur, t.libelle, pu.date_conf, pu.etablissement
			FROM publication pu, type_these t
			WHERE pu.id_personne = $id_pers
			AND t.id = pu.id_type_these
			AND pu.id_type = 0";


	$q2 = pg_query ($dbconn, $req2);	

	// requete permettant de recupérer les publications du chercheur

	$req3 = "SELECT pu.id_type, pu.directeur, pu.titre_communication, pu.titre_journal, pu.revue_volume, pu.page_deb, pu.page_fin, pu.nb_pages, pu.date_publi, pu.auteur_sec, pu.titre_ouvrage, pu.editeur_ville , pu.editeur, pu.collection, pu.date_conf
			FROM publication pu
			WHERE pu.id_personne = $id_pers
			AND pu.visible = true";


	$q3 = pg_query ($dbconn, $req3);	


	// constructeur du pdf
	$pdf = new PDFChercheur();
	$pdf->AddPage();
	// initialisations du pdf avec les requetes que l'on a declarer plus haut
	$pdf->createPDF($q, $q2, $q3);
	$pdf->Output();

?>