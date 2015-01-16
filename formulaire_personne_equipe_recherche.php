 <script type="text/javascript">
	$(document).ready(function()
	{
	    $('#new_num_equipe_recherche').simpleAutoComplete('ajax_query.php?from="recherche"&champ="num_equipe" ',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'generique_identifiant_trois_champs'
	    },majequipe);

        });
	
	function majequipe( par )
	{
	    $("#new_libelle_equipe_recherche").val( par[2] );
		$("#new_id_equipe_recherche").val( par[0] );
	}

	
</script>    

	<div>
		Num Equipe (ex: EA4011) :
		<input type="text" id="new_num_equipe_recherche" name="new_num_equipe_recherche" autocomplete="off" style="width: 80px; height: 23px;" <?php if ($num_equipe_princ!= ''){echo "value='$num_equipe_princ'";}?>/>
		<input type="text" id="new_libelle_equipe_recherche" name="new_libelle_equipe_recherche" <?php if ($accronyme_equipe_princ!= ''){echo "value='$accronyme_equipe_princ'";}?> disabled />
		<input type="hidden" id="new_id_equipe_recherche" name="new_id_equipe_recherche" <?php if ($id_equipe_princ!= ''){echo "value='$id_equipe_princ'";}?> />
		<?php
		if($_SESSION['modif_recherche']=='t') 
		{
			echo"<a href='modif_equipe_recherche.php'><img src='images/button_edit.png' ></a>";
		}
		?>
    </div>

