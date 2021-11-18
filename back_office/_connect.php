<?php

try {


    $bdd = new PDO('mysql:host=localhost;dbname=ppe3;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $erreur) {

    die('Erreur : ' . $erreur->getMessage());
}
