<?php
    include "../CONTROL/controleur.php";
    session_start();
    $_SESSION["gog"] = true;
    if($_SESSION["permission"] != "oui") {
        header("location:index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../view/css/secretaire.css">
  <title>Page Secrétaire</title>
  <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <style>
      
    </style>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <!-- _________nav __________________________ -->
    <div class="nav_container">
        <nav class="nav">
        <input type="checkbox" id="nav-check" />
        <div class="nav-header">
            <div class="nav-title">
            <?php 
                    $n = new Control;
                    $r = $n->agence_info(); 
                    while($row=$r->fetch()){
                    echo "<img src='$row[6]' alt='' />";
                    } 
                ?>
            </div>
        </div>
        <div class="nav-btn">
            <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
            </label>
        </div>

        <div class="nav-links">
            <a class="cool-link"  href="../CONTROL/deconnexion.php">Déconnexion </a>
            <!-- <a class="cool-link"  href="admin_page.php">Retour</a> -->
        </div>
        </nav>
    </div>
    
    <div id="notification">
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>
                    <table id="notiftb">
                    </table>
                </p>
            </div>

        </div>
    </div>
    <div id="notif">
        <p id="indicc">0</p>
        <a href="#" class="notification" id="myBtn">
        <img class="image_not" src="./icons/icons8-rappels-de-rendez.png" alt="">
        <span class="badge" id="badge"></span>
        </a>
    </div>
    <section class="secretaire_section">
        <a href="./manage_reservation_secretaire.php">
            <img src="./icons/booking.png" alt="">
            <span>Réservation</span>
        </a>
        <a href="./gestion_reparations_secretaire.php">
            <img src="./icons/repair-tools.png" alt="">
            <span>Répartions</span>
        </a>
        <a href="./car_management_reservation.php">
            <img src="./icons/voiture.png" alt="">
            <span>Voitures</span>
        </a>
    </section>
    <script src="../view/javascript/jquery-3.6.0.min.js"></script>
    <script src="./javascript/secretaire.js"></script>
    <script>
        // setInterval(() => {
        //     triggerNotif();
        // }, 3000);
    </script>
</body>
<?php
    include "./loading.php"
    ?>
<script src="./javascript/main.js"></script>
</html>