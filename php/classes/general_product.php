<?php

//declaring a constant COMMON_ATTRIBUTES, the common attributes between all types
define("COMMON_ATTRIBUTES","6");


abstract class Product 
{
    private $dbhandler;
    private $type;
    private $sku;
    private $name;
    private $price;
    public $validator;
    
     public function __construct($sku , $name , $price , $type )
     {
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
        $this->type = $type;
        $this->dbhandler = new DBHandler();
     }
     

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getSKU()
    {
        return $this->sku;
    }

    public function setSKU($sku)
    {
        $this->sku = $sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

     public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }


    /* a function that finds the specific attributes for each type ...
       by iterating on all the attibutes of the object and skipping 
       the common attributes defined at the top of this file
       EX :
        dvd object -> size
        book object -> weight
    */
    public function getSpecificAttributes()
    {
        $attributes = [];
        $values = [];

        //iterating on all the attributes of the object
        foreach ($this as $key => $value)
        {
            array_push($attributes , $key);
        }

        //calculating the number of attributes to skip in order to obtain just the specific attributes
        $n = count($attributes);
        $m = $n - COMMON_ATTRIBUTES;
        $result = "( sku ,";
        for ($x = 0 ; $x < $m ; $x++)
        {
            //concatinating the next attribute with the result then adding , after each attribute
            $result = $result.$attributes[$x].",";
        }

        //removing the last ',' in the result variable
        $target = strlen($result)-1;
        $result =  substr_replace($result, '', $target, 1);
        $result = $result.")";

        //returning the attributes in the form of (attribute1 , attribute2 , attribute3 ..)
        return $result;
        
    }

    /* finds the values that correspond to each spefific attribue in the function above
    */
    public function getSpecificValues()
    {
        
        $values = [];
        foreach ($this as $key => $value)
        {
            array_push($values , $value);
        }
        $n = count($values);
        $m = $n - COMMON_ATTRIBUTES;
        $result = "( "."'".$this->sku."'"." ,";
        for ($x = 0 ; $x < $m ; $x++)
        {
            $result = $result."'".$values[$x]."'".",";
        }
        $target = strlen($result)-1;
        $result =  substr_replace($result, '', $target, 1);
        $result = $result.")";

        return $result;
    }
   
  
    public function save()
    {
        return $this->dbhandler->save($this);
    }
    public function delete()
    {
        return $this->dbhandler->delete($this);
    }
    public function getMessage()
    {
        return $this->validator->getMessage();
    }
    public function setMessage($message)
    {
        $this->validator->setMessage($message);
    }
     Public function validate()
    {
        //the overall validation is calculated by validating the common attributes in the general product class and validating ..
        //the specific attributes for each type, then returns the overall result
        $condition1 = $this->validator->validateCommonData();
        $condition2 = $this->validator->validateSpecialData();
        
        return $condition1 && $condition2;
    }

    //an abstract function that displays the specifc data for each product type ..
    //its implementation differs by the class(type)
    abstract public function displayTypeData(); 
}




