<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php";
	include_once "libs/modele.php";

	$addArgs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";

		/*
		if ($action != "Connexion")
			securiser("login");
		*/

		// On gère les différents cas
		switch($action)
		{


			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
              // On verifie la presence des champs pseudo et passe
      				$qs = "?view=connexion";

      				if ($pseudo = valider("pseudo"))
      				if ($passe = valider("passe"))
      				{
      					// On verifie l'utilisateur, et on crée des variables de session si tout est OK
      					// Cf. maLibSecurisation
      					if (verifUser($pseudo,$passe))
      						$qs = "?view=profil&categorie=both";
      				}
			break;


      // Inscription //////////////////////////////////////////////////
      case 'Inscription' :
        //on vérifie la présence des champs
        $qs = "?view=inscription";

        if ($pseudo = valider("pseudo"))
        if ($passe1 = valider("passe1"))
        if ($passe2 = valider("passe2"))
        {

          if (existancePseudo($pseudo)) {
            //afficher que le pseudo est déjà pris
            $qs = "?view=inscription";
          }
          elseif($passe1==$passe2){
            creerUtilisateur($pseudo,$passe1);
						if (verifUser($pseudo,$passe1)){
            	$qs = "?view=profil&categorie=both";
						}
          }
          else {
            $qs = "?view=inscription";
          }

        }
      break;


      // Déconnexion /////////////////////////////////////////
      case 'Deconnexion' :
        session_destroy();
        $qs = "?view=accueil";
      break;

      // Pour demander en amis ou retirer de ses Amis
      case 'demanderAmitie':
        if($pseudo=valider("pseudo")){
          creerNotification($_SESSION["pseudo"],$pseudo,"amis");
          $qs = "?view=profil&pseudo=" . $pseudo;
        }
      break;

      case 'retirerAmitie':
        if($pseudo=valider("pseudo")){
          deleteAmitie($_SESSION["pseudo"],$pseudo);
          $qs = "?view=profil&pseudo=" . $pseudo;
        }
      break;

      // Pour accepter ou refuser les demandes d'Amis
      case 'Accepter':
        if($pseudo = valider("pseudo"))
        if($idN = valider("idN"))
        {
          creerAmitie($_SESSION["pseudo"],$pseudo);
          deleteNotification($idN);

          $qs = "?view=notifications";
        }
      break;

      case 'Refuser':
      if($pseudo = valider("pseudo"))
      if($idN = valider("idN"))
      {
        deleteNotification($idN);

        $qs = "?view=notifications";
      }
      break;

			case 'Supprimer la notification':
      if($pseudo = valider("pseudo"))
      if($idN = valider("idN"))
      {
        deleteNotification($idN);

        $qs = "?view=notifications";
      }
      break;

      case 'Public':
        $qs = "?view=profil&categorie=visible";
      break;

      case 'Tout':
        $qs = "?view=profil&categorie=both";
      break;

      case 'Privé':
        $qs = "?view=profil&categorie=hidden";
      break;

			case 'Rendre public':
				$qs = "?view=profil&categorie=both";
				if($idP = valider("idP"))
				{
					updateCategoriePhoto($idP,1);
				}
			break;

			case 'Rendre privé':
				$qs = "?view=profil&categorie=both";
				if($idP = valider("idP"))
				{
					updateCategoriePhoto($idP,0);
				}
			break;

			case 'Supprimer':
				$qs = "?view=profil";
				if($idP = valider("idP"))
				{
					supprimerPhoto($idP);
				}
			break;

			case 'Aimer':
				if($view = valider("view"))
				if($pseudo = valider("pseudo"))
				if($idP = valider("idP"))
				{
					creerLike($_SESSION["pseudo"],$pseudo,$idP);
					$qs = "?view=$view&pseudo=" . $pseudo;
				}
			break;

			case 'Ne plus aimer':
				if($view = valider("view"))
				if($pseudo = valider("pseudo"))
				if($idP = valider("idP"))
				{
					$idN = supprimerLike($_SESSION["pseudo"],$pseudo,$idP);
					deleteNotification($idN);
					$qs = "?view=$view&pseudo=" . $pseudo;
				}
			break;

			case 'Rechercher':
				if($recherche = valider("recherche"))
				{
					$qs = "?view=rechercher&pseudo=" . $recherche;
				}
			break;



		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();

?>
