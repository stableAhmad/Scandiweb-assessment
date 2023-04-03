<!DOCTYPE html>
<html>

<head>

    <title> Add</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign.css">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>

<body>

    <form action="./add_page.php" method="POST" id="product_form"  accept-charset="utf-8">

        <header id="main_header" class="padding-20">
            <h1 class="page_title">Product Add</h1>
            <div class="links">
                <button type="button" id="add_button">Save</button>
                <button type="button" id="cancel">Cancel</button>
            </div>
        </header>

        <div id="products_container">
            <div id="form_container">
                <div class="mt-4 outer">

                    <div class="mb-4" id="container">

                        <div class="form-group mb-3">
                            <lable>SKU</lable>
                            <input class="collect" name="sku" type="text" id="sku" value="<?php echo isset($_POST['sku']) ? $_POST['sku'] : ''; ?>">

                        </div>
                        <div class="form-group mb-3">
                            <lable>Name</lable>
                            <input class="collect" name="name" type="text" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">     
                        </div>
                        <div class="form-group mb-3">
                            <lable>Price</lable>
                            <input class="collect" name="price" type="text" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" id="price">
                        </div>
                        <div class="form-group mb-3">

                            <select class="collect" class="padding-5" selected="DVD" name="type" id="productType" >
                                <option disabled selected  value="">Type switcher</option>
                                <option  value="DVD">DVD</option>
                                <option  value="Book">Book</option>
                                <option  value="Furniture">Furniture</option>
                            </select>

                        </div>

                        <div id="extra"  class="form-group mb-3">
                            please select the product type
                        </div>
                        
                        <div id="messages"  class="form-group mb-3">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <footer id="main_footer" class="padding-20">
            <p class="center">
                Scandiweb Test assignment
            </p>
        </footer>

    </form>


  <button type="button"  id="launch_modal" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">Launch notification</button>


  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal_content">

        </div>
        <div class="modal-footer">
            <button type="button" class="" data-bs-dismiss="modal">Close</button>

        </div>
    </div>
</div>
</div>

</body>

<script src="./js/jquery.js"></script>
<script src="./js/add.js" ></script>
<script src="./js/bootstrap.bundle.min.js" ></script>

</html> 