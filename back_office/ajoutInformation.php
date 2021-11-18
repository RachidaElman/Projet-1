<?php


require('_connect.php');
session_start();
if (empty($_SESSION['login'])) {
    header("Location:../index.php");
    exit();
}
if (isset($_GET['idmod'])) {








    $id2 = $_GET['idmod'];


    $reqdossier = $bdd->prepare(
        "SELECT *
    FROM dossier d
    INNER JOIN candidat ca ON d.Candidat_Id=ca.Candidat_Id
    INNER JOIN contact c ON c.Contact_Id=ca.Candidat_Id
    WHERE c.Contact_Id= '$id2'"
    );
    $reqdossier->execute(array($id2));
    $reqdo = $reqdossier->fetch();


    $req_situationpro =  $bdd->prepare('SELECT Candidat_Situation_Pro
    FROM candidat');
    $req_situationpro->execute(array($id2));
    $reqsp = $req_situationpro->fetch();


    $req_formation =  $bdd->prepare('SELECT Dossier_Formation
    FROM dossier');
    $req_formation->execute(array($id2));
    $reqfor = $req_formation->fetch();
}
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
    <form action="update2.php" method="POST">
        <div class="container">
            <p>Bonjour <?php echo $_SESSION['Prenom']; ?></p>

            <input type="hidden" name="Contact_Id" value="<?= $reqdo['Contact_Id'] ?>">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Candidat <?php echo $reqdo['Contact_Nom'] . " " . $reqdo['Contact_Prenom']; ?></h1>
                    <h1> Ajouts informations</h1>

                </div>

                <div class="container">
                    <!--date début formation-->
                    <div class="form-row">
                        <div class="form-group" data-provide="datepicker">
                            <label for="Dossier_Session">Date de début de formation</label>

                            <input type="date" class="form-control" name="Dossier_Session" id="Dossier_Session" value="<?= $reqdo['Dossier_Session'] ?>" />

                        </div>
                    </div>





                    <h5>Parcours</h5>

                    <div class="row mb-4">
                        <div class="col">
                            <label for="Candidat_Diplome">Diplômes validés</label>

                            <input type="text" name="Candidat_Diplome" class="form-control" value="<?= $reqdo['Candidat_Diplome'] ?>">





                        </div>
                        <label class="form-check form-check-inline">Parcours personnalisé</label>

                        <div class="form-check form-check-inline">
                            <?php
                            $chek0 = "";
                            $chek1 = "";
                            if ($reqdo['Dossier_Parcours_personnalise'] == 1) {
                                $chek1 = 'checked';
                            } else {
                                $chek0 = 'checked';
                            }
                            ?>
                            <input class="form-check-input" type="radio" <?= $chek1 ?> name="Dossier_Parcours_personnalise" id="inlineRadio1" value="1" />
                            <label class="form-check-label" for="inlineRadio1">Oui</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?= $chek0 ?> name="Dossier_Parcours_personnalise" id="inlineRadio1" value="0" />
                            <label class="form-check-label" for="inlineRadio1">Non</label>
                        </div>
                    </div>




                </div>


                <div class="container">
                    <h5>Compétences</h5>

                    <div class="row mb-4">
                        <div class="col">

                            <label for="Candidat_Competence"></label>

                            <input type="text" name="Candidat_Competence" class="form-control" value="<?= $reqdo['Candidat_Competence'] ?>">
                        </div>


                    </div>
                </div>





                <div class="container">
                    <h5>Bilan entretien</h5>

                    <label for="Dossier_Bilan_Formation">Bilan entretien</label>

                    <input type="text" name="Dossier_Bilan_Formation" class="form-control" value="<?= $reqdo['Dossier_Bilan_Formation'] ?>">
                </div>


                <div class="container">
                    <h5>Dossier</h5>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="Dossier_Financeur">Nom du Financeur</label>
                            <input type="text" class="form-control" name="Dossier_Financeur" value="<?= $reqdo['Dossier_Financeur'] ?>">
                        </div>
                    </div>



                    <div class="form-row">
                        <div class="form-group" data-provide="datepicker">
                            <label for="Dossier_Transmission">Date de transmission</label>
                            <input type="date" class="form-control" id="Dossier_Transmission" name="Dossier_Transmission" value="<?= $reqdo['Dossier_Transmission'] ?>">
                        </div>
                    </div>





                    <div class="form-row">
                        <div class="form-group" data-provide="datepicker">
                            <label for="Dossier_DateRetourFinanceur">Date retour financeur</label>
                            <input type="date" class="form-control" id="Dossier_Report" name="Dossier_DateRetourFinanceur" value="<?= $reqdo['Dossier_DateRetourFinanceur'] ?>">
                        </div>
                    </div>




                    <div class="form-row">
                        <div class="form-group" data-provide="datepicker">
                            <label for="Dossier_Annulation">Date annulation</label>
                            <input type="date" class="form-control" id="Dossier_Annulation" name="Dossier_Annulation" value="<?= $reqdo['Dossier_Annulation'] ?>">
                        </div>
                    </div>




                </div>
                <div class="container">

                    <div class="row mb-4">
                        <div class="col">
                            <input type="submit" class="form-control" name="envoyer" value="Transmettre formulaire" id="submit2">
                        </div>
                    </div>
                </div>

    </form>
    <div class="container">









        <!-- Footer -->
        <?php require('_footer.php'); ?>
        <!-- Footer -->

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/script.js"></script>
</body>

</html>