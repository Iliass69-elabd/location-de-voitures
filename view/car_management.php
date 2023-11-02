<?php
   include "../CONTROL/controleur.php";
   session_start();
    if($_SESSION["autoriser"] != "oui") {
        header("location:index.php");
        exit();
    }
    $mtrv="";
    if(isset($_GET['matricul'])){
      $mtrv = $_GET['matricul'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../view/css/admin_page.css">
  <title>Gestion des voitures</title>
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
<body >
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
        <button id="myBtn" class="add">Ajouter une voiture</button>
        <div class="sreach_keyup">
              <form  method="post">
                <input type="text" id="chercher_une_voiture" value="<?php if(isset($mtrv )){echo $mtrv;} ?>" placeholder="Chercher une voiture 🔎">
              </form>
        </div>
      </div>
      <span style="display:none" id="message"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></span>
      <!-- __________add_container_____________ -->
      <!-- ________________table_container__________________________ -->
      <!-- <div>
        <div class="sreach_keyup">
            <form  method="post">
              <input type="text" id="chercher_une_voiture" placeholder="Chercher une voiture 🔎">
            </form>
      </div>
      </div> -->
      <div class="table_container">
      <table style="overflow-x: scroll;" id="myTable">
        <thead>
          <tr>
            <th>Matricule</th>
            <th>Marque</th>
            <th>Capacité</th>
            <th>Prix</th>
            <th>Image 1</th>
            <th>Action</th>
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
          <h1>Modifier voiture</h1>
          <form id="myform" name="update_form" action="action.php" method="post" enctype="multipart/form-data" class="row g-3"></form>
        </div>

      </div>
      
      <!-- __________update modal___________________ -->




      <!-- __________Add modal___________________ -->
      <div id="myModal2" class="modal2">

        <!-- Modal content -->
        <div class="modal-content2">
          <span class="close2">&times;</span>
          <h1>Ajouter une voiture</h1>
          <!-- <form name="add_form" id="myform"  enctype="multipart/form-data"> -->
          <form class="row g-3" name="add_form" id="myform" action="action.php" method="post" enctype="multipart/form-data">
          <!-- <input type='hidden'  name='update_id'  value='$row[0]'/> -->
          <div class="col-md-6">
            <label class="form-label">
              Matricule  : 
            </label>
            <input type='text' class="form-control" name='add_Matricul' required />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Marque : 
            </label>
            <input type='text' class="form-control" name='add_Mark'required  />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Capcité : 
            </label>
            <input type='text' class="form-control" name='add_Capcity' required/>
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Modèle : 
            </label>
            <input type='text' class="form-control" name='add_Model' required/>
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Prix : 
            </label>
            <input type='text' class="form-control" name='add_Prix' required />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Type de carburant : 
            </label>
            <!-- <input type='text' class="form-control" name='add_Type_carburant' required /> -->
            <select class="form-select" name='add_Type_carburant'  aria-label="Default select example">
              <option selected disabled>Sélectionner un type de carburant</option>
              <option value="essance">Essence</option>
              <option value="diesel">Diesel</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Description : 
            </label>
            <input type='text' class="form-control" name='add_Description'required  />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Type de voiture : 
            </label>
            <input type='text' class="form-control" name='add_Type_voiture' required />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              N° chassis : 
            </label>
            <input type='text' class="form-control" name='add_n_chassis'required  />
          </div>
          <div class="col-md-6">
            <label class="form-label">
              Km actuel : 
            </label>
            <input type='text' class="form-control" name='add_km_actuel' required />
          </div>
          <div class="col-md-6">
            <label class="form-label">
            Couleur: 
          </label>
          <input type='text' class="form-control" name='add_Couleur' required />
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Status: 
          </label>
          <!-- <input type='text' class="form-control" name='add_status' required /> -->
          <select class="form-select" name='add_status'  aria-label="Default select example">
              <option selected disabled>Veuillez choisir le status de la voiture</option>
              <option value="disponible">Disponible</option>
              <option value="indisponible">Indisponible</option>
            </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Image 1: 
          </label>
          <input type='file' class="form-control" name='add_Image1'required />
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Image 2: 
          </label>
          <input type='file' class="form-control" name='add_Image2'required />
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Image 3: 
          </label>
          <input type='file' class="form-control" name='add_Image3'required />
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Image 4: 
          </label>
          <input type='file' class="form-control" name='add_Image4'required />
        </div>
        <div class="col-md-6">
          <label class="form-label">
            Image 5: 
          </label>
          <input type='file' class="form-control" name='add_Image5'required />
        </div>

        <div class="col-md-12">
          <button id="myBtn_accessoire" type="button" class="btn btn-primary">Accessoire</button>
        </div>
        <div id="myModal_accessoire" class="modal_accessoire">
        <div class="modal-content_accessoire">
          <span class="close_accessoire">&times;</span>
          <div class="checks-form">
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Frein de stationnement électronique" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Frein de stationnement électronique
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Caméra à 360°" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Caméra à 360°
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Aide au stationnement automatique" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Aide au stationnement automatique
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Assistant de vision nocturne" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Assistant de vision nocturne
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Climatisation automatique" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Climatisation automatique
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Ecran tactile" name="check_list[]"  id="">
            <label class="form-check-label" for="">
              Ecran tactile
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Vitres électriques anti-pincement" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Vitres électriques anti-pincement
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Support lombaire réglable" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Support lombaire réglable
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Avertissement de vérification du moteur" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Avertissement de vérification du moteur
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Compresseur" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Compresseur
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Coussins gonflables à deux phases" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Coussins gonflables à deux phases
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Commande/contrôle vocal" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Commande/contrôle vocal
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Mode de conduite"  name="check_list[]" id="">
            <label class="form-check-label" for="">
            Mode de conduite
            </label>
          </div>
          <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="Régulateur de vitesse adaptatif" name="check_list[]"  id="">
            <label class="form-check-label" for="">
            Régulateur de vitesse adaptatif
            </label>
          </div>
          </div>
        </div>
      </div>
          <!-- <button onclick="add_car()" type='button'>Add</button> -->
          <button name="Ajouter" class="btn btn-primary">Ajouter</button>
          </form>
        </div>

      </div>
      <!-- _______________accessoire_______________________ -->
      
                    <!-- The Modal -->
<div id="md" class="mdc">

<!-- Modal content -->
<div class="mdcc" id="md">
  <span class="cls">&times;</span>
  <form class="row g-3">
  <div class="col-md-6">
    <label class="form-label">
      Carte grize  : 
    </label>
    <input type='date' class="form-control" id='carteGriz' required />
  </div>
  <div class="col-md-6">
    <label class="form-label">
      Date Vidange  : 
    </label>
    <input type='date' class="form-control" id='vidange' required />
  </div>
  <div class="col-md-6">
    <label class="form-label">
       Date Visite Technique : 
    </label>
    <input type='date' class="form-control" id='vtech' required />
  </div>
  <div class="col-md-6">
    <label class="form-label">
    Date Fin Assurance : 
    </label>
    <input type='date' class="form-control" id='assurance' required />
  </div>
  <div class="col-md-6">
    <label class="form-label">
      Date Retour  : 
    </label>
    <input type='date' class="form-control" id='ret'  readonly />
  </div>
  <div class="col-md-6">
    <label class="form-label">
      Matricule  : 
    </label>
    <input type='text' class="form-control" id='matricule' required />
  </div>
  <button id="setupdt" class="btn btn-primary btn-lg active"> Modifier</button>
  <button id="setadd" class="btn btn-primary btn-lg active"> Ajouter</button>
  </form>
</div>

</div>
      <!-- __________Add modal___________________ -->

      <!-- ____________ delete model _____________ -->
      <div id="myModal3" class="modal3">
      <div class="modal-content3">
        <span class="close3">&times;</span>
        <h1>Supprimer une voiture</h1>
        <i class="fa-solid fa-triangle-exclamation"></i>
        <p id="myp_del"></p>
      </div>

      </div>
      <?php
        include "./loading.php"
      ?>
      <!-- ____________ delete model _____________ -->
      
      <script src="../view/javascript/cars_managementt.js"></script>
      <script src="./javascript/main.js"></script>
      <script>
          var modal2 = document.getElementById("myModal2");
          var btn = document.getElementById("myBtn");
          var span2 = document.getElementsByClassName("close2")[0];
          // document.getElementById("myBtn").onclick = function () {
          //   console.log("wa hassan");
          // modal2.style.display = "block";
          // };
          $(document).on("click", "#myBtn", function () {
            console.log("works properly");
            modal2.style.display = "block";
          });

          $(document).on("click", "#myBtn", () => {
            $("close2").show();
          });
          span2.onclick = function () {
            modal2.style.display = "none";
          };
          window.onclick = function (event) {
            if (event.target == modal2) {
              modal2.style.display = "none";
            }
          };
// ____________________________________________

      </script>
</body>
</html>