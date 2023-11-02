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
    <title>Gestion d'agence</title>
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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="./css/main.css">
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
        <div class="table_container">
            <table style="overflow-x: scroll;" >
                <thead>
                <tr>
                    <th>Nom d'agence</th>
                    <th>Ville</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
        <!-- ________________table_container__________________________ -->
        <!-- ________________ add _modal _____________________ -->
        <div id="myModal2" class="modal2">
            <div class="modal-content2">
            <span class="close2">&times;</span>
            <h1>Ajouter une agence</h1>
                <form class="row g-3" name="add_form" id="myform" action="action.php" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label class="form-label">
                        Nom d'agence  : 
                        </label>
                        <input type='text' class="form-control" name='add_nom_agence' required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        ville : 
                        </label>
                        <input type='text' class="form-control" name='add_ville'required  />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        adresse : 
                        </label>
                        <input type='text' class="form-control" name='add_adresse' required/>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        telephone : 
                        </label>
                        <input type='text' class="form-control" name='add_tel' required/>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        Email : 
                        </label>
                        <input type='text' class="form-control" name='add_Email' required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        Logo : 
                        </label>
                        <input type='file' class="form-control" name='add_Logo' required />
                    </div>
                    
                    <button name="Ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>

        </div>

        <!-- ________________ update_______________________________________ -->
        <div id="myModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Modifier l'agence</h1>
            <form id="myform_update_a" name="update_form" action="action.php" method="post" enctype="multipart/form-data" class="row g-3"></form>
            </div>
        </div>
    </body>
    <?php
    include "./loading.php"
    ?>
    <script src="javascript/agence_gest.js"></script>
    <script src="./javascript/main.js"></script>

</html>