<?php


include_once((__DIR__).'/../classes/dvd.php');
include_once((__DIR__).'/../classes/book.php');
include_once((__DIR__).'/../classes/furniture.php');


class DBHandler
{

private $server_name = "localhost";
private $username = "root";
private $password = "";
private $dbname = "assessment";
private $connection_state = false;
private $connection ;


private function connect()
{
    //attempting a connection to the database 
    $this->connection = mysqli_connect($this->server_name , $this->username , $this->password , $this->dbname);

    //if the connection was not established we output a message and exit the current php sciprt 
    //otherwise we se the utf as the charset used in the DB
    if ($this->connection->connect_error) {
        die("Connection failed: " . $this->connection->connect_error);
	} else {
        $this->connection->set_charset("utf8");
        $this->connection_state = true;
    }   
}


//a function that saves any product in the database
public function save($instance)
{
    //if there is no connection we attempt a connection
    if (!$this->connection_state) {
        $this->connect();
    }

    $type_table = strtolower($instance->getType());
    $name = $instance->getName();
    $price = $instance->getPrice();
    $sku = $instance->getSKU();

    //forming the first query for saving the product in the general product table by getting the common attributes for any product...
    //(sku , name , price), we make sure that each value is surrounded by a single quote in order to be a valid sql query
    $q1 = "INSERT INTO product (sku , name, price) VALUES ("."'".$sku."'"." , "."'".$name."'"." , "."'".$price."'".") ;";


    //forming the second query for saving the product in its table depending on its type
    //the columns in the query represent the values for the special attributes of the product
    //vals stores their values
    $cols = $instance->getSpecificAttributes();
    $vals = $instance->getSpecificValues();
    

    $q2 = "INSERT INTO $type_table $cols
        VALUES $vals ;";
    
    
    $res1 = $this->connection->query($q1);
    //if saving the product in the first table is successful then we save it in the second table
    if ($res1) {
    $res2 = $this->connection->query($q2);
    }

    return $this->connection->error;
}

public function delete($instance)
{
    
    //making sure there is a connection
    if (! $this->connection_state) {
        $this->connect();
    }

    $sku = $instance->get_sku();
    $table = strtolower( $instance->get_type());

    //deleting by the primary key (sku)
    $q3 = "DELETE  FROM product WHERE sku="."'"."$sku"."'".";";
    $q4 = "DELETE  FROM $table WHERE sku="."'"."$sku"."'".";";
    
    //executing the queries
    $res1 = $this->connection->query($q3);
    $res2 = $this->connection->query($q4);
}

public function fetch($table_name)
{
    //making sure there is a connection
    if (! $this->connection_state) {
        $this->connect();
        $this->connection_state = true;
    }

    //fetching the products by the sku from the general product table
    $q1 = "SELECT * FROM product , $table_name WHERE product.sku = $table_name.sku ORDER BY product.sku";

    //executing the above query
    $result = $this->connection->query($q1);

    //gathering the results if there is any
    if ($result->num_rows > 0) {
        $objects = [];

        //For each fetched product we create an object with the right type, we use this ...
        //objects to display the products in the home pag by the getters
        foreach ($result as $x) {

            $class_name = strtoupper($table_name);
            $x["type"] = $class_name;
            $temp = new $class_name($x);
            array_push($objects , $temp);
            }
        return $objects;
     } else {
        return 0;
     }
}


//A function to execute some query in the database and returns whether there is an error or not
public function execute($q)
{
    if (!$this->connection_state) {
        $this->connect();
        $this->connection_state = true;
    }
    $this->connection->query($q);
    return $this->connection->error ;
}

}

