<?php
include "../CONTROL/controleur.php";
session_start();
$oi = new Control();
if(isset($_POST["nom"]) && isset($_POST["prenom"])&& isset($_POST["email"])&& isset($_POST["password"])&& isset($_POST["identity"])){
    $oi->ajouter_t($_POST["prenom"],$_POST["nom"],$_POST["identity"],$_POST["email"],$_POST["password"]);
    $re = $oi->insert_client();
    if($re > 0){
      if(isset($_SESSION["bouchon"])){
        echo 1;
      }else{
        echo 2;
      }
    }else{
      echo 0;
    }
}

if(isset($_POST["email"])&& isset($_POST["password"])){
  $_SESSION["login_simple"] = true;
  $r = $oi->loginn_secretaire($_POST["email"], $_POST["password"]);
  $cherche = $r->fetchAll();
  if(count($cherche) > 0) {
      echo 5;
      $_SESSION["permission"] = "oui";
      $_SESSION["email"] = $_POST["email"];
      $_SESSION["password"] = $_POST["password"];
  }
  $r = $oi->loginn_directeur($_POST["email"],$_POST["password"]);
  $cherche = $r->fetchAll();
  if(count($cherche) > 0 ){
      echo 1;
      $_SESSION["autoriser"] = "oui";
      $_SESSION["email"] = $_POST["email"];  
      $_SESSION["password"] = $_POST["password"];
  }else{
      $r = $oi->loginn_client($_POST["email"],$_POST["password"]);
      $cherche = $r->fetchAll();
      if(count($cherche) > 0 ){
          if(isset($_SESSION["bouchon"])){
            echo 3;
          }else if(isset($_SESSION["com"])){ 
            echo 4;
          }else{
            echo 2;
          }
          $_SESSION["connecter"] = true;
          $_SESSION["email"] = $_POST["email"]; 
          $_SESSION["user"] = $cherche[0];
         
      }else{
          echo 0;
          unset($_SESSION["login_simple"]);
      }
    }
  }


if(isset($_GET["mark"])&&isset($_GET['type_carburent'])){
  $c = new Control();
  $tabb = $c->search($_GET["mark"],$_GET['type_carburent']);
    while($row = $tabb->fetch()){
      echo "
      <div class='cars_container'>
        <img src='$row[1]' alt=''>
        <h1>$row[2]</h1>
        <span>$row[5] Dh/day</span>
        <a href='consulter.php?matricule=$row[0]'>Détails</a>
      </div>
      ";
  }
}
if(isset($_GET["prix_un"])&&isset($_GET['prix_deux'])){
  $c = new Control();
  $tabb = $c->min_maxx($_GET["prix_un"],$_GET['prix_deux']);
    while($row = $tabb->fetch()){
      echo "
      <div class='cars_container'>
        <img src='$row[1]' alt=''>
        <h1>$row[2]</h1>
        <span>$row[5] Dh/day</span>
        <a href='consulter.php?matricule=$row[0]'>Détails</a>
      </div>
      ";
  }
}
// ____________________________ start staff_____________________
if(isset($_POST['show_staff'])){
  $staf = new Control();
  $res = $staf->show_staff();
  while($row = $res->fetch()){
    echo "
    <tr>
      
      <td>$row[1]</td>
      <td>$row[2]</td>
      <td>$row[3]</td>
     
      <td>$row[7]</td>
      <td><button  value='$row[0]' onclick='showmodal($row[0])' class='update'>Détails</button><button onclick='showmodal_delet($row[0])' class='delete'>Supprimer</button></td>
    </tr>
    ";
  }
}

if(isset($_POST['id_staff'])){
  $info_staff = new Control();
  $res_info = $info_staff->get_staff_by_id($_POST['id_staff']);
  while($row = $res_info->fetch()){
    echo"
      <input type='hidden'  name='update_id'  value='$row[0]'/>
      <div class='col-md-6'>
        <label class='form-label'>Nom : </label>
        <input type='text' class='form-control' name='update_familyname'  value='$row[1]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Prenom : </label>
        <input type='text' class='form-control' name='update_firstname'  value='$row[2]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Email : </label>
        <input type='text' name='update_email' class='form-control' value='$row[3]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Cin : </label>
        <input type='text' class='form-control' name='update_cin'  value='$row[4]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Horaire : </label>
        <input type='time' class='form-control' name='update_horaire'  step='2' value='$row[5]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Fonctionnalité : </label>
        <input type='text' class='form-control' name='update_functionality'  value='$row[6]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Salaire : </label>
        <input type='text' class='form-control' name='update_salaire'  value='$row[7]'/>
      </div>
      <button  onclick='update_staff_f()' class='btn btn-primary' type='button'>Modifier</button>
    ";
  }
}

if(isset($_POST['id']) && isset($_POST['flname']) && isset($_POST['frname']) && 
  isset($_POST['email']) && isset($_POST['cin']) && isset($_POST['horaire']) && 
  isset($_POST['funcion'])&&$_POST['salaire']) {

  $uf = new Control();
  $rs = $uf->updt_stf($_POST['id'],$_POST['flname'],$_POST['frname'],$_POST['email'],$_POST['cin'],$_POST['horaire'],$_POST['funcion'],$_POST['salaire']);

  if($rs>0){
    echo "updated";
  }else{
    echo "not updated";
  }
}

if(isset($_POST['add_flname']) && isset($_POST['add_frname']) && 
  isset($_POST['add_email']) && isset($_POST['add_cin']) && isset($_POST['add_horaire']) && 
  isset($_POST['add_funcion'])&&isset($_POST['add_Salaire'])) {

    $af = new Control();
    $rsa = $af->add_staff($_POST['add_flname'],$_POST['add_frname'],$_POST['add_email'],$_POST['add_cin'],$_POST['add_horaire'],$_POST['add_funcion'],$_POST['add_Salaire']);
    if($rsa>0){
      echo "added";
    }else{
      echo "not added";
    }
}

