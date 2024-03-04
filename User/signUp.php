<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/Signup.css">
    <title>Sign Up Form</title>
</head>
<body>
    <div class="container">
        <form id="signup-form" action="#" method="post">
            <h2>Sign Up</h2>
            <!-- <label for="name">Name</label> -->
            <input type="text" id="name" name="name" placeholder="Name" required>

            <!-- <label for="email">Email</label> -->
            <input type="email" id="email" name="email" placeholder="Email" required>

            <!-- <label for="mobile">Mobile Number</label> -->
            <input type="tel" id="mobile" name="mobile" placeholder="Mobile no" required>

            <!-- <label for="password">Password</label> -->
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- <label for="confirm-password">Confirm Password</label> -->
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>

            
            <button type="submit" name="submit">Sign Up</button>
            <a href="./signin.php">Sign in</a>
            
        </form>
    </div>

    <?php
    include './Backend/dbcon.php';
    session_start();

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mob = $_POST['mobile'];
        $password = $_POST['password'];
        $cpassword = $_POST['confirm-password'];

        // Check if email already exists using prepared statement
        $emailquery = "SELECT * FROM user WHERE email=?";
        $stmtEmail = mysqli_prepare($con, $emailquery);
        mysqli_stmt_bind_param($stmtEmail, "s", $email);
        mysqli_stmt_execute($stmtEmail);
        $resultEmail = mysqli_stmt_get_result($stmtEmail);
        $emailcount = mysqli_num_rows($resultEmail);

        if($emailcount ==1){
            ?>
            <script> alert("Email already exists try to sign in by your email")</script>
            <?php
        } else {
            if($password === $cpassword){
                $pass = password_hash($password, PASSWORD_BCRYPT);
                $insertquery = "INSERT INTO user( name, email, mobile_no, password) VALUES ('$name', '$email', '$mob', '$pass')";
                $query = mysqli_query($con, $insertquery);
                
                if($query){
                    $_SESSION['user_email_address'] = $email;
                    header("Location: index.php"); // Redirect to a success page
                    exit();
                    // echo "Successfully inserted";
                } else {
                    echo "Not inserted";
                }
            } else {
                ?>
                <script> alert("Password and confirm password are not the same")</script>
                <?php
            }
        }

        // Close prepared statement (if used for INSERT)
        // mysqli_stmt_close($stmtInsert);
     } 
     //else {
    //     echo "No Button has been clicked";
    // }
    ?>
</body>
</html>
