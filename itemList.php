<?php
	include('server/connection.php');

	$query_body_care = "SELECT * FROM products WHERE product_type='Body Care'";
	$body_care_prod = mysqli_query($conn, $query_body_care);

	$query_dental_care = "SELECT * FROM products WHERE product_type='Dental Care'";
	$dental_care_prod = mysqli_query($conn, $query_dental_care);

	$query_hair_care = "SELECT * FROM products WHERE product_type='Hair Care'";
	$hair_care_prod = mysqli_query($conn, $query_hair_care);

	$query_skin_care = "SELECT * FROM products WHERE product_type='Skin Care'";
	$skin_care_prod = mysqli_query($conn, $query_skin_care);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item</title>
    <link rel="stylesheet" href="style.css">
	<script src="script.js"></script>
	<script src="https://kit.fontawesome.com/34fcbc38f7.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!--Nav Bar-->
	<?php include('templates/header.php')?>
    <!--Item List-->

	<div class="header-itemList">
		<img class="itemList-pic" src="images/background2.png" alt="background_pic">
            <nav>
                <div class="content">
                    <h1>Watsis</h1>
                 	<a href="#BodyCare">Check Out Our Products Now!</a>
				</div>
            </nav>
	</div>
	<section id="product1" class="section-p1">
		<!--Body Care category-->
		<div id="BodyCare">
			<h2>Body Care</h2>
			<div class="pro-container">
				<?php while($row = mysqli_fetch_assoc($body_care_prod)){ ?>

					<div class ="pro" onclick="window.location.href='itemDetails.php?product_id=<?php echo $row['product_id']; ?>'">
						<img src="<?php echo $row['product_image1']; ?>" alt="">
						<div class= "des">
							<span>Watsis</span>
							<h5><?php echo $row['product_name']; ?></h5>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
							<h4>RM<?php echo $row['product_price']; ?></h4>
						</div>
						<a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>
					</div>
				<?php } ?>		
			</div>
		</div>

		<!--Dental Care category-->
		<div id="DentalCare">
			<h2>Dental Care</h2>
			<div class="pro-container">
				<?php while($row = mysqli_fetch_assoc($dental_care_prod)){ ?>

					<div class ="pro" onclick="window.location.href='itemDetails.php?product_id=<?php echo $row['product_id']; ?>'">
						<img src="<?php echo $row['product_image1']; ?>" alt="">
						<div class= "des">
							<span>Watsis</span>
							<h5><?php echo $row['product_name']; ?></h5>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
							<h4>RM<?php echo $row['product_price']; ?></h4>
						</div>
						<a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>
					</div>
				<?php } ?>		
			</div>
		</div>

		<!--Hair Care category-->
		<div id="HairCare">
			<h2>Hair Care</h2>
			<div class="pro-container">
				<?php while($row = mysqli_fetch_assoc($hair_care_prod)){ ?>

					<div class ="pro" onclick="window.location.href='itemDetails.php?product_id=<?php echo $row['product_id']; ?>'">
						<img src="<?php echo $row['product_image1']; ?>" alt="">
						<div class= "des">
							<span>Watsis</span>
							<h5><?php echo $row['product_name']; ?></h5>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
							<h4>RM<?php echo $row['product_price']; ?></h4>
						</div>
						<a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>
					</div>
				<?php } ?>		
			</div>
		</div>

		<!--Skin Care category-->
		<div id="SkinCare">
			<h2>Skin Care</h2>
			<div class="pro-container">
				<?php while($row = mysqli_fetch_assoc($skin_care_prod)){ ?>

					<div class ="pro" onclick="window.location.href='itemDetails.php?product_id=<?php echo $row['product_id']; ?>'">
						<img src="<?php echo $row['product_image1']; ?>" alt="">
						<div class= "des">
							<span>Watsis</span>
							<h5><?php echo $row['product_name']; ?></h5>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
							<h4>RM<?php echo $row['product_price']; ?></h4>
						</div>
						<a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>
					</div>
				<?php } ?>		
			</div>
		</div>
		<h2>New products Coming Soon!</h2>
	</section>

	<!--Footer-->
	<?php include('templates/footer.php')?>
</body>
</html>
