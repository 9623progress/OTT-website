<?php
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $userEmail = $_POST['user_email'];

    // Assuming you have a table named 'cart' with columns 'subject' and 'user_email'
    $addToCartQuery = "INSERT INTO cart (subject, email) VALUES ('$subject', '$userEmail')";
    $addToCartResult = $con->query($addToCartQuery);

    if ($addToCartResult) {
        echo "Added to cart successfully.";
    } else {
        echo "Error adding to cart.";
    }
}
?>
