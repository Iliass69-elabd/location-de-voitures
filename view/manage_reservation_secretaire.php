<?php 
ini_set("display_errors", "1");
error_reporting(E_ALL);
  session_start();
  if($_SESSION["permission"] != "oui"){
    header("location:index.php");
    exit();
  }
  if(isset($_GET['client'])){
    $clt = $_GET['client'];
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
  <title>Gestion des résérvations</title>
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
            <a class="cool-link"  href="secretaire.php">Retour</a>

        
        </nav>
      </div>      
      <div class="add_container">
            <!-- <button id="myBtn2" class="add">Ajouter une réparation</button> -->
            <div class="sreach_keyup">
            <form  method="post">
            <input type="text" class="form-control rounded" value="<?php if(isset($clt)){ echo $clt;}  ?>" placeholder="Chercher une réservation 🔎" aria-label="Search" aria-describedby="search-addon" id="searchInput"/>
            </form>
        </div>
      </div>
      <div class="search_date">
            <!-- <span>Chercher par date</span> -->
            <form >
                <div class="search_inputs_date">
                De<input placeholder="Date debut" type="date" id="startDate"> <span>à</span>
                <input type="date" id="endDate">
                </div>
                <button class="button_search_date" onclick="searchTable()" type="button">Chercher</button>
                <button class="all_data" id='all_data' type="button" name="hamid" onclick="loadihadchi()">Toutes les données</button>
            </form>
        </div>
      <!-- ________________table_container__________________________ -->
      <div class="table_container">
      <table id="myTable" >
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Matricule</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Durée</th>
            <th>Prix</th>
            <th>Mode Paiment</th>
            <th>2<sup>ème</sup> conducteur</th>
            <th>Prix Unitaire</th>
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
          <form class="row g-3">
            <div class="col-md-6">
              <label for="exampleInputEmail1" class="form-label">Id réservation:</label>
              <input type="text" class="form-control" id="id_res">
            </div>
            <div class="col-md-6">
              <label for="exampleInputEmail1" class="form-label">Id Client:</label>
              <input type="text" class="form-control" id="idClient">
            </div>
            <div class="col-md-6">
              <label for="exampleInputEmail1" class="form-label">Nom:</label>
              <input type="text" class="form-control" id="nom">
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Prénom:</label>
              <input type="text" class="form-control" id="prenom">
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Matricule:</label>
              <input type="text" class="form-control" id="matricule" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Date Début:</label>
              <input type="date" class="form-control" id="debut" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Date Fin:</label>
              <input type="date" class="form-control" id="fin" onchange="set_duree()">
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Durée:</label>
              <input type="text" class="form-control" id="duree" disabled >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Prix:</label>
              <input type="text" class="form-control" id="prix" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Mode de paiment:</label>
              <input type="text" class="form-control" id="modePay" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">2<sup>ème</sup> conducteur:</label>
              <input type="text" class="form-control" id="Dconduct" >
            </div>
            <div class="col-md-6">
              <label for="exampleInputPassword1" class="form-label">Prix unitaire:</label>
              <input type="text" class="form-control" id="prixUni" >
            </div>
            <button type="button" class="btn btn-primary" id="modifier">Modifier</button>
          </form>
        </div>
      </div>

</body>
<?php
    include "./loading.php"
    ?>
<script src="../view/javascript/jquery-3.6.0.min.js"></script>
<script src="../view/javascript/manage_reservations_secretaire.js"></script>
<script src="./javascript/main.js"></script>
<script>
  
</script>
</html>