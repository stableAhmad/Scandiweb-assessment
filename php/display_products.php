<?php


//including the database handling file and a helper class 
include_once((__DIR__).'./DBhandling/dbhandler.php');
include_once((__DIR__).'./classes/helper.php');

/*
Although those above includes and the below function together in the same file doesn't satisfy one of the (PSR-1: Basic Coding Standard) ,
I couldn't build the below method without some help from those files , And I had to choose between putting the below code in the page that has html or make it in a separate function so I choose what I did .
*/

function displayProducts()
{
    //instantiating a db handler
    $handler = new DBHandler();

    //fetching products with different types
    $result1 = $handler->fetch("dvd");
    $result2 = $handler->fetch("book");
    $result3 = $handler->fetch("furniture");

    //creating an instance of the helper class in order to use the merge method
    $helper = new Helper;

    //merging prdocuts of result1 with products of result2, then merging the result with the products in result3 in order to sort all the products
    $products = $helper->merge(($result1 != 0) ? $result1 : [] , ($result2 != 0) ? $result2 : []);
    $products = $helper->merge($products , ($result3 != 0) ? $result3 : []);

    //soring the products
    usort($products , array("Helper" , "compareBySKU"));
    
    return $products;
}
            
