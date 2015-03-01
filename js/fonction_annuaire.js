function DivStatus( nom, numero )
		{
			
			var divID = nom + numero;
			//alert(divID);
			if ( document.getElementById && document.getElementById( divID ) ) // Pour les navigateurs récents
				{
					Pdiv = document.getElementById( divID );
					PcH = true;
		 		}
			else if ( document.all && document.all[ divID ] ) // Pour les veilles versions
				{
					Pdiv = document.all[ divID ];
					PcH = true;
				}
			else if ( document.layers && document.layers[ divID ] ) // Pour les très veilles versions
				{
					Pdiv = document.layers[ divID ];
					PcH = true;
				}
			else
				{
					
					PcH = false;
				}
			if ( PcH )
				{
					Pdiv.className = ( Pdiv.className == 'cachediv' ) ? '' : 'cachediv';
				}
		}
		
	/*
	* Cache tous les divs ayant le même préfixe
	*/
	function CacheTout( nom )
		{	
			var NumDiv = 1;
			if ( document.getElementById ) // Pour les navigateurs récents
				{
					while ( document.getElementById( nom + NumDiv) )
						{
							SetDiv = document.getElementById( nom + NumDiv );
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
			else if ( document.all ) // Pour les veilles versions
				{
					while ( document.all[ nom + NumDiv ] )
						{
							SetDiv = document.all[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
			else if ( document.layers ) // Pour les très veilles versions
				{
					while ( document.layers[ nom + NumDiv ] )
						{
							SetDiv = document.layers[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != 'cachediv' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
		}
	
	/*
	* Montre tous les divs ayant le même préfixe
	*/
	function MontreTout( nom )
		{	
			var NumDiv = 1;
			if ( document.getElementById ) // Pour les navigateurs récents
				{
					while ( document.getElementById( nom + NumDiv) )
						{
							SetDiv = document.getElementById( nom + NumDiv );
							if ( SetDiv && SetDiv.className != '' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
			else if ( document.all ) // Pour les veilles versions
				{
					while ( document.all[ nom + NumDiv ] )
						{
							SetDiv = document.all[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != '' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
			else if ( document.layers ) // Pour les très veilles versions
				{
					while ( document.layers[ nom + NumDiv ] )
						{
							SetDiv = document.layers[ nom + NumDiv ];
							if ( SetDiv && SetDiv.className != '' )
								{
									DivStatus( nom, NumDiv );
								}
							NumDiv++;
						}
				}
		}
		
	/*
	* Inverse les divs: Cache les divs visible et montre le divs cachés :)
	*/
	function InverseTout( nom )
		{	
			var NumDiv = 1;
			if ( document.getElementById ) // Pour les navigateurs récents
				{
					while ( document.getElementById( nom + NumDiv ) )
						{
							SetDiv = document.getElementById( nom + NumDiv );
							DivStatus( nom, NumDiv );
							NumDiv++;
						}
				}
			else if ( document.all ) // Pour les veilles versions
				{
					while ( document.all[ nom + NumDiv ] )
						{
							SetDiv = document.all[ nom + NumDiv ];
							DivStatus( nom, NumDiv );
							NumDiv++;
						}
				}
			else if ( document.layers ) // Pour les très veilles versions
				{
					while ( document.layers[ nom + NumDiv ] )
						{
							SetDiv = document.layers[ nom + NumDiv ];
							DivStatus( nom, NumDiv );
							NumDiv++;
						}
				}
		}


function hideshow(obj){
	var nom = obj;
if (document.getElementById(nom).style.display =='none'){
	document.getElementById(nom).style.display = 'block';
}
if(document.getElementById(nom).style.display == 'block'){
	document.getElementById(nom).style.display = 'none';
}

}

function show(){
	
	document.getElementById('tabAjout').style.display = 'block';
}


function showForm(annee,c)
{
	var id = "" + annee + c;
	var idInput = "Input" + id;
	var idBut = "But" + id;
	var idTP = "typePai" + id;

	document.getElementById(id).style.visibility = 'hidden';
	document.getElementById(idInput).style.visibility = 'visible';
	document.getElementById(idBut).style.visibility = 'visible';
	document.getElementById(idTP).style.visibility = 'visible';

}
