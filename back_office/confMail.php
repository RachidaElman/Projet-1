<?php
session_start();
if (empty($_SESSION['login'])) {
    header("Location:../index.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PPE3_GEFOR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<?php require('_header.php'); ?>

<body>

    <div class="container">
        <p>Bonjour <?php echo $_SESSION['Prenom']; ?></p>
        <div class>

            <h4>Mail transmis avec succés!</h4>
            <form action="index.php" method="post">
                <input type="button" value="Tableau de bord" onclick="history.go(-1)">
            </form>

        </div>


        <!-- Footer -->
        <?php require('_footer.php'); ?>
        <!-- Footer -->

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/script.js"></script>
</body>

</html>