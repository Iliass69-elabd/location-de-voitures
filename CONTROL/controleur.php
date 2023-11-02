<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

include "../MODEL/db.php";
include "../MODEL/client.php";
include "../MODEL/directeur.php";
include "../MODEL/employe.php";
include "../MODEL/voiture.php";
include "../MODEL/reservation.php";

class Control{
    public $cpt = 0;
    public $data = "wlc";
    public $t = array();
    public function loginn_client($email,$pass){
        $c = new Db();
        $r = $c->selectdb("SELECT * FROM client where '$email' = email_client  and '$pass' = password_client ",$this->data);
        return $r;
    }
    public function login_google($tok){
        $c = new Db();
        $r = $c->selectdb("SELECT * FROM client where '$tok' = token ",$this->data);
        return $r;
    }
    public function loginn_directeur($email,$pass){
        $c = new Db();
        $r = $c->selectdb("SELECT * FROM directeur where '$email' = email_dir  and '$pass'= password_dir  ",$this->data);
        return $r;
        
    }
    public function loginn_secretaire($email,$pass){
        $c = new Db();
        $r = $c->selectdb("SELECT * FROM secretaire where '$email' = email_sec  and '$pass'= password_sec  ",$this->data);
        return $r;
        
    }
   
   
    // _________________________start staff management__________________________________
    
    public function show_staff(){
        $stf = new  Db();
        $res = $stf->selectdb("SELECT * FROM employee",$this->data);
        return $res;
    }
    public function get_staff_by_id($id){
        $stf = new  Db();
        $res = $stf->selectdb("SELECT * FROM employee WHERE	id_emp=$id",$this->data);
        return $res;
    }
    public function updt_stf($id,$flname,$frname,$email,$cin,$horaire,$funcion,$salire){
        $stf_updt = new Db();
        $res_updt = $stf_updt->misajourdb("UPDATE `employee` SET `family_name_emp`='$flname',`first_name_emp`='$frname',`email_emp`='$email',`cin_emp`='$cin',`horrair_emp`='$horaire',`fonctionality`='$funcion',`salaire`=$salire Where id_emp=$id ",$this->data);
        return $res_updt;
    }
    public function add_staff($flname,$frname,$email,$cin,$horaire,$funcion,$salire){
        $stf_add = new Db;
        $res_add = $stf_add->misajourdb("INSERT INTO `employee`( `family_name_emp`, `first_name_emp`, `email_emp`, `cin_emp`, `horrair_emp`, `fonctionality`,`salaire`) VALUES ('$flname','$frname','$email','$cin','$horaire','$funcion',$salire)",$this->data);
        return $res_add;
    }
    public function delete_staf($id){
        $stf_delete = new Db;
        $res_del = $stf_delete->misajourdb("DELETE from employee Where id_emp=$id",$this->data);
        return $res_del;
    }
    public function chercher_employe($empc){
        $emp = new Db;
        $remp = $emp->selectProcedure("chercher_employe('$empc')",$this->data);
        return $remp;
  }
     // _________________________end staff management__________________________________

    // _________________start clients management _____________________
    public function ajouter_t($first,$last,$iden,$email,$pass){
        $c = new Client($first,$last,$iden,$email,$pass);
        $this->t[$this->cpt] = $c;
        $this->cpt++;

    }   
    public function insert_client(){
        for ($i=0; $i <$this->cpt ; $i++) { 
            $first = $this->t[$i]->getFirstNameClient();
            $last = $this->t[$i]->getFamilyNameClient();
            $email = $this->t[$i]->getEmailClient();
            $pass = $this->t[$i]->getPasswordClient();
            $iden = $this->t[$i]->getIdentity();
            $c = new Db();
            $r = $c->misajourdb("INSERT INTO client(nom_client,prenom_client,identity_card,email_client,password_client) VALUES ('$first','$last','$iden','$email','$pass')",$this->data);
            return $r;
        }
    }
   