if(isset($_POST['id_delete'])){
  $info_staff = new Control();
  $res_info = $info_staff->get_staff_by_id($_POST['id_delete']);
  while($row = $res_info->fetch()){
    echo "<span>Etes-vous sûr que vous voulez supprimer $row[1] $row[2]</span><br><button onclick='delete_staff($row[0])' class='delete_confirm'>Supprimer</button>";
  }
}
if(isset($_POST['id_to_delete'])){
  $df = new Control;
  $res_d = $df->delete_staf($_POST['id_to_delete']);
  if($res_d>0){
    echo "deleted";
  }else{
    echo "not deleted";
  }
}
if(isset($_POST['chercher_un_employe'])){
  $emp = new Control();
  $res = $emp->chercher_employe($_POST['chercher_un_employe']);
  if($res){
    while($row = $res->fetch()){
      echo "
      <tr>
        
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
      
        <td>$row[7]</td>
        <td><button  value='$row[0]' onclick='showmodal($row[0])' class='update'>Détails</button><button onclick='showmodal_delet($row[0])' class='delete'>Supprimer</button></td>
      </tr>
      ";
    }
  }else{
    echo "
    <tr><td>Aucun résultat</td></tr>
    ";
  }
}
// ____________________________ end staff_____________________


// ____________________________ start clients _____________________________

if(isset($_POST['show_client'])){
  $staf = new Control();
  $res = $staf->show_clients();
  while($row = $res->fetch()){
    echo "
    <tr>
      <td>$row[1]</td>
      <td>$row[2]</td>
      <td>$row[3]</td>
      <td>$row[4]</td>
    
      
      <td><button  value='$row[0]' onclick='showmodal($row[0])' class='update'>Détails</button><button onclick='showmodal_delet($row[0])' class='delete'>Supprimer</button></td>
    </tr>
    ";
  }
}


if(isset($_POST['id_client'])){
  $info_staff = new Control();
  $res_info = $info_staff->get_client_by_id($_POST['id_client']);
  while($row = $res_info->fetch()){
    echo"
      <input type='hidden'  name='update_id'  value='$row[0]'/>
      <div class='col-md-6'>
        <label class='form-label'>Nom : </label>
        <input type='text' name='update_nom' class='form-control'  value='$row[1]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Prenom: </label>
        <input type='text' name='update_prenom' class='form-control' value='$row[2]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Carte d'identité : </label>
        <input type='text' name='update_identity_card' class='form-control' value='$row[3]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label'>Email : </label>
        <input type='text' name='update_email' class='form-control' value='$row[4]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >Password : </label>
        <input type='text' name='update_password' class='form-control' value='$row[5]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >Ville : </label>
        <input type='text' name='update_city' class='form-control' value='$row[7]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >N° permis : </label>
        <input type='text' name='update_permis' class='form-control' value='$row[6]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >Tel : </label>
        <input type='text' name='update_tel' class='form-control' value='$row[10]'/>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >Photo cin : </label>
        <input type='file' name='update_photo_cin' required class='form-control' value='$row[8]'/>
      </div>
      <div class='col-md-6'>
        <img src='$row[8]' alt'your browser is not suported'/> | | <a download href='$row[8]'>Telecharger📥</a>
      </div>
      <div class='col-md-6'>
        <label class='form-label' >Photo permis : </label>
        <input type='file' name='update_photo_permis' required class='form-control' value='$row[9]'/>
      </div>
      <div class='col-md-6'>
        <img src='$row[9]' alt'your browser is not suported'/> | | <a download href='$row[9]'>Telecharger📥</a>
      </div>

      
      
      <button name='Modifier_client' class='btn btn-primary' >Modifier</button>
    ";
  }
}

// if(isset($_POST['id_c_u']) && isset($_POST['frname_c_u']) && isset($_POST['flname_c_u']) && isset($_POST['email_c_u']) && isset($_POST['password_c_u'])) {
//     $uc = new Control();
//     $rss = $uc->updt_client($_POST['id_c_u'],$_POST['frname_c_u'],$_POST['flname_c_u'],$_POST['email_c_u'],$_POST['password_c_u']);
//     if($rss>0){
//       echo "updated";
//     }else{
//       echo "not updated";
//     }
//   }   
  if(isset($_POST['id_delete_c'])){
    $info_staff = new Control();
    $res_info = $info_staff->get_client_by_id($_POST['id_delete_c']);
    while($row = $res_info->fetch()){
      echo "<span>Etes-vous sûr que vous voulez supprimer $row[1] $row[2]</span><br><button onclick='delete_staff($row[0])' class='delete_confirm'>Supprimer</button>";
    }
  }
  if(isset($_POST['id_c_to_delete'])){
    $df = new Control;
    $res_d = $df->delete_client($_POST['id_c_to_delete']);
    if($res_d>0){
      echo "deleted";
    }else{
      echo "not deleted";
    }
  }

if(isset($_POST['Modifier_client'])&&isset($_POST['update_id'])&&isset($_POST['update_nom'])
&&isset($_POST['update_prenom'])&&isset($_POST['update_identity_card'])
&&isset($_POST['update_email'])&&isset($_POST['update_password'])
&&isset($_POST['update_city'])&&isset($_POST['update_permis'])&&isset($_POST['update_tel'])&&isset($_FILES['update_photo_cin'])&&isset($_FILES['update_photo_permis'])){
  $id=$_POST['update_id'];
  $nom = $_POST['update_nom'];
  $prenom = $_POST['update_prenom'];
  $identity_card = $_POST['update_identity_card'];
  $email = $_POST['update_email'];
  $password = $_POST['update_password'];
  $city = $_POST['update_city'];
  $permis = $_POST['update_permis'];
  $photo_cin = $_FILES['update_photo_cin'];
  $photo_permis = $_FILES['update_photo_permis'];
  $tel = $_POST['update_tel'];

  $img_loc1 = $_FILES['update_photo_cin']['tmp_name'];
  $img_name1 =  $_FILES['update_photo_cin']['name'];
  $img_desc1 = "Uploaded_images/" .$img_name1;
  move_uploaded_file($img_loc1,'Uploaded_images/'.$img_name1);
  $img_loc2 = $_FILES['update_photo_permis']['tmp_name'];
  $img_name2 =  $_FILES['update_photo_permis']['name'];
  $img_desc2 = "Uploaded_images/" .$img_name2;
  move_uploaded_file($img_loc2,'Uploaded_images/'.$img_name2);

  $c= new Control;
  $r = $c->updt_client($id,$nom,$prenom,$identity_card,$email,$password,$permis,$city,$img_desc1,$img_desc2,$tel);
  if($r>0){
    header("location:manage_clients.php?message=1");
  }else{
    header("location:manage_clients.php?message=2");
  }
}
if(isset($_POST['chercher_un_client'])){
  $c = new Control();
  $res = $c->chercher_client($_POST['chercher_un_client']);
  if($res){
    while($row = $res->fetch()){
      echo "
      <tr>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
        <td>$row[4]</td>
      
        
        <td><button  value='$row[0]' onclick='showmodal($row[0])' class='update'>Détails</button><button onclick='showmodal_delet($row[0])' class='delete'>Supprimer</button></td>
      </tr>
      ";
    }
  }else{
    echo "
    <tr><td>Aucun résultat</td></tr>
    ";
  }
}

