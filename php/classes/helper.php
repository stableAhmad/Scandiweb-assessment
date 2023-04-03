<?php


//A class that has some helper/reusable function
class Helper
{
    //A function that takes two arrays and merges them into one array
    public static function merge($arr1 , $arr2)
    {
        $all = [];
        foreach ($arr1 as $x)
            array_push($all , $x);
        foreach ($arr2 as $x)
            array_push($all , $x);
        return $all;
    }

    //A function that is used in the comparison based sorting algorithm in ordered to decide which product
    //is going to be placed before the other (sorting by SKU)
    public static function compareBySKU($first ,$second)
    {
        return strcmp($first->getSKU() , $second->getSKU());
    }
}
