<?php 
include("commun/connexion_db.php");



if(isset( $_GET["id"]) &&  $_GET["id"] != "Choix possible d'équipe de recherche")
{
	$id = $_GET["id"];

	$result= pg_query("SELECT id,num_equipe,accronyme 
				   FROM recherche
				   WHERE id=".$id.""); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1].",".$row[2]."";
	
	}
	
}
if(isset( $_GET["numEq"]) &&  $_GET["numEq"] != "")
{
	$numEq = $_GET["numEq"];

	$result= pg_query("SELECT id,num_equipe,accronyme 
				   FROM recherche
				   WHERE num_equipe='".$numEq."'"); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1].",".$row[2]."";
	
	}
}

if(isset( $_GET["idVille"]) &&  $_GET["idVille"] != "")
{
	$idVille = $_GET["idVille"];

	$result= pg_query("SELECT id,libelle
				   FROM ville
				   WHERE id=".$idVille.""); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1]."";
	
	}
}

if(isset( $_GET["nomVille"]) &&  $_GET["nomVille"] != "")
{
	$nomVille = $_GET["nomVille"];

	$result= pg_query("SELECT id,libelle
				   FROM ville
				   WHERE libelle='".$nomVille."'"); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1]."";
	
	}
}
if(isset( $_GET["idEta"]) &&  $_GET["idEta"] != "")
{
	$idEta = $_GET["idEta"];

	$result= pg_query("SELECT id,nom
				   FROM etablissement
				   WHERE id=".$idEta.""); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1]."";
	
	}
}
if(isset( $_GET["nomEta"]) &&  $_GET["nomEta"] != "")
{
	$nomEta = $_GET["nomEta"];

	$result= pg_query("SELECT id,nom
				   FROM etablissement
				   WHERE nom='".$nomEta."'"); 
	while ($row = pg_fetch_row($result))
	{
		echo "".$row[0].",".$row[1]."";
	
	}
}
//ecrit ville
if(isset( $_GET["nomVilleForListe"]) &&  $_GET["nomVilleForListe"] != "")
{
	$nomVilleForListe = $_GET["nomVilleForListe"];

	$result= pg_query("SELECT id
				   FROM ville
				   WHERE libelle='".$nomVilleForListe."'"); 
		
		$res = pg_fetch_result($result, 0, 0);
		$opt= "Choix possible d'établissement,Choix possible d'établissement,";

		$result= pg_query("SELECT e.id,e.nom,v.libelle FROM Etablissement e, ville v
				   WHERE e.id_ville = v.id
				   AND e.id_ville = ".$res.""); 
		while ($row = pg_fetch_row($result))
		{
			$opt=$opt. "".$row[0].",".$row[1]."(".$row[2]."),";
		}
		$pos = strripos($opt, ",");
		$debopt=substr($opt,0,$pos);
		echo $debopt;
		
	
}
//selectionne ville dans liste
if(isset( $_GET["idVilleListe"]) &&  $_GET["idVilleListe"] != "")
{
	$idVilleListe = $_GET["idVilleListe"];

	
		
		$res = $idVilleListe;
		$opt= "Choix possible d'établissement,Choix possible d'établissement,";

		$result= pg_query("SELECT e.id,e.nom,v.libelle FROM Etablissement e, ville v
				   WHERE e.id_ville = v.id
				   AND e.id_ville = ".$res.""); 

		while ($row = pg_fetch_row($result))
		{
			$opt=$opt. "".$row[0].",".$row[1]."(".$row[2]."),";
		}
		$pos = strripos($opt, ",");
		$debopt=substr($opt,0,$pos);
		echo $debopt;
		
		
}
?>


