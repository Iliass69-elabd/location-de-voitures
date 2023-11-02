<?php
include '../CONTROL/controleur.php';
$c = new Control;

session_start();

if(isset($_POST["submit"])){
  $_SESSION["client_google"] = "az";
  $_SESSION["date_debut"] = $_POST["date_debut"];
  $_SESSION["date_fin"] = $_POST["date_fin"];
  $_SESSION["deux_con"] = $_POST["deux_con"];
  $_SESSION["duree"] = $_POST["duree"];
  $_SESSION["bouchon"] = $_GET["matricule"];
  $duree = $c->count_duree($_POST["date_debut"],$_POST["date_fin"]);
    if($_SESSION["connecter"] != true){
      header("location:signup.php");
    }else{
      header("location:payment.php");
    }
  }

if((isset($_POST["confirmer_commentaire"]) && !empty($_POST["review"])) || (isset($_SESSION["com"]) && isset($_SESSION["rev"]))){
  if(!empty($_POST["review"])){
    $_SESSION["com"] = $_GET["matricule"];
    $_SESSION["rev"] = $_POST["review"];
    unset($_SESSION["new"]);
  }
    if($_SESSION["connecter"] != true && !$_SESSION["new"]){
      $_SESSION["client"] = true;
      header("location:signup.php"); 
    }else{
      $id= $_SESSION["com"]; 
      unset($_SESSION["com"]); 
      $_SESSION["client"] = true;
      $c->review($_SESSION["rev"],$_SESSION["user"][0],$id);
      header("location:consulter.php?matricule=" .$id);   
   }
}else{
  $show = $c->show_cars_by_matricul($_GET['matricule']);
  $voiture = $show->fetch();
  if(!$voiture){
    header("location:index.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"
        ></script>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
        />

        <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <title>Consulter</title>
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link rel="stylesheet" href="../view//css//consulter.css">
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body onload="load()">
    <!-- ____________ start nav bar ________________ -->
    <div class="nav_container">
      <nav class="nav">
        <input type="checkbox" id="nav-check" />
        <div class="nav-header">
          <div class="nav-title">
            <img src="LOGO/logonew.png" alt="" />
          </div>
        </div>
        <div class="nav-btn">
          <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
          </label>
        </div>
        <?php if($_SESSION["client"] == true ){
         ?>
        <div class="nav-links">
          <a  class="cool-link" href="./cars_page.php">Acceuil</a>
        </div>
      <?php }else{
          ?>
           <div class="nav-links">
          <a class="cool-link"  href="./signup.php">CONNEXION</a>
          <a  class="cool-link" href="./signin.php">INSCRIPTION</a>
          <a  class="cool-link" href="./index.php">Acceuil</a>
        </div>
          <?php
          }?>
      </nav>
    </div>
    <!-- ____________ end nav bar ________________ -->

    <!-- _____________ start car details section __________________ -->
    <div class="container_for_car">
        <?php 
         
             echo "<div class='car_name_reserve'>
             <h2><span>$voiture[2]</span><span>$voiture[5] DH/Jours</span></h2>
             <button id='myBtn'>Réserver</button>
           </div>";

        ?>
        <section class="company_services">
          <div><i class="fa-solid fa-check"></i> <span>Annulation gratuite</span></div>
          <div><i class="fa-solid fa-check"></i> <span>Payez à la prise en charge</span></div>
          <div><i class="fa-solid fa-check"></i><span> Kilométrage compteur illimité</span></div>
        </section>
    <!-- _____________ end car details section __________________ -->
    <!-- ____________ start car section ______________ -->
        <section class="car_section">
          <div class="show_car">
              <div class="main_show_div">
                <?php
  
                    echo "<img class='main_img' src='$voiture[1]' alt=''/>";
                  
                ?>
              </div>
              <div class="details_pictures">
                <?php
                    echo "
                    <img  class='image_to_show' src='$voiture[1]' alt=''/>
                    <img class='image_to_show'  src='$voiture[13]' alt=''/>
                    <img  class='image_to_show' src='$voiture[14]' alt=''/>
                    <img class='image_to_show'  src='$voiture[15]' alt=''/>
                    <img class='image_to_show'  src='$voiture[16]' alt=''/>
                    ";
                  
                ?>
              
              </div>
              
          </div>
        </section>
        <section class="accessoire_section">
          <div><h1>Caractéristiques de la voiture</h1></div>
          <div class="Caracteristiques">
              <?php
                $ac = new Control;
                $resac = $ac->select_accessoires($_GET['matricule']);
                while($row = $resac->fetch()){
                  echo"
                    <span><i class='fa-solid fa-check'></i> $row[1]</span>
                  ";
                }

              ?>
          </div>
        </section>
      </div>
      
      <div id="myModal" class="modal">
        <div class="modal-content">
          <div class="close_div">
            <span class="close">&times;</span>
          </div>
          <div class="payement">
            <form action="" method="post">
            <div class="price">
             <?php 
             
                  $price = $voiture[5];
                  echo $price;
              
             ?>
             Dh
            </div>
              <div>
                <label for="">Prise en charge</label>
                <input type="date" name="date_debut" required>
              </div>
              <div>
                <label for="">Retour</label>
                <input type="date"  name="date_fin" class="date_retour" required>
              </div>
              <div>
                <label for="">Durée</label>
                <input type="text" name="duree" class="duree" readonly>
              </div>
              <div class="block-item-text">
              <label for="read-more" class="read-more-trigger_closed">Supplément</label>
                <input type="checkbox" hidden class="read-more-state" id="read-more">
                <div class="read-more-wrap">
                  <p class="read-more-target">
                    <label for="">2éme Conducteur(50 Dh):<input type="checkbox" name="deux_con" id="deux_con" class="a"></label>
                  </p>
                </div>
                
                </div>
                
              <button name="submit" class="submit"  disabled>Réserver maintenant</button>
            </form>
        </div>
        </div>
      </div>
   
    <!-- ____________ end car section ______________ -->
    <section class="description_car">
      <h1>Description :</h1>
      <div>
      <?php 
             echo "<div class='text_description'>
                     <p class='cc'>$voiture[7]</p>
                  </div>
                   ";
           
      ?>
    </div> 
    </section>
    <!-- ________section des commentaires ____________-->
    <section class="description_car">
            <script src="https://use.fontawesome.com/a6f0361695.js"></script>
            <h2 id="fh2">NOUS APPRECIONS VOS AVIS!</h2>
            <form id="feedback" action="" method="post">
              <!-- <div class="pinfo">Laissez un commentaire.</div> -->
              <div class="form-group">
                <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                <!-- <span class="input-group-addon"><i class="fa fa-pencil"></i></span> -->
                <textarea class="form-control" placeholder="Ajoutez un commentaire..."  id="review" name="review"  class="rev" rows="3"></textarea>
                  </div>
                </div>
              </div>

              <div class="button_comment"><button type="submit" name="confirmer_commentaire" class="btn_comment">Envoyer</button></div>
              <div class="comment-section">
                  <?php 
                         $acc = $c->affichage_commentaire($_GET['matricule']);
                         while($row = $acc->fetch()){
                           echo"
                           <div class='comment'>
                           <div><i class='fa-solid fa-comment'></i> <span class='comment-owner'>$row[0] $row[1]</span></div>
                           <div class='the-comment'>$row[2]</div>
                         </div>
                           ";
                         }
                        
                  ?>
              </div>
            </form>
            
    </section>
    <section>
    <div class="big_contain">
        <div class="box_app_deux">
            <img src="./images/annule.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>Politique d’annulation flexible</h3>
                <p class="espacement">Une erreur ? Pas de soucis ! </p>
            </div>
        </div>
        <div class="box_app_deux">
            <img src="./images/carte-bancaire.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>Paiement Sécurisé</h3>
                <p class="espacement">Réservez aujourd’hui et payez un acompte de 15% seulement!</p>
            </div>
        </div>
        <div class="box_app_deux">
            <img src="./images/content.png" class="imagef" alt="">
            <div class="paragraphe_ecrit">
                <h3>Sourire Garanti!</h3>
                <p class="espacement">WLC à sélectionné pour vous les meilleurs véhicules!</p>
            </div>
        </div>
    </div>
    </section>
    <section>
      
    </section>

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

    <!-- ________ end footer______________ -->
</body>
    <script>
       $(document).ready(function(){
           	$(".btn_comment").click(function(){
			        $('.rev').attr('required', true); 
			 });
		  });
       var nbr = $(".price").text();
       function datee(){
            Swal.fire({
            title: 'La date doit être Supérieur',
            showConfirmButton: false,
            timer: 2000
            })
        }
       function datee2(){
            Swal.fire({
            title: 'La date doit être Supérieur à la date d\'aujourdhui',
            showConfirmButton: false,
            timer: 2000
            })
        }
      $("input[type=date]").on("change",function(){
        var dte1 = $("input[type=date]")[0].value;
        var dte2 = $("input[type=date]")[1].value;
        var deux = $("input[type=checkbox]")[0].value;
        var trois = $("input[type=checkbox]")[1].value;
        var test = false;
        var test1 = false;
        var test2 = false;
        if(dte1 == dte2){
          datee()
          test =false;
        }else{
          test=true;
        }
        if( dte1 < new Date().toISOString().split('T')[0]){
              datee2();
              test1 = false;
        }else{
          test1 = true
        }
        if(dte1 != "" && dte2 != "" ){
          if(dte1 >dte2){
            test2 = false;
            datee();
        }else{
          test2 = true;
          var date1 = new Date($("input[type=date]")[0].value);
          var date2 = new Date($("input[type=date]")[1].value);

          var difference = date2 - date1;

          var days = difference/(24*3600*1000);
          $(".duree").val(days); 
          $(".price").text(parseFloat(nbr) * days + " Dh"); 
        }
        if(test1 && test2 && test){
           $(".submit").attr("disabled",false);
        }else{
           $(".submit").attr("disabled",true);
        }
        }
        $("input[type=checkbox]").on("click",function(){
        if ($("#deux_con").is(":checked")){
            $(".price").text(parseFloat(nbr) * days + 50 + " Dh"); 
        }else{
          $(".price").text(parseFloat(nbr) * days + " Dh"); 
        }
        if ($(".a").is(":checked") && $(".e").is(":checked")){
            $(".price").text(parseFloat(nbr) * days + 70 + " Dh"); 
        }
      })
  
      })
    </script>
    <?php
    include "./loading.php"
    ?>
    <script src="../view/javascript/consulter.js"></script>
    <script src="./javascript/main.js"></script>
</html>