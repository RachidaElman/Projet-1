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
   <form action="update.php" method="POST">
     <div class="container">
       <p>Bonjour <?php echo $_SESSION['Prenom']; ?></p>
       <input type="hidden" name="Contact_Id" value="<?= $reqdo['Contact_Id'] ?>">

       <div class="row">
         <div class="col-lg-12">
           <h1>Modifications informations du candidat <?php echo $reqdo['Contact_Nom'] . " " . $reqdo['Contact_Prenom']; ?></h1>
         </div>
       </div>
       <div class="container">
         <h5>Identité du candidat</h5>
         <div class="row mb-4">
           <div class="col">
             <label for="Contact_Prenom">Prénom</label>
             <input type="text" class="form-control" name="Contact_Prenom" value="<?= $reqdo['Contact_Prenom'] ?>">
           </div>
           <div class="col">
             <label for="Contact_Nom">Nom de famille</label>
             <input type="text" class="form-control" name="Contact_Nom" value="<?= $reqdo['Contact_Nom'] ?>">
           </div>
         </div>

         <h5>Coordonnées</h5>

         <div class="row mb-4">
           <div class="col">
             <label for="Contact_Adresse">Adresse</label>
             <input type="text" class="form-control" name="Contact_Adresse" value="<?= $reqdo['Contact_Adresse'] ?>">
           </div>
         </div>

         <div class="row mb-4">
           <div class="col">
             <label for="Contact_Ville">Ville</label>
             <input type="text" class="form-control" name="Contact_Ville" value="<?= $reqdo['Contact_Ville'] ?>">
           </div>
           <div class="col">
             <label for="Contact_CodePostal">Code postal</label>
             <input type="text" class="form-control" name="Contact_CodePostal" value="<?= $reqdo['Contact_CodePostal'] ?>">
           </div>
         </div>

         <div class="row mb-4">
           <div class="col">
             <label for="Contact_Tel">Numéro de téléphone portable</label>
             <input type="text" class="form-control" name="Contact_Tel" value="<?= $reqdo['Contact_Tel'] ?>">
           </div>
         </div>


         <div class="row mb-4">
           <div class="col">
             <label for="Contact_Email">Adresse Mail</label>
             <input type="text" name="Contact_Email" readonly value="<?= $reqdo['Contact_Email'] ?>">
           </div>
         </div>




         <h5>Situation professionnelle</h5>
         <div class="row mb-4">
           <div class="form-check ">
             <label for="Candidat_Situation_Pro" class="competence"></label>
             <select name="Candidat_Situation_Pro" id=Candidat_Situation_Pro class="form-control">
               <option value="" disabled selected>Situation professionnelle</option>
               <?php foreach (['CDI', 'CDD', 'Intérimaire', "Demandeur emploi", 'Autre'] as $situation) : ?>
                 <?php $selected = $reqdo['Candidat_Situation_Pro'] == $situation ? "selected" : ""; ?>
                 <option <?= $selected ?> value="<?= $situation ?>"><?= $situation ?></option>
               <?php endforeach; ?>
             </select>
           </div>
         </div>






         <h5>Formation</h5>

         <div class="row mb-4">
           <div class="form-check ">
             <label for="Dossier_Formation" class="competence"></label>
             <select name="Dossier_Formation" id=Dossier_Formation class="form-control">
               <option value="" disabled selected>Formation</option>
               <?php foreach (['BTS SIO SLAM', 'BTS SIO SISR', 'BTS GPME', 'BTS CG', 'BTS Assurance', 'BTS MCO', 'BTS banque'] as $diplome) : ?>
                 <?php $selected = $reqdo['Dossier_Formation'] == $diplome ? "selected" : ""; ?>
                 <option <?= $selected ?> value="<?= $diplome ?>"><?= $diplome ?></option>
               <?php endforeach; ?>
             </select>
           </div>
         </div>




         <div class="form-row">
           <label class="form-check form-check-inline">CPF</label>

           <div class="form-check form-check-inline">
             <?php
              $chek0 = "";
              $chek1 = "";
              if ($reqdo['Candidat_CPF'] == 1) {
                $chek1 = 'checked';
              } else {
                $chek0 = 'checked';
              }
              ?>
             <input class="form-check-input" type="radio" <?= $chek1 ?> name="Candidat_CPF" id="inlineRadio1" value="1" />
             <label class="form-check-label" for="inlineRadio1">Oui</label>
           </div>
           <div class="form-check form-check-inline">
             <input class="form-check-input" type="radio" <?= $chek0 ?> name="Candidat_CPF" id="inlineRadio1" value="0" />
             <label class="form-check-label" for="inlineRadio1">Non</label>
           </div>
         </div>






         <div class="col">
           <input type="submit" class="form-control" name="envoyer" value="Transmettre formulaire" id="submit2">
         </div>
       </div>
     </div>
   </form>

   <!-- Footer -->
   <?php require('_footer.php'); ?>
   <!-- Footer -->

   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.bundle.min.js"></script>
   <script src="js/script.js"></script>
 </body>

 </html>