// ____________________________ end clients _____________________________


// _______ start car _________________________
if(isset($_POST['Ajouter'])){
  $matricule = $_POST["add_Matricul"];

  $picture1 = $_FILES['add_Image1'];
  $picture2 = $_FILES['add_Image2'];
  $picture3 = $_FILES['add_Image3'];
  $picture4 = $_FILES['add_Image4'];
  $mark = $_POST['add_Mark'];
  $capacity = $_POST['add_Capcity'];
  $model = $_POST['add_Model'];
  $prix = $_POST['add_Prix'];
  $Type_carburant = $_POST['add_Type_carburant'];
  $description = $_POST['add_Description'];
  $Type_voiture = $_POST['add_Type_voiture'];
  $n_chassis =$_POST['add_n_chassis'];
  $km_actuel =$_POST['add_km_actuel'];
  $Couleur = $_POST['add_Couleur'];
  $status =$_POST['add_status'];
  $img_loc = $_FILES['add_Image']['tmp_name'];
  $img_name = $_FILES['add_Image']['name'];
  $img_desc = "Uploaded_images/" .$img_name;
  move_uploaded_file($img_loc,'Uploaded_images/'.$img_name);

  $img_loc1 = $_FILES['add_Image1']['tmp_name'];
  $img_name1 =  $_FILES['add_Image1']['name'];
  $img_desc1 = "Uploaded_images/" .$img_name1;

  $img_loc2 = $_FILES['add_Image2']['tmp_name'];
  $img_name2 =  $_FILES['add_Image2']['name'];
  $img_desc2 = "Uploaded_images/" .$img_name2;

  $img_loc3 = $_FILES['add_Image3']['tmp_name'];
  $img_name3 =  $_FILES['add_Image3']['name'];
  $img_desc3 = "Uploaded_images/" .$img_name3;

  $img_loc4 = $_FILES['add_Image4']['tmp_name'];
  $img_name4 =  $_FILES['add_Image4']['name'];
  $img_desc4 = "Uploaded_images/" .$img_name4;

  $img_loc5 = $_FILES['add_Image5']['tmp_name'];
  $img_name5 =  $_FILES['add_Image5']['name'];
  $img_desc5 = "Uploaded_images/" .$img_name5;

  move_uploaded_file($img_loc1,'Uploaded_images/'.$img_name1);
  move_uploaded_file($img_loc2,'Uploaded_images/'.$img_name2);
  move_uploaded_file($img_loc3,'Uploaded_images/'.$img_name3);
  move_uploaded_file($img_loc4,'Uploaded_images/'.$img_name4);
  move_uploaded_file($img_loc5,'Uploaded_images/'.$img_name5);

  $checklist = $_POST['check_list'];

  $add = new Control;
  $is_added = $add->ajouter_voiture($matricule,$img_desc1,$mark,$capacity,$model,$prix,$Type_carburant,$description,$Type_voiture,$n_chassis,$km_actuel,$Couleur,$status,$img_desc2,$img_desc3,$img_desc4,$img_desc5);
  foreach($_POST['check_list'] as $selected){
    $accessoire = new Control;
    $ajouter_Control = $accessoire->ajouter_accessoire($selected,$matricule);
  }
  if($is_added>0){
    if($_SESSION['permission'] =="oui"){
      header("location:car_management_reservation.php?message=3");
    }else{
      header("location:car_management.php?message=3");
    }
  }else{
    if($_SESSION['permission'] =="oui"){
      header("location:car_management_reservation.php?message=4");
    }else{
      header("location:car_management.php?message=4");
    }
  }
}

if(isset($_POST['show_car'])){
  $staf = new Control();
  $res = $staf->show_cars_table();
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }

  // echo json_encode($res->fetchAll());
  // while($row = $res->fetch()){
  //   echo "
  //   <tr>
  //     <td>$row[0]</td>
  //     <td>$row[2]</td>
  //     <td>$row[3]</td>
     
  //     <td>$row[5]</td>
     
  //     <td><img src='$row[1]' alt='your browser is not suported'/></td>
     
  //     <td><button  value='$row[0]' onclick='showmodal(`$row[0]`)' class='update'>Détails</button> <button onclick='showmodal_delet(`$row[0]`)' class='delete'>Supprimer</button> <button onclick='() => {ShowPapier()}' class='papier' >Papier</button></td>
  //   </tr>
  //   ";
  // }
}

if(isset($_POST['chercher_une_voiture'])){
  $v = new Control();
  $res = $v->chercher_voiture($_POST['chercher_une_voiture']);
  if($res){
    while($row = $res->fetch()){
      echo "
      <tr>
        <td $row[0]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
       
        <td>$row[5]</td>
       
        <td><img src='$row[1]' alt='your browser is not suported'/></td>
       
        <td><button  value='$row[0]' onclick='showmodal(`$row[0]`)' class='update'>Détails</button><button onclick='showmodal_delet(`$row[0]`)' class='delete'>Supprimer</button> </td>
      </tr>
      ";
    }
  }else{
    echo "
    <tr><td>Aucun résultat</td></tr>
    ";
  }
}

