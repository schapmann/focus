<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=inscription");
	die("");
}

?>

<div class="container">

  <h1>Inscription</h1>


	<div class="jumbotron etroit">
	<form action="controleur.php" method="POST">
		<label for="pseudo">Pseudo</label>
		<input type="text" name="pseudo" class="form-control"/><br />
		<label for="passe1">Mot de passe</label>
	<input type="password" name="passe1" class="form-control"/><br />
	<label for="passe2">Confirmation du mot de passe</label>
<input type="password" name="passe2" class="form-control"/><br />
	<input type="submit" name="action" value="Inscription" class="btn btn-default"/>
	</form>
	</div>

</div>
