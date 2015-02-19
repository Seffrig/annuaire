<tr>
	<th ><input type="text" maxlength="4" size="6" name="new_annee" id="new_annee" onkeypress="chiffres(event)" value="<?php echo $annee;?>" /></th>
	<th>
		<?php
			//select_ordre($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
			select_ordre('', 'new_id_type_paiement', 'type_paiement', 'libelle', $id_type_paiement,"300px"); ?>
	</th>
	<th>
		<input type="checkbox" name="new_revue" id="new_revue" <?php  if ($revue=="t"){echo "CHECKED";}?> >
	</th>
	<th>
		<input type="text" maxlength="5" size="5" name="new_valeur" id="new_valeur" <?php  if ($valeur!= ''){echo "value='".$valeur."'";}?>  >
	</th>

				
