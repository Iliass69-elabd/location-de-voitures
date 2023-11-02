<?php
session_start();
if($_SESSION["autoriser"] != "oui") {
    header("location:index.php");
    exit();
}
include "../CONTROL/controleur.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WLC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=El+Messiri:wght@400;500;600;700&family=Fira+Mono:wght@400;500;700&family=Kufam:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&family=Reem+Kufi+Fun:wght@400;500;600;700&family=Reem+Kufi+Ink&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/admin_page.css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/main.css">
  </head>
  <body>
</header> 

<div class="sidebar open">
    <div class="logo-details">
        <div class="logo_name">WLC </div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
     
      <li>
        <a href="#">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Tableau de bord</span>
        </a>
         <span class="tooltip">Tableau de bord</span>
      </li>
      <li>
       <a href="./car_management.php">
         <i class='bx bx-car' ></i>
         <span class="links_name">Gestion des voitures</span>
       </a>
       <span class="tooltip">Gestion des voitures</span>
     </li>
     <li>
       <a href="./manage_clients.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Gestion des clients</span>
       </a>
       <span class="tooltip">Gestion des clients</span>
     </li>
     <li>
       <a href="./manage_staff.php">
          <i class="fa-sharp fa-solid fa-clipboard-user"></i>
         <span class="links_name">Gestion des employés</span>
       </a>
       <span class="tooltip">Gestion des employés</span>
     </li>
     <li>
       <a href="./manage_reservation.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Réservations</span>
       </a>
       <span class="tooltip">Réservations</span>
     </li>
     <li>
       <a href="./gestion_agence.php">
       <i class="fa-solid fa-building"></i>
          <span class="links_name">Agence</span>
       </a>
       <span class="tooltip">Agence</span>
     </li>
     <li>
       <a href="./gestion_reparations.php">
       <i class="fa-solid fa-screwdriver-wrench"></i>
          <span class="links_name">Réparations</span>
       </a>
       <span class="tooltip">Réparations</span>
     </li>
     <li>
       <a href="./stripe.php">
       <i class="fa-solid fa-money-bill-wave"></i>
          <span class="links_name">Stripe Info</span>
       </a>
       <span class="tooltip">Stripe Info</span>
     </li>
     <li>
       <a href="./charges.php">
       <i class="fa-solid fa-sack-dollar"></i>
          <span class="links_name">Charges</span>
       </a>
       <span class="tooltip">Charges</span>
     </li>
     
     <li class="profile">
         
         <a href="../CONTROL/deconnexion.php">
          <i class='bx bx-log-out' id="log_out" ></i>
         </a>
     </li>
    </ul>
  </div>
</header>

<!-- ------------links sections---------------- -->

<section class="home-section">
  <div id="notif">
  <a href="#" class="notification" id="myBTN">
    <img class="image_not" src="./icons/icons8-rappels-de-rendez.png" alt="">
    <span class="badge" id="badge"></span>
  </a>
  <div id="myMDL" class="MDL">
    <div class="modal-content-notif">
      <span class="close-notif">&times;</span>
      <div class="notifContent">
      <table class="table-notif">
        <tbody class="notcnt">
        </tbody>
      </table>
      </div>
    </div>

  </div>
  </div>
    <div class="calendre">
      <form action="" method="post" name="form_calendrier">
        <input type="date" name="avant" class="inputscalendre">
        <input type="date" name="apres" class="inputscalendre">
        <input id="submit" class="btn_calendre" type="button" value="Choisir" onclick="chercher()" />
        <input id="submit" class="btn_calendre" type="button" value="aujourd'hui" onclick="jour()" />
      </form>
    </div>
    <div id="content">
      <div class="statistics">
        <div class="logo_stats">
          <img src="./icons/icons8-réservation.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>RESERVATIONS</span>
          <h1 id="numres"></h1>
        </div>
      </div>


      <div class="statistics">
        <div class="logo_stats">
          <img src="./icons/icons8-client.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>CLIENTS</span>
          <h1 id="numcl"></h1>
          <div class="others">
            <p>Nº Clients Réserver: <span id="numclres"></span></p>
            <p>Nº Clients non réserver: <span id="numclnres"></span></p>
          </div>
        </div>
      </div>

      <div class="statistics">
        <div class="logo_stats">
          <img src="./icons/icons8-voiture.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>VOITURES</span>
          <h1  id="numv"></h1>
          <div class="others">
          <p>Nº Voitures Réserver: <span id="numvres"></span></p>
          <p>Nº Voitures non réserver: <span id="numvnres"></span></p>
          </div>
        </div>
      </div>


      <div class="statistics">
        <div class="logo_stats">
        <img src="./icons/icons8-sac-d'argent.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>Total Gagné</span>
          <div id="total_g"><h1 id="totg" >0</h1> <h2>/DH</h2></div>
        </div>
        </p>
      </div>

      <div class="statistics">
        <div class="logo_stats">
        <img src="./icons/icons8-poubelle.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>Dépenses</span>
          <div id="depense"><h1 id="dep">0</h1> <h2>/DH</h2></div>
        </div>
        </p>
      </div>


      <div class="statistics">
        <div class="logo_stats">
           <img src="./icons/icons8-employer.png" alt="" srcset="">
        </div>
        <div class="stats">
          <span>Employer</span>
          <div id="employer"><h1 id="emp"></h1></div>
        </div>
        </p>
      </div>


     


    </div>
    <div class="charts">
      <div id="chartbar">
        <canvas id="myChartbar" ></canvas>
      </div>
      <div id="chartpie1">
        <canvas id="myChartline" ></canvas>
      </div>
    </div>
