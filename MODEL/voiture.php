<?php 

class Voiture
{
    private $id_voi;
    private $picture_car;
    private $mark_voi;
    private $capacity_voi;
    private $model_voi;
    private $price;
    private $type_carburent;

    public function getIdVoi()
    {
        return $this->id_voi;
    }

    public function setIdVoi($id_voi)
    {
        $this->id_voi = $id_voi;
    }

    public function getPictureCar()
    {
        return $this->picture_car;
    }

    public function setPictureCar($picture_car)
    {
        $this-> picture_car = $picture_car;
    }

    public function getMarkVoi()
    {
        return $this->mark_voi;
    }

    public function setMarkVoi($mark_voi)
    {
        $this->mark_voi = $mark_voi;
    }

    public function getCapacityVoi()
    {
        return $this->capacity_voi;
    }

    public function setCapacityVoi($capacity_voi)
    {
        $this->capacity_voi = $capacity_voi;
    }

    public function getModelVoi()
    {
        return $this->model_voi;
    }

    public function setModelVoi($model_voi)
    {
        $this->model_voi = $model_voi;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getTypeCarburent()
    {
        return $this->type_carburent;
    }

    public function setTypeCarburent($type_carburent)
    {
        $this->type_carburent = $type_carburent;
    }
}
