<?php 

class Client
{
    private $first_name_client;
    private $family_name_client;
    private $iden;
    private $email_client;
    private $password_client;
    public function __construct($n, $p, $idenn,$e, $mdp){
        $this->first_name_client = $n;
        $this->family_name_client = $p;
        $this->iden = $idenn;
        $this->email_client = $e;
        $this->password_client = $mdp;    
    }
    public function getFirstNameClient()
    {
        return $this->first_name_client;
    }

    public function setFirstNameClient($first_name_client)
    {
        $this->first_name_client = $first_name_client;
    }

    public function getFamilyNameClient()
    {
        return $this->family_name_client;
    }

    public function setFamilyNameClient($family_name_client)
    {
        $this->family_name_client = $family_name_client;
    }
    public function getIdentity()
    {
        return $this->iden;
    }

    public function setIdentity($i)
    {
        $this->iden = $i;
    }

    public function getEmailClient()
    {
        return $this->email_client;
    }

    public function setEmailClient($email_client)
    {
        $this->email_client = $email_client;
    }

    public function getPasswordClient()
    {
        return $this->password_client;
    }

    public function setPasswordClient($password_client)
    {
        $this->password_client = $password_client;
    }
}
