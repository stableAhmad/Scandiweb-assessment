<?php

//including DB handler php file
include_once((__DIR__).'./DBhandling/dbhandler.php');

//getting the form data from the client side
$data = $_POST;

//instantiating new DB handler
$handler = new DBHandler;

//for each product selected 
foreach ($data as $key => $value) {

    //specifying the table name from which we want to delete
    $table = strtolower($key);

    //queries for deleting the product from both the general product table and the specific type table
    $q1 = "DELETE  FROM product WHERE sku="."'"."$value"."'".";";;
    $q2 = "DELETE  FROM $table WHERE sku="."'"."$value"."'".";";;
    
    //using the DB handler to execute the queries
    $r1 = $handler->execute($q2);
    $r2 = $handler->execute($q1);  
}

//changing the location back to the products page 
echo "<script> window.location.href = '../index.php'; </script>";



