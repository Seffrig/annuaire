<?php
/**
 * @author Wellington Ribeiro
 * @version 1.0
 * @since 2010-02-09
 */

header('Content-type: text/html; charset=UTF-8');

//connection à la base
include("commun/connexion_db.php");

if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" )
{

	$q = pg_escape_string ($_REQUEST['query'] );
	$q_ss_cas = "lower('" . $q . "')";

	// pour la recherche des logins
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "login")
    {

		$sql = "SELECT * FROM utilisateur where position(". $q_ss_cas ." IN lower(login)) > 0 order by position (". $q_ss_cas ."  IN lower(login)), lower(login) ";

		$r = pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul>'."\n";

			while( $l = pg_fetch_row( $r ) )
			{
			$id = $l[0];
			
			$id_modif  = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $id );
			echo "\t".'<li id="autocomplete_'.$id.'" rel="'.$id.'">'. $id_modif .'</li>'."\n";
			}
			echo '</ul>';
		}
    }
	
	// pour la recherche des noms
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "nom")
    {
		// pour la CAS
		$q_ss_cas = "lower('" . $q . "')";
	
		$sql = "SELECT * FROM personne where position(". $q_ss_cas ." IN lower(nom)) > 0 and visible ='true' order by position (". $q_ss_cas ." IN lower(nom)), lower(nom) ";

		$r = pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul>'."\n";

			while( $l = pg_fetch_row( $r ) )
			{
				$id_personne = $l[0];
				$nom_personne = $l[2];
				$prenom = $l[3];
				$nom_personne_modif = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $nom_personne);
				echo "\t".'<li id="autocomplete_'.$id_personne.'" rel="'.$id_personne.'_' . $nom_personne . '">'.  $nom_personne_modif . ' ' . $prenom . '</li>'."\n";
			}
			echo '</ul>';
		}
    }
	
	// pour la recherche de liste générique
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "generique")
    {
		// pour la CAS
		$champ_ss_cas = "lower(" . $_GET['champ'] .")" ;
		$q_ss_cas = "lower('" . $q . "')";
		$sql = "SELECT * FROM " . $_GET['from'] . " where position(". $q_ss_cas ." IN " . $champ_ss_cas. ") > 0 order by position (". $q_ss_cas ." IN " . $champ_ss_cas . "), " . $champ_ss_cas . " ";

		$r = pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul>'."\n";

			while( $l = pg_fetch_row( $r ) )
			{
				$id = $l[0];
				$libelle= $l[1];

				$libelle_modif  = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $libelle );
				echo "\t".'<li id="autocomplete_'.$libelle.'" rel="'.$libelle.'">'. $libelle_modif .'</li>'."\n";
			}
			echo '</ul>';
		}
    }
	
	// pour la recherche de liste générique avec identifiant dans l'url
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "generique_identifiant")
    {
		// pour la CAS
		$champ_ss_cas = "lower(" . $_GET['champ'] .")" ;
		$q_ss_cas = "lower('" . $q . "')";
		$sql = "SELECT * FROM " . $_GET['from'] . " where position(". $q_ss_cas ." IN " . $champ_ss_cas. ") > 0 order by position (". $q_ss_cas ." IN " . $champ_ss_cas . "), " . $champ_ss_cas . " ";

		$r = pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul >'."\n";
			while( $l = pg_fetch_row( $r ) )
			{
				$id = $l[0];
				$libelle= $l[1];

				$libelle_modif  = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $libelle );
				echo "\t".'<li id="autocomplete_'.$id.'" rel="'.$id.'_' . $libelle . '">'. $libelle_modif .'</li>'."\n";
			}
			echo '</ul>';
		}
    }
	
	// pour la recherche de liste générique avec identifiant dans l'url
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "generique_identifiant_trois_champs")
    {
		// pour la CAS
		$champ_ss_cas = "lower(" . $_GET['champ'] .")" ;
		$q_ss_cas = "lower('" . $q . "')";
		$sql = "SELECT * FROM " . $_GET['from'] . " where position(". $q_ss_cas ." IN " . $champ_ss_cas. ") > 0 order by position (". $q_ss_cas ." IN " . $champ_ss_cas . "), " . $champ_ss_cas . " ";

		$r = pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul id="listeAuto" name="listeAuto">'."\n";

			while( $l = pg_fetch_row( $r ) )
			{
				$id = $l[0];
				$libelle= $l[1];
				$libelle2= $l[2];

				$libelle_modif  = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $libelle );
				echo "\t".'<li id="autocomplete_'.$id.'" rel="'.$id.'_' . $libelle . '_' . $libelle2 . '">'. $libelle_modif .'</li>'."\n";
			}
			echo '</ul>';
		}

		
    }
	
	// pour la recherche de liste générique avec identifiant dans l'url avec extra parametre
	if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "generique_identifiant_extraparametre")
    {
		$sql = isset( $_REQUEST['extraParam'] ) ? " and " . $_GET['champ_extra'] . " = " . pg_escape_string( $_REQUEST['extraParam'] ) . " " : "";
		
		// pour la CAS
		$champ_ss_cas = "lower(" . $_GET['champ'] .")" ;
		$q_ss_cas = "lower('" . $q . "')";
		@$sql = "SELECT * FROM " . $_GET['from'] . " where position(". $q_ss_cas ." IN " . $champ_ss_cas. ") > 0 $sql order by position (". $q_ss_cas ." IN " . $champ_ss_cas . ") limit 10";

		$r = @pg_query($dbconn, $sql);
		if ( $r )
		{
			echo '<ul>'."\n";

			while( $l = pg_fetch_row( $r ) )
			{
				$id = $l[0];
				$libelle= $l[1];

				$libelle_modif  = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold; color:red;">$1</span>', $libelle );
				echo "\t".'<li id="autocomplete_'.$id.'" rel="'.$id.'_' . $libelle . '">'. $libelle_modif .'</li>'."\n";
			}
			echo '</ul>';
		}
    }
	
	/*
    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "new_etabl_principal")
    {
		$sql = isset( $_REQUEST['extraParam'] ) ? " and id_ville = " . pg_escape_string( $_REQUEST['extraParam'] ) . " " : "";
		$sql = "SELECT * FROM etablissement where position('$q' IN nom) > 0 $sql order by position ('$q' IN nom) limit 10";

		$r = pg_query($dbconn, $sql);
		if ( count( $r ) > 0 )
		{
			echo '<ul>'."\n";
			while( $l = pg_fetch_row( $r ) )
			{
				$p = $l[1];
				$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
				echo "\t".'<li id="autocomplete_'.$l[0].'" rel="'.$l[0].'_' . $l[1] . '">'.  $p .'</li>'."\n";
			}
	    echo '</ul>';
		}
    }*/
	
}

?>