    public function nom_client(){
        $email2= $_SESSION['email'];
        $c = new Db;
        $r = $c->selectdb("SELECT * FROM `client` where `email_client`='$email2'",$this->data);
        while ($row=  $r->fetch()){
            echo $row['first_name_client'] ;
        }
    }
    public function show_clients(){
        $stf = new  Db();
        $res = $stf->selectdb("SELECT * FROM client",$this->data);
        return $res;
    }
    public function get_client_by_id($id){
        $stf = new  Db();
        $res = $stf->selectdb("SELECT * FROM client WHERE id_client=$id",$this->data);
        return $res;
    }
    public function updt_client($id,$nom,$prenom,$identity_card,$email,$password,$permis,$ville,$photo_cin,$photo_permis,$tel){
        $cl_updt = new Db();
        $res_updt_c = $cl_updt->misajourdb("UPDATE `client` SET `nom_client`='$nom',`prenom_client`='$prenom',`identity_card`='$identity_card',`email_client`='$email',`password_client`='$password',`permis`='$permis',`ville`='$ville',`phote_cin`='$photo_cin',`photo_permis`='$photo_permis',`telephone`='$tel' WHERE `id_client` = $id",$this->data);
        return $res_updt_c;
    }
    public function delete_client($id){
        $stf_delete = new Db;
        $res_del = $stf_delete->misajourdb("DELETE from client Where id_client=$id",$this->data);
        return $res_del;
    }
    public function chercher_client($ct){
        $c = new Db;
        $rc = $c->selectProcedure("chercher_client('$ct')",$this->data);
        return $rc;
  }
    // _________________end clients management_____________________

