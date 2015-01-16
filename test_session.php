<?php
// ouverture de la session
session_start(); 

//teste l'utilsateur sinon retour à la page login
if ($_SESSION['type_user']=='') 
{ 
	header('Location: ./index.php?mode=erreur');  
}

?>