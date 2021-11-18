<?php
    //On démarre une nouvelle session
    session_start();

	if(empty($_SESSION['login'])) 
	{
	  // Si inexistante ou nulle, on redirige vers le formulaire de login
	  header("Location: ../../Login/Application-login.php");
	  exit();
	}
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
			<p>Bonjour <?php echo $_SESSION['Prenom']," ", $_SESSION['Nom']; ?>,<br>cliquer ici pour se déconnecter</p>
					<form action="../../Login/Deconnexion.php" method="post">
						<p><input type="submit" value="Déconnexion"/></p>
					</form>
			</div>

			<h1 id="h1index">FAQ</h1>

			<div>
					<ul class="faq">
						<li><p>Je souhaite rectifier des informations sur mon dossier mais je n'y ai pas accès :
							<br>Une fois les informations validées par le gestionnaire il est impossible de modifier les données qui apparaissent désormais en consultation sur votre profil.<br>Il est nécessaire de nous contacter via le formulaire de l'onglet <a href="../Contact/contact.php">CONTACT</a> pour nous soumettre toute demande de modification</p>
						</li>
						<li><p>J'ai rempli mon dossier de préinscription, dois-je envoyer ma demande de congé à mon employeur ?
							<br>Vous devez passer l'entretien au sein de notre organisme et attendre notre accord avant de demander votre congé</p>
						</li>
						<li><p>Je suis en attente de l'accord de mon employeur, comment puis-je préparer mon dossier CPF ?
							<br>L'accès au formulaire sur nos services ne sera disponible qu'à réception de l'accord de votre employeur. Vous pouvez cependant consulter sur le site de<a href="https://www.transitionspro-idf.fr/accueil-particulier/les-documents-a-telecharger/"> Transition Pro,</a> les informations concernant le dossier à réaliser</p>
						</li>
						<li><p>J'ai reçu l'accord de mon employeur, comment puis-je préparer mon dossier CPF ?
							<br>Vous devez téléverser le scan de votre accord depuis l'onglet <a href="../Dossier/dossier.php">DOSSIER</a></p>
						</li>
						<li><p>J'ai déjà des compétences/diplômes, puis-je bénéficier d'une équivalence ?
							<br>Vos compétences vous seront utiles pour la constitution du dossier.Si vous avez des diplômes pouvant donner lieu à des équivalences, vous devez téléverser le scan de votre/vos diplômes depuis l'onglet <a href="../Dossier/dossier.php">DOSSIER</a></p>
						</li>
					</ul>
			</div>
			<footer><?php include("../../Inclusions/footer.php"); ?></footer>
		</div>	
	</body>
</html>