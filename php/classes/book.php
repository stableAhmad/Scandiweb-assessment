<?php

include_once((__DIR__).'/general_product.php');
include_once((__DIR__).'/../validation/book_validator.php');

class Book extends Product 
{
    protected $weight;
    
    
    public function __construct($form_data)
    {
        parent::__construct($form_data["sku"] , $form_data["name"] , $form_data["price"] , $form_data["type"]);
        $this->weight = $form_data["weight"];
        $this->validator = new BookValidator($this);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    public function displayTypeData()
    {
        return "Weight: ".$this->weight." KG";
    }
    
}


