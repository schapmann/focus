<?php


  include_once("maLibSQL.pdo.php");


  function verifUserBdd($pseudo,$passe)
{
	// Vérifie l'identité d'un utilisateur
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM utilisateurs WHERE pseudo='$pseudo' AND passe='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function existancePseudo($pseudo)
{
  //on regarde s'il existe déjà quelqu'un avec ce pseudo, car le pseudo doit être unique
  $SQL = "SELECT id FROM utilisateurs WHERE pseudo='$pseudo'";
  return SQLGetChamp($SQL);
}

function creerUtilisateur($pseudo,$passe)
{
  $SQL="INSERT INTO utilisateurs(pseudo,passe) VALUES ('$pseudo','$passe')";
  return SQLInsert($SQL);
}

function nombrePhotos($pseudo,$qui)
{
  $SQL="SELECT COUNT(*) FROM photos WHERE pseudo='$pseudo' AND visible<2";
  if ($qui == "autre" )
		$SQL .= " AND visible=1";
  return SQLGetChamp($SQL);
}

function nombreAmis($pseudo)
{
  // Cette fonction compte le nombre de photos publiées
  $SQL="SELECT COUNT(*) FROM amis WHERE pseudo1='$pseudo'";
  return SQLGetChamp($SQL);
}

function extensionAvatar($pseudo){
  $SQL = "SELECT extension FROM photos WHERE pseudo='$pseudo' AND visible=2";
  return SQLGetChamp($SQL);
}

function listerPhotos($pseudo,$classe ="both")
{
  //Cette fonction liste des informations sur des photos de la base de donnée
  // et renvoie un tableau d'enregistrements
  // Chaque enregistrement est un tableau associatif contenant les champs
  // idP

  // Lorsque la variable $classe vaut "both", elle renvoie toustes les photos de l'utilisateur
	// Lorsqu'elle vaut "visible", elle ne renvoie que les photos visibles aux amis de l'utilisateur
	// Lorsqu'elle vaut "hidden", elle ne renvoie que les photos cachées aux amis de l'utilisateur

  $SQL = "SELECT idP,extension,visible FROM photos WHERE pseudo='$pseudo' AND visible<2";
  if ($classe == "visible")
		$SQL .= " AND visible=1";
	if ($classe == "hidden")
		$SQL .= " AND visible=0";

  // On classe selon l'identifiant décroissant pour les afficher de la plus récente à la plus ancienne
  $SQL .= " ORDER BY idP DESC";
  $ressourceMySQL = SQLSelect($SQL);
  $tab = parcoursRs($ressourceMySQL);

  return($tab);
}

function listerAmis($pseudo)
{
  //Cette fonction liste les amis de l'utilisateur dans la base de données
  // et renvoie un tableau d'enregistrements
  // Chaque enregistrement est un tableau associatif contenant les champs
  // pseudo2

  $SQL="SELECT pseudo2 FROM amis WHERE pseudo1='$pseudo'";
  $ressourceMySQL = SQLSelect($SQL);
  $tab = parcoursRs($ressourceMySQL);

  return($tab);
}

function listerLikes($pseudo)
{
  //Cette fonction liste les informations des photos qu'aime l'utilisateur dans la base de données
  // et renvoie un tableau d'enregistrements
  // Chaque enregistrement est un tableau associatif contenant les champs
  // idL,pseudo2,idPhoto

  //$SQL="SELECT idL,pseudo2,idPhoto FROM likes WHERE pseudo1='$pseudo' ORDER BY idL DESC";
  $SQL = "SELECT * FROM likes INNER JOIN photos ON likes.idPhoto = photos.idP WHERE pseudo1='$pseudo' ORDER BY idN DESC";
  $ressourceMySQL = SQLSelect($SQL);
  $tab = parcoursRs($ressourceMySQL);

  return($tab);
}
function informationsPhotosNotifications($idN){
  $SQL = "SELECT idPhoto,extension FROM likes INNER JOIN photos ON likes.idPhoto = photos.idP WHERE idN='$idN'";
  $ressourceMySQL = SQLSelect($SQL);
  $tab = parcoursRs($ressourceMySQL);
  return($tab[0]);
}

function listerNotifications($pseudo)
{
  //Cette fonction liste notifications de l'utilisateur dans la base de données
  // et renvoie un tableau d'enregistrements
  // Chaque enregistrement est un tableau associatif contenant les champs
  // idN,pseudo,action
  $SQL="SELECT idN,pseudo,action FROM notifications WHERE destinataire='$pseudo' ORDER BY idN DESC";
  $ressourceMySQL = SQLSelect($SQL);
  $tab = parcoursRs($ressourceMySQL);

  return($tab);
}

function creerAmitie($pseudo1,$pseudo2){
  // Cette fonction crée une amitié entre deux personnes dans la base de donnée
  // nous faisons deux requêtes pour savoir que le premier est amis avec le deuxieme
  // et que le deuxieme est amis avec le premier
  $SQL1 = "INSERT INTO amis(pseudo1,pseudo2) VALUES ('$pseudo1','$pseudo2')";
  SQLInsert($SQL1);
  $SQL2 = "INSERT INTO amis(pseudo1,pseudo2) VALUES ('$pseudo2','$pseudo1')";
  SQLInsert($SQL2);
}

function demandeAmitie($pseudo1,$pseudo2){
  $SQL="SELECT COUNT(*) FROM notifications WHERE pseudo='$pseudo1' AND destinataire='$pseudo2'";
  return SQLGetChamp($SQL);
}

function deleteAmitie($pseudo1,$pseudo2){
  // Cette fonction crée une amitié entre deux personnes dans la base de donnée
  // nous faisons deux requêtes pour savoir que le premier est amis avec le deuxieme
  // et que le deuxieme est amis avec le premier
  $SQL1 = "DELETE FROM amis WHERE pseudo1='$pseudo1' AND pseudo2='$pseudo2'";
  SQLInsert($SQL1);
  $SQL2 = "DELETE FROM amis WHERE pseudo1='$pseudo2' AND pseudo2='$pseudo1'";
  SQLInsert($SQL2);
}

function creerNotification($pseudo,$destinataire,$action)
{
  $SQL="INSERT INTO notifications(pseudo,destinataire,action) VALUES ('$pseudo','$destinataire','$action')";
  return(SQLInsert($SQL));
}

function supprimerNotification($pseudo,$destinataire,$action)
{
  $SQL = "DELETE FROM notifications WHERE pseudo='$pseudo' AND destinataire='$destinataire' AND action='$action'";
	SQLDelete($SQL);
}

function deleteNotification($idN)
{
  $SQL = "DELETE FROM notifications WHERE idN='$idN'";
	SQLDelete($SQL);
}

function identifiantNotificationLike($pseudo1,$pseudo2,$idPhoto){
  $SQL = "SELECT idN FROM likes WHERE pseudo1='$pseudo1' AND pseudo2='$pseudo2' AND idPhoto='$idPhoto'";
  return(SQLGetChamp($SQL));
}
function supprimerLike($pseudo1,$pseudo2,$idPhoto){
  $idN = identifiantNotificationLike($pseudo1,$pseudo2,$idPhoto);
  $SQL = "DELETE FROM likes WHERE pseudo1='$pseudo1' AND pseudo2='$pseudo2' AND idPhoto='$idPhoto'";
	SQLDelete($SQL);
  return $idN;
}

function creerLike($pseudo1,$pseudo2,$idPhoto)
{
  $idN = creerNotification($pseudo1,$pseudo2,"likes");
  $SQL ="INSERT INTO likes(idN,pseudo1, pseudo2, idPhoto) VALUES ('$idN','$pseudo1','$pseudo2','$idPhoto')";
  SQLInsert($SQL);
}

function creerPhoto($pseudo,$extension,$visible)
{
  $SQL ="INSERT INTO photos(pseudo,extension,visible) VALUES ('$pseudo','$extension','$visible')";
  return(SQLInsert($SQL));
}
function deletePhotoAvatar($pseudo){
  $SQL = "DELETE FROM photos WHERE pseudo='$pseudo' AND visible=2";
	SQLDelete($SQL);
}

function supprimerPhoto($idP){
  $SQL = "DELETE FROM photos WHERE idP='$idP'";
	SQLDelete($SQL);
}

function updateCategoriePhoto($idP,$visible){
  $SQL = "UPDATE photos SET visible='$visible' WHERE idP='$idP'";
	SQLUpdate($SQL);
}


function etreAmis($pseudo1,$pseudo2)
{
  $SQL="SELECT COUNT(*) FROM amis WHERE pseudo1='$pseudo1' AND pseudo2='$pseudo2'";
  return SQLGetChamp($SQL);
}

function dejaAimer($pseudo,$idP){
  $SQL="SELECT COUNT(*) FROM likes WHERE pseudo1='$pseudo' AND idPhoto='$idP'";
  return SQLGetChamp($SQL);
}


?>
