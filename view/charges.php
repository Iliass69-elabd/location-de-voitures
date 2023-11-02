<?php 
ini_set("display_errors", "1");
error_reporting(E_ALL);

session_start();
if($_SESSION["autoriser"] != "oui"){
header("location:index.php");
exit();
}

include "../CONTROL/controleur.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../view/css/admin_page.css">
  <link rel="stylesheet" href="../view/css/manage_reservation.css">
  <title>Gestion des charges</title>
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
    <link rel="stylesheet" href="./css/main.css">
</head>
<body onload="">
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
        </nav>
      </div>     
      <div class="add_container">
        <button id="add_ch" class="add" onclick="show_add_form()">Ajouter une charge</button>
        <div class="sreach_keyup">
            <form  method="post">
            <input type="search" class="form-control rounded" placeholder="Chercher des charges🔎" aria-label="Search" aria-describedby="search-addon" id="searchInput"/>
            </form>
        </div>
      </div> 
      <!-- ________________table_container__________________________ -->
      
<!--       
      <div class="input-group rounded">
        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="searchInput"/>
        <span class="input-group-text border-0" id="search-addon">
          <i class="fas fa-search"></i>
        </span>
      </div> -->

      <div class="table_container">
      <table id="myTable" >
        <thead>
          
            <!-- <th>id</th> -->
            <!-- <th>ID</th> -->
            <th>Matricule</th>
            <th>Date Achat</th>
            <th>Avance</th>
            <th>Reste</th>
            <th>Montant global</th>
            <th>Prix par mois</th>
            <th>Etat</th>
            <th>Traite</th>
            <th>Prix assurance</th>
            <th>Date Fin Echéance</th>
            <th>Action</th>
          
        </thead>
        <tbody id="tbody" >
            
        </tbody>
      </table>
      </div>
      <!-- ________________table_container__________________________ -->
      <!-- Trigger/Open The Modal -->

      <!-- The Modal -->
      <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <form class="row g-3" id="formulaireWSF">
            <div class="col-md-6">
              <!-- <span> Click the select and type the first letter of the matricule</span> <br> -->
              <label for="exampleInputEmail1" class="form-label">Matricule:</label>
              <input type="text" class="form-control" id="search_matricule" style="display: none;">
              <select name="matricule" class="form-select" id="select_matricule"></select>
              <div id="infoContainer"></div>
            </div>
            <div class="col-md-6">
              <label for="exampleInputEmail1" class="form-label">Date Achat:</label>
              <input type="date" class="form-control" id="dateAchat">
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Avance:</label>
              <input type="text" class="form-control" id="avance">
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Reste:</label>
              <input type="text" class="form-control" id="reste" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label"> Prix par mois:</label>
              <input type="text" class="form-control" id="prix_par_mois" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Etat:</label>
              <!-- <input type="text" class="form-control" id="etat" > -->
              <select name="" class="form-select" id="etat">
                <option value="inpaye" selected>Non payé</option>
                <option value="payé">payé</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Traite:</label>
              <input type="text" class="form-control" id="traite" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Prix Assurance:</label>
              <input type="text" class="form-control" id="prixAssurance" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Date Fin Echehance:</label>
              <input type="date" class="form-control" id="dtFinEchehance" >
            </div>
            <button type="button" class="btn btn-primary" name="modf" id="modifier">Ajouter</button>
            <button type="button" class="btn btn-primary" name="modd" id="modf">Modifier</button>
          </form>
        </div>
      </div>
</body>
<?php
    include "./loading.php"
    ?>
<script src="../view/javascript/jquery-3.6.0.min.js"></script>
<script src="../view/javascript/manage_charges.js"></script>
<script src="./javascript/main.js"></script>
</html>