if(isset($_POST['matricule'])){
  $info_staff = new Control();
  $res_info = $info_staff->show_cars_by_matricul($_POST['matricule']);
  $aa = new Control();
  $r = $aa->select_accessoires($_POST['matricule']);
  $a="";
  $b="";
  $c="";
  $d="";
  $e="";
  $f="";
  $j="";
  $h="";
  $i="";
  $g="";
  $k="";
  $l="";
  $m="";
  $n="";
  while($rw = $r->fetch()){
    if($rw[1]=="Frein de stationnement électronique"){
      $a = "checked";
    }elseif($rw[1]=="Caméra à 360°"){
      $b = "checked";
    }
    elseif($rw[1]=="Aide au stationnement automatique"){
      $c = "checked";
    }
    elseif($rw[1]=="Assistant de vision nocturne"){
      $d = "checked";
    }
    elseif($rw[1]=="Climatisation automatique"){
      $e = "checked";
    }
    elseif($rw[1]=="Ecran tactile"){
      $f = "checked";
    }
    elseif( $rw[1]=="Vitres électriques anti-pincement"){
      $j = "checked";
    }
    elseif($rw[1]=="Support lombaire réglable"){
      $h = "checked";
    }
    elseif($rw[1]=="Avertissement de vérification du moteur"){
      $i = "checked";
    }
    elseif( $rw[1]=="Compresseur"){
      $g = "checked";
    }
    elseif($rw[1]=="Coussins gonflables à deux phases"){
      $k = "checked";
    }
    elseif($rw[1]=="Commande/contrôle vocal"){
      $l = "checked";
    }
    elseif($rw[1]=="Mode de conduite"){
      $m = "checked";
    }
    elseif($rw[1]=="Régulateur de vitesse adaptatif"){
      $n = "checked";
    }else{
      return "";
    }


  }
  while($row = $res_info->fetch()){
    $diesel = $row[6]=='diesel'?"selected":"";
    $essence = $row[6]=='essence'?"selected":"";
    $disponible = $row[12]=='disponible'?"selected":"";
    $indisponible = $row[12]=='indisponible'?"selected":"";

    echo"
    <div class='col-md-6'>
      <label class='form-label'>Matricule  : </label>
      <input   required value='$row[0]' class='form-control' type='text' readonly name='update_Matricul' required />
    </div>
   
    <div class='col-md-6'>
      <label class='form-label'>Mark : </label>
      <input   required value='$row[2]' class='form-control' type='text' name='update_Mark'required  />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Capcity : </label>
      <input   required value='$row[3]' class='form-control' type='text' name='update_Capcity' required/>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Model : </label>
      <input  required  value='$row[4]' class='form-control' type='text' name='update_Model' required/>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Prix : </label>
      <input   required value='$row[5]' class='form-control' type='text' name='update_Prix' required />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Type carburant : </label>
      <select  class='form-select' name='update_Type_carburant'  aria-label='Default select example'>
        <option {$essence} value='essence'>Essence</option>
        <option {$diesel} value='diesel'>Diesel</option>
      </select>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Description : </label>
      <input   required value='$row[7]' class='form-control' type='text' name='update_Description'required  />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Type voiture : </label>
      <input   required value='$row[8]' class='form-control' type='text' name='update_Type_voiture' required />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>N° chassis : </label>
      <input  required  value='$row[9]' class='form-control' type='text' name='update_n_chassis'required  />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Km actuel : </label>
      <input   required value='$row[10]' class='form-control' type='text' name='update_km_actuel' required />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Couleur: </label>
      <input   required value='$row[11]' class='form-control' type='text' name='update_Couleur' required />
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Status: </label>
    
      <select  class='form-select' name='update_status'  aria-label='Default select example'>
        <option {$disponible} value='disponible'>Disponible</option>
        <option {$indisponible} value='indisponible'>Indisponible</option>
      </select>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Image 1: </label>
      <input  required  value='$row[1]' class='form-control' type='file' name='update_Image1'required />
    </div>
    <div class='col-md-6'>
      <img src='$row[1]'/> | | <a download href='$row[1]'>Telecharger📥</a>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Image 2: </label>
      <input  required  value='$row[13]' class='form-control' type='file' name='update_Image2'required />
    </div>
    <div class='col-md-6'>
      <img src='$row[13]'/> | | <a download href='$row[13]'>Telecharger📥</a>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Image 3: </label>
      <input   required value='$row[14]' class='form-control' type='file' name='update_Image3'required />
    </div>
    <div class='col-md-6'>
      <img src='$row[14]'/> | | <a download href='$row[14]'>Telecharger📥</a>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Image 4: </label>
      <input   required value='$row[15]' class='form-control' type='file' name='update_Image4'required />
    </div>
    <div class='col-md-6'>
      <img src='$row[15]'/> | | <a download href='$row[15]'>Telecharger📥</a>
    </div>
    <div class='col-md-6'>
      <label class='form-label'>Image 5: </label>
      <input   required value='$row[16]' class='form-control' type='file' name='update_Image5'required />
    </div>
    <div class='col-md-6'>
      <img src='$row[16]'/> | | <a download href='$row[16]'>Telecharger📥</a>
    </div>

    <div class='col-md-12'><button id='myBtn_update' type='button' class='btn btn-primary'>Accessoire</button></div>
    <div id='myModal_update' class='modal_update'>
      <div class='modal-content_update'>
        <span class='close_update'>&times;</span>
        <div class='checks-form'>

        
        <div class='form-check '>
        <input class='form-check-input'  {$a}  type='checkbox' value='Frein de stationnement électronique' name='update_check_list[]'  id='flexCheckDefault'>
        <label class='form-check-label' for=''>
          Frein de stationnement électronique
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$b}  type='checkbox' value='Caméra à 360°' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
          Caméra à 360°
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$c}  type='checkbox' value='Aide au stationnement automatique' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
          Aide au stationnement automatique
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$d}  type='checkbox' value='Assistant de vision nocturne' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
          Assistant de vision nocturne
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$e}  type='checkbox' value='Climatisation automatique' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
          Climatisation automatique
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$f}  type='checkbox' value='Ecran tactile' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
          Ecran tactile
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$j}  type='checkbox' value='Vitres électriques anti-pincement' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Vitres électriques anti-pincement
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$h}  type='checkbox' value='Support lombaire réglable' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Support lombaire réglable
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$i}  type='checkbox' value='Avertissement de vérification du moteur' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Avertissement de vérification du moteur
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$g}  type='checkbox' value='Compresseur' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Compresseur
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$k}  type='checkbox' value='Coussins gonflables à deux phases' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Coussins gonflables à deux phases
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$l}  type='checkbox' value='Commande/contrôle vocal' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Commande/contrôle vocal
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$m}  type='checkbox' value='Mode de conduite'  name='update_check_list[]' id=''>
        <label class='form-check-label' for=''>
        Mode de conduite
        </label>
      </div>
      <div class='form-check '>
        <input class='form-check-input'  {$n}  type='checkbox' value='Régulateur de vitesse adaptatif' name='update_check_list[]'  id=''>
        <label class='form-check-label' for=''>
        Régulateur de vitesse adaptatif
        </label>
      </div>
      </div>
      </div>
    </div>
      <button name='modifier' class='btn btn-primary col-md-12'>Modifier</button>
    ";
  }
}
if(isset($_POST['modifier'])){
  $matricule = $_POST["update_Matricul"];
  $picture1 = $_FILES['update_Image1'];
  $picture2 = $_FILES['update_Image2'];
  $picture3 = $_FILES['update_Image3'];
  $picture4 = $_FILES['update_Image4'];
  $mark = $_POST['update_Mark'];
  $capacity = $_POST['update_Capcity'];
  $model = $_POST['update_Model'];
  $prix = $_POST['update_Prix'];
  $Type_carburant = $_POST['update_Type_carburant'];
  $description = $_POST['update_Description'];
  $Type_voiture = $_POST['update_Type_voiture'];
  $n_chassis =$_POST['update_n_chassis'];
  $km_actuel =$_POST['update_km_actuel'];
  $Couleur = $_POST['update_Couleur'];
  $status =$_POST['update_status'];

  $img_loc1 = $_FILES['update_Image1']['tmp_name'];
  $img_name1 =  $_FILES['update_Image1']['name'];
  $img_desc1 = "Uploaded_images/" .$img_name1;

  $img_loc2 = $_FILES['update_Image2']['tmp_name'];
  $img_name2 =  $_FILES['update_Image2']['name'];
  $img_desc2 = "Uploaded_images/" .$img_name2;

  $img_loc3 = $_FILES['update_Image3']['tmp_name'];
  $img_name3 =  $_FILES['update_Image3']['name'];
  $img_desc3 = "Uploaded_images/" .$img_name3;

  $img_loc4 = $_FILES['update_Image4']['tmp_name'];
  $img_name4 =  $_FILES['update_Image4']['name'];
  $img_desc4 = "Uploaded_images/" .$img_name4;

  $img_loc5 = $_FILES['update_Image5']['tmp_name'];
  $img_name5 =  $_FILES['update_Image5']['name'];
  $img_desc5 = "Uploaded_images/" .$img_name5;
  move_uploaded_file($img_loc1,'Uploaded_images/'.$img_name1);
  move_uploaded_file($img_loc2,'Uploaded_images/'.$img_name2);
  move_uploaded_file($img_loc3,'Uploaded_images/'.$img_name3);
  move_uploaded_file($img_loc4,'Uploaded_images/'.$img_name4);
  move_uploaded_file($img_loc5,'Uploaded_images/'.$img_name5);

  $update = new Control;
  $is_updateed = $update->modifier_voiure($matricule,$img_desc1,$mark,$capacity,$model,$prix,$Type_carburant,$description,$Type_voiture,$n_chassis,$km_actuel,$Couleur,$status,$img_desc2,$img_desc3,$img_desc4,$img_desc5);
  $accessoire_supprimer = new Control;
  $accessoire_supprimerr = $accessoire_supprimer->supprimer_accessoire($matricule);
  foreach($_POST['update_check_list'] as $selected){
    $accessoire_update = new Control;
    $accessoire_updateee = $accessoire_update->ajouter_accessoire($selected,$matricule);
  }
  if($is_updateed>0){
    
    if($_SESSION['permission'] =="oui"){
      header("location:car_management_reservation.php?message=1");
    }else{
      header("location:car_management.php?message=1");
    }
  }else{
    if($_SESSION['permission'] =="oui"){
      header("location:car_management_reservation.php?message=2");
    }else{
      header("location:car_management.php?message=2");
    }
  }
  
}
if(isset($_POST['matricule_supprimer'])){
  $info_voiture = new Control();
  $res_info = $info_voiture->show_cars_by_matricul($_POST['matricule_supprimer']);
  while($row = $res_info->fetch()){
    echo "<span>êtes-vous sûr de vouloir supprimer la voiture $row[2]  avec le matricul $row[0]</span><br><button value='$row[0]' class='delete_confirm delete_car'>Supprimer</button>";
  }
}
if(isset($_POST['matricule_to_delete'])){
  $dd = new Control;
  $res_s = $dd->supprimer_accessoire($_POST['matricule_to_delete']);
  $df = new Control;
  $res_d = $df->supprimer_voiture($_POST['matricule_to_delete']);
  if($res_d>0){
    echo "deleted";
  }else{
    echo "notdeleted";
  }; 
}
// _______ end car _________________________

