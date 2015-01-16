function couleur(obj) 
{
     obj.style.backgroundColor = "#FFFFFF";
}

function check_valider_equipe() 
{
	var msg='';
	var colorAlert="#FF6533";
	
	/*num_equipe*/
	if (document.form_equipe_recherche.num_equipe.value == "")	
	{
		msg += "Veuillez saisir votre numéro d'équipe\n";
		document.form_equipe_recherche.num_equipe.style.backgroundColor = colorAlert;
	}  
	
	/*accronyme*/
	if (document.form_equipe_recherche.accronyme.value == "")	
	{
		msg += "Veuillez saisir l'acronyme\n";
		document.form_equipe_recherche.accronyme.style.backgroundColor = colorAlert;
	}  
	
	/*num_rue*/
	if (document.form_equipe_recherche.num_rue.value == "")	
	{
		msg += "Veuillez saisir le numéro de rue \n";
		document.form_equipe_recherche.num_rue.style.backgroundColor = colorAlert;
	}  
	
	/*nom_rue*/
	if (document.form_equipe_recherche.nom_rue.value == "")	
	{
		msg += "Veuillez saisir le nom de la rue \n";
		document.form_equipe_recherche.nom_rue.style.backgroundColor = colorAlert;
	}  
	
	/*code_postal*/
	if (document.form_equipe_recherche.code_postal.value == "")	
	{
		msg += "Veuillez saisir le code postal \n";
		document.form_equipe_recherche.code_postal.style.backgroundColor = colorAlert;
	}  
		
	/*ville*/
	if (document.form_equipe_recherche.ville.value == "")	
	{
		msg += "Veuillez saisir le nom de la ville \n";
		document.form_equipe_recherche.ville.style.backgroundColor = colorAlert;
	}  
	
	/*pays*/
	for(i=0;i<document.form_equipe_recherche.id_pays.length;++i)
	if(document.form_equipe_recherche.id_pays.options[i].selected == true)
	if (document.form_equipe_recherche.id_pays.options[i].value == '')	
	{
		msg += "Veuillez saisir le pays \n";
		document.form_equipe_recherche.id_pays.style.backgroundColor = colorAlert;
	} 
		
	// validation ou pas du formulaire
	if (msg == "") {return true;}
	else
	{
		alert(msg);
		return false ;
	}
}
