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


echo "<h1>Amis</h1>";


affichageAmis($_SESSION["pseudo"]);

?>
