<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}

?>

<div id="corps" class="container">

<h1>Connexion</h1>

<div class="jumbotron etroit">
<form action="controleur.php" method="POST">
	<label for="pseudo">Pseudo</label>
	<input type="text" name="pseudo" class="form-control"/><br />
	<label for="passe">Mot de passe</label>
<input type="password" name="passe" class="form-control"/><br />
<input type="submit" name="action" value="Connexion" class="btn btn-default"/>
</form>
</div>




</div>
