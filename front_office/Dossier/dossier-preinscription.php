<?php
//On démarre une nouvelle session
session_start();

if (empty($_SESSION['login'])) {
	// Si inexistante ou nulle, on redirige vers le formulaire de login
	header("Location:../../index.php");
	exit();
}

use PHPMailer\PHPMailer\PHPMailer;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="CSS\style.css">
	<link rel="stylesheet" href="..\..\CSS\style.css">
	<title>Service d'inscription en ligne - Inscription</title>
</head>

<body>
	<div id="main">
		<?php require_once("../../Inclusions/entete.php"); ?>

		<div class="deco">
			<p>Bonjour <?php echo $_SESSION['Prenom'], " ", $_SESSION['Nom']; ?>,<br>cliquer ici pour se déconnecter</p>
			<form action="../../index.php" method="post">
				<p><input type="submit" value="Déconnexion" /></p>
			</form>
		</div>

		<?php
		// connexion à la base
		require_once("../../Inclusions/connexionBDD.php");

		//var mail = session mail
		$mail = $_SESSION['login'];

		$querycontact = $dbco->prepare("SELECT * FROM contact, candidat WHERE Contact_Email = '$mail' AND Candidat_Id = Contact_Id");
		$querycontact->execute();
		$resultat = $querycontact->fetchAll();

		foreach ($resultat as $donnee) {
			$id = $donnee['Contact_Id'];
			$Contact_Nom = $donnee["Contact_Nom"];
			$Contact_Prenom = $donnee["Contact_Prenom"];
			$Adresse = $donnee['Contact_Adresse'];
			$CodePostal = $donnee['Contact_CodePostal'];
			$Ville = $donnee['Contact_Ville'];
			$Candidat_CPF = $donnee['Candidat_CPF'];
			$Candidat_Situation_Pro = $donnee['Candidat_Situation_Pro'];
		}

		$querydossier = $dbco->prepare("SELECT dossier.Dossier_Id, dossier.Dossier_Formation, gestionnaire.Gestionnaire_Nom, gestionnaire.Gestionnaire_Prenom FROM dossier, gestionnaire WHERE gestionnaire.Gestionnaire_Id = dossier.Gestionnaire_Id AND dossier.Candidat_Id = '$id'");
		$querydossier->execute();
		$resultatd = $querydossier->fetchAll();

		foreach ($resultatd as $donnee) {
			$numdossier = $donnee['Dossier_Id'];
			$gestionnairenom = $donnee['Gestionnaire_Nom'];
			$gestionnaireprenom = $donnee['Gestionnaire_Prenom'];
		}

		?>
		<aside>
			<div>
				<h2>Vos informations</h2>

				<!-- Mise en forme dans le tableau -->
				<table>
					<caption>
						<h3>Etat civil</h3>
					</caption>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
						</tr>
					</thead>
					<?php
					foreach ($resultat as $donnee) {
						print("<tr><td>" . $donnee["Contact_Nom"] . "</td><td>" . $donnee["Contact_Prenom"] . "</td></tr>");
					}
					?>
				</table>

				<table>
					<caption>
						<h3>Coordonnées</h3>
					</caption>
					<thead>
						<tr>
							<th>Adresse postale</th>
							<th>Code postal</th>
							<th>Ville</th>
							<th>Téléphone</th>
							<th>Email</th>
						</tr>
					</thead>

					<?php
					foreach ($resultat as $donnee) {
						print("<tr><td>" . $donnee['Contact_Adresse'] . "</td><td>" . $donnee['Contact_CodePostal'] . "</td><td>" . $donnee['Contact_Ville'] . "</td><td>" . $donnee["Contact_Tel"] . "</td><td>" . $donnee["Contact_Email"] . "</td></tr>");
					}
					?>
				</table>

				<table>
					<caption>
						<h3>Situation actuelle</h3>
					</caption>
					<thead>
						<tr>
							<th>Situation professionnelle</th>
							<th>Candidat CPF</th>
						</tr>
					</thead>

					<?php
					foreach ($resultat as $donnee) {
						print("<tr><td>" . $donnee["Candidat_Situation_Pro"] . "</td><td>" . $Candidat_CPF . "</td></tr>");
					}
					?>
				</table>

				<table>
					<caption>
						<h3>Votre dossier</h3>
					</caption>
					<thead>
						<tr>
							<th>N° d'étudiant</th>
							<th>N° de dossier</th>
							<th>Formation choisie</th>
							<th>Dossier suivi par</th>
						</tr>
					</thead>
					<?php
					foreach ($resultatd as $donnee) {
						print("<tr><td>" . $id . "</td><td>" . $donnee["Dossier_Id"] . "</td><td>" . $donnee["Dossier_Formation"] . "</td><td>" . $donnee["Gestionnaire_Nom"] . " " . $gestionnaireprenom . "</td></tr>");
					}
					?>
				</table>

				<h4>
					Si vous constatez des erreurs ou souhaitez apporter des modifications à ces informations, merci de nous en communiquer les détails, <a href="../Contact/contact.php">par mail</a>, depuis votre espace.
				</h4>
			</div>

			<div>
				<h2>Envoyer des documents</h2>

				<form method="POST" action="fileupload.php" enctype="multipart/form-data">
					<label for="document">Fichier</label><br />
					<input type="file" name="document" />
					<input type="submit" name="upload" value="Envoyer le fichier" />
				</form>

				<?php
				$files = scandir("../../fichiers");
				if (isset($_POST['upload'])) {
					for ($a = 2; $a < count($files); $a++) {
				?>
						<p><?php echo $files[$a]; ?>
							<a href="fileupload<?php echo $files[$a]; ?>" download="<?php echo $files[$a]; ?>/">Envoyer ou Supprimer un fichier</a>
						</p>
				<?php
					}
				}
				?>
			</div>

		</aside>
		<h1 id="h1index">Bienvenue sur votre espace de consultation<br>et de saisie de votre dossier d'inscription</h1>

		<?php

		if ($Candidat_Situation_Pro != '') {
		?>

			<h2 style="text-align: center; min-height: 900px;">Vos données sont en cours de traitement.<br>Nous reviendrons vers vous dans les meilleurs délais.Vous pouvez consulter vos informations et nous faire parvenir la copie de vos documents grâce à l'envoi de document sur cette page.</h2>

		<?php
		} else {
		?>
			<h2>Compléter le formulaire pour finaliser votre inscription</h2>
			<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" class="hautform" id="desactive" method="post">

				<p>
					<label for="Candidat_Situation_Pro">Votre situation professionnelle *</label>
					<select name="Candidat_Situation_Pro" id="Candidat_Situation_Pro" required>
						<option value="">Sélectionner</option>
						<option value="1">CDI</option>
						<option value="2">CDD</option>
						<option value="3">Intérimaire</option>
						<option value="4">Demandeur d’emploi</option>
						<option value="5">Autre</option>
					</select>
				</p>

				<p>Candidat en Formation CPF</p>
				<p>
					<input type="radio" name="Candidat_CPF" value="1" id="Candidat_CPF" checked="checked" />
					<label for="Candidat_CPF">Oui</label>
					<input type="radio" name="Candidat_CPF" value="NULL" id="Candidat_CPF" />
					<label for="Candidat_CPF">Non</label>
				</p>

				<h3 style="margin-bottom:15px">Saisissez ou corrigez vos données postales</h3>
				<p>
					<label for="Contact_Adresse">Adresse postale *</label>
					<input type="text" class="long" required name="Contact_Adresse" value="<?php echo $Adresse; ?>" />
					<label for="Contact_CodePostal ">Code postal *</label>
					<input type="text" class="court" required name="Contact_CodePostal" value="<?php echo $CodePostal; ?>" />
					<label for="Contact_Ville">Ville *</label>
					<input type="text" required name="Contact_Ville" value="<?php echo $Ville; ?>" />
				</p>

				<p>
					<input type="submit" name="Envoyer" value="Envoyer" />
				</p>
			</form>

			<?php

			// On récupère les valeurs si l'utilisateur a cliqué sur le bouton envoyer
			if (isset($_POST['Envoyer'])) {

				// Suppression des caractères à risque
				function securite($data)
				{
					$data = strip_tags($data);
					$data = trim($data);
					$data = htmlspecialchars($data);
					return $data;
				}

				// On récupère les valeurs du formulaire			           
				$Candidat_Situation_Pro = $_POST["Candidat_Situation_Pro"];
				$Candidat_CPF = $_POST["Candidat_CPF"];
				$Contact_Adresse = $_POST["Contact_Adresse"];
				$Contact_CodePostal = $_POST["Contact_CodePostal"];
				$Contact_Ville = $_POST["Contact_Ville"];

				$Contact_Nom = securite($Contact_Nom);
				$Contact = securite($Contact);
				$Adresse = securite($Adresse);
				$CodeP = securite($CodeP);
				$Ville = securite($Ville);
				$Candidat_CPF = securite($Candidat_CPF);
				$Candidat_Situation_Pro = securite($Candidat_Situation_Pro);
				$Contact_Adresse = securite($Contact_Adresse);
				$Contact_CodePostal = securite($Contact_CodePostal);
				$Contact_Ville = securite($Contact_Ville);
				
				//On update les données reçues
				$rqcandidat = $dbco->prepare("UPDATE candidat SET Candidat_Situation_Pro = '$Candidat_Situation_Pro', Candidat_CPF = '$Candidat_CPF' WHERE Candidat_Id = $id");
				$rqcandidat->execute();

				$rqcontact = $dbco->prepare("UPDATE contact SET Contact_Adresse = '$Contact_Adresse', Contact_CodePostal = '$Contact_CodePostal', Contact_Ville = '$Contact_Ville' WHERE Contact_Id = $id");
				$rqcontact->execute();


				//creation du mail						
				$name = $Contact_Nom . " " . $Contact_Prenom;
				$destinataire = $gestionnaireprenom . " " . $gestionnairenom;
				$email = "geforwebmaster@gmail.com";	//destinataireEmail
				$mail = "geforwebmaster@gmail.com";
				$subject = "Validation de formulaire sur l'application Gefor inscription en ligne";
				$body = "Bonjour $destinataire<br><p>L'étudiant $name numéro de dossier $numdossier a validé son formulaire de préinscription.<br>";

				require_once "../../PHPMailer/PHPMailer.php";
				require_once "../../PHPMailer/SMTP.php";
				require_once "../../PHPMailer/Exception.php";

				$mail = new PHPMailer();

				$mail->isSMTP();
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = true;
				$mail->Username = "geforwebmaster@gmail.com";
				$mail->Password = 'geforwebmaster@gmail.com1!';
				$mail->Port = 465;
				$mail->SMTPSecure = "ssl";

				$mail->isHTML(true);
				$mail->setFrom($email, $name);
				$mail->addAddress("geforwebmaster@gmail.com");
				$mail->addAddress($email);
				$mail->Subject = ("$subject");
				$mail->Body = $body;

				if ($mail->send()) {
					$status = "success";
					$response = "Votre formulaire est en cours de validation";
			?><script type="text/javascript">
						window.location.reload()
					</script><?php
							} else {
								$status = "failed";
								$response = "Une erreur est survenue: <br>" . $mail->ErrorInfo;
							}
							exit(json_encode(array("statut" => $response)));
						}
					}
					// On ferme la connection
					$dbco = null;
								?>

	</div>
	<footer><?php require_once("../../Inclusions/footer.php"); ?></footer>
</body>

</html>
