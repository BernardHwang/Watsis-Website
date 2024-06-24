<?php

	session_start();

	include('server\connection.php');

	// contact/index.php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Initialize variables
		$name = $_POST['name'] ?? '';
		$email = $_POST['email'] ?? '';
		$phone = $_POST['phone'] ?? '';

		// Initialize an array to hold error messages
		$errors = [];

		// Perform validation
		if (empty($name)) {
			$errors['name'] = '*Name is required';
		}
		if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = '*A valid email is required';
		}
		$phone = str_replace([' ', '-', '(', ')'], '', $phone); // Strip common formatting characters
		if (empty($phone)) {
			$errors['phone'] = '*Phone number is required.';
		} elseif (!ctype_digit($phone)) {
			$errors['phone'] = '*Phone number must be numeric.';
		} elseif(!preg_match("/^[0-9]{10}$/", $phone)){ // Corrected the regular expression pattern
			$errors['phone'] = '*Phone number should have 10 digits';
		}		
		
		// Check if there are any errors
		if (empty($errors)) {
			// Process the input (send mail, etc.)
			// For example:
			echo '<div class="container3">';
			echo "<h2>Submission Details</h2>";
			echo "Name: " . htmlspecialchars($name) . "<br>";
			echo "Email: " . htmlspecialchars($email) . "<br>";
			echo "Phone: " . htmlspecialchars($phone) . "<br>";
			//mail('jim@test.com', 'Contact Form Submission', $message, "From: $email");

			// Redirect or display a success message
			echo 'Thank you for contacting us! We will get back to you shortly.';
			echo "</div>";

			if (isset($_POST['submitForm'])) {
				//get info and store it in database
				$user_id = $_SESSION['user_id'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$country = $_POST['country'];  
				$subject = $_POST['subject'];

				$stmt = $conn->prepare("INSERT INTO contact(user_id, user_name, user_email, user_phone, user_country, subject)
								VALUES (?,?,?,?,?,?); ");

				$stmt->bind_param('isssss', $user_id, $name, $email, $phone, $country, $subject);

				$stmt_status= $stmt->execute();
				if (!$stmt_status){
					header('location: index.php');
					exit;
				}
			}
		} else {
			// Redisplay the form, with error messages
			include('contact_form.php');
		}
	} else {
		// Display the form for the first time
		$name = $email = $phone = $message = $salutation = '';
		$enquiry = [];
		$errors = [];
		include('contact_form.php');
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us Page</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
	<script src="https://kit.fontawesome.com/34fcbc38f7.js" crossorigin="anonymous"></script>
	<style>
        .error {
            color: red;
        }
   	</style>
</head>
<body>

	<script>
	<?php if (!empty($errors)) { ?>
		window.onload = function() {
			document.getElementById("containerId").style.display = "block";
		};
	<?php } ?>
	</script>
	<!--Nav Bar-->
    <?php include('templates/header.php')?>
	
	<section class="contact">
		<div class="content">
			<h2><b>Contact Us</b></h2>
				<h3><b>Ask us a question!</b></h3>
				<p>Watsis here,if you need to stay in contact with us, have doubts on your purchase and registration,
				please do not hesitate to contact us.
				</p>
				<p>Please feel free to fill in the form at the right bottom of the page, we will get in touch with you within 5 working days.
				We believe in providing the best cusotmers' satisfaction to you.</p>
		</div>
		<div class="container">
			<div class="contactInfo">
				<div class="box">
					<div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
					<div class="text">
						<h3>Address</h3>
						<p>Jalan Sungai Long,<br> Bandar Sungai Long, Cheras <br>43000 Kajang, Selangor.</p>
				</div>
				<div class="box">
					<div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
					<div class="text">
						<h3>Phone</h3>
						<p>+603-9086 0288</p>
				</div>
				<div class="box">
					<div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
					<div class="text">
						<h3>Email</h3>
						<p>info@utar.edu.my</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Footer-->
	<?php include('templates/footer.php')?>
</body>
</html>
