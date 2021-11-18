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

			<h1 id="h1index">Informations</h1>

			<div class="info">
				<h2>Formations BTS</h2>
					<ul>
						<li>La FAQ de la <a target="_blank" href="https://www.gefor.com/faq-formations-bts-cif-1an/">formation BTS</a></li>
					</ul>
				<h2>Le CPF Projet de transition professionnelle (Ex CIF) :</h2>
					<ul>
						<li>Suis-je éligible au CPF ? <a target="_blank" href="https://www.gefor.com/questionnaire-deligibilite-au-cpfptp/">questionnaire</a></li>
						<li>Consulter le détail des modalités générales sur notre <a target="_blank" href="https://www.gefor.com/le-conge-individuel-de-formation-cif/">site</a></li>
						<li>Ouvrir mon compte d'activité sur <a target="_blank" href="https://www.moncompteformation.gouv.fr/espace-prive/html/#/">Mon compte formation</a></li>
						<li>Reporter mes heures de DIF vers mon compte CIF ?<a target="_blank" href="https://www.gefor.com/report-de-vos-heures-de-dif-vers-votre-compte-cpf/"> comment procéder</a></li>
						<li>Consulter les <a target="_blank" href="https://www.gefor.com/conditions-dadmission-cif/">conditions d'admission</a> à la formation</li>
					</ul>
				<h2>Transition Pro :</h2>
					<ul>
						<li>Créer mon <a target="_blank" href="https://monespace.sim-fongecif.fr/#/login">espace personnel</a></li>
					</ul>
			</div>
			<footer><?php include("../../Inclusions/footer.php"); ?></footer>
		</div>	
	</body>
</html>