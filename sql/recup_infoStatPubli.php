<?php


function tabStatPubli($lettre){

	
	//la liste de tous les chercheurs avec le nombre de publications derrière
	$result= pg_query("SELECT p.id,p.nom,p.prenom,count(pu.id) as nbpubli
		FROM personne p,publication pu
		WHERE p.id = pu.id_personne
		GROUP BY p.nom,p.prenom,p.id 
		ORDER BY p.nom ASC;"); 

	//pour chaque personne on compte le nb de publi par type
	
	while ($row = pg_fetch_row($result))
	{
		
		//si le nom commence par la lettre on affiche
		if($row[1] != "" && $row[1][0] == $lettre || $lettre == "global"){
			$res0=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 0
				AND pu.id_personne=".$row[0]."");

			$p0 = pg_fetch_result($res0, 0, 0);
			

			$res1=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 1
				AND pu.id_personne=".$row[0]."");

			$p1 = pg_fetch_result($res1, 0, 0);
			


			$res3=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 3
				AND pu.id_personne=".$row[0]."");

			$p3 = pg_fetch_result($res3, 0, 0);
			

			$res4=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 4
				AND pu.id_personne=".$row[0]."");

			$p4 = pg_fetch_result($res4, 0, 0);
			

			$res5=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 5
				AND pu.id_personne=".$row[0]."");

			$p5 = pg_fetch_result($res5, 0, 0);
			

			$res6=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 6
				AND pu.id_personne=".$row[0]."");

			$p6 = pg_fetch_result($res6, 0, 0);
			

			$res7=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 7
				AND pu.id_personne=".$row[0]."");

			$p7 = pg_fetch_result($res7, 0, 0);
			

			$res8=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 8
				AND pu.id_personne=".$row[0]."");

			$p8 = pg_fetch_result($res8, 0, 0);
			
			$res9=pg_query("SELECT count(*) as cp
				FROM publication pu
				WHERE pu.id_type = 9
				AND pu.id_personne=".$row[0]."");

			$p9 = pg_fetch_result($res9, 0, 0);
			
			?>
			<tr>
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
	}
	?>
	</table>
	</div>
	</br></br>
	<?php
}

function statPubli($global="",$dateDeb=1,$dateFin=99999){
	//initialise les comptes de publi
	$c0=0;
	$c1=0;
	$c3=0;
	$c4=0;
	$c5=0;
	$c6=0;
	$c7=0;
	$c8=0;
	$c9=0;
	
	//la liste de tous les chercheurs avec le nombre de publications derrière
	$result= pg_query("SELECT id_type,date_publi,date_conf
		FROM publication"); 

	//pour chaque personne on compte le nb de publi par type
	while ($row = pg_fetch_row($result))
	{
		if($row[1] == ""){
			$date = intval(substr($row[2], 0,4));
		}
		else{
			$date = intval($row[1]);
		}
		


		if(($row[0] == 0 && $date >= $dateDeb && $date <= $dateFin) || ($global != ""  && $row[0] == 0)){
			$c0 += 1;
		}
		if(($row[0] == 1 &&  $date >= $dateDeb && $date <= $dateFin)  ||( $global != "" && $row[0] == 1)){
			$c1 += 1;
		}
		if(($row[0] == 3 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 3)){
			$c3 += 1;
		}
		if(($row[0] == 4 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 4)){
			$c4 += 1;
		}
		if(($row[0] == 5 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 5)){
			$c5 += 1;
		}
		if(($row[0] == 6 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 6)){
			$c6 += 1;
		}
		if(($row[0] == 7 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 7)){
			$c7 += 1;
		}
		if(($row[0] == 8 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 8)){
			$c8 += 1;
		}
		if(($row[0] == 9 && $date >= $dateDeb && $date <= $dateFin ) || ($global != "" && $row[0] == 9)){
			$c9 += 1;
		}
	}
	?>
	<input type="hidden" id="c0" value="<?php echo $c0 ?>" >
	<input type="hidden" id="c1" value="<?php echo $c1 ?>" >
	<input type="hidden" id="c3" value="<?php echo $c3 ?>" >
	<input type="hidden" id="c4" value="<?php echo $c4 ?>" >
	<input type="hidden" id="c5" value="<?php echo $c5 ?>" >
	<input type="hidden" id="c6" value="<?php echo $c6 ?>" >
	<input type="hidden" id="c7" value="<?php echo $c7 ?>" >
	<input type="hidden" id="c8" value="<?php echo $c8 ?>" >
	<input type="hidden" id="c9" value="<?php echo $c9 ?>" >




	<?php
}


