<?php

include_once((__DIR__).'/general_product.php');
include_once((__DIR__).'/../validation/dvd_validator.php');

class DVD extends Product 
{
    protected $size;
    

    public function __construct($form_data)
    {
        parent::__construct($form_data["sku"] , $form_data["name"] , $form_data["price"] , $form_data["type"]);
        $this->size = $form_data["size"];
        $this->validator = new DVDValidator($this);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = size;
    }
    public function displayTypeData()
    {
        return "Size: ".$this->size." MB";
    }
   
}

