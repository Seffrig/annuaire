<?php 
	if(isset($_GET['mode']) && ($_GET['mode'] == "deconnection")) 
	{	 		      
		echo "<span class='blue_text'>D&eacute;connexion r&eacute;ussie. A bient&ocirc;t</span>";
	}
	else
	{

		set_include_path(get_include_path() . ":/usr/share/pear");

		// import phpCAS lib
		include_once('identification/CAS/CAS.php'); 
		include_once('identification/CAS/cas.sso');
		
		phpCAS::setDebug();

		// initialize phpCAS
		phpCAS::client(CAS_VERSION_2_0,$serveurSSO,$serveurSSOPort,$serveurSSORacine);

		// Désactive la vérification SSL
		phpCAS::setNoCasServerValidation();

		// Force l'authentification CAS
		phpCAS::forceAuthentication();
	 

		$_SESSION['login']=phpCAS::getuser(); 

		header("Location:test_login.php");
	}
?>
