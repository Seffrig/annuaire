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
	
	$(function() {

        $('#listeEDR').click(function() {
        	var id = document.getElementById('listeEDR').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { id : id },
            	success: function(data) {
            		if(id != "Choix possible d'équipe de recherche"){
            			var res = data.split(",");
            			var majId = res[0];
            			var majNumEq = res[1];
            			var majLibelEq = res[2];
              
              			document.getElementById('new_id_equipe_recherche').value=majId;
              			document.getElementById('new_num_equipe_recherche').value=majNumEq;
              			document.getElementById('new_libelle_equipe_recherche').value=majLibelEq;
              			document.getElementById("span_libel").innerHTML="<label> Accronyme : </label> "+majLibelEq+"";		
            		}
            	
				}

          });    

        });  
        $('#new_num_equipe_recherche').focus(function() {
        	var numEq = document.getElementById('new_num_equipe_recherche').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { numEq : numEq },
            	success: function(data) {
            		//alert(data);
            		if(numEq != ""){
            			var res = data.split(",");
            			var majId = res[0];
            			var majNumEq = res[1];
            			var majLibelEq = res[2];
            			var listeEDR = document.getElementById('listeEDR');
						var i = 0;
						for(i=0;i<=listeEDR.length-1;i++) 
						{
           					var text=listeEDR.options[i].value;
           					if(text==majId)
            				{
            					//alert("la");
                				listeEDR.selectedIndex=i;
                				break;
           					 }
        				}
              			document.getElementById('new_id_equipe_recherche').value=majId;
              			document.getElementById('new_libelle_equipe_recherche').value=majLibelEq;
              		    document.getElementById("span_libel").innerHTML="<label> Accronyme : </label> "+majLibelEq+"";
            		}
            	
				}

          });    

        });  
      });

	function majequipe( par )
	{
	    $("#new_libelle_equipe_recherche").val( par[2] );
		$("#new_id_equipe_recherche").val( par[0] );
	}

	



	
</script>    

<script type="text/javascript">

</script>

<?php



$listeOptionEq="<option>Choix possible d'équipe de recherche</option>";

$result= pg_query("SELECT id,num_equipe FROM recherche
					ORDER BY num_equipe"); 
while ($row = pg_fetch_row($result))
{
	$listeOptionEq = $listeOptionEq."<option value=".$row[0].">".$row[1]."</option>";
}
?>

		<label>Num Equipe :</label>
		<input type="text" id="new_num_equipe_recherche" name="new_num_equipe_recherche" autocomplete="off"  style="width: 80px; height: 23px; "
		 <?php 
		 if ($num_equipe_princ!= ''){
		 	echo "value='$num_equipe_princ'";
		 }
		 ?> 
		 />
		<input type="hidden" id="new_libelle_equipe_recherche" name="new_libelle_equipe_recherche" 
		<?php 
		if ($accronyme_equipe_princ!= ''){
			echo "value='$accronyme_equipe_princ'";
		}
		?> disabled />
		<input type="hidden" id="new_id_equipe_recherche" name="new_id_equipe_recherche" <?php if ($id_equipe_princ!= ''){echo "value='$id_equipe_princ'";}?> />
		<select name="listeEDR" id="listeEDR" >
			<?php echo $listeOptionEq ?>
		</select>
		<br>
		<span id="span_libel" style="margin-left: 5px;">
			<label>Accronyme : </label>
				<?php if ($accronyme_equipe_princ!= ''){
					echo $accronyme_equipe_princ;
				}
				?>
		
		</span>
		<?php


		?>
   

