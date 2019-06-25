function twRequeteVariable(sVariable) {
  // Éliminer le "?"
  var sReq = window.location.search.substring(1);
  // Matrice de la requête
  var aReq = sReq.split("&");
  // Boucle les variables
  for (var i=0;i<aReq.length;i++) {
    // Matrice de la variables / valeur
    var aVar = aReq[i].split("=");
    // Retourne la valeur si la variable
    // demandée = la variable de la boucle
    if(aVar[0] == sVariable){return aVar[1];}
  }
  // Aucune variable de trouvée.
  return(false);
}

var categorie = twRequeteVariable('categorie');
document.getElementById(categorie).className = "btn btn-default type_photo col-xs-12 col-sm-12 col-md-4 col-lg-4 active";
