<?php
    include "../CONTROL/controleur.php";
    session_start();
if($_SESSION["permission"] != "oui") {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/css/admin_page.css">
    <title>Gestion des réparations</title>
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
<body>
    <!-- _____________________nav ______________________ -->
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
                <a class="cool-link"  href="secretaire.php">Retour</a>
            </div>
            </nav>
        </div>
        <!-- ___________________ nav ____________________ -->
        <!-- ________________table_container__________________________ -->
        <div class="add_container">
            <button id="myBtn2" class="add">Ajouter une réparation</button>
            <div class="sreach_keyup">
            <form  method="post">
              <input type="text" id="chercher_une_reparation" placeholder="Chercher une réparation 🔎">
            </form>
        </div>
        </div>
        <div class="search_date">
            <!-- <span>Chercher par date</span> -->
            <form action="" method="post">
                <div class="search_inputs_date">
                    <input type="date" name="date_debut" id="date_debut"/>
                    <input type="date" name="date_fin" id="date_fin"/>
                </div>
                <button class="button_search_date" id='button_search_date' type="button">Chercher</button>
                <button class="all_data" id='all_data' type="button">Toutes les données</button>
            </form>
        </div>
        <span style="display:none" id="message"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></span>
        <div class="table_container">
            <table style="overflow-x: scroll;" >
                <thead>
                    <tr>
                        <th>Matricule de voiture</th>
                        <th>Marque</th>
                        <th>Type de reparation</th>
                        <th>Coût de reparation</th>
                        <th>Date de reparation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
        <!-- ________________table_container__________________________ -->
        <!-- ________________ add _modal _____________________ -->
        <div id="myModal2" class="modal2">
            <div class="modal-content2">
            <span class="close2">&times;</span>
            <h1>Ajouter une réparation</h1>
                <form class="row g-3" name="Ajout_form" id="myform" action="action.php" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label class="form-label">
                        Matricule  : 
                        </label>
                        <div class="col-md-12" id="search_car">
                            <input type='text' id="matricule_v_search" class="form-control" name='add_matricule' required  />
                            <div class="col-md-12" id="result_search">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        Marque : 
                        </label>
                        <input type='text' id="mark_v" readonly class="form-control" name='add_mark' required  />
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">
                        Type de réparation : 
                        </label>
                        <!-- <input type='text' class="form-control"  required/> -->
                        <textarea class="form-control" required id="exampleFormControlTextarea1" name='add_type_reparation' rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        Coût de réparation : 
                        </label>
                        <input type='number'  class="form-control" name='add_cout' required  />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                        Date de réparation : 
                        </label>
                        <input type='date'  class="form-control" name='add_date' required  />
                    </div>
                    <button name="Ajouter" id='ajouter_rep' type="button" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- ________________ update_______________________________________ -->
        <div id="myModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Modifier l'agence</h1>
            <form id="myform_update_a" name="update_form" method="post"  class="row g-3">
                <input type="hidden" name="id_rep" id="id_rep">
                <div class="col-md-6">
                    <label class="form-label">
                    Matricule  : 
                    </label>
                    <div  id="search_car_update">
                        <input type='text' id="matricule_v_search_update" class="form-control" name='update_matricule' required  />
                        <div id="update_result_search">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                    Marque : 
                    </label>
                    <input type='text' id="mark_v_uapdate" readonly class="form-control" name='update_mark' required  />
                </div>
                <div class="col-md-12">
                    <label class="form-label">
                    Type de réparation : 
                    </label>
                    <!-- <input type='text' class="form-control"  required/> -->
                    <textarea class="form-control" required id="type_rep" name='update_type_reparation' rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                    Coût de réparation : 
                    </label>
                    <input type='number' id="cout_rep_update" class="form-control" name='update_cout' required  />
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                    Date de réparation : 
                    </label>
                    <input type='date' id="dete_rep_update"  class="form-control" name='update_date' required  />
                </div>
                <button name="Ajouter" id='update_rep' type="button" class="btn btn-primary">Modifier</button>
            </form>
            </div>
        </div>
        <script src="javascript/gestion_raparations.js"></script>
    </body>
    <?php
    include "./loading.php"
    ?>
    <script src="./javascript/main.js"></script>
</html>