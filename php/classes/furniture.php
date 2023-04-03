<?php

include_once((__DIR__).'/general_product.php');
include_once((__DIR__).'/../validation/furniture_validator.php');

class Furniture extends Product 
{
    protected $height;
    protected $width;
    protected $length;
    

    public function __construct($form_data)
    {
        parent::__construct($form_data["sku"] , $form_data["name"] , $form_data["price"] , $form_data["type"]);
        $this->height = $form_data["height"];
        $this->width = $form_data["width"];
        $this->length = $form_data["length"];
        $this->validator = new FurnitureValidator($this);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function displayTypeData()
    {
        return "Dimensions: ".$this->height."x".$this->width."x".$this->length;
    }

}