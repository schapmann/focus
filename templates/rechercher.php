<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=amis");
	die("");
}

include_once "libs/modele.php";
include_once "libs/affichage.php";


echo "<h1>Rechercher</h1>";

if($pseudo = valider("pseudo"))
if(existancePseudo($pseudo)){

  $typePersonne = "autre";
  if($pseudo == $_SESSION["pseudo"]){
    $typePersonne = "moi";
  }

  affichageBandeauProfil($pseudo,$typePersonne,"profil");
}
else{
  echo"<div class=\"container text-center jumbotron\"><p>Aucun résultat pour votre recherche.</p></div>";
}


?>
