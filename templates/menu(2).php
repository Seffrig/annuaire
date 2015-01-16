<div id="bandeau">
	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <ul class="nav navbar-nav">
      <li><a href="compte.php?id_personne=<?php echo $_SESSION['id_personne'] ?>" >Informations personnelles</a></li>
      <li><a href="these.php?id_personne=<?php echo $_SESSION['id_personne'] ?> ">Thèses</a></li>
      <li><a href="bibliographie.php">Bibliographie</a></li>
      <li class="active"><a href="recherche.php">Recherche</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gestion<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="gestion_cotisations.php">Gestion des cotisations</a></li>
          <li><a href="modif_gestion_utilisateurs.php">Gestions des utilisateurs</a></li>
        </ul>
      </li>
      <li ><a href="deconnexion.php">Deconnexion</a></li> 
    </ul>
  </nav>
</div>
<br><br>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="bootstraps/dist/js/bootstrap.min.js"></script>
<script src="bootstraps/docs/assets/js/docs.min.js"></script>