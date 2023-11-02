<?php
include '../CONTROL/controleur.php';
$c = new Control;
session_start();

unset($_SESSION["com"]);
unset($_SESSION["rev"]);
$_SESSION["client"] = 0;
unset($_SESSION["client_google"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link rel="stylesheet" href="../view//css//index.css">
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
        
    <link rel="stylesheet" href="./css/main.css">
  </head>
<body>
    <!-- ____________ start nav bar ________________ -->
    <div class="nav_container">
      <nav class="nav">
        <input type="checkbox" id="nav-check" />
        <div class="nav-header">
          <div class="nav-title">
          <?php 
            $n = new Control; 
            $r = $n->agence_info(); 
            while($row=$r->fetch()){
            echo "<img id='logo_wlc' src='$row[6]' alt='' />";
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
          <a class="cool-link"  href="#aboutus_big_container">à propos</a>
          <a  class="cool-link" href="#contact_big_container">Contact</a>
          <a class="cool-link"  href="./signup.php">connexion</a>
          <a  class="cool-link" href="./signin.php">inscription</a>
        </div>
      </nav>
    </div>
    <!-- ____________ end nav bar ________________ -->

    <!-- ____________ start home section _____________ -->
        <section class="home_section" style='background: url("../view/images/voiture.jpg");background-repeat: no-repeat;background-attachment: fixed;background-size: cover;' >
            <h1>WE LOVE CARS</h1>
            <span>Location de voitures</span>

            <a href="#models_cars">
                Découvrir
            </a>
        </section>
    <!-- ____________ end home section _____________ -->
        <section>
        <div class="big_contai">
        <div class="box_app">
            <img src="./images/mise-a-jour.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>Kilométrage illimité</h3>
                <p>Profitez de nos véhicules sans aucunes limites!</p>
            </div>
        </div>
        <div class="box_app">
            <img src="./images/support-informatique.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>24/7 Support et aide</h3>
                <p>L’ensemble de notre parc automobile à moins d’un ans.</p>
            </div>
        </div>
        <div class="box_app">
            <img src="./images/rabais.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>Véhicules neufs</h3>
                <p>Nous sommes à votre service durant toute la durée de votre location.</p>
            </div>
        </div>
    </div>
    <hr style="width:80%;margin-left:auto;margin-right:auto">
        </section>
    <!-- __________ start example cars section __________ -->

        <section id="example_section" class="example_section"> 
            <h1 id="models_cars">Modèle des voitures</h1>
            <div class="cc">
            <form action="" name="f" class="search_form">
              <div id="search_inputs">
                <div class="input_and_select">
                  <input type="search" placeholder="Chercher..." name="mark" class="search" onkeyup='search()'>
                  <select name="type_carburent" onchange="search()">
                  <option value="tout">Tout</option>
                    <?php
                      $c->optionn();
                    ?>
                  </select>
                </div>
                <div id="minmax">
                  <h4>Recherche par prix</h4>
                  <!-- <span>Recherc</span> -->
                  <input  class="min_max_search_inputs" type="number"  name="prix_un" placeholder="Min" >
                  <input class="min_max_search_inputs" type="number" name="prix_deux" placeholder="Max">
                  <button type="button"  onclick="min_max()" class="chercher_min_max">Chercher</button>
                </div>
              </div>
            </form>
            
            </div>
            <div id="big_container_car" class="big_container_car">
            <?php 
                $c->affichage_voiture();
                ?>
            </div> 
        </section>
      
    <!-- __________ end  example cars section __________ -->
        <section id="aboutus_big_container" class="about_us_section">
            <h1>à propos :</h1>
            <p>  Nous sommes un service de bout en bout, ici pour rendre la location d'une voiture à WLC simple et sans stress. Nous négocions directement avec les sociétés de location de voitures afin de vous proposer les prix de location les moins chers sur une large gamme de voitures. En une simple recherche, nous comparons les prix et vous donnons toutes les informations dont vous avez besoin à l'avance, tandis que les filtres pratiques vous aident à trouver rapidement votre voiture de location idéale.</p>
        </section>
    <!-- __________ About section _______________ -->


    <!-- _________ start contact  us section ______________ -->
        <section id="contact_big_container" class="contact_us_section">
            <h1>Contactez-nous</h1>
            <form name="email_form">
                <label for="">
                    Nom et Prénom :
                    <input type="text" name="fullname" placeholder="Nom et Prénom ">
                </label>
                <label for="">
                    Email:
                    <input type="text" name="email" placeholder="Email">
                </label>
                <label for="">
                    sujet :
                    <input type="text" name="sujet" placeholder="sujet">
                </label>
                <label for="">
                    Message :
                    <textarea name="message" id="" placeholder="Message"></textarea>
                </label>
                <button type="button" id="button_email">Envoyer</button>
            </form>
        </section>
    <!-- _________ end contact  us section ______________ -->


    <!-- ________ start footer______________ -->
    <footer>
      <div class="footer_logo"><img src="images/hzefezfh.png" alt="" /></div>
      <div class="info_container">
        <div class="store_infos">
          <span href="../html/contact.html" id="contact_form_link"
            >Contact Us From</span
          >
          <div id="email">
            <i class="fa-solid fa-at"></i> wlc.car_rental@gmail.com
          </div>
          <div id="phone_number">
            <i class="fa-solid fa-phone"></i> 0655243799
          </div>
          <div id="location">
            <i class="fa-solid fa-location-dot"></i> Marrakech
          </div>
          <div class="social_media_links">
            <a href=""><i class="fa-brands fa-facebook-f facebook" id="facebook"></i></a>
            <a href=""><i class="fa-brands fa-instagram instagram" id="instagram"></i></a
            ><a href=""><i class="fa-brands fa-twitter twitter" id="twitter"></i></a>
          </div>
        </div>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3398.3639243113353!2d-8.031084385106771!3d31.59648638134441!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafef2395d6941d%3A0x26ef4746c8d87b54!2sSaad%20Rent%20Cars%20Marrakech!5e0!3m2!1sfr!2sma!4v1666527103365!5m2!1sfr!2sma"
          width="600"
          height="450"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>

      <div class="copy_right">© 2022 WLC CAR RENTAL</div>
    </footer>

    <!-- ________ end footer______________ -->
</body>
<script>
     function search(){
            var mark = document.f.mark.value;
            var type_carburent = document.f.type_carburent.value;
            var s = new XMLHttpRequest();
            s.open("get","action.php?mark="+mark+"&type_carburent="+type_carburent,false);
            s.send();
            document.getElementById("big_container_car").innerHTML = s.responseText;
      }
      function min_max(){
            var prix_deux = document.f.prix_deux.value;
            var prix_un = document.f.prix_un.value;
            var s = new XMLHttpRequest();
            s.open("get","action.php?prix_deux="+prix_deux+"&prix_un="+prix_un,false);
            s.send();
            document.getElementById("big_container_car").innerHTML = s.responseText;
      }
      
      // $(document).ready(function(){
      // $(window).scroll(function(){
      //   var scroll = $(window).scrollTop();
      //   if (scroll > 250) {
      //     $(".nav").css("background" , "white");
      //     $(".cool-link").css("color" , "black");  
      //     $("#logo_wlc").css("filter" , " brightness(0)"); 
      //   }
      //   else{
      //     $(".nav").css("background" , "none");  	
      //     $(".cool-link").css("color" , "white"); 
      //     $("#logo_wlc").css("filter" , " brightness(100)");
      //   }
      //   })
      // })
      $(document).ready(function () {
        $.ajax({
          url: "./action.php",
          type: "post",
          data: { showshow: "hamiid" },
          dataType: "json",
          success: function (data) {
            console.log(data);
          },
          error: function (err) {
            console.log(err);
          },
        });
      });
</script>
<?php
    include "./loading.php"
    ?>
<script src="./javascript/index.js"></script>
<script src="./javascript/main.js"></script>
</html> 