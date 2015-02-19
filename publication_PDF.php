<?php 

//	include('test_session.php');
	require( 'fpdf.php' );
	

	//connection à la base
	include("commun/connexion_db.php");

	class PDF extends FPDF
	{
		function createPDF($query)
		{	    
			$publi = pg_fetch_row($query);
			$line ="";

			//$id_personne_publi = $publi[1];
			$id_type_publi = $publi[2];
			//$type_publi_publi = $publi[3];
			$titre_communication_publi = $publi[4];
			$titre_journal_publi = $publi[5];
			$auteur_sec_publi = $publi[6];
			$revue_volume_publi = $publi[7];
			$revue_fascicule_publi = $publi[8];
			$titre_ouvrage_publi = $publi[9];
			$editeur_publi = $publi[10];
			$editeur_ville_publi = $publi[11];
			$collection_publi = $publi[12];
			$url_publi = $publi[13];
			$page_deb_publi = $publi[14];
			$page_fin_publi = $publi[15];
			$nb_pages_publi = $publi[16];
			$date_conf_publi = $publi[17];
			$date_publication = $publi[18];
			$pays_conf_libelle_publi = $publi[19];
			$langue_libelle_publi = $publi[20];
			//$audience_publi = $publi[21];
			$etablissement_publi = $publi[22];
			$directeur_publi = $publi[23];
			//$type_publi_libelle_publi = $publi[24];
			$observation_publi = $publi[25];
			//$selectionner_ordre = $publi[26];
			$nom = $publi[27];
			$prenom = $publi[28];

			$x = 15;
			$y = 10;
			$leftBorder = 190;
		    $this->SetXY( $x, $y );

			$this->SetFont('Arial','B',10);

			if($id_type_publi == 6 || $id_type_publi == 9)
				 $this->MultiCell($leftBorder,3,$titre_ouvrage_publi , 0, 'L');
			else
				$this->MultiCell($leftBorder,3,$titre_communication_publi , 0, 'L');
			$this->SetFont('Arial','',10);			

			
			$this->ln();
			$y+=10;
		    $this->SetXY( $x, $y );

			$fullname =  $prenom . ' ' . $nom;
			$this->Cell(0,0,"Ecrit par : ". $fullname,0,0,'L');

			if ($auteur_sec_publi != "")
			{
			    $y += 5;
			    $this->SetXY( $x, $y );
			    $this->Cell(0,0, "Co auteur : ". $auteur_sec_publi,0,0,'L');
			}

			if ($url_publi != "")
			{
			    $y += 5;
			    $this->SetXY( $x, $y );
				$this->Cell(0,0,$url_publi,0,0,'L');
			}

			if ($id_type_publi != 3 && $id_type_publi!= 4) $line = "publié en : ". $date_publication;
			if($editeur_publi != "") $line = $line . " édité par " . $editeur_publi; 
			if($pays_conf_libelle_publi != "" && $id_type_publi==1 ) $line = $line . ", " . $pays_conf_libelle_publi;
			if($editeur_ville_publi != "")	$line = $line . "(" . $editeur_ville_publi .")";

			if($line!="")
			{
				$y += 5;
				$this->SetXY( $x, $y );
				$this->Cell(0,0,$line,0,0,'L');
			}

			$y += 5;
			$this->Line($x,$y,$leftBorder + 10, $y);

			if ($id_type_publi == 7 || $id_type_publi == 8)
			{
			
				if ($directeur_publi!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,"Publié par : " . $directeur_publi,0,0,'L');
				}	
			
				if ($titre_ouvrage_publi!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->MultiCell($leftBorder,4,"Publié dans : " . $titre_ouvrage_publi, 0, 'L');
					$y += 10;
				}
			}


			if($id_type_publi == 1 || $id_type_publi == 3)
			{
				$line ="";
				if($titre_journal_publi != "" || $titre_ouvrage_publi != "" ) $line =  "paru dans : " ;
				$line = $line . $titre_journal_publi . "  " ;
				$line = $line . $titre_ouvrage_publi . "  " ;
				if ($line!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->MultiCell($leftBorder,4,$line , 0, 'L');
					$y+=5;
				}
			}

			if($id_type_publi == 4 || $id_type_publi ==5)
			{
				if ($titre_ouvrage_publi!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );

					$this->MultiCell($leftBorder,4,"Intitulé du colloque : " . $titre_ouvrage_publi , 0, 'L');
					$y+=10;
				}
			}

			if($id_type_publi == 3 || $id_type_publi == 4 || $id_type_publi == 5)
			{
				if($id_type_publi == 5) $line ="Conférence ";
				else $line = "Communication Orale ";
				
				$line = $line . "en " .  $date_conf_publi . "  " ;
				$line = $line . $pays_conf_libelle_publi . "  " ;
				if ($line!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,$line,0,0,'L');
				}
			}

			if ($id_type_publi == 5 )
			{
				if($etablissement_publi!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,"Etablissement :  ". $etablissement_publi,0,0,'L');
				}
			}

			
			if ($id_type_publi == 4 || $id_type_publi == 5 || $id_type_publi == 7 || $id_type_publi == 8)
			{
				if($collection_publi != "" )
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,"Collections : ". $collection_publi,0,0,'L');
				}
			}

			if ($id_type_publi == 1 || $id_type_publi == 3 )
			{
				$line ="";
				if($revue_volume_publi != "") $line = "volume n° : " . $revue_volume_publi .  "  ";
				if($revue_fascicule_publi != "") $line = "fascicule n° : " . $revue_fascicule_publi;
				$y += 5;
				$this->SetXY( $x, $y );
				$this->Cell(0,0,$line,0,0,'L');
			}

			if ($observation_publi != "" )
			{
				$y += 5;
				$this->SetXY( $x, $y );
				$this->MultiCell($leftBorder,3,$observation_publi , 0, 'L');
				$y += 25;
			}

			$y += 5;

			if ($id_type_publi == 1 || $id_type_publi == 3 || $id_type_publi == 7 )
			{
				$line="";
				if($page_deb_publi!="") $line = "Première page : " . $page_deb_publi; 
				if($page_deb_publi!="") $line =$line. " Dernière pages ". $page_fin_publi;
				if ($line!="")
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,$line,0,0,'L');
				}
			}

			if ($id_type_publi == 1 || $id_type_publi == 3 || $id_type_publi == 6 ||
				$id_type_publi == 7 || $id_type_publi == 8 || $id_type_publi == 9 )
			{
				if($nb_pages_publi != "" )
				{
					$y += 5;
					$this->SetXY( $x, $y );
					$this->Cell(0,0,"Nombre de pages : ". $nb_pages_publi,0,0,'L');
				}
			}
			
 			$y += 5;
			$this->SetXY( $x, $y );
			$this->Cell(0,0,$langue_libelle_publi,0,0,'L');

    		
		}
	}

	$id_publi ='';
	if (isset($_GET['id_publi'])) $id_publi = $_GET['id_publi']; 

	$r = "SELECT  pub.id, pub.id_personne, t_pub.id, t_pub.libelle, pub.titre_communication, pub.titre_journal, pub.auteur_sec, pub.revue_volume, pub.revue_fascicule, 
								pub.titre_ouvrage, pub.editeur, pub.editeur_ville, pub.collection, pub.url, pub.page_deb, pub.page_fin, pub.nb_pages, pub.date_conf, pub.date_publi, 
								pa.libelle, l.libelle, pub.audience, pub.etablissement, pub.directeur, t_these.libelle, pub.observation, pub.selectionner_ordre, pers.nom, pers.prenom
						FROM publication pub
							LEFT OUTER JOIN type_publication t_pub
								ON pub.id_type = t_pub.id
							LEFT OUTER JOIN pays pa
								ON pub.id_pays_conf = pa.id
							LEFT OUTER JOIN langue l
								ON pub.id_langue = l.id
							LEFT OUTER JOIN type_these t_these
								ON pub.id_type_these = t_these.id
							LEFT OUTER JOIN personne pers
								ON pub.id_personne = pers.id

						WHERE pub.id =" . $id_publi. "
						ORDER BY pub.date_publi DESC, date_conf DESC, pub.id DESC";

	$q = pg_query ($dbconn, $r);	


	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->createPDF($q);
	$pdf->Output();

?>