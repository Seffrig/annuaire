<?php
/* lit un fichier en lecture et remplace les caractères */
function remplace($fichier,$changements)
{

	//crée une ressource nommée, spécifiée par le paramètre filename
	$pointeur = @fopen($fichier,'r');
	
	//lit jusqu'à length  octets dans le fichier référencé par handle
	$buffer = fread($pointeur,filesize($fichier));
	
	fclose($pointeur);
	// remplace toutes les occurences dans une chaine 
	echo str_replace(array_keys($changements),array_values($changements),$buffer);
}

// créé un select avec les valeur presente dans la base de donnée ordonnée par le Champ
function select_simple($description, $nom, $table, $champ, $preselection) 
{
	echo "<label for=".$nom.">".$description."</label> ";
	echo "<select name=".$nom." id=".$nom.">";

	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." order by ".$champ." ");

	while ($cible = pg_fetch_row($result))
	{ 				
		echo "<option value='$cible[0]'";
		if ($cible[1]==$preselection) {echo "selected='selected'";}
		echo ">$cible[1]</option>";			
	}								
	echo "</select> ";		 
}

// créé un select_simple avec le choix VIDE en plus  
function select_simple_vide($description, $nom, $table, $champ) 
{
	echo "<label for=".$nom.">".$description."</label>  ";
	echo "<select name=".$nom." id=".$nom.">";
	echo "<option value='' selected='selected' > </option> ";			
	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." order by ".$champ." ");		
	while ($cible = pg_fetch_row($result))
	{ 				
		echo "<option value='$cible[0]'";		
		echo ">$cible[1]</option>";			
	}								
	echo "</select> ";		 
}


//  trier par champ ORDRE sans champ vide
function select_ordre_simple($description, $nom, $table, $champ, $preselection) {
	echo "<label for=".$nom.">".$description."</label>  ";
	echo "<select name=".$nom." id=".$nom.">";
	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." ORDER by ordre ");		
	while ($cible = pg_fetch_row($result))
	{ 				
		echo "<option value='$cible[0]'";	
		if ($cible[0]==$preselection) {echo "selected='selected'";}
		echo ">$cible[1]</option>";			
	}								
	echo "</select> ";
}

//  trier par champ ORDRE
// requete : select id, $champ from $table order by ordre
// $identifiant_css sert à l'identifiant du composant pour la css
// $libelle_affichage le libellé affiché
// $ preselection pour spécifié quelle élément et sélectionné
function select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
{
	echo "<label for=".$identifiant_css.">".$libelle_affichage."</label>  ";
	echo "<select name=".$identifiant_css." id=".$identifiant_css.">";
	echo "<option value='' selected='selected' > </option> ";	
	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." ORDER by ordre ");		
	while ($row = pg_fetch_row($result))
	{ 				
		echo "<option value = '$row[0]'";	
		if ($row[0] == $preselection) 
		{
			echo "selected='selected'";
		}
		echo ">$row[1]</option>";			
	}								
	echo "</select> ";		 
}

//  trier par champ ORDRE
// requete : select id, $champ from $table order by ordre
// $identifiant_css sert à l'identifiant du composant pour la css
// $libelle_affichage le libellé affiché
// $ preselection pour spécifié quelle élément et sélectionné
function select_ordre_validation($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
{
	echo "<label for=".$identifiant_css.">".$libelle_affichage."</label>  ";
	echo "<select name=".$identifiant_css." id=".$identifiant_css." onChange='this.form.submit();'>";
	echo "<option value='' selected='selected' > </option> ";	
	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." ORDER by ordre ");		
	while ($row = pg_fetch_row($result)) 
	{ 				
		echo "<option value = '$row[0]'";	
		if ($row[0] == $preselection) 
		{
			echo "selected='selected'";
		}
		echo ">$row[1]</option>";			
	}								
	echo "</select> ";	
	echo '<noscript><input type="submit" value="Changer" /></noscript>';	
}

//Utilisée dans formulaire_personne

