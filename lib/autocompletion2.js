function ac_return(field, item){
	// on met en place l'expression régulière
	var regex = new RegExp('[0123456789]*-idcache', 'i');
	// on l'applique au contenu
	var nomimage = regex.exec($(item).innerHTML);
	//on récupère l'id
	id = nomimage[0].replace('-idcache', '');
	// et on l'affecte au champ caché
	$(field.name+'_id').value = id;
}