<?php

require('../../Inclusions/connexionBDD.php');
//On démarre une nouvelle session
session_start();
if (empty($_SESSION['login'])) {
	// Si inexistante ou nulle, on redirige vers le formulaire de login
	header("Location:../../index.php");
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="..\..\CSS\style.css">
	<title>Service d'inscription en ligne - Groupe GEFOR</title>
</head>

<body>
	<?php include("../../Inclusions/entete.php"); ?>

	<div class="deco">
		<p>Bonjour <?php echo $_SESSION['Prenom'], " ", $_SESSION['Nom']; ?>,<br>cliquer ici pour se déconnecter</p>
		<form action="../../index.php" method="post">
			<p><input type="submit" value="Déconnexion" /></p>
		</form>
	</div>

	<h1 id="h1index">Bienvenue sur le service d'inscription en ligne<br>du Groupe GEFOR</h1>

	<h2 id="h1index">Vous pouvez compléter le formulaire d'inscription<br>et consulter votre dossier depuis l'onglet <a href="../Dossier/dossier.php">DOSSIER</a>
		<p>Un service d'aide est disponible depuis l'onglet <a href="../Informations/informations.php">INFORMATIONS</a></p>
	</h2>

	<footer><?php include("../../Inclusions/footer.php"); ?></footer>

</body>

</html>