<?php
include "dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $price = $_POST['price'];

    // Insert data into the "price" table
    $insertQuery = "INSERT INTO price (subject, price) VALUES ('$subject', '$price')";
    $insertResult = $con->query($insertQuery);

    if ($insertResult) {
        echo "Price details added successfully.";
    } else {
        echo "Error adding price details.";
    }
}
?>
