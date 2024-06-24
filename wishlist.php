<?php
session_start();

// Check if wishlist session variable is initialized
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

if(isset($_POST['addwishlist'])){

    //if user has added a product to wishlist before
    if(isset($_SESSION['wishlist'])){

        //get all product id that have been added to wishlist
        $products_array_ids = array_column($_SESSION['wishlist'], "product_id");
        //if product that user want to add to cart has not been added to cart before
        if(!in_array($_POST['product_id'], $products_array_ids)){

            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' =>$_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image']
            );

            $_SESSION['wishlist'][$product_id] = $product_array;

        //if product has been added to cart before
        }else{
            echo '<script> alert("Product was added to wishlist before!"); </script>';
        }
    //if this is the first product added to wishlist
    }else{

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
        );

        $_SESSION['wishlist'][$product_id] = $product_array;
    }
}else if(isset($_POST['remove_wishlist'])){

    $product_id = $_POST['product_id'];
    unset($_SESSION['wishlist'][$product_id]);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>
    <title>Wishlist</title>
</head>
<body>
    <!--Nav Bar-->
    <?php include('templates/header.php')?>
    <!--Wishlist-->
    <section class="wishlist">

        <h2 class="heading">Wishlist</h2>
        
        <div class="box_container">
        <?php if (!empty($_SESSION['wishlist'])) { ?>
        <?php foreach($_SESSION['wishlist'] as $key => $value){ ?>
            <div class="box">
                <div class="product">
                    <span class="stock_status">In Stock</span>
                    <div class="image" onclick="window.location.href='itemDetails.php?product_id=<?php echo $value['product_id']; ?>'">
                        <img src="<?php echo $value['product_image'];?>" alt="product image">
                    </div>
                    <div class="content">
                        <p class = prod_name><?php echo $value['product_name'];?></p>
                        <p class = prod_price>RM <?php echo $value['product_price'];?></p>
                    </div>
                </div>
                
                <div class="btn">
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                        <input type="hidden" name="product_image" value="<?php echo $value['product_image']; ?>"/>
                        <input type="hidden" name="product_name" value="<?php echo $value['product_name']; ?>"/>
                        <input type="hidden" name="product_price" value="<?php echo $value['product_price']; ?>"/>
                        <input type="hidden" name='product_qty' value="1">
                        <input type="submit" class="button" id="addcartbtn" name="addcart" value="Add to Cart">
                    </form>
                    <form method="POST" action="wishlist.php">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                        <input type="submit" class="button" id="removebtn" name="remove_wishlist" value="Remove">
                    </form>
                </div>

            </div>
        <?php } ?>
        <?php } else { ?>
            <div class="empty_wishlist_message">
                <p>Your wishlist is empty.</p>
                <p>Browse more <a href="itemList.php">Watsis products</a> and add to wishlist now!</p>
            </div>
        <?php } ?>
        </div>

                
    </section>

    <!--Footer-->
    <?php include('templates/footer.php')?>
</body>
</html>

