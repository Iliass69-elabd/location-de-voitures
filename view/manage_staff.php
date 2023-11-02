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
  <title>Gestion des employés</title>
  <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/main.css">
</head>
<body onload="show()">
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
            <a class="cool-link"  href="admin_page.php">Retour</a>
          </div>
        </nav>
      </div>
      <!-- _________nav __________________________ -->
      <!-- __________add_container_____________ -->
      <div class="add_container">
        <button id="myBtn" class="add">Ajouter un employé</button>
        <div class="sreach_keyup">
            <form  method="post">
              <input type="text" id="chercher_un_employe" placeholder="Chercher un employé 🔎">
            </form>
        </div>
      </div>
      <!-- __________add_container_____________ -->
      <!-- ________________table_container__________________________ -->
      
      <div class="table_container">
      <table >
        <thead>
          <tr>
            <!-- <th>id</th> -->
            <th>Nom</th>
            <th>Prénom</th>
            <th>email</th>
            <!-- <th>cin</th> -->
            <!-- <th>horaire</th> -->
            <!-- <th>Fonctionnalité</th> -->
            <th>salaire</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody id="tbody">

        </tbody>
      </table>
      </div>
      <!-- ________________table_container__________________________ -->

      <!-- __________update modal___________________ -->
      <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <h1>Modifier un employé</h1>
          <form id="myform" class="row g-3" name="form_staff"></form>
        </div>

      </div>
      
      <!-- __________update modal___________________ -->




      <!-- __________Add modal___________________ -->
      <div id="myModal2" class="modal2">

        <!-- Modal content -->
        <div class="modal-content2">
          <span class="close2">&times;</span>
          <h1>Ajouter un employé</h1>
          <form name="add_form" id="myform" class="row g-3">
          <!-- <input type='hidden'  name='update_id'  value='$row[0]'/> -->
          <div class="col-md-6">
            <label class="form-label"> Nom: </label>
            <input type='text' class="form-control" name='add_familyname'  />
          </div>
          <div class="col-md-6">
            <label class="form-label">Prénom : </label>
            <input type='text' class="form-control" name='add_firstname' />
          </div>
          <div class="col-md-6">
            <label class="form-label">Email : </label>
            <input type='text' class="form-control" name='add_email'  />
          </div>
          <div class="col-md-6">
            <label class="form-label">Cin : </label>
            <input type='text' class="form-control" name='add_cin' />
          </div>
          <div class="col-md-6">
            <label class="form-label">Horaire : </label>
            <input type='time' class="form-control" name='add_horaire' step="2"/>
          </div>
          <div class="col-md-6">
            <label class="form-label">Fonctionalité : </label>
            <input type='text' class="form-control" name='add_functionality'  />
          </div>
          <div class="col-md-6">
            <label class="form-label">Salaire : </label>
            <input type='text' class="form-control" name='add_Salaire'  />
          </div>
          <button onclick="add_staff_f()" class="btn btn-primary" type='button'>Ajouter</button>
          </form>
        </div>

      </div>
      <!-- __________Add modal___________________ -->

      <!-- ____________ delete model _____________ -->
      <div id="myModal3" class="modal3">
      <div class="modal-content3">
        <span class="close3">&times;</span>
        <h1>Supprimer un employé</h1>
        <i class="fa-solid fa-triangle-exclamation"></i>
        <p id="myp_del"></p>
      </div>

      </div>
      <!-- ____________ delete model _____________ -->
</body>
<?php
    include "./loading.php"
    ?>
<script src="../view/javascript/staff_management.js"></script>
<script src="./javascript/main.js"></script>
</html>