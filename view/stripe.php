<?php
 include "../CONTROL/controleur.php";
 session_start();
if($_SESSION["autoriser"] != "oui") {
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
    <link rel="stylesheet" href="../view/css/admin_page.css">
    <title>Informations stripe</title>
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
</head>
<body>
    <!-- _____________________nav ______________________ -->
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
                <a class="cool-link"  href="admin_page.php">Retour</a>
            </div>
            </nav>
        </div>
        <!-- ___________________ nav ____________________ -->
        <!-- ________________table_container__________________________ -->
        <!-- <div class="add_container">
            <button id="myBtn" class="add">Ajouter agence</button>
        </div> -->
        <span style="display:none" id="message"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></span>
        <!-- <div class="table_container">
            <table style="overflow-x: scroll;" >
                <thead>
                <tr>
                    <th>clé secrete</th>
                    <th>clé publique</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div> -->
        <div class="row g-3" id="form-stripe">
            <form action="" id="stripe_infos_">
                

            </form>
        </div>

        <!-- ________________table_container__________________________ -->
        <script src="javascript/stripe.js"></script>

        <!-- ________________ update_______________________________________ -->
        <div id="myModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Modifier les clés</h1>
            <form id="myform_update_a" name="update_form" action="action.php" method="post" enctype="multipart/form-data" class="row g-3">
                
            </form>
            </div>
        </div>
</body>
</html>