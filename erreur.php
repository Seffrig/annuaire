<?php
	// Suprressions session
	session_unset("authentification");
?>
<html>
	<head>
		<title>ERREUR LOGIN ISTA</title>

		<!-- lien vers la css -->
		<link rel="stylesheet" type="text/css" href="../CSS/connection.css" media="all" >

	</head>
	<body>
		<div align="center" id="centree_horizontal">
			<strong>      
			<?php 
				if(isset($_GET['erreur']) && ($_GET['erreur'] == "login")) 
				{  
					echo "<span class='red_text'>Echec d'authentification. login ou mot de passe incorrect. Veuillez contacter l'administrateur</span>";
				}
				if(isset($_GET['erreur']) && ($_GET['erreur'] == "delog")) 
				{	 		      
					echo "<span class='blue_text'>D&eacute;connexion r&eacute;ussie. A bient&ocirc;t</span>";
				}
				if(isset($_GET['erreur']) && ($_GET['erreur'] == "intru")) 
				{ 
					echo "<span class='red_text'>Echec d'authentification. Aucune session n'est ouverte</span>
						  <span class='red_text'>ou vous n'avez pas les droits pour afficher cette page. Veuillez contacter l'administrateur</span>";
				} 
			?>
			</strong>
		</div>
	</body>
</html>
