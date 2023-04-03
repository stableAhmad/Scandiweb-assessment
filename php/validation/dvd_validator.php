<?php 

include_once((__DIR__).'/validator.php');

class DVDValidator extends Validator
{
    private $size;

    public function __construct($instance)
    {
        parent::__construct($instance->getSKU() , $instance->getPrice(), $instance->getName() );
        $this->size = $instance->getSize();
    }

    public function validateSpecialData()
    {
        //Two steps to validate the special data, we check if the size is not empty and then we check if it is a valid number
        $cond1 = $this->validNumber($this->size);

        //empty sometimes returns false although the string is empty so I make sure that the length is 0
        $cond2 = (strlen($this->size) != 0);

        //setting the error message for each kind of error or returning true if both conditions are true (the special data is valid)
        if ($cond2) {
            if ($cond1) {
                return true;
            } else {

                //if the message is empty means we haven't found any error before the current one, So that means the current error...
                //is the only one so far and we need to display a message to the user
                if ($this->getMessage() == "") {
                    $this->setMessage("The DVD size you have entered is not valid <br>Please make sure the size is<br>-Between 0 and 1000000000000<br>-Only contains digits");
                }
                return false;
            }
        } else {
            
            if ($this->getMessage() == "") {
                $this->setMessage("DVD size cannot be empty");
            }
            return false;
        }
    }
}
