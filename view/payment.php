<?php
include '../CONTROL/controleur.php';
$c = new Control;


session_start();
// echo "<pre>";
// var_dump($_SESSION);
// echo"</pre>";
if(empty($_SESSION["date_debut"])){
  header("location:index.php");
}
$voituree = null;
if($_SESSION["connecter"] != true){
  header("location:index.php");
  exit();
}
if(isset($_SESSION["bouchon"])){
    $id = $_SESSION["bouchon"];
    unset($_SESSION["bouchon"]);  
    header("location:payment.php?matricule=" . $id);
}else{
  $r = $c->affichage_voiture_par_matricule($_GET["matricule"]);
  if(count($r) > 0){
    $voituree = $r;
    $date_debut = $_SESSION["date_debut"];
    $date_fin = $_SESSION["date_fin"];
    $duree = $_SESSION["duree"];
    $deux = $_SESSION["deux_con"];
    $price = $voituree["price"]*$duree;
    $t = $voituree["price"];
    if(isset($deux)){
      $price += 50;
    }
    $client = $c->client_reserver($_SESSION["user"][0]);
  }else{
      header("Location:index.php");
      // var_dump($_SESSION);
  }
}
if(isset($_POST["submit"])){
    $cin = $_FILES["photo_cin"];
    $permis = $_FILES["photo_permis"];
    $img_loc1 = $_FILES['photo_cin']['tmp_name'];
    $img_name1 =  $_FILES['photo_cin']['name'];
    $img_desc1 = "Uploaded_images/" .$img_name1;
    move_uploaded_file($img_loc1,'Uploaded_images/'.$img_name1);

    $img_loc2 = $_FILES['photo_permis']['tmp_name'];
    $img_name2 =  $_FILES['photo_permis']['name'];
    $img_desc2 = "Uploaded_images/" .$img_name2;
    move_uploaded_file($img_loc2,'Uploaded_images/'.$img_name2);

    $modepaiment = $_POST["payment"];
    
    $contrada = $c->contrat($_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$_GET["matricule"],$voituree["mark_voi"],$voituree["km_actuel"],$date_debut,$date_fin,$t);
    $update = $c->update_info_client($_POST["permis"],$_POST["ville"],$img_desc1,$img_desc2,$_POST["phone"],$_SESSION["user"][0]);
    $reserver = $c->reserver($date_debut,$date_fin,$_GET["matricule"],$_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$duree,$price,$modepaiment,$deux,$t);
    include '../CONTROL/mail.php';
    header("location:facture.php");
}
if(isset($_POST["submitt"])){
    include '../CONTROL/mail.php';
    $modepaiment = $_POST["payment"];
    $contrada = $c->contrat($_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$_GET["matricule"],$voituree["mark_voi"],$voituree["km_actuel"],$date_debut,$date_fin,$t);
    $reserver = $c->reserver($date_debut,$date_fin,$_GET["matricule"],$_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$duree,$price,$modepaiment,$deux,$t);
    header("location:facture.php");
    
}

