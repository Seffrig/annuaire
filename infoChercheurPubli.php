<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '	<script type="text/javascript" src="js/jquery.js"></script>
								<script type="text/javascript" src="js/simpleautocomplete.js"></script>
								<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    							';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/simpleautocomplete.css" />';
$changements['__TITLE__'] = '<title>Recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="recherche">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="recherche">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";


// vérifie les droits pour la page
$page="recherche";
include("verification_droit.php");	

include ("sql/recup_personne.php"); 

$c0=0;
$c1=0;
$c3=0;
$c4=0;
$c5=0;
$c6=0;
$c7=0;
$c8=0;
$c9=0;

function affichecomptepubli(){
//  la liste de tous les chercheurs avec le nombre de publications derrière
$result= pg_query("SELECT p.id,nom,prenom,count(pu.id) as nbpubli
						FROM personne p,publication pu
						WHERE p.id = pu.id_personne
						GROUP BY p.nom,p.prenom,p.id 
						ORDER BY p.nom ASC;"); 
?>
</div><!---pour fermer div général !-->
<div style='overflow-y:scroll;width:1080px;height:500px;margin-left:10%'>
<table style='background-color:white;width:899px' class="table table-bordered table-hover">
	<tr>
		<th >Chercheur</th>
		<th >Total de publication</th>
		<th> These </th>
		<th>Article dans une revue</th>
		<th >Communications avec actes</th>
		<th >Communications sans actes</th>
		<th >Conférence invitée</th>
		<th >Ouvrage</th>
		<th >Chapitre d'ouvrage</th>
		<th >Direction d'ouvrage</th>
		<th >Autre type de publication</th>
		
		

	</tr>
	<tr>
		<?php
		while ($row = pg_fetch_row($result))
		{
			$res0=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 0
						AND pu.id_personne=".$row[0]."");
			
			$p0 = pg_fetch_result($res0, 0, 0);
			$c0 += $p0;

			$res1=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 1
						AND pu.id_personne=".$row[0]."");
			
			$p1 = pg_fetch_result($res1, 0, 0);
			$c1 += $p1;
			

			$res3=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 3
						AND pu.id_personne=".$row[0]."");
			
			$p3 = pg_fetch_result($res3, 0, 0);
			$c3 += $p3;

			$res4=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 4
						AND pu.id_personne=".$row[0]."");
			
			$p4 = pg_fetch_result($res4, 0, 0);
			$c4 += $p4;

			$res5=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 5
						AND pu.id_personne=".$row[0]."");
			
			$p5 = pg_fetch_result($res5, 0, 0);
			$c5 += $p5;

			$res6=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 6
						AND pu.id_personne=".$row[0]."");
			
			$p6 = pg_fetch_result($res6, 0, 0);
			$c6 += $p6;

			$res7=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 7
						AND pu.id_personne=".$row[0]."");
			
			$p7 = pg_fetch_result($res7, 0, 0);
			$c7 += $p7;

			$res8=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 8
						AND pu.id_personne=".$row[0]."");
			
			$p8 = pg_fetch_result($res8, 0, 0);
			$c8 += $p8;
			
			$res9=pg_query("SELECT count(*) as cp
						FROM publication pu
						WHERE pu.id_type = 9
						AND pu.id_personne=".$row[0]."");
			
			$p9 = pg_fetch_result($res9, 0, 0);
			$c9 += $p9;







			
			?>
			<td><?php echo $row[1]." ".$row[2] ?></td>
			<td><?php echo $row[3] ?></td>
			<td><?php echo $p0 ?></td>
			<td><?php echo $p1 ?></td>
			<td><?php echo $p3 ?></td>
			<td><?php echo $p4 ?></td>
			<td><?php echo $p5 ?></td>
			<td><?php echo $p6 ?></td>
			<td><?php echo $p7 ?></td>
			<td><?php echo $p8 ?></td>
			<td><?php echo $p9 ?></td>
		</tr>
			<?php

		}
		?>
</table>
</div>
}
?>

</br></br>


<?php
		include ("templates/footer.php");			