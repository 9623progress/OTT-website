<?php
// Assuming you have a database connection established
include "./Backend/dbcon.php";

// Start the session
session_start();
header('Permissions-Policy: payment=(self "https://api.razorpay.com/v1")');

// Check if the user is logged in
if (isset($_SESSION['user_email_address'])) {
    $userEmail = $_SESSION['user_email_address'];

    $userQuery="SELECT * FROM user where email='$userEmail'";
    $userResult=$con->query($userQuery);

    if($userRow = $userResult->fetch_assoc()){
        $_SESSION['user_id']=$userRow['id'];
        $_SESSION['name']=$userRow['name'];
    }




    // Fetch user's cart items
    $cartQuery = "SELECT * FROM cart WHERE email = '$userEmail'";
    $cartResult = $con->query($cartQuery);

    // Initialize variables to store total price and cart items
    $totalPrice = 0;
    $cartItems = array();

    // Loop through the cart items
    while ($cartRow = $cartResult->fetch_assoc()) {
        $subjectName = $cartRow['subject'];

        // Fetch subject details including 'thumbnail' from 'Admin' table
        $subjectQuery = "SELECT * FROM Admin WHERE subject = '$subjectName' ";
        $subjectResult = $con->query($subjectQuery);
        $subjectRow = $subjectResult->fetch_assoc();

        // Fetch price details
        $priceQuery = "SELECT * FROM price WHERE subject = '$subjectName'";
        $priceResult = $con->query($priceQuery);
        $priceRow = $priceResult->fetch_assoc();

        $id=$cartRow['id'];
        // Calculate total price
        $totalPrice += $priceRow['price'];

        // Store cart item details
        $cartItems[] = array(
            'id' => $id,
            'subject' => $subjectName,
            'thumbnail' => $subjectRow['thumbnail'], // Use 'thumbnail' from 'Admin'
            'price' => $priceRow['price']
        );
    }
} else {
    // Redirect to login page or display a message for non-logged-in users
    header("Location: signIn.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/cart.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/phone.css">
    <title>User Cart Details</title>
    <!-- Add your CSS styles here -->
</head>

<body>
    <div class="navbar" id="myNavbar">
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"> &#9776;</a>
        <div>
            <a href="#" class="logo">Cognifront</a>
        </div>

        <div class="nav">
            <a href="./index.php">Home</a>
            <a href="./index.php">Courses</a>
            <a href="./subscription.php">My Courses</a>
            <?php
            if(isset($_SESSION['user_email_address'])){
                ?>
            <a href="logout.php">Log out</a>
            <?php
            }
            else{
                ?>
            <a href="SignIn.php">SignIn</a>
            <?php
            }
            ?>

            <a class="cart-link" href="./cart.php">
                <img class="cart-img" src="./images/cart.png" alt="Cart">
            </a>
        </div>

    </div>



    <?php if (!empty($cartItems)) { ?>

    <div class="items">
        <h2>Your cart details</h2>
        <?php foreach ($cartItems as $item) { ?>
        <div class="cart-item">
            <p>Subject: <?php echo $item['subject']; ?></p>
            <img src="../Admin/Backend/thumbnails/<?php echo $item['thumbnail']; ?>" alt="Thumbnail">
            <p>Price: Rs.<?php echo $item['price']; ?></p>
            <button onclick="toggleDeleteConfirmationPrice(<?php echo $item['id']; ?>)">Delete from Cart</button>
            <!-- Inside the cart item loop -->
            <form action="./checkout.php" method="post">
                <input type="hidden" name="amount" value="<?php echo $item['price']; ?>">
                <input type="hidden" name="subject" value="<?php echo $item['subject']; ?>">
                <button type="submit">Proceed to Payment</button>
            </form>

           
        </div>
        <?php } 
        
        
        ?>

    </div>
    <?php } else { ?>
    <p>No items in the cart.</p>
    <?php } ?>

    <!-- Add your HTML and CSS for better UI presentation -->


    <script src="./JavaScript/user.js"></script>

</body>

</html>