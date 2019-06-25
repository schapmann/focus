<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=profil");
	die("");
}

include_once "libs/modele.php";
include_once "libs/affichage.php";

echo "<h1>Profil</h1>";

if($pseudo = valider("pseudo")){
  affichageBandeauProfil($pseudo,"autre","profil");
}
else{
  if($categorie = valider("categorie")){
    affichageBandeauProfil($_SESSION["pseudo"],"moi","profil",$categorie);
  }
  else{
    affichageBandeauProfil($_SESSION["pseudo"],"moi","profil");
  }
}


?>
