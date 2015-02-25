<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '<link rel="stylesheet" type="text/css" href="css/tableau.css" />';
$changements['__TITLE__'] = '<title>Modification équipe de recherche</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="Ajout gestion utilisateurs">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="Ajout gestion utilisateurs">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

?>
<!--
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
-->
<?php
	// ajout 
	if ($_GET['type_modif'] == 'ajout')
	{
		?>
		<br><br><br><br>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Ajout d'un nouvel utilisateur</h2>	
			</div>
			<div class="panel-body">
				<?php
		
		echo "<form action='maj_gestion_utilisateurs.php?type_modif=ajout' onsubmit='return check_valider_gestion_utilisateurs()' name='form_gestion_utilisateurs' method='post'  >";
	}
	// modification
	else if ($_GET['type_modif'] == 'modif')
	{
		?>
		<br><br><br><br>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Modification de l'utilisateur</h2>	
			</div>
			<div class="panel-body">
				<?php
		$id_recherche = $_GET['id_rech'];
		
		echo "<form action='maj_gestion_utilisateurs.php?type_modif=modif&id_rech=". $id_recherche ."' onsubmit='return check_valider_gestion_utilisateurs()' name='form_gestion_utilisateurs' method='post'  >";

							
		$result_utilisateur = pg_query("SELECT  u.login, u.id_type, tu.libelle
											FROM utilisateur u, type_user tu
											WHERE u.id_type = tu.id 
											AND u.login = '". $id_recherche ."' ");	
											
		$row_utilisateur = pg_fetch_row($result_utilisateur);

		$id_recherche = $row_utilisateur[0]; 
		$id_type_user = $row_utilisateur[1];
		$libelle_type_user = $row_utilisateur[2];
	}
?>
			
			

			<br>		
			<label class='labelpublibase' for="nom_cree">Nom :</label> 
			<input size="20" type="text" name="nom_cree" id="nom_cree" onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>
			<br/>
			<label class='labelpublibase' for="prenom_cree">Prenom :</label> 
			<input size="20" type="text" name="prenom_cree" id="prenom_cree" onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>
			<br/>
		
<!--
			<label  class="labelpublibase"  for="Ville">Ville :</label>
			<input type="text" id="new_ville_etabl_principal" name="new_ville_etabl_principal" autocomplete="off" style="width: 250px; height: 23px;" >
			<input type="hidden" id="new_id_ville_etabl_principal" name="new_id_ville_etabl_principal" disabled />
			<br>
			<label class="labelpublibase" for="Etablissement">Etablissement :</label>
			<input type="text" id="new_etabl_principal" name="new_etabl_principal" autocomplete="off" style="width: 250px; height: 23px;" disabled />
			<input type="hidden" id="new_id_etabl_principal" name="new_id_etabl_principal"/>
			<br/>
	-->	

			<label class='labelpublibase' for="login_cree">Login :</label>
				<input size="10" type="text" maxlength="8" style='text-transform:uppercase' name="login_cree" id="login_cree" onKeyUp="javascript:couleur(this);"
				<?php  
				if (isset($id_recherche) && $id_recherche != '')
					{echo 'value = "' . $id_recherche . '"  disabled';}  ?> /> 
			(8 caractères maxi : 1ere lettre du prénom + 7 premières lettres du nom)
			<font class='ast'>*</font>
			<br/>	
			<label class='labelpublibase' for="pass_cree">Mot de passe :</label> 
			<input size="20" type="password" name="pass_cree" id="pass_cree" onKeyUp="javascript:couleur(this);"/> 
			<font class='ast'>*</font>
	
			<br/>
			<?php
			//selection_menu_der($libelle_affichage, $identifiant_css, $table, $champ, $preselection) 
			if(isset($id_type_user))
			{
				selection_menu_der ("Type d'utilisateur ", "id_type","type_user", "libelle", $id_type_user,"145px" );
				echo "<font class='ast'>*</font>";
			}
				 
			?>
			<br/>
			<input type="submit" value="Valider" style="margin-left: 40%;"/>
			<a href="modif_gestion_utilisateurs.php"> <input type="button" value="Annuler"> </a>
		</form>	
		
		</div></div>
		<?php 
		//function affichage_colonne($id, $champ, $table, $page_modif, $page_sup) 
		affichage_colonne('login', 'login', 'utilisateur','modif_gestion_utilisateurs.php','maj_gestion_utilisateurs.php');		
		?>			
	
<?php
	include "templates/footer.php";
?>

