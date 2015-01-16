<?php
 // utilisable pour la creation de personne  et la modification
function affichage_form_morale($id_personne) { 
	
	if ($id_personne!=0) {				
		?> <form action="script_personne.php?type=modif" name="formulaire" id="formulaire" method="post"  onSubmit="return check_personne();" >		
		<input  name="id_personne" type="HIDDEN" value=<?php echo $id_personne; ?> id="id_personne" />
		<input  name="titre" type="HIDDEN" value='0' id="titre" />
		<input  name="prenom" type="HIDDEN" value='MORALE' id="prenom" />
		<input  name="id_corps" type="HIDDEN" value='0' id="id_corps" />	

		<?php 		
		$personne_modif = pg_query("SELECT id, id_titre, nom, prenom, id_corps,	code_postal_pro,localite_pro, num_rue_pro, nom_rue_pro, complement_pro, 
												code_postal_perso, localite_perso, num_rue_perso,nom_rue_perso,complement_perso,tel_pro,tel_perso,courriel_pro,
												courriel_perso, courrier, revue, id_pays_pro, id_pays_perso, commentaire FROM personne WHERE id='$id_personne'");	
		$old_personne = pg_fetch_row($personne_modif);
		$old_id=$old_personne[0];					
		$old_id_titre=$old_personne[1];
		$old_nom=$old_personne[2];
		$old_prenom=$old_personne[3];
		$old_id_corps=$old_personne[4];
		$old_code_postal_pro=$old_personne[5];
		$old_localite_pro=$old_personne[6];
		$old_num_rue_pro=$old_personne[7];
		$old_nom_rue_pro=$old_personne[8];
		$old_complement_pro=$old_personne[9];
		$old_code_postal_perso=$old_personne[10];
		$old_localite_perso=$old_personne[11];
		$old_num_rue_perso=$old_personne[12];
		$old_nom_rue_perso=$old_personne[13];
		$old_complement_perso=$old_personne[14];
		$old_tel_pro=$old_personne[15];
		$old_tel_perso=$old_personne[16];
		$old_courriel_pro=$old_personne[17];
		$old_courriel_perso=$old_personne[18];
		$old_courrier=$old_personne[19];
		$old_revue=$old_personne[20];	
		$old_id_pays_pro=$old_personne[21];	
		$old_id_pays_perso=$old_personne[22];
		$old_commentaire=$old_personne[23];			
	}
	else { 
	?>	<form action="script_personne.php?type=ajout" name="formulaire" id="formulaire" method="post"  > 
		<input  name="titre" type="HIDDEN" value='0' id="titre" />
		<input  name="prenom" type="HIDDEN" value='MORALE' id="prenom" />
		<input  name="id_corps" type="HIDDEN" value='0' id="id_corps" />
	
	<?php			
		
	}
	?>		
	<br>	
	<label for="nom">Nom</label>  <input type="text" maxlength="30 "name="nom" id="nom" <?php  if ($old_nom!= ''){echo "value='".stripslashes(htmlspecialchars($old_nom, ENT_QUOTES))."'";}?> onKeyUp="javascript:couleur(this);"/> <font id='ast'>*</font>		
	<br>	

	<div class="info">							
		<div class="principal"  >
			<h2>  Informations professionnelles </h2>	
			<label for="num_rue_pro">Numéro de rue</label> <input type="text" maxlength="30 "name="num_rue_pro" id="num_rue_pro"  <?php  if ($old_num_rue_pro!= ''){echo "value='$old_num_rue_pro'";}?> onKeyUp="javascript:couleur(this);"/> 	
			<br>	
			<label for="complement_pro">(complément) </label> <input type="text" maxlength="30 "name="complement_pro" id="complement_pro"  <?php  if ($old_complement_pro!= ''){echo "value='".stripslashes(htmlspecialchars($old_complement_pro, ENT_QUOTES))."'";}?> onKeyUp="javascript:couleur(this);"/>
			<br>	
			<label for="nom_rue_pro">Nom de rue  </label> <input type="text" maxlength="30 "name="nom_rue_pro" id="nom_rue_pro"  <?php  if ($old_nom_rue_pro!= ''){echo "value='".stripslashes(htmlspecialchars($old_nom_rue_pro, ENT_QUOTES))."'";}?> onKeyUp="javascript:couleur(this);"/> <font id='ast'>*</font>		
			<br>												
			<label for="code_postale_pro">Code postal </label> <input type="text" maxlength="30 "name="code_postal_pro" id="code_postal_pro" <?php  if ($old_code_postal_pro!= ''){echo "value='$old_code_postal_pro'";}?>  onKeyUp="javascript:couleur(this);"/> <font id='ast'>*</font>		
			<br>	
			<label for="localite_pro">Ville</label> <input type="text" maxlength="30 "name="localite_pro" id="localite_pro" <?php  if ($old_localite_pro!= ''){echo "value='".stripslashes(htmlspecialchars($old_localite_pro, ENT_QUOTES))."'";}?>  onKeyUp="javascript:couleur(this);" /> <font id='ast'>*</font>		
			<br>	
			<?php select_ordre ('Pays', 'id_pays_pro','pays', 'libelle',$old_id_pays_pro );	?>&nbsp;<?php  if($_SESSION['modif_pays']=='t') echo"<a href='modif_pays.php'><img src='images/button_edit.png' ></a>";?>

			<br>				
			<label for="tel_pro">Téléphone  </label> <input type="text" maxlength="30 "name="tel_pro" id="tel_pro" <?php  if ($old_tel_pro!= ''){echo "value='$old_tel_pro'";}?>  onKeyUp="javascript:couleur(this);"/> 
			<br>	
			<label for="courriel_pro">Courriel</label>  <input type="text" maxlength="30 "name="courriel_pro" id="courriel_pro" <?php  if ($old_courriel_pro!= ''){echo "value='$old_courriel_pro'";}?>  onKeyUp="javascript:couleur(this);" /> <font id='ast'>*</font>		
			<br>
		</div>				
		<div class='clear'/>	
	</div>		
	<h2>  Etablissement</h2>			
	<div onclick="document.getElementByClassName('document','*','AutoCompleteDiv').style.display='none';"  class="principal">					
		<label for="ville"> Ville  </label> 
		<input name="ville" id="ville" <?php  if ($old_ville_eta!= ''){echo "value='$old_ville_eta'";}?> autocomplete="off" onclick="initAutoComplete(document.getElementById('no'),document.getElementById('ville'),
		document.getElementById('no'),'libelle','ville','libelle') " onchange="formu_lie('nom_var=etablissement&nom_ville_eta='+this.value,'formulaire_lie_etablissement.php', 'POST','liste_etablissement');"onload="formu_lie('nom_var=etablissement&nom_ville_eta='+this.value,'formulaire_lie_etablissement.php', 'POST','liste_etablissement');">
		</div>	
		<!-- ICI  on met un bloc avec un id ou va s'insérer le code de
		 la seconde liste déroulande -->
	<div class="secondaire">
		<div id="liste_etablissement">   								
		</div>
	</div>	
	<br><br>
	</div>					
		<div class='position_submit'>
			<INPUT type="button" onClick="submit();" value="Valider" >
		</div>		
	</div>
</form>	
<?php 
}
?>