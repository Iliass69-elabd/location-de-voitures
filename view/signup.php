<?php 
    session_start();
 
    require "../CONTROL/controleur.php"; 
    $_SESSION["new"] = true; 
    require_once '../CONTROL/google.php';
    if(isset($_SESSION["user_token"])){
      header("location:cars_page.php");
    }else{

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
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
    <link rel="stylesheet" href="css/signup.css" />
    <script
      src="https://kit.fontawesome.com/dad8a5aed6.js"
      crossorigin="anonymous"
    ></script>
 
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="javascript/jquery-3.2.0.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#email").keyup(function () {
          regemail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
          email = $("#email").val();
          emailtest = regemail.test(email);
          if (emailtest == false) {
            $("#email").css("color", "red");
            $("#span_email").html(
              "Email n'est pas valide!!"
            );
            $("#span_email").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#email").css("color", "green");
            $("#span_email").html("");
            $("#span_email").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
          }
        });

        $("#submit").click(function () {
          if (emailtest == true && $("#password").val() != "") {
            $("#submit").attr("type", "submit");
          } else {
            $("#submit").removeAttr("submit");
          }
        });
      });
    </script>
    <link rel="stylesheet" href="./css/main.css">
  </head>
  <body>
    <!-- _______nav_____________ -->
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
          <a class="cool-link" href="index.php">ACCEUIL </a>
          <a class="cool-link" href="signin.php">INSCRIPTION</a>
        </div>
      </nav>
    </div>
    <!-- _______nav_____________ -->

    <!-- /* sign up section____________________ */ -->
    <section class="sign_up_section">
     
        <h1 class="titlr">SE CONNECTER</h1>
        <div > </div>
        <form action="" name="f" id="form" method="post">
        <div id="results"></div>
          <label  for="email">
            <span >Email : </span>
            <span  id="span_email"></span>

            <input required type="email" id="email" name="email" />
          </label>
          <label  for="password">
            <span>Mot de passe : </span>
            <input required type="password" id="password" name="password" />
          </label>
          <div class="form_buttons">
            <input type="button" value="Connexion" onclick="connecter()" />
            <input type="reset" value="Réinitialiser" />
          </div>
          <?php 
              echo "<a id='google_link' href='" . $client->createAuthUrl() . "'><img src='./icons/chercher.png' class='google'/>Continuer avec google</a>";
            }
              
          ?>
        </form>
        <span> Vous n'avez pas de compte? <a href="signin.php">S'inscrire</a></span>
    </section>
    <!-- /* sign up section____________________ */ -->
    <!-- __________footer_____________ -->

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
            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a
            ><a href=""><i class="fa-brands fa-twitter"></i></a>
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
    <!-- __________footer_____________ -->
    <script>
        function error(){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Email or password  incorrect",
            })
        }
        function connecter(){
          var email = document.f.email.value;
          var pass = document.f.password.value;
            var s = new XMLHttpRequest();
            s.open("post","action.php",false);
            s.setRequestHeader(
                  "Content-type",
                  "application/x-wwW-form-urlencoded"
              );
            s.send("email="+email+"&&password="+pass);
            if(s.responseText < 1 ){
                error()
            }else if(s.responseText == 1){
              window.location="admin_page.php";
            }else if(s.responseText == 2){
              window.location="cars_page.php";
            }else if(s.responseText == 3){
              window.location="payment.php";
            }else if(s.responseText == 4){
              window.location="consulter.php";
            }else if(s.responseText == 50){
              window.location="secretaire.php";
            }else{
              window.location="index.php";
            }
          }
    </script>
  </body>
  <?php
    include "./loading.php"
    ?>
  <script src="./javascript/main.js"></script>
</html>
