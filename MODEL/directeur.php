<?php
class Directeur
{
    private $id_dir;
    private $family_name_dir;
    private $first_name_dir;
    private $email_dir;
    private $cin_dir;
    private $password_dir;

    public function getIdDir()
    {
        return $this->id_dir;
    }

    public function setIdDir($id_dir)
    {
        $this->id_dir = $id_dir;
    }

    public function getFamilyNameDir()
    {
        return $this->family_name_dir;
    }

    public function setFamilyNameDir($family_name_dir)
    {
        $this->family_name_dir = $family_name_dir;
    }

    public function getFirstNameDir()
    {
        return $this->first_name_dir;
    }

    public function setFirstNameDir($first_name_dir)
    {
        $this->first_name_dir = $first_name_dir;
    }

    public function getEmailDir()
    {
        return $this->email_dir;
    }

    public function setEmailDir($email_dir)
    {
        $this->email_dir = $email_dir;
    }

    public function getCinDir()
    {
        return $this->cin_dir;
    }

    public function setCinDir($cin_dir)
    {
        $this->cin_dir = $cin_dir;
    }

    public function getPasswordDir()
    {
        return $this->password_dir;
    }

    public function setPasswordDir($password_dir)
    {
        $this->password_dir = $password_dir;
    }
}