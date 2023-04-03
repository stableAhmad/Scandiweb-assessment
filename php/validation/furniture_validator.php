<?php 

include_once((__DIR__).'/validator.php');


class FurnitureValidator extends Validator
{
    private $height;
    private $width;
    private $length;
    
    public function __construct($instance)
    {
        parent::__construct($instance->getSKU() , $instance->getPrice(), $instance->getName() );
        $this->height = $instance->getHeight();
        $this->length = $instance->getLength();
        $this->width = $instance->getWidth();
    }

    private function validateHeight()
    {
        //Two steps to validate the special data, we check if the height is not empty and then we check if it is a valid number
        $cond1 = $this->validNumber($this->height);
        $cond2 = (strlen($this->height) != 0);

        //setting the error message for each kind of error or returning true if both conditions are true (the special data is valid)
        if ($cond2) {
            if ($cond1) {
                return true;

            } else {

                //if the message is empty means we haven't found any error before the current one, So that means the current error...
                //is the only one so far and we need to display a message to the user
                if ($this->getMessage() == "") {

                    $this->setMessage("The Product height you have entered is not valid
                    <br>Please make sure the height is<br>-Between 0 and 1000000000000<br>-Only contains digits");
                }
                return false;
            }
        } else {
            
            if ($this->getMessage() == "") {
                    $this->setMessage("Product height cannot be empty");
            }
            return false;
        }
    }

    private function validateWidth()
    {
        $cond1 = $this->validNumber($this->width);
        $cond2 = (strlen($this->width) != 0);

        if ($cond2) {
            if ($cond1) {
                return true;

            } else {
                
                if ($this->getMessage() == "") {

                $this->setMessage("The Product width you have entered is not valid
                <br>Please make sure the width is<br>-Between 0 and 1000000000000<br>-Only contains digits");
            }
                return false;
            }
        } else {
            
            if ($this->getMessage() == "") {
                    $this->setMessage("Product width  cannot be empty");
            }
            return false;
        }
    }

    private function validateLength()
    {
        $cond1 = $this->validNumber($this->length);
        $cond2 = (strlen($this->length) != 0);

        if ($cond2) {
            if ($cond1) {
                return true;
            } else {
                if ($this->getMessage() == "") {

                $this->setMessage("The Product length you have entered is not valid
                <br>Please make sure the length is<br>-Between 0 and 1000000000000<br>-Only contains digits");
                }
                return false;
            }
        } else {
            
            if ($this->getMessage() == "") {
                    $this->setMessage("Product length cannot be empty");
            }
            return false;
        }
    }
    
    //the overall validation is determined by the reuslt of 3 above functions
    public function validateSpecialData()
    {
        $cond1 = $this->validateWidth();
        $cond2 = $this->validateHeight();
        $cond3 = $this->validateLength();

        if ($cond1 && $cond2 && $cond3) {
            return true;
        } else 
            return false;
    }
}

