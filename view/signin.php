<?php
include "../CONTROL/controleur.php";
session_start();
$_SESSION["new"] = true; 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=El+Messiri:wght@400;500;600;700&family=Fira+Mono:wght@400;500;700&family=Kufam:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&family=Reem+Kufi+Fun:wght@400;500;600;700&family=Reem+Kufi+Ink&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/signin.css" />
    <script
      src="https://kit.fontawesome.com/dad8a5aed6.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="javascript/jquery-3.2.0.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#name").keyup(function () {
          regname = /^[a-zA-z][^0-9]{2,}$/;
          nname = $("#name").val();
          nametest = regname.test(nname);
          if (nametest == false) {
            $("#name").css("color", "red");
            $("#span_name").html(
              "name must be only letters (greater then 4 letters)"
            );
            $("#span_name").css("color", "#ff004f");
            // $("#span_name").css("text-transform", "uppercase");
          } else {
            $("#name").css("color", "green");
            $("#span_name").html("");
            $("#span_name").css("color", "white");
            // $("#span_name").css("text-transform", "uppercase");
          }
        });
        $("#lastname").keyup(function () {
          reglastname = /^[a-zA-z][^0-9]{2,}$/;
          lastname = $("#lastname").val();
          lastnametest = reglastname.test(lastname);
          if (lastnametest == false) {
            $("#lastname").css("color", "red");
            $("#span_lastname").html(
              "last name must be only letters (greater then 2 letters)"
            );
            $("#span_lastname").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#lastname").css("color", "green");
            $("#span_lastname").html("");
            $("#span_lastname").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
          }
        });

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
        
        $("#Marocain").click(function(){
          $("#identity_span").html("Cin");
          $(".identity_input").attr("id","identity_cin");
          $(".identity_regx").attr("id","identity_regx_cin");
        })
        $("#etranger").click(function(){
          $("#identity_span").html("Numéro passeport");
          $(".identity_input").attr("id","identity_passeport");
          $(".identity_regx").attr("id","identity_regx_passeport");
        })

        $(document).on("keyup","#identity_cin",function () {
          regidentity_cin = /^[a-zA-z]{1,2}[0-9]{6}$/;
          identity_cin = $("#identity_cin").val();
          identity_cintest = regidentity_cin.test(identity_cin);
          if (identity_cintest == false) {
            $("#identity_cin").css("color", "red");
            $("#identity_regx_cin").html(
              "Cin invalide"
            );
            $("#identity_regx_cin").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#identity_cin").css("color", "green");
            $("#identity_regx_cin").html("");
            $("#identity_regx_cin").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
          }
        });


        $(document).on("keyup","#identity_passeport",function () {
          console.log("ff");
          regidentity_passeport = /^[a-zA-z]{3}[0-9]{5}$/;
          identity_passeport = $("#identity_passeport").val();
          identity_passeporttest = regidentity_passeport.test(identity_passeport);
          if (identity_passeporttest == false) {
            $("#identity_passeport").css("color", "red");
            $("#identity_regx_passeport").html(
              "Numéro passeport invalide"
            );
            $("#identity_regx_passeport").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#identity_passeport").css("color", "green");
            $("#identity_regx_passeport").html("");
            $("#identity_regx_passeport").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
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
          <a class="cool-link"  href="index.php">ACCEUIL </a>
          <a class="cool-link"  href="signup.php">SE CONNECTER</a>
        </div>
      </nav>
    </div>
    <!-- _______nav_____________ -->

    <!-- /* sign up section____________________ */ -->
    <section class="sign_in_section">
  
        <h1 class="titlr">INSCRIPTION</h1>
        
        <form action="" name="d" method="post">
          <label for="name">
            <span>Nom : </span>
            <span id="span_name"></span>
            <input required type="text" id="name" name="name" />
          </label>
          <label for="lastname">
            <span>Prénom : </span>
            <span id="span_lastname"></span>
            <input required type="text" id="lastname" name="lastname" />
          </label>
          <label for="email">
            <span>Email : </span>
            <span id="span_email"></span>
            <input required type="email" id="email" name="email" />
          </label>
          <label for="password">
            <span>mot de passe : </span>

            <input  type="password" id="password" name="password" />
          </label>
          <label for="confpassword">
            <span>Confirmer le mot de passe : </span>
            <input
              
              type="password"
              id="confpassword"
              name="confpassword"
            />
          </label>
          <div id='type_identity'>
            <label for="identity">
              <span>Marocain</span>
              <input
              type="radio"
              id="Marocain"
              name="type_identity"
              checked
              />
              </label>
            <label for="identity">
              <span>Étranger</span>
              <input
              type="radio"
              id="etranger"
              name="type_identity"
              />
              </label>
          </div>
          

          <label for="identity">
            <span id="identity_span">Cin</span>
            <span id="identity_regx_cin" class="identity_regx"></span>
            <input
              type="text"
              class="identity_input"
              id="identity_cin"
              name="identity"
            />
          </label>
          <div class="form_buttons">
            <input id="submit" type="button" value="S'inscrire" name="signup" onclick="ajouter()" />
            <input type="reset" value=" Réinitialiser" />
          </div>
        </form>
      
    </section>
    <!-- /* sign up section____________________ */ -->
    <!-- __________footer_____________ -->
    <footer>
      <div class="footer_logo"><img src="images/hzefezfh.png" alt="" /></div>
      <div class="info_container">
        <div class="store_infos">
          <span id="contact_form_link">Contact Us From</span>
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
         function success(){
            Swal.fire({
            icon: 'success',
            title: 'Ajoute avec succès',
            showConfirmButton: false,
            timer: 1500
            })
        }
        function error(){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Quelque chose s'est mal passé !",
            })
        }
        function errorr(){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Password not matched",
            })
        }
        function ajouter(){
          var nom = document.d.name.value;
          var prenom = document.d.lastname.value;
          var email = document.d.email.value;
          var pass = document.d.password.value;
          var cfp = document.d.confpassword.value;
          var iden = document.d.identity.value;
          if(pass != cfp){
            errorr();
          }else{
            var s = new XMLHttpRequest();
            s.open("post","action.php",false);
            s.setRequestHeader(
                  "Content-type",
                  "application/x-wwW-form-urlencoded"
              );
            s.send("nom="+nom+"&&prenom="+prenom+"&&identity="+iden+"&&email="+email+"&&password="+pass);
            if(s.responseText == 22 ){
              window.location="cars_page.php";
            }else if(s.responseText == 13){
                  window.location="payment.php";
            }else{
                  error();
            }
          }
        }
    </script>
  </body>
  <?php
    include "./loading.php"
    ?>
  <script src="./javascript/main.js"></script>
</html>
