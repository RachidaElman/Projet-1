<?php
session_start();
if (empty($_SESSION['login'])) {
    header("Location:../index.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;

require('_connect.php');



// Requête pour récupérer les infos que d'un contact qui n'est pas étudiant
$querycontact = $bdd->prepare("SELECT * FROM contact WHERE NOT EXISTS (SELECT Candidat_Id  FROM candidat WHERE Contact_Id = Candidat_Id) ORDER BY Contact_Nom");
$querycontact->execute();
$contact = $querycontact->fetchAll();

// Requête pour récupérer les infos que d'un contact qui est étudiant
$querycandidat = $bdd->query("SELECT * FROM contact c
INNER JOIN candidat ca ON ca.Candidat_Id = c.Contact_Id
INNER JOIN dossier d ON d.Candidat_Id= ca.Candidat_Id
  WHERE c.Contact_Id = ca.Candidat_Id");
$querycandidat->execute();
$candidat = $querycandidat->fetchAll();

//Requête pour récupérer les infos de la table gestionnaire
$querygestionnaire = $bdd->prepare("SELECT * FROM gestionnaire");
$querygestionnaire->execute();
$resultatg = $querygestionnaire->fetchAll();


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


    <!-- Début de la page-->
    <div class="container">
        <p>Bonjour <?php echo $_SESSION['Prenom']; ?></p>
        <div class="row">
            <div class="col-lg-12">
                <h1>Liste des contacts</h1>
            </div>
        </div>

        <!-- tableau liste des contacts avec codes pour le passage de contact à candidat-->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Email</th>


                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($contact as $user) { ?>

                    <tr>
                        <input type="hidden" name="Contact_Id" value="<?= $user['Contact_Id'] ?>">
                        <th scope="row"><?php echo $user['Contact_Id']; ?></th>
                        <td><?php echo $user['Contact_Nom']; ?></td>
                        <td><?php echo $user['Contact_Prenom']; ?></td>
                        <td><?php echo $user['Contact_Tel']; ?></td>
                        <td><?php echo $user['Contact_Email'] ?></td>
                    </tr>

                <?php }
                ?>
            </tbody>
        </table>



        <form action="#" method="post">

            <div class="row">

                <div class="form-groupe">

                    <label for="Contact_Id">Créer un dossier candidat pour le contact N°</label>
                    <select required name="Contact_Id" id="Contact_Id" class="enligne">
                        <?php echo "<option ='selected' value=''>Choisir contact</option>";
                        foreach ($contact as $donnee) {
                            echo '<option>' . $donnee["Contact_Id"] . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="form-groupe">
                    <label for="Dossier_Formation">Formation choisie</label>
                    <select required name="Dossier_Formation" id="Dossier_Formation" class="enligne">
                        <option selected value=''>Choisir la formation</option>";
                        <option value='1'>BTS SIO SLAM</option>";
                        <option value='2'>BTS SIO SISR</option>";
                        <option value='3'>BTS GPME</option>";
                        <option value='4'>BTS CG</option>";
                        <option value='5'>BTS Assurance</option>";
                        <option value='6'>BTS MCO</option>";
                        <option value='7'>BTS Banque</option>";
                    </select>
                </div>


                <div class="form-groupe">
                    <label for="Gestionnaire_Id">Sélectionner le gestionnaire du dossier</label>
                    <select required name="Gestionnaire_Id" id="Gestionnaire_Id" class="enligne">
                        <?php echo "<option ='selected' value=''>Choisir le gestionnaire</option>";
                        foreach ($resultatg as $donnee) {
                            echo '<option value="' . $donnee['Gestionnaire_Id'] . '">' . $donnee['Gestionnaire_Nom'] . ' ' . $donnee['Gestionnaire_Prenom'] . '</option>';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-groupe">
                <p>
                    <input type="submit" name="Candidat" value="Créer un dossier" id="submit2">
                </p>
            </div>





            <?php
            if (isset($_POST['Candidat'])) {
                // On récupère les valeurs du formulaire			           
                $Contact_Id = $_POST["Contact_Id"];
                $Candidat_Id = $_POST["Contact_Id"];
                $Gestionnaire_Id = $_POST["Gestionnaire_Id"];
                $Dossier_Formation = $_POST["Dossier_Formation"];
                var_dump($_POST['Dossier_Formation']);

                //On crée les variables necessaires
                $Dossier_MotDePasse = uniqid();
                $Dossier_DateCreation = date('Y-m-d');

                //On insère les données reçues
                $reqcandidat = $bdd->prepare("INSERT INTO candidat (Candidat_Id) VALUES (:Candidat_Id)");
                $reqcandidat->bindParam(':Candidat_Id', $Contact_Id);
                $reqcandidat->execute();

                $rqdossier = $bdd->prepare("INSERT INTO dossier (Dossier_MotDePasse, Dossier_DateCreation, Gestionnaire_Id, Candidat_Id, Dossier_Formation) VALUES (:Dossier_MotDePasse, :Dossier_DateCreation, :Gestionnaire_Id, :Candidat_Id,  :Dossier_Formation)");

                $rqdossier->bindParam(':Dossier_MotDePasse', $Dossier_MotDePasse);
                $rqdossier->bindParam(':Dossier_DateCreation', $Dossier_DateCreation);
                $rqdossier->bindParam(':Gestionnaire_Id', $Gestionnaire_Id);
                $rqdossier->bindParam(':Candidat_Id', $Candidat_Id);
                $rqdossier->bindParam(':Dossier_Formation', $Dossier_Formation);
                $rqdossier->execute();

                // création du mail : 
                $rqmail = $bdd->prepare("SELECT * FROM contact, dossier WHERE Contact_Id = $Contact_Id AND dossier.Candidat_Id = $Candidat_Id");
                $rqmail->execute();
                $resultatmail = $rqmail->fetchAll();

                foreach ($resultatmail as $donnee) {
                    $name = "Groupe GEFOR";
                    $destinataire = $donnee['Contact_Prenom'] . " " . $donnee["Contact_Nom"];
                    $email = $donnee['Contact_Email'];    //destinataireEmail
                    $contactmdp = $donnee['Dossier_MotDePasse'];
                }
                $mail = "geforwebmaster@gmail.com";
                $subject = 'Votre inscription au centre de formation Gefor';
                $body = "Bonjour $destinataire<br><p>Suite à notre entretien téléphonique, nous avons le plaisir de vous confirmer la création de votre compte <br>sur l'espace d'inscription en ligne du centre de formation Gefor.<br> Vous pouvez vous y connecter en cliquant sur le lien suivant : http://localhost/PPE3/index.php <br>Votre identifiant : $email<br>Votre mot de passe : $contactmdp<br>L'équipe de Gefor</p>";

                require_once "PHPMailer/PHPMailer.php";

                require_once "PHPMailer/SMTP.php";
                require_once "PHPMailer/Exception.php";

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
                } else {
                    $status = "failed";
                    $response = "Une erreur est survenue: <br>" . $mail->ErrorInfo;
                }
                $_SESSION['response'] = "$response";
                echo '<script language="Javascript">document.location.replace("confMail.php");</script>';
            }

            // On ferme la connection
            $bdd = null;

            ?>





    </div>
    <!-- tableau liste des candidats avec les liens pour les autres fonctionnalités -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Liste des candidats</h1>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code postal</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Détail</th>
                    <th scope="col">Corriger dossier</th>
                    <th scope="col">Compléter dossier</th>
                    <th scope="col">Statut</th>







                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($candidat as $candid) { ?>

                    <tr>
                        <th scope="row"><?php echo $candid['Contact_Id']; ?></th>
                        <td><?php echo $candid['Contact_Nom']; ?></td>
                        <td><?php echo $candid['Contact_Prenom']; ?></td>
                        <td><?php echo $candid['Contact_Tel']; ?></td>
                        <td><?php echo $candid['Contact_Email']; ?></td>
                        <td><?php echo $candid['Contact_Adresse']; ?></td>
                        <td><?php echo $candid['Contact_CodePostal']; ?></td>
                        <td><?php echo $candid['Contact_Ville']; ?></td>


                        <td><a href="detail_candidat.php?iduser=<?php echo $candid['Contact_Id']; ?>"> Plus de détails</a></td>
                        <td><a href="modifInformation.php?idmod=<?php echo $candid['Contact_Id']; ?>"> Modifier le dossier</a></td>
                        <td><a href="ajoutInformation.php?idmod=<?php echo $candid['Contact_Id']; ?>"> Compléter le dossier</a></td>
                        <td>
                            <?php



                            if ($candid['Dossier_Transmission'] != NULL && $candid['Dossier_Transmission'] != '0000-00-00') {
                                echo "En attente financement";
                            } else {
                                echo "En attente de test";
                            }




                            ?>
                        </td>





                    </tr>
                <?php }
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