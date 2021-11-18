<?php



require('_connect.php');


if (isset($_POST['envoyer'])) {



    // variable pour les insertions et modifications

    $contactid = $_POST['Contact_Id'];

    $session = $_POST['Dossier_Session'];
    $diplome = $_POST['Candidat_Diplome'];
    $parcperso = $_POST['Dossier_Parcours_personnalise'];
    $competence = $_POST['Candidat_Competence'];
    $bilan = $_POST['Dossier_Bilan_Formation'];
    $nomfinanceur = $_POST['Dossier_Financeur'];
    $datefinan = $_POST['Dossier_DateRetourFinanceur'];
    $datetransm = $_POST['Dossier_Transmission'];
    $dateannul = $_POST['Dossier_Annulation'];

    // Ternaire afin que les dates vides puissent être intégrées dans la BDD

    $datefinan = empty($datefinan) ? 'NULL' : "'$datefinan'";
    $datetransm = empty($datetransm) ? 'NULL' : "'$datetransm'";
    $dateannul = empty($dateannul) ? 'NULL' : "'$dateannul'";

    $query_dossier2 = $bdd->prepare("UPDATE dossier
    INNER JOIN candidat ca ON ca.Candidat_Id=dossier.Candidat_Id
     INNER JOIN contact c ON c.Contact_Id= ca.Candidat_Id
     SET dossier.Dossier_Session= '$session',ca.Candidat_Diplome='$diplome',dossier.Dossier_Parcours_personnalise =$parcperso,ca.Candidat_Competence='$competence', dossier.Dossier_Bilan_Formation= '$bilan', dossier.Dossier_Financeur='$nomfinanceur', dossier.Dossier_DateRetourFinanceur=$datefinan, dossier.Dossier_Transmission=$datetransm, dossier.Dossier_Annulation=$dateannul
     WHERE c.Contact_Id= $contactid");
    var_dump($query_dossier2);
    $query_dossier2->execute();
}


header("Location:accueil.php");
