<?php
include "../Control/controleur.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["user"][1]." ".$_SESSION["user"][2]   ?></title>
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script
      src="https://kit.fontawesome.com/dad8a5aed6.js"
      crossorigin="anonymous"
    ></script>
    <script src="../view/javascript/jquery-3.2.0.min.js"></script>
    <script src="../view/javascript/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/LICENSE"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/package.json"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/README.md"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/sweetalert2.d.ts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    
    <!-- <link rel="stylesheet" href="./css/facture.css"> -->



    <link rel="stylesheet" href="../view/css/profile.css">

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

        $("#id_card").keyup(function () {
          regidcard = /^[a-zA-z]{2}[0-9]{6}$/;
          id_card = $("#id_card").val();
          idcardetest = regidcard.test(id_card);
          if (idcardetest == false) {
            $("#id_card").css("color", "red");
            $("#span_idcard").html(
              "Identity card number must be like xx666666"
            );
            $("#span_idcard").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#id_card").css("color", "green");
            $("#span_idcard").html("");
            $("#span_idcard").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
          }
        });

        $("#email").keyup(function () {
          regemail = /^[a-zA-z]{4,15}[0-9]{1,4}@gmail.(com|net|fr)$/;
          email = $("#email").val();
          emailtest = regemail.test(email);
          if (emailtest == false) {
            $("#email").css("color", "red");
            $("#span_email").html(
              "emeil must be like 4-15 litters 1-4 numbers @ gmail.com/net/fr"
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

        $("#password").keyup(function () {
          regpass = /^[A-Za-z0-9]{4,}$/;
          pass = $("#password").val();
          passtest = regpass.test(pass);
          if (passtest == false) {
            $("#password").css("color", "red");
            $("#span_pass").html(
              "password must be 4 characters/numbers or more"
            );
            $("#span_pass").css("color", "#ff004f");
            // $("#span_lastname").css("text-transform", "uppercase");
          } else {
            $("#password").css("color", "green");
            $("#span_pass").html("");
            $("#span_pass").css("color", "white");
            // $("#span_lastname").css("text-transform", "uppercase");
          }
        });

        // $("#submit").click(function () {
        //   if (
        //     lastnametest == true &&
        //     idcardetest == true &&
        //     nametest == true &&
        //     emailtest == true &&
        //     passtest == true 
        //   ) {
        //     $("#submit").attr("type", "submit");
        //   } else {
        //     $("#submit").removeAttr("submit");
        //   }
        // });

        $("#one").click(function(){
            $("#name").removeAttr("readonly")
            $("#submit").removeAttr("hidden")
            $("#name").css("border","1px")
            $("#name").css("border","black")
            $("#name").css("border","solid")
        })
        $("#two").click(function(){
            $("#lastname").removeAttr("readonly")
            $("#submit").removeAttr("hidden")
            $("#lastname").css("border","1px")
            $("#lastname").css("border","black")
            $("#lastname").css("border","solid")
        })
        $("#three").click(function(){
            $("#id_card").removeAttr("readonly")
            $("#submit").removeAttr("hidden")
            $("#id_card").css("border","1px")
            $("#id_card").css("border","black")
            $("#id_card").css("border","solid")
        })
        $("#four").click(function(){
            $("#sex").removeAttr("disabled")
            $("#submit").removeAttr("hidden")
            $("#sex").css("border","1px")
            $("#sex").css("border","black")
            $("#sex").css("border","solid")
        })
        $("#five").click(function(){
            $("#email").removeAttr("readonly")
            $("#submit").removeAttr("hidden")
            $("#email").css("border","1px")
            $("#email").css("border","black")
            $("#email").css("border","solid")
        })
        $("#six").click(function(){
            $("#password").removeAttr("readonly")
            $("#submit").removeAttr("hidden")
            $("#password").css("border","1px")
            $("#password").css("border","black")
            $("#password").css("border","solid")
        });
      });

      
    </script>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
      <!-- ----------navbar--------------- -->
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
          <a  class="cool-link" href="./cars_page.php">Retour</a>
          <a  class="cool-link" href="../CONTROL/deconnexion.php">Déconnexion</a>
        </div>
      </nav>
    </div>
    <!-- ----------navbar--------------- -->
    <div class="stats_container" >
      <div id="reervations_nomber"> 
          <div class="logo_stats">
                <img src="data:image/png;base64,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">
          </div>
          <div class="stats">
              <span>Vos réservations</span> 
              <h1 id="nb_res">0</h1>
          </div>
      </div>
      <div id="reviews_nomber"> 
          <div class="logo_stats">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFZElEQVR4nO2Z31MbRRzAqVX/AH0BfLf1Sej4oqNPQh8strYPTqDTYq0CrUALjEKsTlsLbWQEcdSpU3zq2CqZwnTashsImkCxBZKUKQXUkSmBZi80t5eQaWmHpOXrfM8mE0J+3eWCPuQ7853L3e7e7iff735393s5OVnJSlay8n8Q30DeFr85t95nzi9c144Bjj7FRNNmxslOxk3VTCKNsuJvfCaaNmOdZO9ZNOf1IsSiOS/oH8iDRXNewNeXX5DhwdufYSLdwSRqFDjhgkQhoXLCGSddLpFux7bx3usfyG1AiLCac+szAjAJxmcZJzUCJ/NJBx8fag6tFQvIZ84vREuELOL99YWXNYdgXvoGk+i0aoAoZRKdYl7y+hqYvvwCvzm3TnMIANggcHKEcfpIK4gwDCdBxqke+9B00GshjBsFif6oNUAMd+vEviL7/rJna4mhu8hv6C7apoUlOiM7nHNfgvYTNdBUsRc+r61ISWvfK4Ovmw/hv5/E1cjZSMsgAIKcvFD0Vlog6E7RnbUdq4Y+2gvSw6WUte2rVvjGMgCtnx0AJiaB8ZKmHM0ndow5oa8slwdnc9hgaNAKo7ZRYJIIg1ZLTMVyBGkZt8O3QxZobqoAl9ibcM64JNNr2oXYONFJX7VPBrl6dVCRRRAE9ftrQ3Cs/n24s3AlYTSDBGtN6tbAdSJOJyGQ4eGhlEE6Otqh2TEWhjk98jscqSmX55sQ9f7AIz94742D4CUH04LAfyLRYqcGhJgI6I2/hEFQf7CNQGPVHrh95+Kq9yPEXZ8FGKfOtKzCxN53Ek1GNSD8wX344vhRGWaVZexj8HFlWdy+3F5TiXoQTrrUgCwsSqvufzOdXXXv9nEgJirPF0PLibDWlMcHETg5rwoCd6gCp6ISEL50D0au98Oln+qAcRFmnJMwaPoOpq275Cve43Msx3pYPxJQX7UvEQhPZde8RgR+5aVkK3A0iG3MDOP9u+Dh3A640FkNf89Ow63B/fDYvRMmBvfDjPMP+TmWY72x0f7UQSQKLpFuUgyCZwelIKj9XZVw07Ibhq1G+d56sQFGyAfyVa5rNcrlWC/aFfXJQbZrGnYTgUz9eRMY98Csa0a+n/5rYtUVn2M51gu1CbXXJwFxi/QjFSD0U2ws+q/D4tIUuL19mkStWDoz70wJhHGqVw3yeCUAKAiTDGTW7Yq7PYmlWF+JRZg6EFM1Nn6wLMDjlWUQ/deSgsx7FsA+bg/rxNTkmmeRimXr4FpE1WRXo043y9xkF1SE33iuhbteLMdrLNdSALJJMUjAoXvFd7v1vkc4lzJIIjdK17WYRO4qPgIv29/dEnCUBoOOUgje2A0e9/mMulZKc4Sr2KIE7LoGGeKJ+mbbVLkWulKiSKYkarm9VPlZfXlMVxhw6AIIEXCUrXjc5/5TizB5G295WjGIDDNeVhBw6Or4/OlTmY5aSS3iJQdy0hX8JxinE1oddWNpqL0+BgjjZFKToy4KZgAxERDdCaaBcAC2G/8mH5Ss6iHFdtge39NUsTcaIuiS6KuaQIRhONVHg7Qfr4Y+cjkta4TU1Is5stqokEs/ydFa4iXoOpprFSXoYmnjh3ugo+UQzLsvR4RbeiZoLysJOHT+oF23TWMY48ZomIwop2ewLwSQQWyl6WUXY8PABswAxpozmiSxpQy4UyLBDCBGFA0hbmk+sRXlvbzkIC5Y6gGoE9cJzUJsKnKy583nT3UX17UZtz4X+RwH4fKStwVOf2acelIYvAf3TpirUr1ipyOGnuJ6Q08xIEyiOeTy9L6I3xRlaz35GIq/8TyBZRn/kJNM0BKG7qLD0RbJSlaykpWc9ZJ/AOT106qkCCHEAAAAAElFTkSuQmCC">
        </div>
        <div class="stats">
          <span>Vos commentaires</span>
          <h1 id="nb_comments">0</h1>
          </div>
      </div>
      <div id="infactions_nomber"> 
          <div class="logo_stats">
                <img src="data:image/png;base64,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">
        </div>
        <div class="stats">
          <span>Vos infractions</span>
          <h1 id="nb_infractions">0</h1>
          </div>
      </div>
    </div>



    <div id="chartbar">
        <canvas id="myChartbar" ></canvas>
    </div>



    <div class="infos_btn">
      <button id="myBtn">
        <div> 
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACAElEQVR4nO2X30ocMRTGY32ESvsI+gq9sWTAPoCorSaaiOAzVEycxItCcxbqtWvRa++F1huhFnwEF/a6gjeuxd74B0fOuK6VonV2djdZyAcfDExm5vclJ8MJIVFRUVF/i7L0HWV2I+GmRpn5g86vuaniPRKq3k6nIwk3PxNus6dMmd3HsSQkJTOWUm5O/wffCoFjZywlIQhnswh8y8w2gliJ55TNEz4gJBvwBo+bsgR8c0943NgJN19LB+Cm6jNArWyAhJuaxwD2rHwAe9bXASi3vz0G6PMSonnLULqE1j0G6PPfKIpyu1fiF/qDBNHEMdsoHIDZBmWrw6Qfm7k8cCjN3IOmjtn955RNMDP/6IGGm2rC7eH9gcYeBn+giYoqodmPn15KBeNSwReh3DehXF1qOBHaXaDza+XqeA/H4Fh8hvjU5OT24LyCCaFhRyi4lBqyIsZnhIYdfEeapi96iJ4NyJXP75uzXAj68TCuPqdgquvoC0trr4Vyu50Cl//6O0/hVVfg55ZhVCj41UX4LLdyx1JXxjoKLxR8aKfO2y8puMRvdgR+fqUyLbW76hW8bNldlQ4xq90bqeC89/BwuxLaXWDptgW/mFaGpHZHvuDl/UocIUvhAEK5Lf/wcOfNwgGkdtcBgGfNVbhuI4BvaHjgGEDGFYBYQlFRUVEkON0ALPjAaNhK0IAAAAAASUVORK5CYII=">        </div>
        <div class="animated_div"><span id="thespan">Vos informations <i class="fa-solid fa-caret-right"></i></span></div>
      </button>
    </div>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close"><span>&times;</span></span>
          <form class="row g-3" action="" name="form_client_infos" method="post">
            <input type="hidden" id="idclient" value="<?php echo $_SESSION["user"][0]?>"   name="id">
          <div class="col-md-6">
            <label class="form-label">Prénom : </label>
            <input class="form-control" required pattern="^[a-zA-z][^0-9]{2,}$" type="text" id="name"  name="name" />
            <span id="span_name"></span> 
          </div>

          <div class="col-md-6">
            <label class="form-label">Nom : </label>
            <input  pattern="^[a-zA-z][^0-9]{2,}$" class="form-control" required type="text" id="lastname"  name="lastname" />
            <span id="span_lastname"></span>
          </div>
          <div class="col-md-6">
                <label for="" class="form-label"> Ville</label>
                <input type="text" name="ville" id="ville" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email :</label>
            <input  required class="form-control" pattern="^[a-zA-z]{4,15}[0-9]{1,4}@gmail.(com|net|fr)$" type="email" id="email"  name="email" />
            <span id="span_email"></span>
          </div>
          <div class="col-md-6">
            <label class="form-label">Mot de passe </label>
            <div class="col-md-12" id='show-hide-password'>
              <input  required pattern="^[A-Za-z0-9]{4,}$" class="form-control"  type="password" id="password"  name="password" /><span id="eye"><i id="open-eye" class="fa-regular fa-eye"></i></span>
            </div>
            <span id="span_pass"></span>
          </div>
          <div class="form_buttons">
            <button class="btn btn-primary" type="button" id="update_btn_client"> Modifier</button>
          </div>
        </form>
        </div>
      </div>
    <!-- --------------form update___________________ -->
    <div id="myModal2" class="modal2">
        <div class="modal-content2">
          <span class="close2"><span>&times;</span></span>
          <form class="row g-3" id="details_form">
            <div class="col-md-6">
              <label class="form-label">Date de début : </label>
              <input type="text" id="date_debut" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date de fin : </label>
              <input type="text"    id="date_fin"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Matricule de voiture : </label>
              <input type="text"    id="matricule"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Marque de voiture : </label>
              <input type="text"    id="marque"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Durée : </label>
              <input type="text"    id="duree"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prix : </label>
              <input type="text"  id="prix"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">2éme conducteur : </label>
              <input type="text"    id="2conducteur"  class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Prix unitaire : </label>
              <input type="text"   id="Prix_unitaire"   class="form-control" readonly>
            </div>
          </form>
        </div>
    </div>
    
    <!-- __________________ table ____________________ -->
  
    <table id = "reservations">
      <thead>
        <tr>
          <th>Date de début</th>
          <th>Date de fin</th>
          <!-- <th>Matricule de voiture</th> -->
          <th>Durée</th>
          <th>Prix</th>
          <!-- <th>2éme conducteur</th> -->
          <!-- <th>Prix unitaire</th> -->
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
        
      </tbody>
    </table>
    <!-- __________________ table ____________________ -->

    <!-- ____________ start  facture model _______________________ -->
    <div class="container_facture_container">
    <div class="facture_container">
            <div class="logo_et_facture">
              <?php 
              $n = new Control; 
              $r = $n->agence_info(); 
              while($row=$r->fetch()){
              echo "<img src='$row[6]' alt='' />";
              } 
            ?>
                <h1>Facture</h1>
            </div>

            <div class="adresse">
              
                <span id="ad1"></span>
                <span id="ad2"></span>
                <span id="ad3"></span>
                <span id="ad4"></span>
            </div>
            <div class="client_infos">
                <div class="client_infos_container">
                    <div class="search_client">
                        <span id='client_name' class="client_name"></span>
                    </div>
                    <div class="adresse_client">
                        <span id="adresse"></span>
                    </div>
                </div>
            </div>
            <div class="tables">
                <table class="table1">
                    <tr>
                        <th>N° Facture</th>
                        <th>Date Facture</th>
                    </tr>
                    <tr class="fac">
                        <td id="fac1"></td>
                        <td id="fac2"></td>
                    </tr>
                </table>
                <div class="Intitule">
                    Intitule :
                    <span id="int"></span
                    >
                </div>
                <table class="table_infos">
                    <tr>
                        <th>Matricule</th>
                        <th>Quantité</th>
                        <th>Durée</th>
                        <th>P.U. (HT)</th>
                        <th>Montant (HT)</th>
                    </tr>
                    <tbody>
                        <tr class="HT">
                            <td id="ht1" class="intitul"></td>
                            <td id="ht2"></td>
                            <td id="ht5"></td>
                            <td id="ht3"></td>
                            <td id="ht4"></td>
                        </tr>
                        <tr class="HT">
                            <td class="intitul"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                      
                        </tr>
                        <tr class="HT">
                            <td class="intitul"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          
                        </tr>
                    </tbody>
                </table>
                <div class="total">
                    <table class="table_total">
                        <tr>
                            <td>Total HT</td>
                            <td id="HT"></td>
                        </tr>
                        <tr>
                            <td>TVA (20%)</td>
                            <td id="TVA"></td>
                        </tr>
                        <tr>
                            <td>Total TTC</td>
                            <td id="totalTTC"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <span
                    >WLC - ICE : <div id="ad5"></div> - Patente : 1236987 - RC :
                    <div id="ad6"></div>- IF : <div id="ad7"></div></span
                >
            </div>
        </div>
    </div>
    <!-- ____________ end  facture model _______________________ -->
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
    <?php
    include "./loading.php"
    ?>
    <script src="./javascript/profile.js"></script>
    <script src="./javascript/main.js"></script>
    
</body>
</html>