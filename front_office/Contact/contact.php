<?php
//On démarre une nouvelle session
session_start();

if (empty($_SESSION['login'])) {
	// Si inexistante ou nulle, on redirige vers le formulaire de login
	header("Location:../../index.php");
	exit();
}

//récup n°dossier depuis var session
$dossiermdp = $_SESSION['pwd'];

// connexion à la base
include("../../Inclusions/connexionBDD.php");

// affichage du numéro de dossier
$ndossier = $dbco->prepare("SELECT Dossier_Id FROM dossier WHERE Dossier_MotDePasse = '$dossiermdp'");
$ndossier->execute();
$ndossier = $ndossier->fetchAll();

//var candidat = id contact de résultat
foreach ($ndossier as $donnee) {
	$DossierId = $donnee['Dossier_Id'];
}
$_SESSION['DossierId'] = $DossierId
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="CSS\style.css">
	<link rel="stylesheet" href="..\..\CSS\style.css">
	<title>Service d'inscription en ligne - Groupe GEFOR</title>
</head>

<body>
	<div id="main">
		<?php include("../../Inclusions/entete.php"); ?>

		<div class="deco">
			<p>Bonjour <?php echo $_SESSION['Prenom'], " ", $_SESSION['Nom']; ?>,<br>cliquer ici pour se déconnecter</p>
			<form action="../../Login/Deconnexion.php" method="post">
				<p><input type="submit" value="Déconnexion" /></p>
			</form>
		</div>

		<h1 id="h1index">Contactez-nous</h1>

		<div class="contact">
			<h2>Contactez-nous :</h2>
			<ul>
				<li>Par téléphone au : 01 55 35 00 20</li>
				<li>Par mail : contact@gefor.com</li>
				<li>Via notre formulaire de contact ci-dessous :<br>nous vous recontacterons dans les meilleurs délais.</li>
			</ul>
			<h2>Horaires :</h2>
			<ul>
				<li>Lundi à vendredi 9h à 12h30</li>
				<li>Lundi à jeudi 13h30 à 18h</li>
				<li>Vendredi 13h30 à 17h</li>
			</ul>
		</div>

		<div class="message">
			<h2>Nouveau message :</h2>
			<p>La réponse à votre question se trouve peut-être dans notre Foire Aux Questions <a href="../FAQ/faq.php">(FAQ).</a><br>Votre message sera routé automatiquement vers le bon collaborateur et vous recevrez une réponse de sa part<br>par mail sur l'adresse que vous nous avez communiquée en créant votre compte.</p>
			<form action="../../PHPMailer/sendMail.php" method="post">
				<p>
					<label for="Dossier_Id">Votre numéro de dossier *</label>
					<input type="text" name="Dossier_Id" value="<?php echo $DossierId; ?>" disabled="disabled" />
				</p>

				<p>
					<label for="Id">l'objet de votre demande *</label>
					<input type="text" required name="subject" />
				</p>

				<p>
					<label for="Contact_Message">Message *</label>
					<textarea required name="body" rows="4" cols="50"></textarea>
				</p>

				<input type="submit" name="Envoyer" value="Envoyer">

			</form>
		</div>
		<footer><?php include("../../Inclusions/footer.php"); ?></footer>
	</div>
</body>

</html>