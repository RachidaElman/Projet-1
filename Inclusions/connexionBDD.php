<?php
// connexion à la base
$serveur = "localhost";
$dbname = "ppe3";
$user = "root";
$pass = "";
$dbco = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
