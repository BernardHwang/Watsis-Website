<?php
// Start a session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['user_id'])) {
  // Redirect the user to the login page
  header("Location: signinupform.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Watsis Personal Care</title>
        <script src="https://kit.fontawesome.com/34fcbc38f7.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <!--Nav Bar-->
        <?php include('templates/header.php')?>
        
        <div class="homepage">
        <div class="backVideo">
            <video autoplay loop muted plays-inline class="back-video">
                <source src="images/background.mp4" type="video/mp4">
            </video>
                <nav>
                    <div class="content">
                        <h1>Watsis</h1>
                        <a href="itemList.php">Explore</a>
                    </div>
                </nav>
            </div>
            <div class="promote-prods">
                <div class="promote-prod">
                    <a href="itemDetails.php?product_id=6"><img src="images/promote_prod1" alt="promote_prod1"></a>
                    <div class="promote-prod-desc">
                        <p class="description">
                            "Is your hair feeling flat and lifeless? Does it lack volume? 
                            You're not alone. 
                            But there is a solution. Introducing Grafen Root Booster Shampoo, 
                            the special edition formula that will transform your hair."
                        </p>
                        
                        <p class="prod-name">
                            —— Grafen Root Booster Shampoo
                        </p>
                    </div>
                    
                </div>
                <div class="promote-prod">
                    <div class="promote-prod-desc">
                        <p class="description">
                            "Indulge in the transformative power of The Ritual of Sakura body oil. 
                            Enriched with cherry blossom extract and rice milk, 
                            this luxurious oil hydrates, nourishes and leaves your 
                            skin feeling irresistibly soft and smooth."
                        </p>
                        <p class="prod-name">
                            —— The Ritual of Sakura Body Oil
                        </p>
                        </div>
                    
                    <a href="itemDetails.php?product_id=3"><img src="images/promote_prod2" alt="promote_prod2"></a>
                    
                </div>
            </div>
            <div class="brief-aboutus">
                <div class="brief-mission">
                    <p>— Our mission —</p>
                </div>
                <div class="briefings">
                    <div class="briefing">
                        <img src="images/mission_icon.png" alt="mission_icon">
                        <p>Making it an essential part of everyday life.</p>
                    </div>
                    <div class="briefing">
                        <img src="images/product_icon.png" alt="product_icon">
                        <p>Provides top-quality products</p>
                    </div>
                    <div class="briefing">
                        <img src="images/customer_satisfaction_icon.png" alt="customer_satisfaction_icon">
                        <p>Your satisfaction is our priority</p>
                    </div>
                </div>
                <nav>
                <div class="content">
                 	<a href="aboutus.php">Explore more about us!</a>
				</div>
            </nav>
            </div>
            <div class="homepage-product">
                <p class="Featured-product">— Featured Product —</p>
                <div class="homepage-scroll-container">
                <?php include('server/get_featured_products.php');
                while($row = $featured_products->fetch_assoc()) { ?>
                <a href="itemDetails.php?product_id=<?php echo $row['product_id']; ?>">
                    <div class="image-container">
                        <img src="<?php echo $row['product_image1']; ?>" alt="">
                        <div class="overlay-homepage-img">
                            <h5><?php echo $row['product_name']; ?></h5>
                        </div>
                    </div>
                </a>
                <?php } ?>

                </div>
            </div>

            <div class="homepage-discovermore">
                <a href="itemList.php">Discover More</a>
            </div>
        </div>
        <?php include('templates/footer.php') ?>
    </body>
</html>
