<?php

require('_connect.php');

if (!isset($_GET['iduser'])) {
    echo "le paramètre iduser est obligatoire";
    exit();
}

/*Afficher les champs "identité" et "coordonnées" et "situation actuelle*/
$id = $_GET['iduser'];
$req_contact = $bdd->prepare('SELECT * FROM contact  WHERE Contact_Id= ?');
$req_contact->execute(array($id));
$contact = $req_contact->fetchAll();

$req_candidat = $bdd->prepare('SELECT *
FROM candidat c
INNER JOIN contact co ON c.Candidat_Id= co.Contact_Id
INNER JOIN dossier d ON d.Candidat_Id = c.Candidat_Id
WHERE Contact_Id= ?');
$req_candidat->execute(array($id));
$candidat = $req_candidat->fetchAll();




?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>PPE3_GEFOR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <?php require('_header.php'); ?>
    <!-- début de contenu de la page -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Identité du Candidat</h4>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom de famille</th>

                </tr>
            </thead>
            <tbody class="bg-dark">

                <?php
                foreach ($contact as $cont) {
                    echo ('<tr>');
                    echo ('<td>' . $cont['Contact_Prenom'] . '</td>');
                    echo ('<td>' . $cont['Contact_Nom'] . '</td>');

                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Coordonnées</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code Postal</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Numéro de téléphone portable</th>
                    <th scope="col">Adresse Mail</th>
                </tr>
            </thead>
            <tbody class="bg-dark">

                <?php
                foreach ($contact as $cont) {
                    echo ('<tr>');
                    echo ('<td>' . $cont['Contact_Adresse'] . '</td>');
                    echo ('<td>' . $cont['Contact_CodePostal'] . '</td>');
                    echo ('<td>' . $cont['Contact_Ville'] . '</td>');
                    echo ('<td>' . $cont['Contact_Tel'] . '</td>');
                    echo ('<td>' . $cont['Contact_Email'] . '</td>');
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Situation actuelle</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">CDI,CDD,Intérim...</th>

                </tr>
            </thead>
            <tbody class="bg-dark">

                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    echo ('<td>' . $candid['Candidat_Situation_Pro'] . '</td>');
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Formation</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Formation visée</th>
                    <th scope="col">Date de la session</th>
                </tr>
            </thead>
            <tbody class="bg-dark">

                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');

                    echo ('<td>' . $candid['Dossier_Formation'] . '</td>');
                    if ($candid['Dossier_Transmission'] != NULL && $candid['Dossier_Transmission'] != '0000-00-00') {
                        $date = strtotime($candid['Dossier_Session']);
                        echo ('<td>' . date('d/m/Y', $date) . '</td>');
                    } else {
                        echo '<td>' . "non renseigné" . '</td>';
                    }

                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Financement</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom du financeur</th>

                </tr>
            </thead>
            <tbody class="bg-dark">

                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    echo ('<td>' . $candid['Dossier_Financeur'] . '</td>');
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Parcours</h4>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Diplômes validés</th>
                    <th scope="col">Parcours personnalisé</th>

                </tr>
            </thead>
            <tbody class="bg-dark">
                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    echo ('<td>' . $candid['Candidat_Diplome'] . '</td>');
                    if ($candid['Dossier_Parcours_personnalise'] == 1) {
                        echo ('<td>OUI</td>');
                    } else {
                        echo ('<td>NON</td>');
                    }

                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Compétences</h4>
        <table class="table">
            <thead class="thead-dark">

                <tr>
                    <th scope="col">Nom des compétences</th>
                </tr>
            </thead>
            <tbody class="bg-dark">
                <!--mettre ici la boucle foreach-->
                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    echo ('<td>' . $candid['Candidat_Competence'] . '</td>');

                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Bilan Entretien</h4>
        <table class="table">
            <thead class="thead-dark">

                <tr>
                    <th scope="col"> Avis entretien et test</th>

                </tr>
            </thead>
            <tbody class="bg-dark">
                <!--mettre ici la boucle foreach-->
                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    echo ('<td>' . $candid['Dossier_Bilan_Formation'] . '</td>');
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
        <h4>Dossier</h4>
        <table class="table">
            <thead class="thead-dark">

                <tr>

                    <th scope="col">Date de transmission du dossier à TP</th>
                    <th scope="col">Date retour financeur</th>
                    <th scope="col">Annulation de dossier</th>
                </tr>
            </thead>
            <tbody class="bg-dark">
                <?php
                foreach ($candidat as $candid) {
                    echo ('<tr>');
                    if ($candid['Dossier_Transmission'] != NULL && $candid['Dossier_Transmission'] != '0000-00-00') {
                        $date1 = strtotime($candid['Dossier_Transmission']);
                        echo ('<td>' . date('d/m/Y', $date1) . '</td>');
                    } else {
                        echo '<td>' . "non renseigné" . '</td>';
                    }



                    if ($candid['Dossier_DateRetourFinanceur'] != NULL && $candid['Dossier_DateRetourFinanceur'] != '0000-00-00') {
                        $date2 = strtotime($candid['Dossier_DateRetourFinanceur']);
                        echo ('<td>' . date('d/m/Y', $date2) . '</td>');
                    } else {
                        echo '<td>' . "non renseigné" . '</td>';
                    }

                    if ($candid['Dossier_Annulation'] != NULL && $candid['Dossier_Annulation'] != '0000-00-00') {
                        $date3 = strtotime($candid['Dossier_Annulation']);
                        echo ('<td>' . date('d/m/Y', $date3) . '</td>');
                    } else {
                        echo '<td>' . "non renseigné" . '</td>';
                    }

                    echo ('</tr>');
                }





                ?>
            </tbody>
        </table>

    </div>
    <!-- fin de contenu de la page -->

    <!-- Footer -->
    <?php require('_footer.php'); ?>
    <!-- Footer -->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>