</section>
<!-- ------------links sections---------------- -->
  </body>
  <script src="path/to/chartjs/dist/chart.umd.js"></script>
  <script src="../view/javascript/jquery-3.6.0.min.js"></script>
  <script src="./javascript/dashBoard.js"></script>
  <script>
    setInterval(() => {
      triggerNotif();
      }, 3000);
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", ()=>{
      sidebar.classList.toggle("open");
      menuBtnChange();//calling the function(optional)
    });

    searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
    });

    // following are the code to change sidebar button(optional)
    function menuBtnChange() {
    if(sidebar.classList.contains("open")){
      closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
    }else {
      closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
    }
    }
    
   function chercher(){
      var s = new XMLHttpRequest();
      var avant = document.form_calendrier.avant.value;
      var apres = document.form_calendrier.apres.value;
      $.ajax({
        url: "./action.php",
        type: "POST",
        data: { avant: avant, apres: apres },
        dataType: "json",
        success: function (data) {
          // Display the data in the data container
          var totg = document.getElementById('totg');
          totg.innerHTML = data.message[0].Total;
          var numres = document.getElementById('numres');
          numres.innerHTML = data.messagee[0].TotalReserver;
          var numclres = document.getElementById('numclres');
          numclres.innerHTML = data.messageeee[0].ClientReserver;
          var numclnres = document.getElementById('numclnres');
          numclnres.innerHTML = data.messages[0].ClientNonReserver;
          var numvres = document.getElementById('numvres');
          numvres.innerHTML = data.messagesss[0].VoitureReserver;
          var numvnres = document.getElementById('numvnres');
          numvnres.innerHTML = data.messag[0].VoitureNonReserver;
          var dep = document.getElementById('dep');
          dep.innerHTML = data.messagtt[0].TotalReparation;
        },
        error: function (err) {
          console.log(err);
        },
      });
      
    }
   function jour(){
      var s = new XMLHttpRequest();
      // var avant = document.form_calendrier.avant.value;
      // var apres = document.form_calendrier.apres.value;
      $.ajax({
        url: "./action.php",
        type: "POST",
        data: { avant: new Date().toISOString().split('T')[0], apres: new Date().toISOString().split('T')[0] },
        dataType: "json",
        success: function (data) {
          // Display the data in the data container
          var totg = document.getElementById('totg');
          totg.innerHTML = data.message[0].Total;
          var numres = document.getElementById('numres');
          numres.innerHTML = data.messagee[0].TotalReserver;
          var numclres = document.getElementById('numclres');
          numclres.innerHTML = data.messageeee[0].ClientReserver;
          var numclnres = document.getElementById('numclnres');
          numclnres.innerHTML = data.messages[0].ClientNonReserver;
          var numvres = document.getElementById('numvres');
          numvres.innerHTML = data.messagesss[0].VoitureReserver;
          var numvnres = document.getElementById('numvnres');
          numvnres.innerHTML = data.messag[0].VoitureNonReserver;
          var dep = document.getElementById('dep');
          dep.innerHTML = data.messagtt[0].TotalReparation;
        },
        error: function (err) {
          console.log(err);
        },
      });
      
    }
    


  </script>
  <?php
    include "./loading.php"
    ?>
  <script src="./javascript/main.js"></script>
</html>