<?php

include_once("modele.php");

function messageAmitie($pseudo){
  if($pseudo != $_SESSION["pseudo"]){
  if(etreAmis($_SESSION["pseudo"],$pseudo))
  {
    echo "<a class=\"btn btn-default\" href=\"controleur.php?action=retirerAmitie&pseudo=" . $pseudo. "\">Ne plus être amis</a>";
  }
  elseif(demandeAmitie($_SESSION["pseudo"],$pseudo)){
    echo "<p>Demande d'amis en attente</p>";
  }
  else {
    echo "<a class=\"btn btn-default\" href=\"controleur.php?action=demanderAmitie&pseudo=" . $pseudo. "\">Demander en amis</a>";
  }
  }
  else{
    echo "<a class=\"btn btn-default\" href=\"index.php?view=ajouterPhoto&dossier=avatar\">Changer mon avatar</a>";
  }
}

function affichageAvatar($pseudo){
  ?>
  <div class="jumbotron row">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
  <div class="div-avatar col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <?php
    if($extension = extensionAvatar($pseudo)){
      echo "<img src=\"ressources/avatar/$pseudo.$extension\" class=\"photo-avatar img-responsive\" alt=\"\">";
    }
    else{
      echo "<img src=\"ressources/batman.jpg\" class=\"photo-avatar img-responsive\" alt=\"\">";
    }
    ?>
  </div>
  <?php
}


function affichageBandeauProfil($pseudo,$qui,$view,$categorie="both")
{
  $nbrPhotos = nombrePhotos($pseudo,$qui);
  $nbrAmis = nombreAmis($pseudo);
  ?>



  <div class="bandeauProfil container">
    <?php
    affichageAvatar($pseudo);
    ?>
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
      <?php
        echo "<a class=\"btn pseudonyme\" href=\"index.php?view=profil&pseudo=$pseudo\">$pseudo</a>";
        echo "<p>$nbrPhotos photos";
        echo "        $nbrAmis amis</p>";
        messageAmitie($pseudo);
       ?>
    </div>
  </div>
  </div>
  <?php

  if($view=="profil"){
    if($pseudo != $_SESSION["pseudo"]) {
      if(etreAmis($_SESSION["pseudo"],$pseudo)){
        affichagePhotos($pseudo,"visible");
      }
      else{
        echo "<div class=\"container jumbotron text-center\"><p>Vous ne pouvez pas voir les photos de ce profil car vous n'êtes pas amis.</p></div>";
      }
    }
    else{
      ?>
    <div class="ajouter container">
      <a class="btn btn-default center-block" href="index.php?view=ajouterPhoto&dossier=photo">Ajouter une photo</a>
    </div>

    <div class="form container" id="categorie-container">
    <form class="categorie row" action="controleur.php">
      <input id="visible" type="submit" name="action" value="Public" class="btn btn-default type_photo col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <input id="both" type="submit" name="action" value="Tout" class="btn btn-default type_photo col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <input id="hidden" type="submit" name="action" value="Privé" class="btn btn-default type_photo col-xs-12 col-sm-12 col-md-4 col-lg-4">
    </form>
    </div>
    <?php

    affichagePhotos($_SESSION["pseudo"],$categorie);
  }
}
}

function affichageOptionsPhotos($pseudo,$idP,$visible)
{
  echo "<div id=\"$idP\" class=\"option-photo container text-center\">";
  echo "<div id=\"$idP\" class=\"option-photo2\">";

  if($view = valider("view"))

  ?>

  <a class="btn btn-default option afficher hidden" href="#">Afficher</a></br>



  <?php
  echo "<form action=\"controleur.php?view=$view&pseudo=$pseudo&idP=$idP\" method=\"POST\">";
  if($pseudo == $_SESSION["pseudo"]){
    if($visible==0){
      echo "<input type=\"submit\" name=\"action\" class=\"btn btn-primary option\" value=\"Rendre public\" />";
    }
    else{
      echo "<input type=\"submit\" name=\"action\" class=\"btn btn-default option\" value=\"Rendre privé\" />";
    }


    echo "<input type=\"submit\" name=\"action\" class=\"btn btn-danger option\" value=\"Supprimer\"/>";

  }
  else{
    $aime=dejaAimer($_SESSION["pseudo"],$idP);
    if($aime==1){
      echo "<input type=\"submit\" name=\"action\" class=\"btn btn-info option\" value=\"Ne plus aimer\"/>";
    }
    else{
      echo "<input type=\"submit\" name=\"action\" class=\"btn btn-info option\" value=\"Aimer\"/ >";
    }


  }
  echo "</form>";
  echo "</div>";
  echo "</div>";
}

function affichagePhotos($pseudo,$classe)
{
  $tabPhotos = listerPhotos($pseudo,$classe);
  ?>
  <div class="container">
    <div class="row">

  <?php
  foreach($tabPhotos as $photos) {
    ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 div-photo">
    <?php
    echo "<a data-toggle=\"lightbox\" href=\"ressources/photos/" . $photos["idP"] . '.' . $photos["extension"] . "\"><img class=\"img-fluid img-responsive center-block photo\" src=\"ressources/photos/" . $photos["idP"] . '.' . $photos["extension"] . "\" /></a>";
    affichageOptionsPhotos($pseudo,$photos["idP"],$photos["visible"]);
    echo "</div>";
  }
  echo "</div>";
  echo "</div>";

}