    // _____________ start cars _________________________
    public function min_maxx($prix_un,$prix_deux){
        $c = new Db();
        if($prix_un === "" || $prix_deux === "" ){
            $r = $c->selectdb("SELECT * FROM voiture WHERE status_voi = 'disponible'",$this->data);
            return $r;
        }
        $tabb = $c->selectdb("SELECT * from voiture WHERE price BETWEEN '$prix_un' and '$prix_deux' ",$this->data);
        return $tabb;
    }
    public function search($model_mark,$type_carb){
        $c = new Db();
        if($type_carb !== "tout"){
            $tabb = $c->selectdb("SELECT * FROM voiture WHERE  (model_voi LIKE '%$model_mark%' OR mark_voi  LIKE '%$model_mark%') and type_carburent='$type_carb'",$this->data);
            return $tabb;
        }else{
            $tabb = $c->selectdb("SELECT * FROM voiture WHERE  (model_voi LIKE '%$model_mark%' OR mark_voi  LIKE '%$model_mark%') ",$this->data);
            return $tabb;
        }
        $tabb = $c->selectdb("SELECT * FROM voiture",$this->data);
        return $tabb;
    }
    public function affichage_voiture(){
        $c = new Db;
        // $new_pic = $c->selectdb("SELECT duree,matricule_voiture_reserver FROM reserver ",$this->data);
        $solution = $c->selectProcedure("dispo_voi()",$this->data);
        $pic = $c->selectdb("SELECT * FROM voiture ",$this->data); // modif here
        $nrow = $solution->fetchAll();
        if($solution){
            // echo $solution->fetch();
            if ($pic) {
                foreach ($nrow as $nrow) {
                 foreach($pic as $row) {
                        // echo $nrow[0];
                        if ($row[12] == "indisponible") {
                            echo "
                            <div class='cars_container'>
                                <img src='$row[1]' alt=''>
                                <h1>$row[2]</h1>
                                <span>$row[5] Dh/day</span>
                                <div class='alert alert-info'>
                                    <strong>Info!</strong> Cette voiture est déja réservée !
                                </div>
                            </div>
                            ";
                        } else {
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
                }
            }
            

        }else{
            header("location:index.php");
        }
        return $pic;
    }
    public function Afficher_v(){
        $v = new Db;
        $r = $v->selectdb("SELECT * FROM voiture",$this->data);
        return $r;
    }
    public function Afficher_v_by_id($m){
        $v = new Db;
        $r = $v->selectdb("SELECT * FROM voiture WHERE matricul='$m'",$this->data);
        return $r;
    }
    public function optionn(){
        $c = new Db;
        $r = $c->selectdb("SELECT DISTINCT type_carburent from voiture ",$this->data); //modif here
        while ($row = $r->fetch()){
                ?>
                <option value="<?= $row[0] ?>"><?= $row[0] ?></option>
                <?php
        }
    } 
    public function affichage_voiture_par_matricule($id){
       
        $c = new Db;
        $pic = $c->selectdb("SELECT * FROM voiture where matricul='$id'",$this->data);
        while ($row = $pic->fetch()){
            return $row;
        }
        return [];
    }
    
    public function ajouter_voiture($val1,$val2,$val3,$val4,$val5,$val6,$val7,$val8,$val9,$val10,$val11,$val12,$val13,$val14,$val15,$val16,$val17){
        $add_car = new Db;
        $added = $add_car->misajourdb("INSERT INTO `voiture`(`matricul`, `picture_car`, `mark_voi`, `capacity_voi`, `model_voi`, `price`, `type_carburent`, `description`, `type_voiture`, `N_chassis`, `km_actuel`, `couleur`, `status_voi`, `picture2`, `picture3`, `picture4`,`picture5`) VALUES ('$val1','$val2','$val3','$val4','$val5','$val6','$val7','$val8','$val9','$val10','$val11','$val12','$val13','$val14','$val15','$val16','$val17')",$this->data);
        return $added;
    }
    public function show_cars_table(){
        $t = new Db;
        $tb = $t->selectdb("SELECT * FROM `voiture`",$this->data);
        // return $tb;
        $res = $tb->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($tb){
            return $res;
        }
        return -1;
    }
    public function show_cars_by_matricul($mt){
        $t = new Db;
        $tb = $t->selectdb("SELECT * FROM `voiture` where matricul='$mt'",$this->data);
        return $tb;
    }
    public function chercher_voiture($vt){
        $v = new Db;
        $rv = $v->selectProcedure("chercher_voiture('$vt')",$this->data);
        return $rv;
    }
    public function supprimer_voiture($mt){
        $t = new Db;
        $tb = $t->misajourdb("DELETE FROM `voiture` where matricul='$mt'",$this->data);
        return $tb;
    }
    public function modifier_voiure($val1,$val2,$val3,$val4,$val5,$val6,$val7,$val8,$val9,$val10,$val11,$val12,$val13,$val14,$val15,$val16,$val17){
        $update_car = new Db;
        $updated = $update_car->misajourdb("UPDATE `voiture` SET `picture_car`='$val2',`mark_voi`='$val3',`capacity_voi`='$val4',`model_voi`='$val5',`price`='$val6',`type_carburent`='$val7',`description`='$val8',`type_voiture`='$val9',`N_chassis`='$val10',`km_actuel`='$val11',`couleur`='$val12',`status_voi`='$val13',`picture2`='$val14',`picture3`='$val15',`picture4`='$val16' ,`picture5`='$val17' WHERE matricul='$val1'",$this->data);
        return $updated;
    }

    public function search_matricul($mt){
        $mt = new Db;
        $rmt = $mt->selectdb("SELECT matricul FROM `voiture` WHERE `matricul` LIKE '%$mt%'",$this->data);
        return $rmt;
    }
    // _____________ end cars _________________________

    // _____________ review part ______________________

    public function review($text,$id_client,$mat){
        $rev = new Db;
        $com = $rev->selectdb("INSERT INTO `review` (`text_review`,`date_review`,`id_client_fk`,`matricule_voiture`) VALUES ('$text',CURRENT_DATE(),'$id_client','$mat')",$this->data);
        return true;
    }
    public function affichage_commentaire($mat){
        $rev = new Db;
        $com = $rev->selectdb("SELECT nom_client,prenom_client,text_review FROM review JOIN client WHERE client.id_client = review.id_client_fk and matricule_voiture = '$mat'",$this->data);
        return $com;
    }


    // _________________ start  accessoire _______________________
    public function ajouter_accessoire($type,$matricule){
        $accessoire = new Db;
        $ajouter_accessoire = $accessoire->misajourdb("INSERT INTO `accessoire`(`type_acc`,`matricule_voiture`) VALUES ('$type','$matricule')",$this->data);
        return $ajouter_accessoire;
    }
    public function supprimer_accessoire($matricule_update){
        $accessoire_supprimer = new Db;
        $ajouter_accessoire_supprimer = $accessoire_supprimer->misajourdb("DELETE FROM `accessoire` WHERE `matricule_voiture`='$matricule_update'",$this->data);
        return $ajouter_accessoire_supprimer;
    }
    public function select_accessoires($mt){
        $a = new Db;
        $r = $a->selectdb("SELECT * FROM `accessoire` WHERE matricule_voiture='$mt'",$this->data);
        return $r;
    }
    // ____
    // _____________ end  accessoire _______________________

    // ______________ reservation ___________________

    public function reserver($dr,$fr,$mat,$id_c,$nom,$prenom,$duree,$prix,$mp,$deuxconducteur,$prixu){
        $c = new Db;
        $added = $c->selectdb("INSERT INTO `reserver`(`debut_res`, `fin_res`, `matricule_voiture_reserver`, `id_client_res_fk`, `nom_client`, `prenom_client`,`duree`, `price`, `mode_paiment`, `Dconducteur`,`prix_unitaire`) VALUES ('$dr','$fr','$mat','$id_c','$nom','$prenom','$duree','$prix','$mp','$deuxconducteur','$prixu')",$this->data);   
    }

    //______________ client reservation _______________

    public function client_reserver($id){
       
        $c = new Db;
        $pic = $c->selectdb("SELECT * FROM client where id_client='$id'",$this->data);
        while ($row = $pic->fetch()){
            return $row;
        }
        return [];
    }

    public function count_duree($date_d,$date_fin){
        $c = new Db;
        $r = $c->selectdb("SELECT '$date_fin' - '$date_d' from reserver",$this->data);
        return $r;
    }
    public function  update_info_client($permis,$ville,$photo_cin,$photo_permis,$phone,$id){
        $c = new Db;
        $r = $c->selectdb("UPDATE client set permis='$permis',ville='$ville',phote_cin='$photo_cin',photo_permis='$photo_permis',telephone='$phone' where id_client='$id'",$this->data);
        return true;
    }
    // ------------------------------------------------ reserver
    public function deleteReservation($id){
        $db = new Db;
        $r = $db->misajourProcedure("deleteReservation('$id')",$this->data);
        // $res = $r->fetchAll(PDO::FETCH_ASSOC);
        if($r){
            echo 'l3ezz';
            return;
        }
        return -1;
    }
    public function showReservation(){
        $db = new Db;
        $r = $db->selectProcedure('showReservation()',$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($r->fetchAll());
        if($res){
            return $res;
        }
        return -1;
    }
    public function updateReservation($id,$debut,$fin,$matricule,$idClient,$nom,$prenom,$duree,$price,$modePay,$Dconduct,$prixUni,$confirm = 0){
        $db = new Db;
        $r = $db->misajourProcedure("updateReserver('$id','$debut','$fin','$matricule','$idClient','$nom','$prenom','$duree','$price','$modePay','$Dconduct','$prixUni','$confirm')",$this->data);
        if($r){
            echo ' l3ezz ';
        }else{
            echo ' tfo ';
            return -1;
        }
    }

    //__________________facture __________________________

    public function affichage_facture(){
        $c = new Db;
        $r = $c->selectdb("SELECT * from facture join reserver where reserver.id_client_res_fk = facture.id_client_fkk order by facture.id_facture desc limit 1",$this->data);
        return $r;
    }
    public function affichage_facture_by_client($id){
        $c = new Db;
        $r = $c->selectdb("SELECT * from facture join reserver where reserver.id_client_res_fk=$id and reserver.id_reserve = facture.id_reserve order by facture.id_facture",$this->data);
        return $r;
    }
  

    // _______________ contrat infos___________________________

    public function contrat_info($gog){
        $d = new Db;
        $r = $d->selectdb("SELECT * from reserver join voiture WHERE reserver.id_reserve = '$gog' AND reserver.matricule_voiture_reserver = voiture.matricul",$this->data);
        return $r;
    }
    public function directeur_info(){
        $d = new Db;
        $r = $d->selectdb("SELECT * from directeur",$this->data);
        return $r;
    }
    public function contrat($id,$nom,$prenom,$mat,$mark,$kilo,$debut,$fin,$prix){
        $c = new Db;
        $added = $c->selectdb("INSERT INTO `contrat`(`if_client_f`, `nom`, `prenom`, `date_contrat`, `mat_voiture`, `marque`,`kilometrage`, `debut_res`, `fin_res`, `prix_par_jour`) VALUES ('$id','$nom','$prenom',CURRENT_DATE(),'$mat','$mark','$kilo','$debut','$fin','$prix')",$this->data);   

    }


    // ______________ agence _infos _______________

    public function agence_info(){
        $c = new Db;
        $r = $c->selectdb("SELECT * from agence",$this->data);
        return $r;
    }
    public function agence_info_by_id($id){
        $c = new Db;
        $r = $c->selectdb("SELECT * from agence where id_agence='$id'",$this->data);
        return $r;
    }
    public function update_agence($id,$nom,$ville,$adresse,$tel,$email,$logo,$if,$rc,$ice,$cnss){
        $ua = new Db;
        $ru = $ua ->misajourdb("UPDATE `agence` SET `Nom_agence`='$nom',`ville_agence`='$ville',`adresse_agence`='$adresse',`telephone`='$tel',`email_agence`='$email',`logo_agence`='$logo',`if_agence`='$if',`rc`='$rc',`ice`='$ice',`cnss`='$cnss' WHERE `id_agence`=$id",$this->data);
        return $ru;
    }
    public function google_un($euse,$nom,$prenom,$tokene){
        $c = new Db;
        $sql = "SELECT * FROM client WHERE email_client = '$euse'";
        $stmt = $c->selectdb($sql,$this->data);
  
        if ($stmt->rowCount() > 0) {
            // user exists
            $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
            $token = $userinfo['token'];
        } else {
            // user does not exist, insert into database
            $sql = "INSERT INTO client (nom_client, prenom_client,email_client,token) VALUES ('$nom', '$prenom', '$euse', '$tokene')";
            $stmt = $c->selectdb($sql,$this->data);
        }
    }

    // ________________________________reparations ________________________________

    public function reparation_infos(){
        $rp = new Db;
        $res_rp = $rp->selectdb("SELECT * FROM `reparation`",$this->data);
        return $res_rp;
    }
    public function ajouter_reparation($mt,$mk,$tr,$cr,$dr){
        $rp = new Db;
        $res_rp = $rp->misajourdb("INSERT INTO `reparation`( `matricule_rep`, `mark_voiture`, `typeRep`, `cout_reparation`, `date_reparation`) VALUES ('$mt','$mk','$tr',$cr,'$dr')",$this->data);
        return $res_rp;
    }
    public function reparation_infos_by_id($id){
        $rp = new Db;
        $res_rp = $rp->selectdb("SELECT * FROM `reparation` where id_rep=$id",$this->data);
        return $res_rp;
    }
    
    public function update_rep($id,$mat,$mark,$type,$cout,$date){
        $urp = new Db;
        $res_urp = $urp->misajourdb("UPDATE `reparation` SET `matricule_rep`='$mat',`mark_voiture`='$mark',`typeRep`='$type',`cout_reparation`='$cout',`date_reparation`='$date' WHERE `id_rep`=$id",$this->data);
        return $res_urp;
    }
    public function delete_rep($id){
        $drp = new Db;
        $res_drp = $drp->misajourdb("DELETE FROM `reparation` WHERE `id_rep`=$id",$this->data);
        return $res_drp;
    }


    // _________________ profile ____________________

    public function profile_infos_client($id){
        $ci = new Db;
        $rci =$ci->selectdb("SELECT * FROM `client` WHERE id_client=$id ",$this->data);
        return $rci;
    }  

    public function profile_reservations($id){
        $ci = new Db;
        $rci =$ci->selectdb("SELECT * FROM `reserver` WHERE id_client_res_fk=$id ORDER by id_reserve DESC",$this->data);
        return $rci;
    }  
    public function profile_email_client($email){
        $ci = new Db;
        $rci =$ci->selectdb("SELECT `email_client` FROM `client` where `email_client`='$email' LIMIT 1 ",$this->data);
        return $rci;
    }  
    public function update_clinet_profile($id,$prenom,$nom,$ville,$email,$password){
        $cu = new Db;
        $rcu =$cu->misajourdb("UPDATE `client` SET `nom_client`='$nom',`prenom_client`='$prenom',`email_client`='$email',`password_client`='$password',`ville`='$ville' WHERE `id_client` = $id ",$this->data);
        return $rcu;
    }  
    /* --------------------------------------------------- STATISTICS --------------------------------------------------- */ 
    public function showStatistic(){
        $db = new Db;
        $r = $db->selectProcedure("statisticReservation()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        // print_r($r->fetchAll());
        if($r){
            return $res;
        }
        return -1;
    }
    public function showProfileStatistic($id){
        $db = new Db;
        $r = $db->selectProcedure("clientReservations('$id')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stGainReserver($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countTotalGain('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalReservation($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countReservation('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalClient(){
        $db = new Db;
        $r = $db->selectProcedure("countTotalClient()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalClientRes($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countClientReserved('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalClientNonRes($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countClientNotReserved('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalVoiture(){
        $db = new Db;
        $r = $db->selectProcedure("countTotalVoiture()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalVoitureRes($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countVoitureReserved('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stTotalVoitureNonRes($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countVoitureNotReserved('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stEmploye(){
        $db = new Db;
        $r = $db->selectProcedure("countEmploye()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stRepartionPrice($avant = "",$apres = ""){
        $db = new Db;
        $r = $db->selectProcedure("countPriceRep('$avant','$apres')",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    /*---------------------- NEW STATISTICS ------------------------*/
    public function reservationPerDay(){
        $db = new Db;
        $r = $db->selectProcedure('reservationPerDay()',$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function reservationPerMonth(){
        $db = new Db;
        $r = $db->selectProcedure('reservationPerMonth()',$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function reservationPerYear(){
        $db = new Db;
        $r = $db->selectProcedure('reservationPerYear()',$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function stVoiturePlusReserver(){
        $db = new Db;
        $r = $db->selectProcedure('countVoiturePlusReserver()',$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function triggerNotifsProcedure(){
        $db = new Db;
        $r = $db->selectProcedure("notif_alert",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res . 'daz dakchi');
        if($r){
            return $res;
        }
        return -1;
    }
    public function notificationsIndicator(){
        $db = new Db;
        $r = $db->selectProcedure("show_notif_indicator()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function notificationsMessage(){
        $db = new Db;
        $r = $db->selectProcedure("show_notif_message()",$this->data);
        $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return $res;
        }
        return -1;
    }
    public function seen($id){
        $db = new Db;
        $r = $db->selectProcedure("seen_notif('$id')",$this->data);
        // $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return "khedam seen ";
        }
        return -1;
    }
    public function triggerNotif(){
        $db = new Db;
        $r = $db->selectProcedure("notif_alert()",$this->data);
        // $res = $r->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($r){
            return "khedam";
        }
        return -1;
    }
    // ----------------------------------- COMMENTAIRE --------------------------------
    public function nombre_commentaies($id){
        $nbr = new Db;
        $rnbr =$nbr->selectdb("SELECT * FROM  review WHERE id_client_fk=$id",$this->data);
        return $rnbr;
    }  
    public function nombre_infractions($id){
        $nbr = new Db;
        $rnbr =$nbr->selectdb("SELECT * FROM  decla_infraction WHERE id_client_fk_decla=$id",$this->data);
        return $rnbr;
    }  
    // ---------- stripe -----------------

    public function stripe(){
        $nbr = new Db;
        $rnbr =$nbr->selectdb("SELECT * FROM  stripe",$this->data);
        return $rnbr;
    }
    public function update_stripe($id,$nom){
        $ua = new Db;
        $ru = $ua ->misajourdb("UPDATE `stripe` SET `secretKey`='$id',`publishableKey`='$nom'",$this->data);
        return $ru;
    }
    // ------------------------------------- CHARGES --------------------------------------
    public function AA_matricule_charges(){
        $db = new Db;
        $cc = $db->selectProcedure('AA_matricule_charges()',$this->data);
        $res = $cc->fetchAll(PDO::FETCH_ASSOC);
        if($cc){
            return $res;
        }
        return -1;
    }
    public function add_charge($matricule,$dateAchat,$avance,$reste,$prixParMois,$etat,$traite,$prixAssurance,$dateFinEchehance){
        $db = new Db;
        $ch = $db->misajourProcedure("add_charge('$matricule','$dateAchat','$avance','$reste','$prixParMois','$etat','$traite','$prixAssurance','$dateFinEchehance')",$this->data);
        if($ch){
            // echo "mzyan";
            return "mzyan";
        }
        return -1;
    }
    public function show_charges(){
        $db = new Db;
        $ch = $db->selectProcedure("show_charges()",$this->data);
        $res = $ch->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($ch){
            return $res;
        }
        return -1;
    }
    public function update_charges($id,$matricule,$dateAchat,$avance,$reste,$prixParMois,$etat,$traite,$prixAssurance,$dateFinEchehance){
        $db = new Db;
        $ch = $db->misajourProcedure("update_charges('$id','$matricule','$dateAchat','$avance','$reste','$prixParMois','$etat','$traite','$prixAssurance','$dateFinEchehance')",$this->data);
        if($ch){
            return "updated succefully !!";
        }
        return -1;
    }
    public function delete_charges($id){
        $db = new Db;
        $ch = $db->misajourProcedure("delete_charge('$id')",$this->data);
        if($ch){
            return "tmse7 !";
        }
        return -1;
    }
    // -------------------------------- CONFIRMER RESERVATION ------------------------------------
    public function confirm($id){
        $db = new Db;
        $c = $db->misajourProcedure("confirmer_reservation('$id')",$this->data);
        if($c){
            return "confirmed!";
        }
        return -1;
    }
    public function numReservation(){
        $db = new Db;
        $cc = $db->selectProcedure("numReservation()",$this->data);
        $res = $cc->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        if($res){
            return $res;
        }
        return -1;
    }
    // --------------------------------- ALERTING ----------------------------------
    public function showAlert($mat){
        $db = new Db;
        $c = $db->selectProcedure("showAlert('$mat')",$this->data);
        $res = $c->fetch(PDO::FETCH_ASSOC);
        // print_r($res);
        if($c){
            return $res;
        }
        return -1;
    }
    public function addAlerting($crt,$vid,$vit,$ass,$ret,$mat){
        $db = new Db;
        $c = $db->misajourProcedure("ajouterAlerting('$crt','$vid','$vit','$ass','$ret','$mat')",$this->data);
        if($c){
            return "Add viri well";
        }
        return -1;
    }
    public function alerting($mat,$crt,$vid,$vit,$ass,$ret){
        $db = new Db;
        $c = $db->misajourProcedure("alerting('$mat','$crt','$vid','$vit','$ass','$ret')",$this->data);
        if($c){
            return "Works viri well";
        }
        return -1;
    }
    public function loading_stats(){
        $db = new Db;
        $cc = $db->selectProcedure('showing_car_fin_reserver()',$this->data);
        if($cc){
            return "Works viri well";
        }
        return -1;
    }
    public function confirm_voiture($mat){
        $db = new Db;
        $c = $db->misajourProcedure("confirm_seen_voiture('$mat')",$this->data);
        if($c){
            return "confirmed car notif";
        }
        return -1;
    }
}
// $obj = new Control;
// $obj->show_cars_table();

 
