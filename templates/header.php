<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Focus</title>
  <!--CSS -->

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

  <nav class="navbar navbar-default">
      <div class="container">
				<div class="navbar-header">
      <!-- à mettre l'image du logo -->
      <a href="index.php" class="navbar-brand">focus</a>

				</div>

        <ul class="nav navbar-nav navbar-right menu">

      <?php
        //si l'utilisateur n'est pas connecté
      if (!valider("connecte","SESSION")){
        ?>

        <li><a href="index.php?view=connexion">Se connecter</a></li>
        <li><a href="index.php?view=inscription" >S'inscrire</a></li>

        <?php
      }
        //si l'utilisateur est connecté
      else {
        ?>

        <li><a href="index.php?view=profil&categorie=both">Profil</a></li>
        <li><a href="index.php?view=amis">Amis</a></li>
        <li>

					<form class="navbar-form navbar-left" action="controleur.php">
      			<div class="form-group">
        			<input type="text" name="recherche" class="form-control" placeholder="Rechercher">
							<input type="submit" name="action" class="btn btn-default hidden" value="Rechercher">
						</div>
    			</form>

				</li>
        <li><a href="index.php?view=notifications">Notifications</a></li>
        <li><a href="index.php?view=likes">Likes</a></li>
        <li><a href="controleur.php?action=Deconnexion">Déconnexion</a></li>

      </ul>

        <?php
      }

     ?>


   </div>
  </nav>


</body>