function affichageNotifications($pseudo)
{
  if($tabNotifications = listerNotifications($pseudo)){
  foreach($tabNotifications as $notifs){
    ?>
    <div class="container notifs">
      <div class="row">
          <?php
          affichageAvatar($notifs["pseudo"]) ;

    if($notifs["action"]=="amis"){


      echo "<div class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\">";

      echo "<a class=\"\" href=\"index.php?view=profil&pseudo=" . $notifs["pseudo"] . "\">". $notifs["pseudo"] . "</a>";

      echo " vous a demandé en amis.<br/>";

      echo "<form action=\"controleur.php?pseudo=" . $notifs["pseudo"] . "&idN=" . $notifs["idN"] . "\"";
      echo " method=\"POST\">";
      echo "<input class=\"btn btn-default\" type=\"submit\" name=\"action\" value=\"Accepter\">";
      echo "<input class=\"btn btn-default\" type=\"submit\" name=\"action\" value=\"Refuser\">";
      echo "</form>";
      echo "</div>";
    }
    if($notifs["action"]=="likes"){
      echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";


      echo $notifs["pseudo"] . " a aimé votre photo.<br/>";

      echo "<form action=\"controleur.php?pseudo=" . $notifs["pseudo"] . "&idN=" . $notifs["idN"] . "\" method=\"POST\">";
      echo "<input class=\"btn btn-danger\" type=\"submit\" name=\"action\" value=\"Supprimer la notification\">";
      echo "</form>";
      echo "</div>";
      ?>
      <div class="div-avatar col-xs-2 col-sm-2 col-md-2 col-lg-2">

        <?php
        $tab = informationsPhotosNotifications($notifs["idN"]);
        echo "<img src=\"ressources/photos/". $tab["idPhoto"] . "." . $tab["extension"] . "\" class=\"photo-avatar img-responsive\" alt=\"\">";

      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}
else{
  echo"<div class=\"container text-center jumbotron\"><p>Vous n'avez pas de notifications.</p></div>";
}
}



function affichageLikes($pseudo)
{
  $photosLikesAccessibles = false;
  if($tabLikes = listerLikes($pseudo)){
  ?>
  <div class="container">
    <div class="row">
  <?php
  foreach($tabLikes as $likes) {
    if($likes["visible"]==1){
      $photosLikesAccessibles = true;
      ?>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 div-photo">
      <?php
      echo "<img class=\"img-fluid img-responsive center-block photo\" src=\"ressources/photos/" . $likes["idP"] . '.' . $likes["extension"] . "\" />";
      affichageOptionsPhotos($likes["pseudo2"],$likes["idP"],1);
      echo "</div>";
    }
    }
    echo "</div>";
    echo "</div>";
  }
  if(!$photosLikesAccessibles){
    echo "<div class=\"container text-center jumbotron\"><p>Vous n'avez pas aimé de photo.</p></div>";
  }
}




function affichageAmis($pseudo)
{
  if($tabAmis = listerAmis($pseudo)){
  //tprint($tabAmis);
  foreach($tabAmis as $amis) {
    affichageBandeauProfil($amis["pseudo2"],"autre","amis");
  }
}
else{
  echo"<div class=\"container text-center jumbotron\"><p>Vous n'avez pas d'amis.</p></div>";
}

}


function ajouterPhoto($pseudo,$dossier="photo"){

  echo "<h1>Ajouter une photo</h1>";

  ?>
  <div class="container">
  <div class="jumbotron text-center etroit">
  <form method="POST" enctype="multipart/form-data" class="">
    <p>
          <label for="photo" class="m-30">Choisir la photo à envoyer</label>
          <input type="file" name="photo" class="fichier"/><br />
          <?php
          if($dossier=="photo"){
          ?>
          <label>Public     <input type="radio" name="categorie" value="public" checked/></label>
          <label class="m-30">Privé      <input type="radio" name="categorie" value="prive"/></label><br />
          <?php
          }
          ?>
  				<input type="submit" value="Envoyer" class="btn-lg btn-default"/>
  			</p>
  </form>

  <?php

  if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0){
    $infosfichier = pathinfo($_FILES['photo']['name']);
    $extension_upload = $infosfichier['extension'];
    $extensions_autorisees = array('png', 'jpg', 'jpeg','gif');//On peut rajouter des extensions dans l'array

    if (in_array($extension_upload, $extensions_autorisees))
    {

      // On peut valider le fichier et le stocker définitivement
      if($dossier=="photo"){

        if($estVisible = valider("categorie")){
          //Les photos sont visibles par défaut si rien n'est coché
          $v=1;
          if($estVisible != "public"){
            $v = 0;
          }

        }
        $idPhoto = creerPhoto($pseudo,$extension_upload,$v);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'ressources/photos/' . $idPhoto . '.' . $extension_upload) ;
      }
      else{
        $extension = extensionAvatar($pseudo);
        if (file_exists('ressources/avatar/' . $pseudo . $extension)){
          unlink('ressources/avatar/' . $pseudo . $extension);
          deletePhotoAvatar($pseudo);
        }
        creerPhoto($pseudo,$extension_upload,2);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'ressources/avatar/' . $pseudo . '.' . $extension_upload) ;
      }
      echo "<p>L'envoi a bien été effectué !</p>";
    }
    echo "</div>";
    echo "</div>";
  }


}
?>