// ---------------------------------------------------------------- reservations ----------------------------------------------------------------

if(isset($_POST['showData'])){
  $c = new Control;
  $r = $c->showReservation();
  // print_r($r);
  if($r == -1){
    echo json_encode(["resp" => false, "message" => "Aucune reservation !"]);
  } else{
    echo json_encode(["resp" => true, "message" => $r]);
  }
}

if(isset($_POST['id_res'])){
  $j = new Control;
  $s = $j->deleteReservation($_POST['id_res']);
  if($s == -1){
    echo "makhdamch";
  }else{
    echo "khdam";
  }
}

if(isset($_POST['id_res_up']) && 
isset($_POST['debut_res']) && 
isset($_POST['fin_res']) && 
isset($_POST['matricule_res']) && 
isset($_POST['idClient_res']) && 
isset($_POST['nom_res']) && 
isset($_POST['prenom_res']) && 
isset($_POST['duree_res']) && 
isset($_POST['price_res']) && 
isset($_POST['modePay_res']) && 
isset($_POST['Dconduct_res']) &&
isset($_POST['prixUni_res'])
){
  $i = new Control;
  $rr = $i->updateReservation($_POST['id_res_up'],$_POST['debut_res'],$_POST['fin_res'],$_POST['matricule_res'],$_POST['idClient_res'],$_POST['nom_res'],$_POST['prenom_res'],$_POST['duree_res'],$_POST['price_res'],$_POST['modePay_res'],$_POST['Dconduct_res'],$_POST['prixUni_res']);
  if($rr == -1){
    echo " makhdamch ";
  }else{
    echo " khdam ";
  }
}