//  trier par champ ORDRE
// requete : select id, $champ from $table order by ordre
// $identifiant_css sert à l'identifiant du composant pour la css
// $libelle_affichage le libellé affiché
// $ preselection pour spécifié quelle élément et sélectionné
function selection_menu_der($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
{
	echo "<label for=".$identifiant_css.">".$libelle_affichage."</label>  ";
	echo "<select name=".$identifiant_css." id=".$identifiant_css.">";
	echo "<option value='' selected='selected' > </option> ";	
	$result = pg_query("SELECT  id, ".$champ."  FROM ".$table." ORDER by ".$champ." ");		
	while ($row = pg_fetch_row($result)) 
	{ 				
		echo "<option value = '$row[0]'";	
		if ($row[0] == $preselection) 
		{
			echo "selected='selected'";
		}
		echo ">$row[1]</option>";			
	}								
	echo "</select> ";		 
}

function selection_menu_der2 ($nom, $champ, $table, $id_user, $description ) { 

	echo "<label for=$nom> $description</label>  ";	
	echo "<select name=$nom id=$nom>";	
	$result = pg_query("SELECT  id, $champ FROM $table order by $champ ");
	if (!$result) {  
		echo "Pas de $table dans la bdd\n";  
		exit;  
	}  			
	while ($courant = pg_fetch_row($result)) { 				
		echo "<option value='$courant[0]'";
		if ($courant[0]== $id_user)  {echo " selected='selected' ";}
		echo ">$courant[1]</option>";			
	}
	echo "</select>";
}		

?>

<?php
// utilisé lors des creation ou modification de table 
// affiche le champ d 'une table dans un tableau
function affichage_colonne_encore($champ, $table, $page_modif, $page_sup) 
{
	$result= pg_query("SELECT $champ FROM $table ORDER BY $champ"); 
	echo '<ul class="liste">';

	while ($row = pg_fetch_row($result))
	{
		echo '<li>	
		<a>	';						
		echo " <a href=' " . $page_modif . "?libelle_rech=" . $row[0] . " '> " . $row[0] . " </a>";
		?>
		<a href="javascript: 
		if (confirm('Cette suppression est définitive. Confirmez-vous?')) 
		{ 
		window.location.href='suppression_<?php echo $page_sup;?>.php?objet=<?php echo $row[0];?>' 
	} 
	else 
	{ 
	void('') 
};"> 
<img width='16px' src='images/CroixSupprimer.gif' >
</a>
<?php
echo '</a></li>';					
}
?>
</ul>	
<br>
<?php	
}

// utilisé lors des creation ou modification de table 
// affiche le champ d 'une table dans un tableau
function affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
{
	$result= pg_query("SELECT $id, $champ FROM $table ORDER BY $champ"); 
	echo '<ul class="liste">';

	while ($row = pg_fetch_row($result))
	{
		echo '<li>';						
		echo " <a href=' " . $page_modif . "?id_rech=" . $row[0] . " '> " . $row[1] . " </a>";
		?>
		<a href="javascript: 
		if (confirm('Cette suppression est définitive. Confirmez-vous?')) 
		{ 
		window.location.href='<?php echo $page_sup;?>?type_modif=supp&id_rech=<?php echo $row[0];?>' 
	} 
	else 
	{ 
	void('') 
};"> 
<img width='16px' src='images/croixsupprimer.gif' >
</a>
<?php
echo '</li>';					
}
?>
</ul>	
<br>
<?php	
}

// utilisé lors des creation ou modification de table 
// affiche le champ d 'une table dans un tableau
function affichage_colonne_2_tables($id1, $champ1, $table1, $rel1, $rel2, $champ2, $table2, $page_modif, $page_sup) 
{
	$result= pg_query("SELECT $table1.$id1, $table1.$champ1, $table2.$champ2 
		FROM $table1, $table2
		WHERE $table1.$rel1 = $table2.$rel2
		ORDER BY $table1.$champ1"); 
	echo '<ul class="listes">';

	$colonne=1;
	while ($row = pg_fetch_row($result))
	{
		if ($colonne == 4){$colonne=1;}
		if ($colonne == 1) {echo '<li id="tableau_3_col">';}
		echo '<span id="col' . $colonne. '">';						
		echo " <a href=' " . $page_modif . "?id_rech=" . $row[0] . " '> " . $row[1] . " (" . $row[2] . ") </a>";
		?>
		<a href="javascript: 
		if (confirm('Cette suppression est définitive. Confirmez-vous?')) 
		{ 
		window.location.href='<?php echo $page_sup;?>?type_modif=supp&id_rech=<?php echo $row[0];?>' 
	} 
	else 
	{ 
	void('') 
};"> 
<img width='16px' src='images/croixsupprimer.gif' >
</a>

<?php
echo '</span>';
if ($colonne == 3) {echo '</li>';}	
$colonne ++;
}
?>
</ul>	
<br>
<?php	
}

// renvoie TRUE sur l'id recherche se trouve dans la table
function trouve_a_modifier_temp($table, $champ, $id_rech) { 
	$trouve=false;
	// si on fait une recherche
	if(!empty($id_rech)) 
	{
		$result = pg_query("SELECT id FROM $table WHERE $champ='".$id_rech."'");	
		if($result) {
			while ($row = pg_fetch_row($result)) {
				$trouve=true;
				$_SESSION['id_modif']=$row[0];	

			}
		}
		else {
			echo "erreur'dapostrophe? pas de champ correspondant";					
		}
	}	
	return $trouve;
}

// renvoie TRUE sur l'id recherche se trouve dans la table
function trouve_a_modifier($table, $champ, $libelle_rech) { 
	$id_rech ='';
	// si on fait une recherche
	if(!empty($libelle_rech)) 
	{
		$result = pg_query("SELECT id FROM $table WHERE $champ='".$libelle_rech."'");	
		if($result) {
			while ($row = pg_fetch_row($result)) {

				$id_rech=$row[0];	

			}
		}
		else {
			echo "erreur'dapostrophe? pas de champ correspondant";					
		}
	}	
	return $id_rech;
}

// renvoie TRUE sur l'id recherche se trouve dans la table
function trouve_a_modifier_LIKE($table, $champ, $libelle_rech, $id) { 
	$id_rech ='';
	// si on fait une recherche
	if(!empty($libelle_rech)) 
	{
		$result = pg_query("SELECT $id FROM $table WHERE $champ LIKE '".$libelle_rech."%'");	
		if($result) {
			while ($row = pg_fetch_row($result)) {

				$id_rech=$row[0];	

			}
		}
		else {
			echo "erreur'dapostrophe? pas de champ correspondant";					
		}
	}	
	return $id_rech;
}

function modifie_un_champ ($table, $champ, $id_rech) { 	
	if(isset($id_rech)) {   //										
		$result = pg_query("UPDATE $table SET $champ ='".$id_rech."'
			WHERE id = '".$_SESSION['id_modif']."'");
		$_SESSION['modif']='Enregistrement effectué';
	}	
}

function formulaire_modif_un_champ ($trouve, $champ, $table, $page, $description) { 	
	// si en modification de champ
	if ($trouve==true) 
	{
		$result = pg_query("SELECT  $champ FROM $table WHERE id='".$_SESSION['id_modif']."'");			
		while ($row = pg_fetch_row($result)){	
			?>			
			<form action="<?php echo $page; ?>" method='get'>						
				Ancienne valeur: <?php echo $row[0];?>
				<br><label for='<?php echo $table; ?>' >   					
				<?php echo $description; ?></label> : <input type="text" value=<?php  echo $row[0]; ?> name="<?php echo $table; ?>" id="<?php echo $table; ?>" size="20" />
				<br>	
				<input type="submit"   value="Modifier"  /><br />				
			</form>								
			<br>		
			<?php  				
		}
	}
}

// enlever les accents
function removeaccents($string)
{
	$str = htmlentities($string, ENT_NOQUOTES, 'utf-8');
	$str = preg_replace('#\&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring)\;#', '\1', $str);
	$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str);
	$str = preg_replace('#\&[^;]+\;#', '', $str);
	$str= strtr($str,  "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn" );
	return $str;
}
/* ******************************* */
/* affichage des tableaux requêtes */
/* ******************************* */
function genere_test_caractere ($condition, $champ) {
	if($_POST["$champ"] != "")
	{
		if ($condition != "")	
		{
			$condition = $condition ."AND ";
		}
		$condition = $condition ." $champ ILIKE '%".$_POST["$champ"]."%' ";
	} 	
	return $condition;
} 

function genere_test_nombre ($condition, $champ) {
	if($_POST["$champ"] != "")
	{
		// ilike ne fonctionne pas avec les nombres
		if ($condition != "")	
		{
			$condition = $condition ."AND ";
		}
		$condition = $condition ." $champ = '".$_POST["$champ"]."'";
	} 	
	return $condition;
} 

/* ******************************* */
/*     fonction mot de passe       */
/* ******************************* */
function fct_passwd( $chrs = "")
{

	if( $chrs == "" ) $chrs = 8;
	$chaine = "";

	$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

	mt_srand((double)microtime()*1000000);
	$newstring="";

	while( strlen( $newstring )< $chrs ) {

		$newstring .= $list[mt_rand(0, strlen($list)-1)];

	}

	return $newstring;
}

?>
