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
		//cette donction à pour but de mettre à jour les champs lié au Equipe de recherche
		//lorsque qu'on sélectionne une équipe dans la liste déroulante
		//si on sélectionne un élement dans la liste des équipes de recherche
        $('#listeEDR').click(function() {
        	var id = document.getElementById('listeEDR').value; //on récupere l'id de l'équipe choisis
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php', //manipulation des données faites sur la page recupDonne.php
            	timeout: 3000,
            	data: { id : id },
            	success: function(data) { //si données récupérées
            		if(id != "Choix possible d'équipe de recherche"){
            			//on récupere les données sous forme de liste donc on va les séparer
            			var res = data.split(",");
            			var majId = res[0];
            			var majNumEq = res[1];
            			var majLibelEq = res[2];
              			//on met à jour l'id,le numéro et le libélé de l'équipe de recherche
              			document.getElementById('new_id_equipe_recherche').value=majId;
              			document.getElementById('new_num_equipe_recherche').value=majNumEq;
              			document.getElementById('new_libelle_equipe_recherche').value=majLibelEq;
              			document.getElementById("span_libel").innerHTML="<label> Accronyme : </label> "+majLibelEq+"";		
            		}
            	
				}

          });    

        });  
 		//Cette fonction à pour but de mettre à jour la liste déoulante des EDR
 		//lorsque qu'on clique/modifie l'EDR dans le champ texte
        $('#new_num_equipe_recherche').focus(function() {
        	var numEq = document.getElementById('new_num_equipe_recherche').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php', //on récupere les données sous forme de liste donc on va les séparer
            	timeout: 3000,
            	data: { numEq : numEq },
            	success: function(data) {
            		if(numEq != ""){
            			//on récupere les données sous forme de liste donc on va les séparer
            			var res = data.split(",");
            			var majId = res[0];
            			var majNumEq = res[1];
            			var majLibelEq = res[2];
            			var listeEDR = document.getElementById('listeEDR');
						var i = 0;
						//on parcours la liste déroulante
						//et quand on trouve que la valeur entré 
						//correspond à une valeur dans la liste
						//on "selectionne" cette valeur pour qu'elle s'affiche dans la liste
						for(i=0;i<=listeEDR.length-1;i++) 
						{
           					var text=listeEDR.options[i].value;
           					if(text==majId)
            				{
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
   

