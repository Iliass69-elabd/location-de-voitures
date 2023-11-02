<?php
include '../CONTROL/controleur.php';
$c = new Control;

session_start();
$voiture = null;
if($_SESSION["connecter"] != true){
  header("location:index.php");
  exit();
}
$facture = $c->affichage_facture();
$affiche = $facture->fetch();
$agence = $c->agence_info();
$a = $agence->fetch();
  
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
    <link rel="stylesheet" href="./css/facture.css"/>
    <title>Facture</title>
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link rel="stylesheet" href="./css/payment.css">
    <script src="https://kit.fontawesome.com/dad8a5aed6.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js" integrity="sha512-oa6kn7l/guSfv94d8YmJLcn/s3Km4mm/t4RqFqyorSMXkKlg6pFM6HmLXsJvOP/Cl/dv/N5xW7zuaA+paSc55Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js" integrity="sha512-OxXHRCrHZMOqbrhaUX+wMD4pRxO+Ym5CKOf0qsPkBTeBOXBjAKirtaTH87wKgEikZBPOMQPOEqE/3fpWa1wiuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js" integrity="sha512-sn/GHTj+FCxK5wam7k9w4gPPm6zss4Zwl/X9wgrvGMFbnedR8lTUSLdsolDRBRzsX6N+YgG6OWyvn9qaFVXH9w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/main.css">
    </head>
<body onload="load()">
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
          <a  class="cool-link" href="./cars_page.php">Acceuil</a>
          <a class="cool-links" href="../CONTROL/deconnexion.php">Déconnexion</a>
        </div>
          <?php
          }?>
      </nav>
    </div>
    <!-- ____________ end nav bar ________________ -->

    <!-- _____________ start facturation __________________ -->
        <div>
        <body>
        <button class="imprimer" id="imprimer" >Imprimer</button>
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
              
                <span><?php echo $a[3]?></span>
                <span><?php echo $a[2]?></span>
                <span><?php echo $a[4]?></span>
                <span><?php echo $a[5]?></span>
            </div>
            <div class="client_infos">
                <div class="client_infos_container">
                    <div class="search_client">
                        <span class="client_name"><?php echo $_SESSION["user"][2]." ".$_SESSION["user"][1]?></span>
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
                        <th>Date de Facture</th>
                    </tr>
                    <tr class="fac">
                        <td><?php echo $affiche[0]?></td>
                        <td><?php echo $affiche[1] ?></td>
                    </tr>
                </table>
                <div class="Intitule">
                    Intitulé :
                    <span><?php echo $affiche[3] ?></span
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
                            <td class="intitul"><?php echo $affiche[14] ?></td>
                            <td><?php echo $affiche[4] ?></td>
                            <td><?php echo $affiche[5] ?></td>
                            <td><?php echo $affiche[22].".00"?></td>
                            <td><?php echo $affiche[7].".00" ?></td>
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
                            <td id="HT"><?php echo $affiche[7].".00" ?></td>
                        </tr>
                        <tr>
                            <td>TVA (20%)</td>
                            <td id="TVA"><?php echo $affiche[8].".00"?></td>
                        </tr>
                        <tr>
                            <td>Total TTC</td>
                            <td id="totalTTC"><?php echo $affiche[9].".00" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <span
                    >WLC - ICE : <?php echo $a[9]?> - Patente : 1236987 - RC :
                    <?php echo $a[8]?> - IF : <?php echo $a[7]?></span
                >
            </div>
        </div> 
        </div>
    <!-- ________ ______________ -->
    <div class="hide-facture">
      <?php 
            $n = new Control; 
            $r = $n->agence_info(); 
            while($row=$r->fetch()){
            echo "<img src='$row[6]' alt='' />";
            } 
          ?>
      <h1>Merci pour votre réservation</h1>
      <a href="./cars_page.php"><i class="fa-solid fa-arrow-left"></i> Retour à la page d'accueil</a>
    </div>
</body>
<script>
    
    </script>
    <script src="../view/javascript/consulter.js"></script>
    <?php
    include "./loading.php"
    ?>
    <script src="./javascript/main.js"></script>
    
</html>