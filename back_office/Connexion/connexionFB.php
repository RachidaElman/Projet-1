<?php
session_start();
// On récupère les valeurs si l'utilisateur a cliqué sur le bouton envoyer
if (isset($_POST['Connexion'])) {
	// On récupère les valeurs identifiant pers et mp du formulaire	dans les variables		           
	$Email = $_POST["Email"];
	$MDP = $_POST["MDP"];
	// connexion à la base
	require_once("../_connect.php");
	// Vérification des identifiants
	// Le contact existe dans la base de données
	$query_contact = $bdd->prepare("SELECT * FROM contact, dossier WHERE Contact_Email = '$Email' AND Dossier_MotDePasse = '$MDP'");
	$query_contact->execute();
	$rquery_contact = $query_contact->fetch();
	// Le gestionnaire existe dans la base de données
	$query_gestionnaire = $bdd->prepare("SELECT * FROM gestionnaire WHERE Gestionnaire_Email = '$Email' AND Gestionnaire_MotDePasse = '$MDP'");
	$query_gestionnaire->execute();
	$rquery_gestionnaire = $query_gestionnaire->fetch();
	// Si les identifiants sont corrects, on redirige vers l'application, sinon on affiche un message d'erreur
	if ($rquery_contact or $rquery_gestionnaire) {
		// on initie les variables booléennes
		if (empty($rquery_contact)) {
			$rquery_contact == 0;
		}
		if (empty($rquery_gestionnaire)) {
			$rquery_gestionnaire == 0;
		}

		// Definition des constantes et variables de session communes (login:mail, pwd:mot de passe)
		$_SESSION['login'] = $_POST["Email"];
		$_SESSION['pwd'] = $_POST["MDP"];
		//Si l'utilisateur est un contact, on ouvre le front et on récupère ses données de session
		if ($rquery_contact != 0 and $rquery_gestionnaire == 0) {
			// Definition des constantes et variables de session contact
			$_SESSION['Id'] = $rquery_contact['Contact_Id'];
			$_SESSION['Nom'] = $rquery_contact['Contact_Nom'];
			$_SESSION['Prenom'] = $rquery_contact['Contact_Prenom'];
			header("Location:../../front_office/Accueil/accueil.php");
		}
		//Si l'utilisateur est un gestionnaire, on ouvre le back
		elseif ($rquery_gestionnaire != 0 and $rquery_contact == 0) {
			// Definition des constantes et variables de session gestionnaire
			$_SESSION['Id'] = $rquery_gestionnaire['Gestionnaire_Id'];
			$_SESSION['Nom'] = $rquery_gestionnaire['Gestionnaire_Nom'];
			$_SESSION['Prenom'] = $rquery_gestionnaire['Gestionnaire_Prenom'];
			// Redirection vers le tableau de bord de l'application des inscriptions en ligne
			header("Location:../accueil.php");
		}
	} else {
		echo "<h2>L'identifiant ou le mot de passe est incorrect</h2>";
	}
}
// On ferme la connection
$bdd = null;
