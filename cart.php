<?php
session_start();

// Ensure session cart variable is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_POST['addcart'])){

    //if user has added product to cart before
    if(isset($_SESSION['cart'])){

        //get all product id that have been added to cart
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        //if product that user want to add to cart has not been added to cart before
        if(!in_array($_POST['product_id'], $products_array_ids)){

            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' =>$_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_qty' => $_POST['product_qty']
            );

            $_SESSION['cart'][$product_id] = $product_array;

        //if product has been added to cart before
        }else{
            echo '<script> alert("Product was added to cart before!"); </script>';
        }
        // if user first time add to cart
    }else{

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_qty = $_POST['product_qty'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_qty' => $product_qty
        );

        $_SESSION['cart'][$product_id] = $product_array;

    }

    //calculate total
    calculateTotalCart();

}else if(isset($_POST['remove_product'])){

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

    //calculate total
    calculateTotalCart();

}else if(isset($_POST['decrement'])|| isset($_POST['increment'])){

    //get id and quantity from the form
    $product_id = $_POST['product_id'];
    $product_array = $_SESSION['cart'][$product_id];
    $current_qty = $product_array['product_qty'];

    if (isset($_POST['increment'])) {
        $new_qty = $current_qty + 1;
    } elseif (isset($_POST['decrement']) && $current_qty > 1) {
        $new_qty = $current_qty - 1;
    } else {
        // If neither increment nor decrement is set or decrementing below 1, do nothing
        $new_qty = $current_qty;
    }

    // Update product quantity
    $product_array['product_qty'] = $new_qty;

    // Update session cart
    $_SESSION['cart'][$product_id] = $product_array;

    // Calculate total
    calculateTotalCart();

}

function calculateTotalCart(){

    $total=0;

    foreach($_SESSION['cart'] as $key => $value){
        $product=$_SESSION['cart'][$key];
        $price=$product['product_price'];
        $quantity=$product['product_qty'];
        $total+=$price*$quantity;
    }

    $_SESSION['total']=$total;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/34fcbc38f7.js" crossorigin="anonymous"></script>
</head>
<body>
    <!--Nav Bar-->
    <?php include('templates/header.php')?>
    <!--Cart-->
    <section class="cart">
        <div class="heading">
            <h2 class="my_shopping_bag">My Shopping Bag</h2>
        </div>

        <div class="box_container">
            <?php if (!empty($_SESSION['cart'])) { ?>
            <div class="prod_box">
            <?php foreach($_SESSION['cart'] as $key => $value){ ?>
                <div class="cart_prod">
                    <form method="POST" action="cart.php">
                    <div class="remove_icon">
                        <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                        <button type="submit" name="remove_product">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                    </form>

                    <div class="prod_img">
                        <img src="<?php echo $value['product_image'];?>" />
                    </div>

                    <div class="prod_info">
                        <div class="prod_name">
                            <h4><?php echo $value['product_name'];?></h4>
                        </div>
                        <div class="prod_price">
                            <span>RM</span>
                            <span class="prod_price"><?php echo $value['product_price'];?></span>
                        </div>
                        
                        <form method="POST" action="cart.php">
                        <div class="prod_quantity">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                            <button type="submit" name="decrement" onclick="decrement(<?php echo $value['product_id'];?>, <?php echo $value['product_price'];?>)">-</button>
                            <input type="text" name="product_qty_<?php echo $value['product_id'];?>" id="quantity_<?php echo $value['product_id'];?>" value="<?php echo $value['product_qty'];?>" min="1">
                            <button type="submit" name="increment" onclick="increment(<?php echo $value['product_id'];?>, <?php echo $value['product_price'];?>)">+</button>
                        </div>
                        </form>
                    </div>

                    <div class="prod_total">
                        <h5>Total</h5>
                        <span class="prod_total" id="prod_total_<?php echo $value['product_id'];?>">RM <?php echo number_format($value['product_qty'] * $value['product_price'], 2) ?></span>

                    </div>
                </div>
            <?php } ?>
            </div>
            
            <div class="checkout_box">
                <div class="order_summary">
                    <h3>Order Summary</h3>
                    <div class="order_summary_row">
                        <span id="title">Subtotal</span>
                        <span id="amount">RM <span><?php echo number_format($_SESSION['total'], 2); ?></span></span>
                    </div>
                    <div class="order_summary_row">
                        <span id="title">Delivery</span>
                        <span id="amount">RM <span>4.90</span></span>
                    </div>
                </div>
                <hr>
                <div class="total">
                    <span id="title">Total</span>
                    <span id="amount">RM <span><?php echo number_format($_SESSION['total'] + 4.90, 2); ?></span></span>
                </div>
                
                <br>
                <div class="checkout_button">
                    <button onclick="location.href='delivery.php'">Checkout</button>
                </div>
            </div>
            <?php } else { ?>
            <div class="empty_cart_message">
                <p>Your cart is empty.</p>
                <p>Browse more <a href="itemList.php">Watsis products</a> and add to cart now!</p>
            </div>
            <?php } ?>
        </div>

    </section>

    <!--Footer-->
    <?php include('templates/footer.php')?>
    <script>
        //Function to increase cart product quantity and update price accordingly
        function increment(productId, productPrice) {
            var quantityInput = document.getElementById('quantity_' + productId);
            var currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
            updateTotal(productId, productPrice);
        }

        //Function to decrease cart product quantity and update price accordingly
        function decrement(productId, productPrice) {
            var quantityInput = document.getElementById('quantity_' + productId);
            var currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
                updateTotal(productId, productPrice);
            }
        }

        //Function to update price
        function updateTotal(productId, productPrice) {
            var quantityInput = document.getElementById('quantity_' + productId);
            var productQty = parseInt(quantityInput.value);
            var productTotal = productQty * productPrice;
            var totalElement = document.getElementById('prod_total_' + productId);
            totalElement.textContent = 'RM ' + productTotal.toFixed(2);
        }
    </script>
</body>
</html>
