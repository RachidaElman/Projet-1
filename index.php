<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>PPE3_GEFOR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="back_office/css/bootstrap.min.css">
    <link rel="stylesheet" href="back_office/css/main.css">
    <title>Application - login - Groupe GEFOR</title>
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <div class="container">
                <img src="back_office/img/logo_gefor.png" width="400" class="img-fluid" alt="">

            </div>
        </div>
    </header>
    <div class="container">
        <h1>Bienvenue sur le Service d'inscription en ligne<br> du Groupe GEFOR</h1>

        <form action="back_office/Connexion/connexionFB.php" method="post">
            <div class="form-group">
                <label for="Email">Identifiant</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="Email" placeholder="Entrez votre adresse adresse mail">
                <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre e-mail avec qui que ce soit.</small>
            </div>
            <div class="form-group">
                <label for="MDP">Mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="MDP" placeholder="Entrez votre mot de passe">
            </div>

            <button type="submit" class="btn btn-primary" name="Connexion" value="Connexion">Envoyer</button>
        </form>
    </div>

    <script src="back_office/js/jquery.min.js"></script>
    <script src="back_office/js/bootstrap.bundle.min.js"></script>
    <script src="back_office/js/script.js"></script>
</body>

</html>