<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=notifications");
	die("");
}

include_once "libs/modele.php";
include_once "libs/affichage.php";

echo "<h1>Notifications</h1>";

affichageNotifications($_SESSION["pseudo"]);


?>