if(isset($_POST["stripeToken"])){
  include("../CONTROL/config.php");
    $token = $_POST["stripeToken"];
    $email = $_SESSION["user"][4];
    $charge = \Stripe\Charge::create([
      "amount" => str_replace(",","",$price)*100,
      "currency" => 'mad',
      "source"=> $token,
    ]);
  if($charge){
      include '../CONTROL/mail.php';
      $modepaiment = $_POST["payment"];
      if(isset($_POST["permis"])){
        $cin = $_FILES["photo_cin"];
        $permis = $_FILES["photo_permis"];
        $img_loc1 = $_FILES['photo_cin']['tmp_name'];
        $img_name1 =  $_FILES['photo_cin']['name'];
        $img_desc1 = "Uploaded_images/" .$img_name1;
        move_uploaded_file($img_loc1,'Uploaded_images/'.$img_name1);
    
        $img_loc2 = $_FILES['photo_permis']['tmp_name'];
        $img_name2 =  $_FILES['photo_permis']['name'];
        $img_desc2 = "Uploaded_images/" .$img_name2;
        move_uploaded_file($img_loc2,'Uploaded_images/'.$img_name2);
        $contrada = $c->contrat($_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$_GET["matricule"],$voituree["mark_voi"],$voituree["km_actuel"],$date_debut,$date_fin,$t);
        $update = $c->update_info_client($_POST["permis"],$_POST["ville"],$img_desc1,$img_desc2,$_POST["phone"],$_SESSION["user"][0]);
      }
      $contrada = $c->contrat($_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$_GET["matricule"],$voituree["mark_voi"],$voituree["km_actuel"],$date_debut,$date_fin,$t);
      $reserver = $c->reserver($date_debut,$date_fin,$_GET["matricule"],$_SESSION["user"][0],$_SESSION["user"][1],$_SESSION["user"][2],$duree,$price,$modepaiment,$deux,$t);
      header("Location:facture.php");
    }else{
    }
  
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="./javascript/script.js" defer></script>
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
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <title>Paiement</title>

    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link rel="stylesheet" href="./css/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
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
        <?php if($_SESSION["client"] == true ){
         ?>
        <div class="nav-links">
          <a  class="cool-link" href="./cars_page.php">Acceuil</a>
          <a class="cool-links" href="../CONTROL/deconnexion.php">Déconnexion</a>

        </div>
      <?php }else{
          ?>
           <div class="nav-links">
          <a  class="cool-link" href="./index.php">Acceuil</a>
          <a class="cool-links" href="../CONTROL/deconnexion.php">Déconnexion</a>
        </div>
          <?php
          }?>
      
      </nav>
    </div>
    <!-- ____________ end nav bar ________________ -->

    <!-- _____________ start facturation __________________ -->
    <div >
        <section class="deux_box">
            <div class="info_voiture">
              <h2 class="titre">Votre résérvation</h2>
                <div class="informations">
                  <div class="cars_show_info">
                      <h3><?php echo $voituree["mark_voi"];?></h3>
                      <div class="container_res_infos">
                        <div class="container_details_res">
                          <span>Durée : </span>
                          <span><?php echo $duree;?> Jours</span>
                        </div>
                        <?php 
                        if($deux === "on"){
                        ?>
                          <div class="container_details_res">
                            <span>2éme conducteur : </span>
                            <span>Inclus</span>
                          </div>
                        <?php
                        $price = ($voituree["price"]*$duree) + 50;
                        }
                      ?>
                        <div class="container_details_res">
                          <span>Totale : </span>
                          <span><?php echo $price;?> Dh</span>                 
                        </div>
                      </div>
                    </div>
                    <div class="reserved_image">
                      <img class="image_voiture" src="<?php echo $voituree["picture_car"];?>" alt="">
                    </div>
                  </div>
              </div>
            <div class="info_client">
                <h2 class="titre">Vos Informations </h2>
                <div class="informationss">
                <form action="" method="post" name="gog" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-6">
                      <label class="form-label" for="" >Nom : 
                        </label> 
                        <input type="text" readonly class="form-control" value="<?php echo $client["nom_client"] ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="">Prénom : 
                        </label> 
                        <input type="text" readonly class="form-control" value="<?php echo $client["prenom_client"] ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="" >Date Début : 
                        </label> 
                        <input type="text" readonly class="form-control" value="<?php echo $date_debut ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="" class="label">Date Fin: 
                        </label> 
                        <input type="text" class="form-control" readonly value="<?php echo $date_fin ?>" >
                    </div>
                  <?php 
                    if($_SESSION["user"][6] == null){
                      $_SESSION["accorde"] =  true;
                        ?>    <div class="col-md-6">
                                <label for="" class="form-label" >Téléphone : </label> 
                                <input class="form-control" type="Number" name="phone" required   >
                              </div>
                              <div  class="col-md-6">
                                <label for=""  class="form-label">Numéro permis : </label> 
                                <input class="form-control" type="text" name="permis" required >
                              </div>
                              <div class="col-md-6">
                                <label for="" >Photo permis : </label> 
                                <input class="form-control" type="file"  name="photo_permis" required >
                              </div>
                              <div class="col-md-6">
                                <label for=""  class="form-label">Photo carte d'identité: </label>
                                <input class="form-control" type="file" name="photo_cin" required >
                              </div>
                              <div>
                                  <label for="" class="form-label" >Ville : </label> 
                                  <input class="form-control" type="text" name="ville" required >
                              </div>
                              <div>
                                <h5>Méthode de payment</h5>
                                <div class="form-check form-check-inline">
                                  <input type="radio" name="payment" value="Carte Bancaire" class="form-check-input" id="bancaire" required>
                                  <label class="form-check-label" for="inlineRadio1">Carte Bancaire</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="payment" checked value="virement espéce" id="espece" required>
                                  <label class="form-check-label" for="inlineRadio1">virement espéce</label>
                              </div>
                              </div>
                          
                              <div class="cont">
                                <div class="stripe">
                                  <script id="scri"></script>
                                </div>
                              </div>
                            
                                  <div class="col-md-12">
                                    <button type="submit" name="submit" id="commm" class="btn btn-primary">Commander</button> 
                                  </div>

                          
                        <?php
                    }else{
                      ?>
                              <div class="col-md-6">
                                <label for=""class="form-label" >Téléphone :</label> 
                                <input type="Number" readonly class="form-control" value="<?php echo $client["telephone"] ?>">
                              </div>
                              <div class="col-md-6">
                                <label for="" class="form-label">Numéro permis : </label> 
                                <input type="text" readonly class="form-control" value="<?php echo $client["permis"] ?>">
                              </div>
                              <div>
                                <h5>Méthode de payment</h5>
                                <div class="form-check form-check-inline">
                                  <input type="radio" name="payment" value="Carte Bancaire" class="form-check-input" id="bancaire" required>
                                  <label class="form-check-label" for="inlineRadio1">Carte Bancaire</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="payment" checked value="virement espéce" id="espece" required>
                                  <label class="form-check-label" for="inlineRadio1">virement espéce</label>
                              </div>
                              </div>
                             
                              <div class="cont">
                                <div class="stripe">
                                  <script id="scri"></script>
                                </div>
                              </div>
                              <div class="col-md-12" >
                                <button type="submit" name="submitt" class=" btn btn-primary" id="comm">Louer</button> 
                              </div>
                      <?php
                    }
                  ?>
                  </form>
                </div>
            </div>
        </section>
    </div>
    <!-- ____________ end car section ______________ -->

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
        function error(){
            Swal.fire({
            icon: 'error',
            title: 'Attention !!',
            text: "Remplissez les informations complémentaires",
            })
        }
    const timeout = 5000;

    // set a timeout function
    const timeoutFunction = setTimeout(function() {
      // if the page is still loading after the timeout, redirect to a different page or display an error message
      window.location.href = "facture.php";
    }, timeout);

    // add an event listener for when the page finishes loading
    window.addEventListener('load', function() {
      // clear the timeout function since the page has finished loading
      clearTimeout(timeoutFunction);
    });
    
    $("[name='payment']").on("change",function(e){
        if(e.target.id === "espece"){
          $(".stripe").remove();
          $("#comm").css("display","block");
          $("#commm").css("display","block");
          $("#scri").remove();
          $("iframe").remove();
          $("#comm").click(function(){
            $("form").append("<input type='hidden' name='submitt' value='rfer'/>");
            $("form").submit();
          });
          $("#commm").click(function(){
            $("form").append("<input type='hidden' name='submit' value='rfer'/>");
            $("form").submit();
            });
        }else if(e.target.id === "bancaire"){
          if($('[name="phone"]').val() != '' && $('[name="permis"]').val() != '' && $('[name="photo_permis"]').val() != '' && $('[name="photo_cin"]').val() != '' && $('[name="ville"]').val() != ''){
            const stripe = document.createElement('div');
            stripe.classList.add('stripe');
            $(".cont").append(stripe);
            $(".stripe").css("display","block");
            
            const script = document.createElement('script');
            script.setAttribute('id', 'scri');
            script.setAttribute("src","https://checkout.stripe.com/checkout.js")
            script.setAttribute("class","stripe-button");
            script.setAttribute("data-key","pk_test_51N1GANKPXJylR4Zi8oElWbfy79ncHLssJzH93VQ06wbWYqGYX702PDB3CbzkgruljWdabpO5fxSIbiFVPO97R5aD00PSWdTYFS");
            script.setAttribute("data-currency","mad");
            script.setAttribute("data-locale","auto");
            
            $(".stripe").append(script);
            $("#comm").css("display","none");
            $("#commm").css("display","none");
          }else{
            error();
            $('#espece').prop('checked', true);
          };
        }
    });

    // add an event listener to the iframe's document
      var cc = setInterval(function() {
        if($('[name="stripeToken"],[name="stripeTokenType"],[name="stripeEmail"]').length > 0){
          var form = document.querySelector('form');
          HTMLFormElement.prototype.submit.call(form);
          clearInterval(cc);
          // console.log("hahahah");
        };
        // console.log("cc");
      });
     </script>
     <?php
    include "./loading.php"
    ?>
    <script src="../view/javascript/consulter.js"></script>
    <script src="./javascript/main.js"></script>
</html>