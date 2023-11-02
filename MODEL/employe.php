<?php
class Employee
{
    private $id_emp;
    private $family_name_emp;
    private $first_name_emp;
    private $email_emp;
    private $cin_emp;
    private $horrair_emp;
    private $fonctionality;
    private $id_dir_fk;

    public function getIdEmp()
    {
        return $this->id_emp;
    }

    public function setIdEmp($id_emp)
    {
        $this->id_emp = $id_emp;
    }

    public function getFamilyNameEmp()
    {
        return $this->family_name_emp;
    }

    public function setFamilyNameEmp($family_name_emp)
    {
        $this->family_name_emp = $family_name_emp;
    }

    public function getFirstNameEmp()
    {
        return $this->first_name_emp;
    }

    public function setFirstNameEmp($first_name_emp)
    {
        $this->first_name_emp = $first_name_emp;
    }

    public function getEmailEmp()
    {
        return $this->email_emp;
    }

    public function setEmailEmp($email_emp)
    {
        $this->email_emp = $email_emp;
    }

    public function getCinEmp()
    {
        return $this->cin_emp;
    }

    public function setCinEmp($cin_emp)
    {
        $this->cin_emp = $cin_emp;
    }

    public function getHorrairEmp()
    {
        return $this->horrair_emp;
    }

    public function setHorrairEmp($horrair_emp)
    {
        $this->horrair_emp = $horrair_emp;
    }

    public function getFonctionality()
    {
        return $this->fonctionality;
    }

    public function setFonctionality($fonctionality)
    {
        $this->fonctionality = $fonctionality;
    }
}
