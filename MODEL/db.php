<?php

class Db {
    public $cnx;
    public function selectdb($requete, $data){
        $this->cnx = new PDO("mysql:host=localhost;dbname={$data};",'root',"");
        $res = $this->cnx->query($requete);
        return $res;
    }
    public function misajourdb($requete, $data){
        $this->cnx = new PDO("mysql:host=localhost;dbname={$data};",'root',"");
        $res = $this->cnx->exec($requete);
        return $res;
    }
    public function selectProcedure($requete, $data){
        $this->cnx = new PDO("mysql:host=localhost;dbname={$data};",'root',"");
        $res = $this->cnx->query("Call {$requete}");
        return $res;
    }
    public function misajourProcedure($requete, $data){
        $this->cnx = new PDO("mysql:host=localhost;dbname={$data};",'root',"");
        $res = $this->cnx->exec("Call {$requete}");
        return $res;
    }
}