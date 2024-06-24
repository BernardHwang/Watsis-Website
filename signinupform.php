<?php
    session_start();
    include("server/connection.php");

    $signin_uname = $signin_psw = $email = $signup_uname = $signup_psw = $repeatPsw = '';
    $signin_unameErr = $signin_pswErr = $emailErr = $signup_unameErr = $signup_pswErr = $repeatPswErr = $checkUsernameErr = $checkUsernameErr2 = '';
    $showPopup = false;

    // Function to sanitize input data
    function test_input($data) {
        $data = trim($data); //remove whitespace before and after the name
        $data = stripslashes($data); 
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validation and processing for login form
    if (isset($_POST['loginSubmit'])) {
        // Validate username
        if(empty($_POST['signin_uname'])){
            $signin_unameErr = "Please enter your name.";
        } else {
            $signin_uname = test_input($_POST['signin_uname']);
            // Validate username only consists of alphabet and whitespace
            if(!preg_match("/^[a-zA-Z ]*$/", $signin_uname)){
                $signin_unameErr = "Please enter only alphabet and whitespace.";
                $signin_uname = '';
            }
        }

        // Validate password for sign-in
        if (empty($_POST['signin_psw'])) {
            $signin_pswErr = 'Password is required for sign-in';
        }

        // If no validation errors, proceed with form submission
        if(empty($signin_unameErr) && empty($signin_pswErr)){
            $username = $_POST['signin_uname'];
            $password = $_POST['signin_psw'];

            // Retrieve hashed password from the database
            $checkPasswordQuery = "SELECT user_id, user_password FROM users WHERE user_username = ?";
            $stmt = $conn->prepare($checkPasswordQuery);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                $checkUsernameErr = "Invalid username or password.";
            }
            else {
                // Fetch the hashed password
                $row = $result->fetch_assoc();
                $hashed_password = $row['user_password'];

                // Verify the entered password against the hashed password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, log the user in
                    $user_id = $row['user_id'];

                    // Store user_id in session
                    $_SESSION['user_id'] = $user_id;

                    // Redirect to index.php or any other page after successful login
                    header("Location: index.php");
                    exit();
                } else {
                    // Password is incorrect
                    $checkUsernameErr = "Invalid username or password.";
                }
            }
        }
    }


    // Validation and processing for signup form
    if (isset($_POST['signupSubmit'])) {
        // Validate email
        if(empty($_POST['email'])){
            $emailErr="Please enter your email.";
        } else {
            $email = test_input($_POST['email']);
            // Validate the email structure
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr="Please enter valid email format. E.g. john24@gmail.com";
                $email = '';
            }
        }

        // Validate username
        if(empty($_POST['signup_uname'])){
            $signup_unameErr = "Please enter your name.";
        } else {
            $signup_uname = test_input($_POST['signup_uname']);
            // Validate username only consists of alphabet and whitespace
            if(!preg_match("/^[a-zA-Z ]*$/", $signup_uname)){
                $signup_unameErr = "Please enter only alphabet and whitespace.";
                $signup_uname = '';
            }
        }

        // Validate password for sign-up
        if (empty($_POST['signup_psw'])) {
            $signup_pswErr = 'Password is required for sign-up';
        }

        // Validate repeated password
        if (empty($_POST['repeatPsw'])) {
            $repeatPswErr = 'Repeat Password is required for sign-up';
        } else if ($_POST['repeatPsw'] !== $_POST['signup_psw']) {
            $repeatPswErr = 'The repeated password does not match with the password above';
            $repeatPsw = '';
        }

        // If no validation errors, proceed with form submission
        if(empty($emailErr) && empty($signup_unameErr) && empty($signup_pswErr) && empty($repeatPswErr)){
            $email = $_POST['email'];
            $username = $_POST['signup_uname'];
            $password = $_POST['signup_psw'];
        
            $checkUsername = "SELECT user_username FROM users WHERE user_username = ?";
            $stmt = $conn->prepare($checkUsername);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $checkUsernameErr2 = "The username has been registered.";
            }
            else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (user_email, user_username, user_password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $email, $username, $hashed_password); // Insert hashed password
                $stmt->execute();
                echo "<script>alert('Registration successful! Please login to continue.');</script>";
                $signup_uname = $email = '';
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body style="padding-top: 0;">
    <div class="sign-in-up-logo">
        <img src = "images\watsis_personal_care-xbg.png" alt="watsis_logo">
    </div>
    <div class="sign-in-up-formbox">
        <div class="sign-in-up-button-box">
            <div id="sign-in-up-btn"></div>
            <button type="button" class="toggle-sign-in-up" onclick="login()">Log In</button>
            <button type="button" class="toggle-sign-in-up" onclick="signup()">Sign up</button>
        </div>
        <form id="login" class="input-sign-in-up" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <span class="error"><?php echo $checkUsernameErr; ?></span>
            <input type="text" class="input-sign-details" placeholder="Username" name="signin_uname" value="<?= htmlspecialchars($signin_uname) ?>">
            <span class="error"><?php echo $signin_unameErr; ?></span>
            <input type="password" class="input-sign-details" placeholder="Password" name="signin_psw">
            <span class="error"><?php echo $signin_pswErr; ?></span>
            <button type="submit" class="sign-in-up-btn" name="loginSubmit" onclick="submitLoginForm()">Log In</button>
        </form>
        <form id="signup" class="input-sign-in-up" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <span class="error"><?php echo $checkUsernameErr2; ?></span>
            <input type="text" class="input-sign-details" placeholder="Username" name="signup_uname" value="<?= htmlspecialchars($signup_uname) ?>">
            <span class="error"><?php echo $signup_unameErr; ?></span>
            <input type="text" class="input-sign-details" placeholder="Email" name="email" value="<?= htmlspecialchars($email) ?>">
            <span class="error"><?php echo $emailErr; ?></span>
            <input type="password" class="input-sign-details" placeholder="Password" name="signup_psw">
            <span class="error"><?php echo $signup_pswErr; ?></span>
            <input type="password" class="input-sign-details" placeholder="Repeat Password" name="repeatPsw">
            <span class="error"><?php echo $repeatPswErr; ?></span>
            <button type="submit" class="sign-in-up-btn" name="signupSubmit" onclick="submitSignupForm()">Sign Up</button>
        </form>
    </div>
    <script>
        function signup() {
            document.getElementById("login").style.left = "-400px";
            document.getElementById("signup").style.left = "50px";
            document.getElementById("sign-in-up-btn").style.left = "110px";
        }
        
        function login() {
            document.getElementById("login").style.left = "50px";
            document.getElementById("signup").style.left = "450px";
            document.getElementById("sign-in-up-btn").style.left = "0px";
        }
        
        // Store active tab before form submission
        function submitLoginForm() {
            sessionStorage.setItem('activeTab', 'login');
            // AJAX submission logic
        }
        
        function submitSignupForm() {
            sessionStorage.setItem('activeTab', 'signup');
            // AJAX submission logic
        }
        
        // Ensure that the same tab is displayed after page reload
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = sessionStorage.getItem('activeTab');
            if (activeTab === 'signup') {
                signup();
            } else {
                login();
            }
        });
    </script>
</body>
</html>
