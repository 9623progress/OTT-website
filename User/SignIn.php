<?php

// Include Configuration File
include('config.php');

$login_button = '';

// Check if Google has provided an authorization code
if (isset($_GET["code"])) {

    // Exchange the authorization code for an access token
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // Check if there is no error in fetching the access token
    if (!isset($token['error'])) {

        // Set the obtained access token
        $google_client->setAccessToken($token['access_token']);

        // Store the access token in the session
        $_SESSION['access_token'] = $token['access_token'];

        // Create a Google OAuth2 service
        $google_service = new Google_Service_Oauth2($google_client);

        // Retrieve user information
        $data = $google_service->userinfo->get();

        // Set session variables with user information
        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

// Check if the access token is not set
if (!isset($_SESSION['access_token'])) {

    // Generate a login link
    $login_button = '<a href="' . $google_client->createAuthUrl() . '">Login With Google</a>';
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./CSS/signin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
        <br />
        <h1>Welcome to Cognifront</h1>

        <br />

        <div class="form-container">
            <form id="signin-form" action="#" method="post">
                <h2>Sign In</h2>
                <input type="email" id="email" name="email" placeholder="Name" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit" name="submit">Sign In</button>
                <div class="register">
                    <a href="./signUp.php">Register</a>
                </div>
            </form>

            <p>or</p>

            <div class="panel panel-default">
                <?php
                if ($login_button == '') {
                    header("location:index.php");
                } else {
                ?>
                    <button class="google">
                        <img src="./images/google_logo.png" alt="#">
                        <?php
                        echo $login_button;
                        ?>
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    include './Backend/dbcon.php';

    // Start the session
    // session_start();

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $emailSearch = "SELECT * FROM user WHERE email='$email'";
        $query = mysqli_query($con, $emailSearch);

        if (!$query) {
            die("Query failed: " . mysqli_error($con));
        }

        $email_count = mysqli_num_rows($query);

        if ($email_count) {
            $email_pass = mysqli_fetch_assoc($query);
            $db_pass = $email_pass['password'];
            $pass_decode = password_verify($pass, $db_pass);

            $_SESSION['name'] = $email_pass['name'];

            if ($pass_decode) {
                ?>
                <script> alert("Login successful")</script>
                <?php
                $_SESSION['user_email_address'] = $email;

                header("Location: index.php"); // Redirect to a success page
                exit();
            } else {
                ?>
                <script> alert("Wrong Password")</script>
            <?php
            }
        } else {
            ?>
            <script> alert("Email does not exist")</script>
    <?php
        }
    }
    ?>
</body>

</html>