// ____________________ agence _____________________________

if(isset($_POST['show_agence'])){
  $a = new Control;
  $r = $a->agence_info();
  while($row = $r->fetch()){
    echo"
    <tr>
      <td>$row[1]</td>
      <td>$row[2]</td>
      <td>$row[3]</td>
      <td>$row[4]</td>
      <td>$row[5]</td>
      <td><img src='$row[6]'/></td>
      <td>
        <button type='button' onclick='get_info(`$row[0]`)'  class='update'>Details</button>
      </td>
    </tr>
    ";
  }
}

if(isset($_POST['id_agence'])){
  $ad = new Control;
  $rd = $ad->agence_info_by_id($_POST['id_agence']);

  while($row = $rd->fetch()){
    echo "
    <input type='hidden'   class='form-control' value='$row[0]' name='update_id_agence' required />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        Nom d'agence  : 
        </label>
        <input type='text' class='form-control' value='$row[1]' name='update_nom_agence' required />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        ville : 
        </label>
        <input type='text' class='form-control' value='$row[2]' name='update_ville'required  />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        adresse : 
        </label>
        <input type='text' class='form-control'  value='$row[3]' name='update_adresse' required/>
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        tel : 
        </label>
        <input type='text' class='form-control' value='$row[4]' name='update_tel' required/>
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        Email : 
        </label>
        <input type='text' class='form-control' value='$row[5]' name='update_Email' required />
    </div>
    
    <div class='col-md-6'>
        <label class='form-label'>
        IF : 
        </label>
        <input type='text' class='form-control' value='$row[7]' name='update_if' required />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        RC : 
        </label>
        <input type='text' class='form-control' value='$row[8]' name='update_rc' required />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        ICE : 
        </label>
        <input type='text' class='form-control' value='$row[9]' name='update_ice' required />
    </div>
    <div class='col-md-12'>
        <label class='form-label'>
        CNSS : 
        </label>
        <input type='text' class='form-control' value='$row[10]' name='update_cnss' required />
    </div>
    <div class='col-md-6'>
        <label class='form-label'>
        Logo : 
        </label>
        <input type='file' class='form-control' value='$row[6]' name='update_Logo' required />
    </div>
    <div class='col-md-6'>
      <img class='img_logo_ag' src='$row[6]'/>
    </div>
    <button name='Modifier_agence' class='btn btn-primary'>Modifier</button>
    ";
  }
}

if(isset($_POST['Modifier_agence'])&&isset($_POST['update_id_agence'])
&&isset($_POST['update_nom_agence'])&&isset($_POST['update_ville'])
&&isset($_POST['update_adresse'])
&&isset($_POST['update_tel'])&&isset($_POST['update_Email'])
&&isset($_POST['update_if'])&&isset($_POST['update_rc'])
&&isset($_POST['update_ice'])&&isset($_POST['update_cnss'])
&&isset($_FILES['update_Logo'])){
  $logo_loc = $_FILES['update_Logo']['tmp_name'];
  $logo_name =  $_FILES['update_Logo']['name'];
  $logo_desc = 'LOGO/'.$logo_name;
  move_uploaded_file($logo_loc,'LOGO/'.$logo_name);
  $ua = new Control;
  $ru = $ua->update_agence($_POST['update_id_agence'],$_POST['update_nom_agence'],$_POST['update_ville'],$_POST['update_adresse'],$_POST['update_tel'],$_POST['update_Email'],$logo_desc,$_POST['update_if'],$_POST['update_rc'],$_POST['update_ice'],$_POST['update_cnss']);
  if($ru>0){
    header('location:gestion_agence.php?message=1');
  }else{
    header('location:gestion_agence.php?message=2');
  }
}



// __________ reaparations ____________________________
// var_dump($_POST['show_reparation']);
if(isset($_POST['show_reparation'])){
  $rpt = new Control;
  $result = $rpt->reparation_infos();
  $v = new Control;
  $rv = $v->Afficher_v();
  // try{
  // $result = $result->fetchAll();
  // echo json_encode($result);
  // }catch(error $e){
  //   echo json_encode([]);
  // }
  $result = $result ? $result->fetchAll():[];
  $rv = $rv ? $rv->fetchAll():[];
  $data = ["voitures"=>$rv,"reparation"=>$result];
  echo json_encode($data);

}

if(isset($_POST['get_mark_v'])){
  $mv = new Control;
  $rmv = $mv->Afficher_v_by_id($_POST['get_mark_v']);
  while($row = $rmv->fetch()){
    echo "$row[2]";
  }
}


if(isset($_POST['matricul_rep'])&&isset($_POST['mark_rep'])&&isset($_POST['type_reparation'])&&isset($_POST['cout_rep'])&&isset($_POST['date_rep'])){
  $ar = new Control ;
  $ra = $ar->ajouter_reparation($_POST['matricul_rep'],$_POST['mark_rep'],$_POST['type_reparation'],$_POST['cout_rep'],$_POST['date_rep']);
  if($ra>0){
    echo 1;
  }else{
    echo 2;
  }
}

if(isset($_POST['id_rep'])&&isset($_POST['update_matricule'])&&isset($_POST['update_mark'])&&isset($_POST['update_type_reparation'])&&isset($_POST['update_cout'])&&isset($_POST['update_date'])){
  $ur = new Control;
  $rur = $ur->update_rep($_POST['id_rep'],$_POST['update_matricule'],$_POST['update_mark'],$_POST['update_type_reparation'],$_POST['update_cout'],$_POST['update_date']);
  if($rur>0){
    echo "updated";
  }else{
    echo "not_updated";
  }
}

if(isset($_POST['id_delete'])){
  $dr = new Control;
  $rdr = $dr->delete_rep($_POST['id_delete']);
  if($rdr>0){
    echo "deleted";
  }else{
    echo "notdeleted";
  }
}




// ________ profile __________________________

