<?php

class Reservation {
    private $id_res;
    private $debut_res;
    private $fin_res;
    private $matricule_voiture_res;
    private $id_clients_res_fk;
    private $nom_clients_res;
    private $prenom_clients_res;
    private $prix_res;
    private $mode_paiment_res;
    private $Deuxieme_conducteur_res;
    private $Troisieme_conducteur_res;
    // ------------------------------------------------ getters ------------------------------------------------
    public function getId(){
        return $this->id_res;
    }
    public function getDebut(){
        return $this->debut_res;
    }
    public function getFin(){
        return $this->fin_res;
    }
    public function getMatricule(){
        return $this->matricule_voiture_res;
    }
    public function getIdClient(){
        return $this->id_clients_res_fk;
    }
    public function getNomClient(){
        return $this->nom_clients_res;
    }
    public function getPrenomClient(){
        return $this->prenom_clients_res;
    }
    public function getPrix(){
        return $this->prix_res;
    }
    public function getModePaiment(){
        return $this->mode_paiment_res;
    }
    public function getDconducteur(){
        return $this->Deuxieme_conducteur_res;
    }
    public function getTconducteur(){
        return $this->Troisieme_conducteur_res;
    }
    // ------------------------------------------------ setters ------------------------------------------------
    public function setId($s_id_res){
        $this->id_res = $s_id_res;
    }
    public function setDebut($s_debut_res){
        $this->debut_res = $s_debut_res;
    }
    public function setFin($s_fin_res){
        $this->fin_res = $s_fin_res;
    }
    public function setMatricule($s_matricule_voiture_res){
        $this->matricule_voiture_res = $s_matricule_voiture_res;
    }
    public function setIdClient($s_id_clients_res_fk){
        $this->id_clients_res_fk = $s_id_clients_res_fk;
    }
    public function setNomClient($s_nom_clients_res){
        $this->nom_clients_res = $s_nom_clients_res;
    }
    public function setPrenomClient($s_prenom_clients_res){
        $this->prenom_clients_res = $s_prenom_clients_res;
    }
    public function setPrix($s_prix_res){
        $this->prix_res = $s_prix_res;
    }
    public function setModePaiment($s_mode_paiment_res){
        $this->mode_paiment_res = $s_mode_paiment_res;
    }
    public function setDconducteur($s_Deuxieme_conducteur_res){
        $this->Deuxieme_conducteur_res = $s_Deuxieme_conducteur_res;
    }
    public function setTconducteur($s_Troisieme_conducteur_res){
        $this->Troisieme_conducteur_res = $s_Troisieme_conducteur_res;
    }
}