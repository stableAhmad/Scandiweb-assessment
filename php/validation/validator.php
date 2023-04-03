<?php 

include_once((__DIR__).'/../DBhandling/dbhandler.php');

//this validator class is responsible for validating the common data between all the products regardless of the type data
abstract class Validator
{
    private $sku;
    private $price;
    private $name;
    private $sku_valid = false;
    private $name_valid = false;
    private $price_valid = false;
    private $message = "";


public function __construct($sku, $price, $name)
{
    $this->sku = $sku;
    $this->price = $price;
    $this->name = $name;
}

    
protected function validateSKU()
{
    //SKU validation is done on 3 steps as shown belowas condition 1,  condition 2 and condition 3
    $cond1 = !($this->isEmpty($this->sku));
    $cond2 = $this->validName($this->sku);
    $cond3 = $this->isUniqueSKU($this->sku);

    //Setting the error message for each kind of error or returning true if all of the conditions are true (the SKU  is valid)
    if ($cond1) {
        if ($cond2) {
            if ($cond3) {
                return true;
            } else {
                $this->message="The SKU you have entered already exists";
                return false;
            } 
        } else {
            $this->message="Product SKU cannot include any of these special characters ! @ # \ [ \ ] ; , $ % ^ & * \/ () \\\ _ ? ";
            return false;
        }
    } else {
        $this->message="Product SKU cannot be empty";
        return false;
    }
}


protected function validateName()        
{
    $cond1 = !($this->isEmpty($this->name));
    $cond2 = $this->validName($this->name);

    if ($cond1) {
        if ($cond2) {
            return true;
        } else {

            //if the message is empty means we haven't found any error before the current one, So that means the current error...
            //is the only one so far and we need to display a message to the user
            if ($this->getMessage() == "") {
                $this->message="Product name length should be between 3 and 20 characters
                <br>Product name cannot include any of these special characters ! @ # \ [ \ ] ; , $ % ^ & * \/ () \\\ _ ? ";
            }
            return false;
        }
    } else {
        if ($this->getMessage() == "") {
            $this->message = "Product name cannot be empty";
        }
        return false;
    }
}

protected function validatePrice()   
{
    $cond1 = !($this->isEmpty($this->price));
    $cond2 = $this->validNumber($this->price);

    if ($cond1) {
        if ($cond2) {
            return true;
        } else {

            if ($this->getMessage() == "") {
                $this->message = "The product price you have entered is not valid
                <br>Please make sure the price is<br>-Between 0 and 1000000000000<br>-Only contains digits";
            }

            return false;
        }
    } else {

        if($this->getMessage() == "") {
            $this->message = "Product price cannot be empty";
        }
        return false;
    }
}

public function validateCommonData()
{
    $cond1 = $this->validateSKU();
    $cond2 = $this->validateName();
    $cond3 = $this->validatePrice();

    if ($cond1 && $cond2 && $cond3) {
            return true;
    } else
        return false;

}

public function isSKUValid()
{
    return $this->sku_valid;
}

public function isPriceValid()
{
    return $this->price_valid;
}

public function isNameValid()
{
    return $this->name_valid;
}

protected function isEmpty($string)
{
    return empty($string) && (strlen($string) == 0);
}

public function getMessage()
{
    return $this->message;
}

public function setMessage($string)
{
    $this->message = $string;
}

protected function validName($string)
{
    $n = strlen($string);

    //Validation on the length using the following regular expressoin
    $cond1 = (preg_match('/^.{3,20}$/', $string));

    //Validation on the characters used in that string , if it is free of special characters
    $special_characters = ( preg_match_all('/[^!@#\[\];,$%^&*\/()\\\_?]/', $string));
    $cond2 = ($special_characters == $n);

    //overall result is determined by the above two conditions
    return $cond2 && $cond1;
}

protected function validNumber($string)
{
    //checking if the string is numeric or not since the data sent form the form comes in the form of  a string
    $cond1 =  is_numeric($string);
    $cond2 = false;

    if ($cond1) {
        $number_value = (float)$string;

        //validatoin on the range of the number
        if (($number_value >=0) && ($number_value < 1000000000000))
            $cond2 = true;
    }

    return ($cond1 && $cond2);
}

//checking if the sku is unique by attempting to save it in the general product table
//if no error was returned then its unique and can be used, otherwise we return false
public function isUniqueSKU($sku)
{
    //creating a new db handler
    $handler = new DBHandler();

    //query to attempt
    $save_query = "INSERT INTO product (sku , name, price) VALUES ("."'".$sku."'"." , "."'dummy_name'"." , "."0".") ;";

    //if it was saved properly then we delete it, it will be saved after the validation is done along with the rest of its data
    $delete_query = "DELETE  FROM product WHERE sku="."'"."$sku"."'".";";

    //executing the queries
    $result1 = $handler->execute($save_query);
    $result2 = $handler->execute($delete_query);
        
    //returning the final result
    if ($result1) {
        return false;
    }
    return true;
}

abstract public function validateSpecialData();

}
