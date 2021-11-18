<?php



require('_connect.php');


if (isset($_POST['envoyer'])) {



    // variable pour  modifications
    $contactprenom = $_POST['Contact_Prenom'];
    $contactid = $_POST['Contact_Id'];
    $contactnom = $_POST['Contact_Nom'];
    $contactadress = $_POST['Contact_Adresse'];
    $contactville = $_POST['Contact_Ville'];
    $contactCP = $_POST['Contact_CodePostal'];
    $contacttel = $_POST['Contact_Tel'];


    $situationid = $_POST['Candidat_Situation_Pro'];
    $nomformation = $_POST['Dossier_Formation'];
    $cpf = $_POST['Candidat_CPF'];






    $query_contact = $bdd->prepare("UPDATE contact 
SET Contact_Nom = '$contactnom',Contact_Prenom='$contactprenom',Contact_Tel = $contacttel,Contact_Adresse='$contactadress', Contact_CodePostal=$contactCP, Contact_Ville='$contactville'
WHERE Contact_Id= $contactid");
    $query_contact->execute();


    $query_dossier = $bdd->prepare("UPDATE candidat
    INNER JOIN contact c ON candidat.Candidat_Id=c.Contact_Id
    INNER JOIN dossier d ON d.Candidat_Id= candidat.Candidat_Id
    SET candidat.Candidat_Situation_Pro = '$situationid' ,candidat.Candidat_CPF= $cpf ,d.Dossier_Formation= '$nomformation'
    WHERE c.Contact_Id= $contactid");
    $query_dossier->execute();
}


header("Location:accueil.php");
