<?php 

include_once((__DIR__).'/validator.php');

class BookValidator extends Validator
{
    private $weight;

    public function __construct($instance)
    {
        parent::__construct($instance->getSKU() , $instance->getPrice(), $instance->getName() );
        $this->weight = $instance->getWeight();
    }
    
    public function validateSpecialData()
    {
    	//Two steps to validate the special data, we check if the weight is not empty and then we check if it is a valid number
        $cond1 = $this->validNumber($this->weight);

        //empty sometimes returns false although the string is empty so I make sure that the length is 0
        $cond2 = !empty($this->weight) && (strlen($this->weight) != 0);

        //setting the error message for each kind of error or returning true if both conditions are true (the special data is valid) 
        if ($cond2) {
            if ($cond1) {
                return true;
            } else {
                
                //if the message is empty means we haven't found any error before the current one, So that means the current error...
                //is the only one so far and we need to display a message to the user
                if ($this->getMessage()== "") {
                    $this->setMessage("The Book weight you have entered is not valid <br>Please make sure the weight is<br>-Between 0 and 1000000000000<br>-Only contains digits");
                }
                return false;
            }
        } else {    

            if ($this->getMessage() == "") {
                 $this->setMessage("Book weight cannot be empty");
            }
            return false;
        }
    }
}
