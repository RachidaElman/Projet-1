<?php
//On démarre une nouvelle session
    session_start();

	if(empty($_SESSION['login'])) 
	{
	  // Si inexistante ou nulle, on redirige vers le formulaire de login
	  header("Location: ../../Login/Application-login.php");
	  exit();
	}
// Getting uploaded file
$files = $_FILES["document"];

// Uploading in "uplaods" folder
move_uploaded_file($files["tmp_name"], "../../fichiers/" . $files["name"]);

//unlink($_GET["name"]); // Supprime le fichier

// Redirecting back
header("Location: dossier-preinscription.php");
?>