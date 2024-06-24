<?php

session_start();

//Define error variables and variables with empty value
$fnameErr = $emailErr = $phoneErr = $addressErr = $cityErr = $stateErr = "";
$fname = $email = $phone = $address = $city = $state = "";

//Check if form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    //Validate name
    if(empty($_POST['fname'])){
        $fnameErr="Please enter your name.";
    } else {
        $fname=test_input($_POST['fname']);
        //Validate the name only contains alphabet and whitespace
        if(!preg_match("/^[a-zA-Z ]*$/", $fname)){
            $fnameErr="Please enter only alphabet and whitespace.";
        }
    }

    //Validate email
    if(empty($_POST['email'])){
        $emailErr="Please enter your email.";
    }else{
        $email=test_input($_POST['email']);
        //Validate the email structure
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr="Please enter valid email format. E.g. john24@gmail.com";
        }
    }

    //Validate phone
    if(empty($_POST['phone'])){
        $phoneErr="Please enter your phone number.";
    }else{
        $phone=test_input($_POST['phone']);
        $phone = str_replace([' ', '-', '(', ')', '+'], '', $phone); // Strip common formatting characters
        //Validate phone number consists only 10 digits
        if(!preg_match("/^[0-9]{10}$/", $phone)){
            $phoneErr="Please enter 10-digits phone number.";
        }
    }

    //Validate address
    if(empty($_POST['address'])){
        $addressErr="Please enter your address.";
    }else{
        $address=test_input($_POST['address']);
    }

    //Validate city
    if(empty($_POST['city'])){
        $cityErr="Please enter your city.";
    }else{
        $city=test_input($_POST['city']);
        //Validate city entered do not contains digit
        if(!preg_match("/^[a-zA-Z ]*$/", $city)){
            $cityErr="Please enter valid city name.";
        }
    }

    //Validate state
    if(empty($_POST['state'])){
        $stateErr="Please select your state.";
    }else{
        $state=$_POST['state'];
    }


    if(empty($fnameErr)&&empty($emailErr)&&empty($phoneErr)&&empty($addressErr)&&empty($cityErr)&&empty($stateErr)){
        // Store form data in session variables
        $_SESSION['delivery_data'] = array(
            'fname' => $fname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state
        );

        header("Location: payment.php");
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data); //remove whitespace before and after the name
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
  }

  if(isset($_SESSION['delivery_data'])){
    $delivery_data = $_SESSION['delivery_data'];
    $fname = isset($delivery_data['fname']) ? $delivery_data['fname'] : '';
    $email = isset($delivery_data['email']) ? $delivery_data['email'] : '';
    $phone = isset($delivery_data['phone']) ? $delivery_data['phone'] : '';
    $address = isset($delivery_data['address']) ? $delivery_data['address'] : '';
    $city = isset($delivery_data['city']) ? $delivery_data['city'] : '';
    $state = isset($delivery_data['state']) ? $delivery_data['state'] : '';
}

// Check if form data exists in $_POST, otherwise use session data
$fname = isset($_POST['fname']) ? $_POST['fname'] : $fname;
$email = isset($_POST['email']) ? $_POST['email'] : $email;
$phone = isset($_POST['phone']) ? $_POST['phone'] : $phone;
$address = isset($_POST['address']) ? $_POST['address'] : $address;
$city = isset($_POST['city']) ? $_POST['city'] : $city;
$state = isset($_POST['state']) ? $_POST['state'] : $state;

