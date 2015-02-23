<?php 


$monUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
$recherche = substr_count ($monUrl,"recherche");
$compte = substr_count ($monUrl,"compte" );
$these = substr_count ($monUrl,"these" );
$bibliographie = substr_count ($monUrl,"bibliographie" );
$gestion = substr_count ($monUrl,"gestion" );
$stat = substr_count ($monUrl,"info" );
$activeR = "";
$activeC = "";
$activeT = "";
$activeB = "";
$activeG = "";
$activeS = "";
if($recherche >= 1){
  $activeR = "active";
}
if($compte >=1){
  $activeC = "active";
}
if($these >=1){
  $activeT = "active";
}
if($bibliographie >=1){
  $activeB = "active";
}
if($gestion >=1){
  $activeG = "active";
}
if($stat >=1){
  $activeS = "active";
}

if($_SESSION['type_user'] == 1){
  ?>
  <div id="bandeau">
  <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <ul class="nav navbar-nav">
      <li class="<?php echo $activeC ?>"><a href="compte.php?id_personne=<?php echo $_SESSION['id_personne'] ?>" >Profil</a></li>
      <li class="<?php echo $activeT ?>"><a href="these.php?id_personne=<?php echo $_SESSION['id_personne'] ?> ">Thèses</a></li>
      <li class="<?php echo $activeB ?>"><a href="bibliographie.php">Bibliographie</a></li>
      <li class="<?php echo $activeR ?>"><a href="recherche.php">Recherche</a></li>
      <li class="dropdown <?php echo $activeG ?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gestion<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="gestion_cotisations.php">Gestion des cotisations</a></li>
          <li><a href="modif_gestion_utilisateurs.php">Gestions des utilisateurs</a></li>
          <li><a href="modif_etablissement.php">Gestions des universités</a></li>
          <li><a href="modif_equipe_recherche.php">Gestions des EDR</a></li>
          <li><a href="modif_pays.php">Gestions des pays</a></li>
          <li><a href="modif_ville.php">Gestions des villes</a></li>
          <li><a href="modif_corps.php">Gestions des corps</a></li>
        </ul>
      </li>
      <li class="dropdown <?php echo $activeS ?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Statistiques<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="infoChercheurPubli.php?lettre=A">Tableau statistique</a></li>
          <li><a href="infoStatGraph.php">Graph statistique</a></li>
        </ul>
      </li>
      <li ><a href="deconnexion.php">Deconnexion</a></li>

    </ul>
  </nav>
</div>
<br><br>
<?php
}
if($_SESSION['type_user'] == 2){
  ?>
  <div id="bandeau">
  <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <ul class="nav navbar-nav">
       <li><a href="gestion_cotisations.php">Gestion des cotisations</a></li>
       <li  ><a style="margin-left: 78%;" href="deconnexion.php">Deconnexion</a></li> 
    </ul>
  </nav>
</div>
<br><br>


  <?php
}
if($_SESSION['type_user'] == 3){
  ?>
<div id="bandeau">
  <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <ul class="nav navbar-nav">
      <li class="<?php echo $activeC ?>"><a style="margin-left: 50px;font-size: large;" href="compte.php?id_personne=<?php echo $_SESSION['id_personne'] ?>" >Informations personnelles</a></li>
      <li class="<?php echo $activeT ?>"><a style="font-size: large;" href="these.php?id_personne=<?php echo $_SESSION['id_personne'] ?> ">Thèses</a></li>
      <li class="<?php echo $activeB ?>"><a style="font-size: large;" href="bibliographie.php">Bibliographie</a></li>
      <li ><a style="font-size: large;" href="deconnexion.php">Deconnexion</a></li> 
    </ul>
  </nav>
</div>
<br><br>


  <?php
}




