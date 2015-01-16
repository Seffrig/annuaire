 <script type="text/javascript">
	$(document).ready(function()
	{
	    $('#new_ville_etabl_principal').simpleAutoComplete('ajax_query.php?from="ville"&champ="libelle" ',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'generique_identifiant'
	    },majville);

	    $('#new_etabl_principal').simpleAutoComplete('ajax_query.php?from="etablissement"&champ="nom"&champ_extra="id_ville" ',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		identifier: 'generique_identifiant_extraparametre',
		extraParamFromInput: '#new_id_ville_etabl_principal'
	    },majetablissement);
        });
	
	function majville( par )
	{
	    $("#new_id_ville_etabl_principal").val( par[0] );
	    $("#new_etabl_principal").removeAttr("disabled");
		$("#new_etabl_principal, #new_id_etabl_principal").val("");
	}

	function majetablissement( par )
	{
	    $("#new_id_etabl_principal").val( par[0] );
	}
	
</script>    

	
		<label for="Ville">Ville :</label>
		<input type="text" id="new_ville_etabl_principal" name="new_ville_etabl_principal" autocomplete="off" style="width: 250px; height: 23px;" 
			<?php  
			if ($ville_etabl_principal!= ''){
				echo "value='$ville_etabl_principal'";}
			?>/>
		<input type="hidden" id="new_id_ville_etabl_principal" name="new_id_ville_etabl_principal" disabled />
		<br><br>
		<label for="Etablissement">Etablissement :</label>
		<input type="text" id="new_etabl_principal" name="new_etabl_principal" autocomplete="off" style="width: 250px; height: 23px;" disabled <?php  if ($nom_etabl_principal!= ''){echo "value='$nom_etabl_principal'";}?>/>
		<input type="hidden" id="new_id_etabl_principal" name="new_id_etabl_principal" <?php  if ($id_etabl_principal!= ''){echo "value='$id_etabl_principal'";}?>  />
		<?php
		if($_SESSION['modif_etablissement']=='t') 
		{
			echo"<a href='modif_etablissement.php'><img src='images/button_edit.png' ></a>";
		}
		?>

	