if(isset($_POST["id_client_profile"])){
  $cf = new Control;
  $rcf = $cf->profile_infos_client($_POST["id_client_profile"]);

  $cg = new Control;
  $rcg = $cg->profile_reservations($_POST["id_client_profile"]);

  $v = new Control;
  $rv = $v->Afficher_v();

  $review = new Control;
  $rreview = $review->nombre_commentaies($_POST["id_client_profile"]);

  $infractions = new Control;
  $rinfractions = $infractions->nombre_infractions($_POST["id_client_profile"]);

  
  $ag = new Control;
  $rag = $ag->agence_info();

  $fc = new Control;
  $rfc = $fc->affichage_facture_by_client($_POST["id_client_profile"]);

  $result_client = $rcf ? $rcf->fetchAll():[];
  $result_reservations = $rcg ? $rcg->fetchAll():[];
  $result_voitures = $rv ? $rv->fetchAll():[];
  $nbr_reviews = $rreview ? $rreview->fetchAll():[];
  $nbr_infractions = $rinfractions ? $rinfractions->fetchAll():[];
  $agence = $rag?$rag->fetchAll():[];

  $facture = $rfc?$rfc->fetchAll():[];
  $data = ["client"=>$result_client,"reservations"=>$result_reservations,"voitures"=>$result_voitures,"nbr_reviews"=>$nbr_reviews,"nbr_infractions"=>$nbr_infractions,"agence"=>$agence,"facture"=>$facture];
  echo json_encode($data);
}

if(isset($_POST['id_client_update'])&&isset($_POST['prenom_client_update'])&&isset($_POST['nom_client_update'])&&isset($_POST['ville_client_update'])&&isset($_POST['email_client_update'])&&isset($_POST['password_client_update'])){
  $cu = new Control;
  $rcu = $cu->update_clinet_profile($_POST['id_client_update'],$_POST['prenom_client_update'],$_POST['nom_client_update'],$_POST['ville_client_update'],$_POST['email_client_update'],$_POST['password_client_update']);
  if($rcu>0){
    echo "updated";
  }else{
    echo "not_updated";
  };
}

if(isset($_POST['showStatistic'])){
  $sta = new Control;
  $c = $sta->showStatistic();
  if($c == -1){
    echo json_encode(["message"=>'Nothing to show']);
  }else{
    echo json_encode(["message"=>$c]);
  }
}

/* ------------------------------------------ STATISTIC ------------------------------------------ */

if(isset($_POST['totalGain'])){
  $st = new Control;
  $rst = $st->stGainReserver();
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rst]);
  }
}
if(isset($_POST['totalRes'])){
  $st = new Control;
  $rst = $st->stTotalReservation();
  if($rst == -1){
    echo json_encode(['messagee'=>'nope']);
  }else{
    echo json_encode(['messagee'=>$rst]);
  }
}
if(isset($_POST['totalClient'])){
  $st = new Control;
  $rst = $st->stTotalClient();
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['messageee'=>$rst]);
  }
}
if(isset($_POST['totalClientRes'])){
  $st = new Control;
  $rst = $st->stTotalClientRes();
  if($rst == -1){
    echo json_encode(['messageeee'=>'nope']);
  }else{
    echo json_encode(['messageeee'=>$rst]);
  }
}
if(isset($_POST['totalClientNonRes'])){
  $st = new Control;
  $rst = $st->stTotalClientNonRes();
  if($rst == -1){
    echo json_encode(['messages'=>'nope']);
  }else{
    echo json_encode(['messages'=>$rst]);
  }
}
if(isset($_POST['totalVoiture'])){
  $st = new Control;
  $rst = $st->stTotalVoiture();
  if($rst == -1){
    echo json_encode(['messagess'=>'nope']);
  }else{
    echo json_encode(['messagess'=>$rst]);
  }
}
if(isset($_POST['totalVoitureRes'])){
  $st = new Control;
  $rst = $st->stTotalVoitureRes();
  if($rst == -1){
    echo json_encode(['messagesss'=>'nope']);
  }else{
    echo json_encode(['messagesss'=>$rst]);
  }
}
if(isset($_POST['totalVoitureNonRes'])){
  $st = new Control;
  $rst = $st->stTotalVoitureNonRes();
  if($rst == -1){
    echo json_encode(['messag'=>'nope']);
  }else{
    echo json_encode(['messag'=>$rst]);
  }
}
if(isset($_POST['Employer'])){
  $st = new Control;
  $rst = $st->stEmploye();
  if($rst == -1){
    echo json_encode(['messagt'=>'nope']);
  }else{
    echo json_encode(['messagt'=>$rst]);
  }
}
if(isset($_POST['priceRep'])){
  $st = new Control;
  $rst = $st->stRepartionPrice();
  if($rst == -1){
    echo json_encode(['messagtt'=>'nope']);
  }else{
    echo json_encode(['messagtt'=>$rst]);
  }
}
if(isset($_POST['showStatisticProfile'])){
  $sta = new Control;
  $c = $sta->showProfileStatistic($_POST['showStatisticProfile']);
  if($c == -1){
    echo json_encode(["message"=>'Nothing to show']);
  }else{
    echo json_encode(["message"=>$c]);
  }
}
/* ------------------------------------------ END-STATISTIC ------------------------------------------ */

// -------------------- stripe info ------------------------------------

// ____________________ agence _____________________________

if(isset($_POST['show_stripe'])){
  $a = new Control;
  $r = $a->stripe();
  while($row = $r->fetch()){
    echo"
    <div class='col-md-12'>
        <label for='exampleFormControlTextarea1' class='form-label'>CLÉ SECRETE</label>
        <textarea disabled class='form-control' id='exampleFormControlTextarea1' rows='3'>$row[0]</textarea>
    </div>
    <div class='col-md-12'>
        <label for='exampleFormControlTextarea1' class='form-label'>CLÉ PUBLIQUE</label>
        <textarea disabled class='form-control' id='exampleFormControlTextarea1' rows='3'>$row[1]</textarea>
    </div>
    <button type='button' onclick='get_info(`$row[0]`)'  class='update'>Details</button>
    ";
  }
}

if(isset($_POST['id_agencee'])){
  $ad = new Control;
  $rd = $ad->stripe();

  while($row = $rd->fetch()){
    echo "
    

    <div class='col-md-12'>
        <label for='exampleFormControlTextarea1' class='form-label'>CLÉ SECRETE</label>
        <textarea class='form-control' id='exampleFormControlTextarea1' name='secret_key' rows='3'>$row[0]</textarea>
    </div>
    <div class='col-md-12'>
        <label for='exampleFormControlTextarea1' class='form-label'>CLÉ PUBLIQUE</label>
        <textarea class='form-control' id='exampleFormControlTextarea1' name='public_key'required  rows='3'>$row[1]</textarea>
    </div>
    <button name='Modifier_stripe' class='btn btn-primary'>Modifier</button>
    ";
  }
}

