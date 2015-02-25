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
	

	$(function() {
        //change val liste ville, maj le champ ville et l'id
        $('#SelectVille').click(function() {
        	var idVille = document.getElementById('SelectVille').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { idVille : idVille },
            	success: function(data) {
            		if(idVille != "Choix possible de ville"){
            			var res = data.split(",");
            			var majId = res[0];
            			var majLibel = res[1];
            			document.getElementById('new_id_ville_etabl_principal').value=majId;
              		document.getElementById('new_ville_etabl_principal').value=majLibel;
                  document.getElementById('new_etabl_principal').value="";
              		}
            	
				      }

          });    

        });  
        //change champs ville, maj le champ ville,l'id, et val select liste ville
        $('#new_ville_etabl_principal').focus(function() {
        	var nomVille = document.getElementById('new_ville_etabl_principal').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { nomVille : nomVille },
            	success: function(data) {
            		//alert(data);
            		if(nomVille != ""){
            			var res = data.split(",");
            			var majId = res[0];
            			var majLibel = res[1];
            			var listeVille = document.getElementById('SelectVille');
						var i = 0;
						for(i=0;i<=listeVille.length-1;i++) 
						{
           					var text=listeVille.options[i].value;
           					if(text==majId)
            				{
                				listeVille.selectedIndex=i;
                				break;
           					 }
        				}
              			document.getElementById('new_id_ville_etabl_principal').value=majId;
              			document.getElementById('new_ville_etabl_principal').value=majLibel;
            		}
            	
				}

          });    

        });
    //creer liste d'etablissement dispo quand change champ ville
 		$('#new_ville_etabl_principal').focus(function() {
        	var nomVilleForListe = document.getElementById('new_ville_etabl_principal').value;

          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { nomVilleForListe : nomVilleForListe },
            	success: function(data) {
            		if(nomVilleForListe != ""){
            			var res = data.split(",");
            			var majId = res[0];
            			var majLibel = res[1];
            			var listeVille = document.getElementById('SelectVille');
                  var listeEta = document.getElementById('SelectEta');
                  listeEta.innerHTML = '';
						      var i = 0;
						      for(i=0;i<=res.length-1;i=i+2) 
						      {
           					if(res[i] != " " || res[i+1] != " "){
                      document.forms.formulaire.SelectEta.options[document.forms.formulaire.SelectEta.options.length] = new Option(res[i+1],res[i]);
                    }
           				}
              }
            	
				  }

      });    
    });
    //creer liste d'etablissement dispo quand change champ ville
    $('#SelectVille').click(function() {
          var idVilleListe = document.getElementById('SelectVille').value;

            $.ajax({
              type: 'GET',
              url: 'recupDonnee.php',
              timeout: 3000,
              data: { idVilleListe : idVilleListe },
              success: function(data) {
                //document.write(data);
                if(idVilleListe != ""){
                  var res = data.split(",");
                  var majId = res[0];
                  var majLibel = res[1];
                  var listeVille = document.getElementById('SelectVille');
                  var listeEta = document.getElementById('SelectEta');
                  listeEta.innerHTML = '';
                  var i = 0;
                  for(i=0;i<=res.length-1;i=i+2) 
                  {
                    if(res[i] != " " || res[i+1] != " "){
                      document.forms.formulaire.SelectEta.options[document.forms.formulaire.SelectEta.options.length] = new Option(res[i+1],res[i]);
                    }
                  }
              }
              
          }

      });    
    });

 		$('#SelectEta').change(function() {
        	var idEta = document.getElementById('SelectEta').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { idEta : idEta },
            	success: function(data) {
            		if(idEta != "Choix possible d'établissement"){
            			var res = data.split(",");
            			var majId = res[0];
            			var majLibel = res[1];
            			document.getElementById('new_id_etabl_principal').value=majId;
              		document.getElementById('new_etabl_principal').value=majLibel;
              	}
            	
				}

          });    

        });  
 		$('#new_etabl_principal').focus(function() {
        	var nomEta = document.getElementById('new_etabl_principal').value;
          	$.ajax({
            	type: 'GET',
            	url: 'recupDonnee.php',
            	timeout: 3000,
            	data: { nomEta : nomEta },
            	success: function(data) {
            		if(nomEta != ""){
            			var res = data.split(",");
            			var majId = res[0];
            			var majLibel = res[1];
            			var listeEta = document.getElementById('SelectEta');
						var i = 0;
						for(i=0;i<=listeEta.length-1;i++) 
						{
           					var text=listeEta.options[i].value;
           					if(text==majId)
            				{
                				listeEta.selectedIndex=i;
                				break;
           					 }
        				}
              			document.getElementById('new_id_etabl_principal').value=majId;
              			
            		}
            	
				}

          });    

        });




	});
		
 function majLibelEta(){
    var listeEta = document.getElementById('SelectEta').value;
    document.getElementById('new_etabl_principal').value=listeEta;

 }

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

  function active(){
    document.getElementById('new_etabl_principal').disabled=false;
    document.getElementById('SelectEta').disabled=false;
  }
	
</script>    
<?php
$listeOptionVille="<option>Choix possible de ville</option>";
$result= pg_query("SELECT id,libelle FROM ville"); 
while ($row = pg_fetch_row($result))
{
	$listeOptionVille = $listeOptionVille."<option value=".$row[0].">".$row[1]."</option>";
}

$listeOptionEta="<option>Choix possible d'établissement</option>";


?>

		<label  class="grandlabel"  for="Ville" style="width:107px" >Ville :</label>
		<input type="text" id="new_ville_etabl_principal" name="new_ville_etabl_principal" autocomplete="off" onclick="active()" style="width: 250px; height: 23px;" 
			<?php  
			if ($ville_etabl_principal!= ''){
				echo "value='$ville_etabl_principal'";}
			?>/>
		<input type="hidden" id="new_id_ville_etabl_principal" name="new_id_ville_etabl_principal" disabled />
		<select id="SelectVille" name="SelectVille" onchange="active()" >
			<?php echo $listeOptionVille ?>
		</select>
		<br>
    
		<label for="Etablissement">Etablissement :</label>
		<input type="text" id="new_etabl_principal" name="new_etabl_principal" autocomplete="off" disabled="true" style="width: 250px; height: 23px;"  <?php  if ($nom_etabl_principal!= ''){echo "value='$nom_etabl_principal'";}?>/>
		<input type="hidden" id="new_id_etabl_principal" name="new_id_etabl_principal" <?php  if ($id_etabl_principal!= ''){echo "value='$id_etabl_principal'";}?>  />
		<select id="SelectEta" name="SelectEta" style="width:250px" disabled="true" onchange="majLibelEta()">
			<?php echo $listeOptionEta ?>
		</select>
    <br/>
    <span style="font-size: 10px; margin-left: 110px;">(Choississez d'abord une ville, puis vous pourrai choisir l'établissement)</span>
		<?php
		
		?>

	