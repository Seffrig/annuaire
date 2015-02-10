<?php
include('test_session.php');

// fonction entête
include_once "commun/fonction.php";
$changements = array();
$changements['__SCRIPTS__'] = '';
$changements['__CSS__'] = '';
$changements['__TITLE__'] = '<title>Informations</title>';
$changements['__DESCRIPTION__'] = '<meta name="description" content="annuaire">';
$changements['__KEYWORDS__'] = '<meta name="keywords" content="annuaire">';
remplace('templates/header.php',$changements);

//connection à la base
include("commun/connexion_db.php");

//menu
include "templates/menu.php";

if(isset($_GET['id_personne']))
	$idP = $_GET['id_personne'];
else
	$idP = '';

?>
<br><br><br><br>
<div class="panel panel-info">
	<div class="panel-heading">
		<h2 class="panel-title">Récapitulatif</h2>
	</div>
	<?php 
	$login= $_SESSION['login'];	
	$id_personne=$_SESSION['id_personne'];

	// si on est entré avec un get id_personne ( pour les admins ) 	
	if ($idP!='' && $_SESSION['type_user'] == 1) 
	{ 
		$_SESSION['id_personne']=$idP;
	}	
	// permet d'aller à la page d'ajout de personne s'il n'y a pas d'id_personne correspondant (cas d'une nouvelle inscription)
	if ($id_personne==0 || $id_personne=='') 
	{  
		$_SESSION['modif']= " ID personne incorrecte " ;	
		header("Location: ajout_personne.php");
	}  	 
	include ("sql/recup_personne.php"); 
	?>
	<div class="panel-body">	
		<b> Nom:</b> <?php echo $nom;?> &nbsp;<b>Prénom:</b> <?php echo $prenom; ?> <br>
		<b>Corps:</b> &nbsp;<?php echo $libelle_corps; ?> <br>	
		<b>Autre(s) responsabilité(s):</b> <?php echo $commentaire; ?> <br>		<br>		
		<b>Page professionelle:</b> <?php echo $page_pro; ?> <br>		
	</div>
</div>
<table>
	<th  width="350px">	
		<div class="panel panel-info">
			<div class="panel-heading">
    			<h2 class="panel-title">Contact professionnel</h2>
  			</div>
  			<div class="panel-body">
    			 Coordonnées: <br/>
    			<?php echo $complement_pro .' <br/>' 
    			.$num_rue_pro.' '.$nom_rue_pro; ?> <br>
				<?php echo $code_postal_pro.' '.$localite_pro; ?> <br>
				<b>Téléphone:  </b> <?php echo $tel_pro;?> &nbsp;	<br>
				<b>Courriel: </b><?php echo $courriel_pro; ?> <br>
				<b> Pays:</b>  &nbsp; <?php echo $libelle_pays_pro;	?> <br>	
			</div>	
  		</div>
  	</th>
	<th width="87px"></th >
  	<th  width="350px">	
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">Contact personnel  </h2>	
			</div>
			<div class="panel-body">
				<b>Coordonnées: </b><br/> <?php echo $complement_perso .' <br/>' .$num_rue_perso.' ' .$nom_rue_perso; ?> <br>
				<?php echo $code_postal_perso.' '.$localite_perso; ?> <br>
				<b>Téléphone: </b><?php echo $tel_perso;?> &nbsp;	<br>
				<b>Courriel: </b> <?php echo $courriel_perso; ?> <br>
				<b> Pays: </b>  &nbsp; <?php echo $libelle_pays_perso; ?> <br>	
			</div>
		</div>	
	</th>

</table>
<div class="panel panel-info">
	<div class="panel-body">
		<b> Etablissement :</b> &nbsp; <br>	<?php echo $nom_etabl_principal; ?> <br>
	</div>	
</div>	
<br>	
<div class="panel panel-info">
	<div class="panel-body">
		<b> Equipe de recherche :</b> &nbsp; <br>	<?php if ($accronyme_equipe_princ!='') {echo $accronyme_equipe_princ . " (" . $num_equipe_princ . ")";} ?> <br>			
	</div>
</div>		
<br><br>
<div class="principal">				
<?php 
if ($revue=='pro')
{
	$revue='professionnelle';
}
else if ($revue=='perso')
{
	$revue='personnelle';
}
if ($courrier=='pro')
{
	$courrier='professionnelle';
}
else if ($courrier=='perso')
{
	$courrier='personnelle';
}	
if ($visible_email_perso=='t')
{	
	$visible_email_perso = "visible";
}
else 
{
	$visible_email_perso = "non visible";
}
?>
<table>
	<th>
	<div class='panel panel-info'>
		<div class='panel-body'>		
			<?php		
			echo "Préference d'envoi pour la revue: <b>Adresse $revue</b><br>";
			echo "Préference d'envoi pour le courrier: <b>Adresse $courrier</b><br>";
			echo "Visibilité de votre email personnel: <b> $visible_email_perso</b><br>";
			?>
		</div>	
	</div>
</th>
<th width="60px"></th >
<th>
	<?php
if ($prenom =='MORALE') 
{
	echo "<a href='modif_personne_morale.php'><input type='button' value='Modifier les informations'> </a>";
}
else 
{
	echo "<a href='modif_personne.php'><input type='button' value='Modifier les informations'></a>";
} 
?>	
</th>
</table>

<br><br>
<?php
	include "templates/footer.php";
?>

