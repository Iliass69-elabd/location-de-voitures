<?php

    include "../CONTROL/controleur.php";
    session_start();
    if($_SESSION["permission"] != "oui"){
        header("location:index.php");
        exit();
    }
    $c = new Control;
    $rr = $c->contrat_info($_GET["id_res"]) ;
    $contrat = $rr->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat</title>
    <link rel="stylesheet" href="css/admin_page.css"/>
    <link href="./css/contrat.css" rel="stylesheet"/>
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="https://cdn-icons-png.flaticon.com/512/4128/4128047.png"
    />
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
    <!-- <nav> -->
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
                    <a class="cool-link"  href="./manage_reservation_secretaire.php">Retour</a>
                </div>
                </nav>
            </div>
    <!-- </nav> -->

    <button class="imprimer" onclick="window.print()">Imprimer</button>
    <section class="contrat">
        <div class="logo_contrat">
                    <?php 
                        $n = new Control; 
                        $r = $n->agence_info(); 
                        while($row=$r->fetch()){
                        echo "<img src='$row[6]' alt='' />";
                        } 
                    ?>
        </div>
        <div class="contrat_head">
            <span>Contrat de location d’une voiture </span>
        </div>
        <div class="SOUSSIGNES">
            <span class="s1">ENTRE LES SOUSSIGNES, </span>
            <span class="s2">La société 
                <span>
                    <?php $n = new Control; $r = $n->agence_info(); while($row=$r->fetch()){
                    echo $row[1];} ?>
                </span>,</span>
            <span class="s3">Monsieur 
                <span id="directeur_c"> 
                    <?php $d = new Control; $r = $d->directeur_info(); while($row=$r->fetch()){
                    echo $row[1]." ".$row[2];} ?>
                </span>
                en sa qualité de directeur,  </span>
            <span class="s4">Appelé ci-après le <strong>loueur</strong>,  </span>
            <span class="s5">ET </span>
            <span class="s6">Mr/Mme <span id="client_c"><?php echo $contrat["nom_client"].' '.$contrat["prenom_client"] ?></span> </span>
            <span class="s7">Appelé ci-après le <strong>locataire</strong>, </span>
        </div>
        <p class="p1">IL A ETE CONVENU CE QUI SUIT: </p>
        <div class="c1">
            <strong class="p_titles">1.1 - Nature et date d'effet du contrat</strong>
            <p>
                Le loueur met à disposition du locataire, un véhicule de marque <span><?php echo $contrat["mark_voi"]?></span> , immatriculé 
                <span><?php echo $contrat["matricul"]?></span> , à titre onéreux et à compter du  <span><?php echo $contrat["debut_res"]?></span> jusqu'au <?php echo $contrat["fin_res"]?> . 
                Kilométrage du véhicule :  <span><?php echo $contrat["km_actuel"]?></span>  kms
            </p>
        </div>
        <div class="c2 c_containers">
            <strong class="p_titles">1.2 - Etat du véhicule</strong>
            <p>
            Lors de la remise du véhicule et lors de sa restitution, un procès-verbal de l'état du véhicule sera établi 
            entre le locataire et le loueur. <br>
            Le véhicule devra être restitué le même état que lors de sa remise. Toutes les détériorations sur le 
            véhicule constatées sur le PV de sortie seront à la charge du locataire. <br>
            Le locataire certifie être en possession du permis l'autorisant à conduire le présent véhicule
            </p>
        </div>
        <div class="c3 c_containers">
            <strong class="p_titles">1.3 - Prix de la location du de la voiture</strong>
            <p>
                Les parties s'entendent sur un prix de location <span><?php echo $contrat["prix_unitaire"]?></span> MAD par jour (calendaires). 
            </p>
        </div>
      
        <div class="c5 c_containers">
            <strong class="p_titles">1.5 - Durée et restitution de la voiture </strong>
            <p>
                Le contrat est à durée indéterminée. Il pourra y être mis fin par chacune des parties à tout moment en
                adressant un courrier recommandé en respectant un préavis d'un mois.
            </p>
        </div>
        <div class="c6 c_containers">
            <strong class="p_titles">1.6 - Autres éléments et accessoires</strong>
            <p>
                Le locataire prendra en charge l'ensemble des charges afférentes à la mise à disposition du véhicule :
                <ul>
                    <li>-   Frais d'entretien du véhicule, </li>
                    <li>-   Impôts et taxes liés au véhicule, </li>
                    <li>-   Les frais d'essence, </li>
                    <li>-   L'assurance du véhicule. </li>
                </ul>
            </p>
        </div>
        <div class="c7 c_containers">
            <strong class="p_titles">1.7 - Clause en cas de litige</strong>
            <p>

            Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat 
            relèvera de la compétence du tribunal de commerce 
            fait en deux exemplaires originaux remis à chacune des parties,
            <br>
            <br>
            <p>
                Fait en deux exemplaires originaux remis à chacune des parties, <br>
                A <span class="ville">
                     <?php $n = new Control; $r = $n->agence_info(); while($row=$r->fetch()){
                    echo $row[2];} ?>
                    </span>,le <span><?php echo date("Y-m-d")?></span>
            </p>
           
            </p>
        </div>
        <div class="c8 c_containers" >
            <table class="table_s">
                <thead>
                    <tr>
                        <th>
                            Le locataire 
                        </th>
                        <th>
                            Le loueur 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            signature précédée de la mention manuscrite
                            bon pour accord
                        </td>
                        <td>
                        signature précédée de la mention manuscrite 
                        bon pour accord
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <div class="hide-contrat">
      <?php 
            $n = new Control; 
            $r = $n->agence_info(); 
            while($row=$r->fetch()){
            echo "<img src='$row[6]' alt='' />";
            } 
          ?>
      <h1>Le contrat est enregistré avec succés</h1>
      <a href="./manage_reservation_secretaire.php" class="fa-solid fa-arrow-left"></i> Retour </a>
    </div>
</body>
<?php
    include "./loading.php"
    ?>
      <script>
        $(document).ready(function(){
            var facture = document.querySelector(".contrat");
            html2pdf().from(facture).save("contrat.pdf");
        })
    </script>
<script src="./javascript/main.js"></script>
</html>