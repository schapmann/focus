<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<?php
session_start();


  include_once "libs/maLibUtils.php";

  // on récupère le paramètre view éventuel
	$view = valider("view");
	/* valider automatise le code suivant :
	if (isset($_GET["view"]) && $_GET["view"]!="")
	{
		$view = $_GET["view"]
	}*/

	// S'il est vide, on charge la vue accueil par défaut
	if (!$view) $view = "accueil";

  //Entête de la page
  include("templates/header.php");


  //En fonction de la vue à afficher, on appelle tel ou tel templates
  switch($view)
  {
    case "accueil" :
      include("templates/accueil.php");
    break;

    default : // si le template correspondant à l'argument existe, on l'affiche
      if (file_exists("templates/$view.php"))
      include("templates/$view.php");

  }
 ?>

<script src="js/categorie.js"></script>
