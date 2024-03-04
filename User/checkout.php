<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";
include "./Backend/dbcon.php"; // Assuming this file contains your database connection code

$subject = $_POST['subject'];
$amount_data = $_POST['amount'];
$amount = $amount_data * 100;

$stripe_secret_key = "your_secret_key";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/OTT/user/success.php",
    "cancel_url" => "http://localhost/OTT/user/index.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "inr",
                "unit_amount" => $amount,
                "product_data" => [
                    "name" => $subject
                ]
            ]
        ],
    ]
]);

// Get the user's email from the session or wherever it's stored
$email = $_SESSION['user_email_address']; // Update this line according to how you store the user's email

// Call the savePaymentDetails function after defining it
savePaymentDetails($email, $subject, $amount/100);

// Redirect to the checkout session URL
http_response_code(303);
header("Location: " . $checkout_session->url);

// Function to save data to the database
function savePaymentDetails($email, $subject, $amount) {
    global $con;

    // Prepare and execute the SQL query to insert data
    $stmt = $con->prepare("INSERT INTO subscription(email, subject, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $email, $subject, $amount); // 'ssd' represents string, string, double
    $stmt->execute();
    $stmt->close();
}
?>