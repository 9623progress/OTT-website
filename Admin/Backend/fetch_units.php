<?php
include "dbcon.php"; // Include your database connection file

// Check if the subject parameter is set
if (isset($_GET['subject'])) {
    $subject = $_GET['subject'];

    // Fetch distinct units based on the selected subject
    $unitQuery = "SELECT DISTINCT unit FROM Admin WHERE subject = '$subject'";
    $unitResult = $con->query($unitQuery);

    $units = array();

    while ($row = $unitResult->fetch_assoc()) {
        $units[] = $row['unit'];
    }

    // Return the units as JSON
    header('Content-Type: application/json'); // Set the content type
    echo json_encode($units);
} else {
    // If subject parameter is not set, return an empty JSON array
    header('Content-Type: application/json'); // Set the content type
    echo json_encode(array());
}
?>