if(isset($_POST['Modifier_stripe'])&&isset($_POST['secret_key'])&&isset($_POST['public_key'])){
 
  $ua = new Control;
  $ru = $ua->update_stripe($_POST['secret_key'],$_POST['public_key']);
  if($ru>0){
    header('location:stripe.php?message=1');  
  }else{
    header('location:stripe.php?message=2');
  }
}

// --------------------- claendrier ------------------------

if(isset($_POST['avant'])&&isset($_POST['apres'])){
  $st = new Control;
  $rst = $st->stGainReserver($_POST['avant'],$_POST['apres']);
  $tt = $st->stTotalReservation($_POST['avant'],$_POST['apres']);
  $totclientres = $st->stTotalClientRes($_POST['avant'],$_POST['apres']);
  $totclientnonres = $st->stTotalClientNonRes($_POST['avant'],$_POST['apres']);
  $totvoires = $st->stTotalVoitureRes($_POST['avant'],$_POST['apres']);
  $totvoinonres = $st->stTotalVoitureNonRes($_POST['avant'],$_POST['apres']);
  $totreparation = $st->stRepartionPrice($_POST['avant'],$_POST['apres']);
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rst,'messagee'=>$tt,'messageeee'=>$totclientres,'messages'=>$totclientnonres,'messagesss'=>$totvoires,'messag'=>$totvoinonres,'messagtt'=>$totreparation]);
  }
 
}

// -----------------NOTIFICATIONS-----------------------

if(isset($_POST['numNotif'])){
  $c = new Control;
  $rst = $c->notificationsIndicator();
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rst]);
  }
}
if(isset($_POST['msgNotif'])){
  $c = new Control;
  $rst = $c->notificationsMessage();
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rst]);
  }
}
if(isset($_POST['seen'])){
  $c = new Control;
  $rst = $c->seen($_POST['seen']);
  if($rst == -1){
    echo json_encode(['message'=>'ohoy']);
  }else{ 
    echo json_encode(['message'=>$rst]);
  }
}
if(isset($_POST['notiff'])){
  $c = new Control;
  $rst = $c->triggerNotif();
  if($rst == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rst]);
  }
}
//------------------------------- CHARGES ---------------------------------
if(isset($_POST['show_ch'])){
  $cc = new Control;
  $rs = $cc->show_charges();
  if($rs == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rs]);
  }
}
if(isset($_POST['select_matricule'])){
  $cc = new Control;
  $rs = $cc->AA_matricule_charges();
  if($rs == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rs]);
  }
}
if(isset($_POST['delete_ch'])){
  $cc = new Control;
  $rs = $cc->delete_charges($_POST['delete_ch']);
  if($rs == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rs]);
  }
}
if(isset($_POST['update']) 
  && isset($_POST['id_ch_updt']) 
  && isset($_POST['matricule_updt'])
  && isset($_POST['datAchat_updt'])
  && isset($_POST['avance_updt'])
  && isset($_POST['reste_udpt'])
  && isset($_POST['prixParMois_updt'])
  && isset($_POST['etat_updt'])
  && isset($_POST['traite_updt'])
  && isset($_POST['prixAssurance_updt'])
  && isset($_POST['dateFinEchehance_updt'])){
  $cc = new Control;
  $rs = $cc->update_charges($_POST['id_ch_updt'],$_POST['matricule_updt'],$_POST['datAchat_updt'],$_POST['avance_updt'],$_POST['reste_udpt'],$_POST['prixParMois_updt'],$_POST['etat_updt'],$_POST['traite_updt'],$_POST['prixAssurance_updt'],$_POST['dateFinEchehance_updt']);
  if($rs == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rs]);
  }
}
if(isset($_POST['add_chh']) 
  && isset($_POST['matricule_ch']) 
  && isset($_POST['dateAchat'])
  && isset($_POST['avance'])
  && isset($_POST['reste'])
  && isset($_POST['prixParMois'])
  && isset($_POST['etat'])
  && isset($_POST['traite'])
  && isset($_POST['prixAssurance'])
  && isset($_POST['dateFinEchehance'])){
  $cc = new Control;
  $rs = $cc->add_charge($_POST['matricule_ch'],$_POST['dateAchat'],$_POST['avance'],$_POST['reste'],$_POST['prixParMois'],$_POST['etat'],$_POST['traite'],$_POST['prixAssurance'],$_POST['dateFinEchehance']);
  if($rs == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$rs]);
  }
}
// ------------------------------- SECRETAIRE ---------------------------------
if(isset($_POST['confirm'])){
  $cc = new Control;
  $res = $cc->confirm($_POST['confirm']);
  if($res == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
// ------------------------------- ADMIN ---------------------------------

if(isset($_POST['confirmAD'])){
  $cc = new Control;
  $res = $cc->confirm($_POST['confirmAD']);
  if($res == -1){
    echo json_encode(['message'=>'nope']);
  }else{
    echo json_encode(['message'=>$res]);
  }
}

if(isset($_POST['numnum'])){
  $c = new Control;
  $res = $c->numReservation();
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
if(isset($_POST['showMAT'])){
  $c = new Control;
  $res = $c->showAlert($_POST['showMAT']);
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
if(isset($_POST['actt'])){
  $c = new Control;
  $res = $c->alerting($_POST['mt'],$_POST['crt'],$_POST['dv'],$_POST['dvt'],$_POST['da'],$_POST['dr']);
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
if(isset($_POST['addMAT'])){
  $c = new Control;
  $res = $c->addAlerting($_POST['crt'],$_POST['dv'],$_POST['dvt'],$_POST['da'],$_POST['dr'],$_POST['addMAT']);
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
if(isset($_POST['showshow'])){
  $c = new Control;
  $res = $c->loading_stats();
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
if(isset($_POST['confirmVoi'])){
  $c = new Control;
  $res = $c->confirm_voiture($_POST['confirmVoi']);
  if($res == -1){
    echo json_encode(['message'=>"nope"]);
  }else{
    echo json_encode(['message'=>$res]);
  }
}
// -------------------------------- ALERTING --------------------------------

