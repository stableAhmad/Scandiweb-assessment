<?php

//including classes necessary for instantiating a product object
foreach (glob((__DIR__).'./classes/*.php') as $filename) {
    include_once( $filename);
}

//including the DB handler php file
include_once((__DIR__).'./DBhandling/dbhandler.php');

//getting the data from the form on the client side 
$data = $_POST;

//creating an object based on the product type 
$type = $data["type"];
$instance = new $type($data);

//using the validator inside each product class to validate the data of the object
$validation_result = $instance->validate();

//saving the product and replying with true to the javascript or replying with the error message as a result of the validation    
if ($validation_result) {
    $instance->save();
    echo true;    
} else {
    echo $instance->getMessage();
}