// Store and display the invalid input when user updates their input
$_SESSION['delivery_data'] = array(
    'fname' => $fname,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'city' => $city,
    'state' => $state
);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Checkout</title>
</head>
<body>
    <!--Navbar-->
    <?php include('templates/header.php')?>
    <!--Checkout-->
    <div class="checkout">
        <div class="checkout-form-container">
            <div class="checkout-form-title">
                <h2 id="delivery">Delivery</h2>
                <h2 id="payment">Payment</h2>
            </div>
            <hr>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="checkout-form">
                <div class="corow">
                    <div class="col-50">
                        <h3>Delivery Information</h3>
                        <div class="nameInput">
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" id="fname" name="fname" placeholder="John M. Doe" value="<?php echo isset($_SESSION['delivery_data']['fname']) ? htmlspecialchars($_SESSION['delivery_data']['fname']) : ''; ?>">
                            <p class="error"><?php echo $fnameErr; ?></p>
                        </div>
                        <div class="emailInput">
                            <label for="email"><i class="fa fa-envelope"></i> Email</label><br>
                            <input type="email" id="email" name="email" placeholder="john@example.com" value="<?php echo isset($_SESSION['delivery_data']['email']) ? htmlspecialchars($_SESSION['delivery_data']['email']) : ''; ?>">
                            <p class="error"><?php echo $emailErr; ?></p>
                        </div>
                        <div class="phoneInput">
                            <label for="phone"><i class="fa fa-phone"></i>Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="0123456789" value="<?php echo isset($_SESSION['delivery_data']['phone']) ? htmlspecialchars($_SESSION['delivery_data']['phone']) : ''; ?>">
                            <p class="error"><?php echo $phoneErr; ?></p>
                        </div>
                        <div class="addressInput">
                            <label for="address"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="address" name="address" placeholder="88, Jalan Sungai Long" value="<?php echo isset($_SESSION['delivery_data']['address']) ? htmlspecialchars($_SESSION['delivery_data']['address']) : ''; ?>">
                            <p class="error"><?php echo $addressErr; ?></p>
                        </div>
                        <div class="cityInput">
                            <label for="city"><i class="fa fa-map-marker"></i> City</label>
                            <input type="text" id="city" name="city" placeholder="Kajang" value="<?php echo isset($_SESSION['delivery_data']['city']) ? htmlspecialchars($_SESSION['delivery_data']['city']) : ''; ?>">
                            <p class="error"><?php echo $cityErr; ?></p>
                        </div>
                        <div class="stateInput">
                            <label for="state"><i class="fa fa-institution"></i> State</label>
                            <select id="state" name="state">
                                <option value="" disabled selected>Select state</option>
                                <option value="Johor" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Johor") echo 'selected="selected"'; ?>>Johor</option>
                                <option value="Kedah" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Kedah") echo 'selected="selected"'; ?>>Kedah</option>
                                <option value="Kelantan" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Kelantan") echo 'selected="selected"'; ?>>Kelantan</option>
                                <option value="Melaka" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Melaka") echo 'selected="selected"'; ?>>Melaka</option>
                                <option value="Negeri Sembilan" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Negeri Sembilan") echo 'selected="selected"'; ?>>Negeri Sembilan</option>
                                <option value="Pahang" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Pahang") echo 'selected="selected"'; ?>>Pahang</option>
                                <option value="Pulau Pinang" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Pulau Pinang") echo 'selected="selected"'; ?>>Pulau Pinang</option>
                                <option value="Perlis" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Perlis") echo 'selected="selected"'; ?>>Perlis</option>
                                <option value="Perak" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Perak") echo 'selected="selected"'; ?>>Perak</option>
                                <option value="Sabah" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Sabah") echo 'selected="selected"'; ?>>Sabah</option>
                                <option value="Sarawak" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Sarawak") echo 'selected="selected"'; ?>>Sarawak</option>
                                <option value="Selangor" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Selangor") echo 'selected="selected"'; ?>>Selangor</option>
                                <option value="Terengganu" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Terengganu") echo 'selected="selected"'; ?>>Terengganu</option>
                                <option value="Wilayah Persekutuan Kuala Lumpur" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Wilayah Persekutuan Kuala Lumpur") echo 'selected="selected"'; ?>>Wilayah Persekutuan Kuala Lumpur</option>
                                <option value="Wilayah Persekutuan Labuan" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Wilayah Persekutuan Labuan") echo 'selected="selected"'; ?>>Wilayah Persekutuan Labuan</option>
                                <option value="Wilayah Persekutuan Putrajaya" <?php if(isset($_SESSION['delivery_data']['state']) && $_SESSION['delivery_data']['state'] == "Wilayah Persekutuan Putrajaya") echo 'selected="selected"'; ?>>Wilayah Persekutuan Putrajaya</option>
                            </select><br>
                            <p class="error"><?php echo $stateErr; ?></p>
                        </div>
                    </div>
                </div>
                <div class="checkout-button">
                    <button type="button" name="backBtn" onclick="window.location.href='cart.php';">Back</button>
                    <button type="submit" name="submitBtn">Submit</button>
                </div>
            </form>  
        </div>
    </div>
    <?php include("templates/footer.php")?>
</body>
</html>