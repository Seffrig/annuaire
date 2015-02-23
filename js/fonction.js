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

function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        	['These', c0],
        	['Article dans une revue', c1],
        	['Communications avec actes', c3],
        	['Communications sans actes', c4],
        	['Conférence invitée', c5],
        	['Ouvrage', c6],
        	['Chapitre douvrage', c7],
        	['Direction douvrage', c8],
        	['Autre type de publication', c9]
        	]);

        // Set chart options
        var options = {'title':'Répartition des publications',
        'width':900,
        'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

 function camembertStatGlobale() {
 	
 	var c0 =parseInt(document.getElementById("c0").value);
 	var c1 =parseInt(document.getElementById("c1").value); 
 	var c3 =parseInt(document.getElementById("c3").value);
 	var c4 =parseInt(document.getElementById("c4").value);
 	var c5 =parseInt(document.getElementById("c5").value);
 	var c6 =parseInt(document.getElementById("c6").value);
 	var c7 =parseInt(document.getElementById("c7").value);
 	var c8 =parseInt(document.getElementById("c8").value);
 	var c9 =parseInt(document.getElementById("c9").value);
 	

 	google.load('visualization', '1.0', {'packages':['corechart']});

 	google.setOnLoadCallback(drawChart);

 	drawChart();
 }