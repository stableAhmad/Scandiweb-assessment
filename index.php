<!DOCTYPE html>
<html>

    <head>

    <title>Products</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign.css">
    <link rel="stylesheet" href="./css/style.css">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

    </head>

<body>

<form action="./php/delete.php" id="outer" method="POST">
    <header id="main_header" class="padding-20">

        <a href="javascript:window.location.href=window.location.href" class="page_title">Product List</a>
        
        <div class="links">
            <button type="button" id="add"> ADD </button>
            <button id="mass_delete">MASS DELETE</button>
        </div>

    </header>

    <div id="products_container">
    
    <?php

    //include the file that has the methods used below
    include './php/display_products.php';   

    //displayProducts does the following
    //1-fetchs the products from the databse
    //2-sorts them by the primary key (sku)
    $products = displayProducts();

    //for each product we generate its HTML form in order to display it using setters and getters defined in the product class
    foreach ($products as $product) {                
        $sku = $product->getSKU();
        $price = $product->getPrice();
        $name = $product->getName();
        $type_data = $product->displayTypeData();
        $type=$product->getType();
        $card = "<div class='card_cover'>
                 <div class='product_card'>
                 <div>
                     <input class='delete-checkbox' type='checkbox' name='$type' value='$sku'>
                 </div>
                 <p class='sku_value unit'>$sku</p>
                 <p class='name_value unit' >$name</p>
                 <p class='price_vlaue unit'>$price $</p>
                 <p class='extra_value unit'>$type_data</p>
                 </div>
                 </div>";
        echo $card;
    }

    //if there were no products found we output a message
    if (count($products) == 0) {
        echo '<h3>No Products Found </h3>';
    }
           
    ?>

    </div>
   
    <footer id="main_footer" class="padding-20">
        <p class="center">
            Scandiweb Test assignment
        </p>
    </footer>
</form>
</body>

<script src="./js/products.js"></script>

</html> 