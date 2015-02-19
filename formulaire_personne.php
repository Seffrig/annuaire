<?php
	
	if ($_SESSION['type_user'])
	{  
		echo" <a href='reinit_mon_pass.php'>Changer son mot de passe</a>";  
	}
	
	// teste si modification ou ajout
	if ($id_personne != 0) 
	{	// si on veut charger les infos d'une personne
 
		echo '<form action="script_personne.php?type=modif" name="formulaire" id="formulaire" method="get"  onSubmit="return check_personne();" >';
		echo '<input  name="id_personne" type="HIDDEN" value='.$id_personne.' id="id_personne" />';
		
	}
	//description pour formulaire d'ajout
	else 
	{ 
		echo '<form action="script_personne.php?type=ajout" name="formulaire" id="formulaire" method="get" onSubmit="return check_personne();" > ';																								
	}
	?>		
	<br>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Civilité </h2>
		</div>
		<div class="panel-body">	
	<?php
	// Mr Mme Mlle

	if (!$id_titre){$id_titre=1;}
	// selection_menu_der($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
	selection_menu_der ('Titre', 'new_titre','titre' , 'libelle', $id_titre);		
	?>
	
	<br>	
		
	<label class="petitlabel" for="new_nom">Nom :</label>  
	<input type="text" maxlength="30" name="new_nom" id="new_nom" 
		<?php  
		if ($nom!= ''){
			echo "value='".stripslashes(htmlspecialchars($nom, ENT_QUOTES))."'";
		}
		?> onKeyUp="javascript:couleur(this);"/> 

	<font class='ast'>*</font>		
	<br>	
	<label class="petitlabel" for="new_prenom">Prénom :</label> 
	<input type="text" maxlength="30" name="new_prenom" id="new_prenom" 
		<?php  if ($prenom!= ''){echo "value='".stripslashes(htmlspecialchars($prenom, ENT_QUOTES))."'";}?> onKeyUp="javascript:couleur(this);"/> 
	<font class='ast'>*</font>		
	<br>
	<?php
		// select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) // retourne une liste triée
		select_ordre ('Corps', 'new_id_corps','corps', 'libelle', $id_corps );
		if($_SESSION['modif_corps']=='t') 
		{
			echo"<a href='modif_corps.php'><img src='images/button_edit.png' ></a>";
		}
	?>
	<br>
			
	<br>
	<label for="new_commentaire">Autre(s) responsabilité(s) </label><br>
	<TEXTAREA name="new_commentaire" id="new_commentaire" rows=3 COLS=60  maxlength="300"><?php if ($commentaire!= ''){echo $commentaire;}?></TEXTAREA><br>
	<div class='indication_form'>(Responsabilités institutionnelles ou administratives)</div>	

	<br/>
	<label for="new_page_pro">Page professionelle</label> 
	<input type="text" maxlength="100" name="new_page_pro" id="new_page_pro" style="width: 500px"
		<?php  if ($page_pro!= ''){echo "value='".stripslashes(htmlspecialchars($page_pro, ENT_QUOTES))."'";}?>  />
		<div class='indication_form'>(Lien vers votre page professionnelle si nécessaire)</div>	
	
	</div>
	</div>
	
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Contact professionnel </h2>
		</div>
		<div class="panel-body">		
					
			<label class="grandlabelbis" for="new_num_rue_pro">Numéro de rue :</label> 
			<input type="text" maxlength="30" name="new_num_rue_pro" id="new_num_rue_pro"  
				<?php  if ($num_rue_pro!= ''){echo "value='$num_rue_pro'";}?> onKeyUp="javascript:couleur(this);"/> 	
			<font class='ast'>*</font>
			<br>	
			<label class="grandlabelbis" for="new_nom_rue_pro">Nom de rue :</label> 
			<input type="text" maxlength="30" name="new_nom_rue_pro" id="new_nom_rue_pro"  
				<?php  if ($nom_rue_pro!= ''){echo "value='".stripslashes(htmlspecialchars($nom_rue_pro, ENT_QUOTES))."'";}?> onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>		
			<br>			
			<label class="grandlabelbis" for="new_complement_pro">(complément) :</label> 
			<input type="text" maxlength="30" name="new_complement_pro" id="new_complement_pro"  
				<?php  if ($complement_pro!= ''){echo "value='".stripslashes(htmlspecialchars($complement_pro, ENT_QUOTES))."'";}?>/>
			<br>				
			<label class="grandlabelbis" for="new_code_postal_pro">Code postal :</label> 
			<input type="text" maxlength="30" name="new_code_postal_pro" id="new_code_postal_pro" 
			<?php  if ($code_postal_pro!= ''){echo "value='$code_postal_pro'";}?>  onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>		
			<br>	
			<label class="grandlabelbis" for="new_localite_pro">Ville :</label> 
			<input type="text" maxlength="30" name="new_localite_pro" id="new_localite_pro" 
			<?php  if ($localite_pro!= ''){echo "value='".stripslashes(htmlspecialchars($localite_pro, ENT_QUOTES))."'";}?>  onKeyUp="javascript:couleur(this);" /> 
			<font class='ast'>*</font>		
			<br>	
			<?php
				//select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection)) // retourn une liste triée
				select_ordre ('Pays', 'new_id_pays_pro','pays', 'libelle', $id_pays_pro, "113px" );	 
				if($_SESSION['modif_pays']=='t') 
				{
					echo"<a href='modif_pays.php'><img src='images/button_edit.png' ></a>";
				}
			?>

			<br>				
			<label class="grandlabelbis" for="new_tel_pro">Téléphone :</label> 
			<input type="text" maxlength="30" name="new_tel_pro" id="new_tel_pro" 
				<?php  if ($tel_pro!= ''){echo "value='$tel_pro'";}?>  onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>	
			<br>	
			<label class="grandlabelbis" for="new_courriel_pro">Courriel :</label>  
			<input type="text" maxlength="100" name="new_courriel_pro" id="new_courriel_pro" 
				<?php  if ($courriel_pro!= ''){echo "value='$courriel_pro'";}?>  onKeyUp="javascript:couleur(this);" /> 
			<font class='ast'>*</font>		
			<br>
		</div>	
	</div>		
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Contact personnel</h2>
		</div>
		<div class="panel-body">		
			<label class="grandlabelbis" for="new_num_rue_perso">Numéro de rue :</label>  
			<input type="text" maxlength="30" name="new_num_rue_perso" id="new_num_rue_perso"
				<?php  if ($num_rue_perso!= ''){echo "value='$num_rue_perso'";}?> />
			<br>
			<label class="grandlabelbis" for="new_nom_rue_perso">Nom de rue :</label>  
			<input type="text" maxlength="30" name="new_nom_rue_perso" id="new_nom_rue_perso" 
				<?php  if ($nom_rue_perso!= ''){echo "value='".stripslashes(htmlspecialchars($nom_rue_perso, ENT_QUOTES))."'";}?>  />
			<br>	
			<label class="grandlabelbis" for="new_complement_perso">(complément) :</label> 
			<input type="text" maxlength="30" name="new_complement_perso" id="new_complement_perso"
				<?php  if ($complement_perso!= ''){echo "value='".stripslashes(htmlspecialchars($complement_perso, ENT_QUOTES))."'";}?>  />
			<br>	
			<label  class="grandlabelbis"for="new_code_postal_perso">Code postal :</label> 
			<input type="text" maxlength="30" name="new_code_postal_perso" id="new_code_postal_perso"
				<?php  if ($code_postal_perso!= ''){echo "value='$code_postal_perso'";}?>  />
			<br>	
			<label class="grandlabelbis"  for="new_localite_perso">Ville :</label> 
			<input type="text" maxlength="100" name="new_localite_perso" id="new_localite_perso"
				<?php  if ($localite_perso!= ''){echo "value='".stripslashes(htmlspecialchars($localite_perso, ENT_QUOTES))."'";}?>  />
			<br>	
			<?php 
				//select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) // retourn une liste triée
				select_ordre ('Pays', 'new_id_pays_perso','pays', 'libelle', $id_pays_perso, "113px" );	  
				if($_SESSION['modif_pays']=='t') 
				{
					echo"<a href='modif_pays.php'><img src='images/button_edit.png' ></a>";
				}
			?>
	
			<br>
			<label class="grandlabelbis" for="new_tel_perso">Téléphone :</label> 
			<input type="text" maxlength="30" name="new_tel_perso" id="new_tel_perso"
				<?php  if ($tel_perso!= ''){echo "value='$tel_perso'";}?>  />
			<br>	
			<label class="grandlabelbis" for="new_courriel_perso">Courriel :</label> 
			<input type="text" maxlength="30" name="new_courriel_perso" id="new_courriel_perso"
				<?php  if ($courriel_perso!= ''){echo "value='$courriel_perso'";}?> />
			<br>
				<INPUT type="checkbox" name="visible_email_perso" value="visible_email_perso_oui" <?php if ($visible_email_perso=='t'){echo "checked='checked'";} ?>> Je souhaite que mon courriel personnel apparaisse en ligne 	
		</div>	
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Etablissement</h2>
		</div>
		<div class="panel-body">		
			<?php 
			include("formulaire_personne_etablissement.php"); 
			?>
			<!-- ICI  on met un bloc avec un id ou va s'insérer le code de
			 la seconde liste déroulande -->
			<br>
		</div>		
	</div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h2 class="panel-title">Equipe de recherche</h2>
		</div>
		<div class="panel-body">	
			<?php include("formulaire_personne_equipe_recherche.php"); ?>
		</div>		
	</div>	
	
							
		<!--
		<br>
		<b>Preférence d'envoi pour l'annuaire</b>
		<br>
		Adresse professionnelle
		<input type="radio" name="new_revue" value="pro" id="pro" checked='checked' /> 
		<input type="radio" name="new_revue" value="perso" id="perso" <?php /*if ($revue=='perso') {echo "checked='checked'";}*/?>  /> Adresse personnelle
		<br>
		-->
		
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Préférence d'envoi pour les courriels</h2>
			</div>
			<div class="panel-body">	
				<input type="radio" name="new_courrier" value="pro" id="pro" checked='checked' />Adresse professionnelle</br>
				<input type="radio" name="new_courrier" value="perso" id="perso" <?php if ($courrier=='perso') {echo "checked='checked'";}?>/>Adresse personnelle
				

			</div>
		</div>
		<br>		
		<div class='position_submit'>
			<INPUT type="submit" onClick="return check_personne();" value="Valider" style="width:130px ; height : 50px;margin-left:30%"  >
			<a href="compte.php?id_personne=<?php echo $id_personne ?>" > <input type="button" value="Annuler"  style="width:130px ; height : 50px"> </a>
		</div>		
	<br>	
</form>	
