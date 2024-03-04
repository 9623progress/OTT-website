<?php
include "./dbcon.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = array(); // Initialize a response array

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'];
    $newSubject = $_POST['new_subject'];
    $unit = $_POST['unit'];
    $newUnit = $_POST['new_unit'];
    $topic = $_POST['topic'];
    $info = $_POST['subject_description'];

    // Check if the user is adding a new subject and set the thumbnail accordingly
    if ($subject === 'add_new_subject') {
        $thumbnail = $_FILES['course_thumbnail']['name'];
        $thumbnail_temp = $_FILES['course_thumbnail']['tmp_name'];
        move_uploaded_file($thumbnail_temp, "./thumbnails/$thumbnail");
        $desc = $info; // Add the description for the new subject
        $subject = $newSubject;
    } else {
        // Get the thumbnail and description of the selected subject from the database
        $getQuery = "SELECT thumbnail, subject_description FROM Admin WHERE subject = '$subject' LIMIT 1";
        $Result = $con->query($getQuery);

        if ($Result->num_rows > 0) {
            $Row = $Result->fetch_assoc();
            $thumbnail = $Row['thumbnail'];
            $desc = $Row['subject_description'];
        } else {
            // Set a default value or handle the case when no thumbnail is found
            $thumbnail = "default_thumbnail.jpg";
            $desc = ""; // Set a default description or handle the case when no description is found
        }
    }

    // Check if the user is adding a new unit
    if ($unit === 'add_new_unit') {
        // You can customize the rest based on your needs
        $unitName = $newUnit;
    } else {
        // Use the existing unit name
        $unitName = $unit;
    }

    // For simplicity, assuming units don't have thumbnails
    $unitThumbnail = "default_unit_thumbnail.jpg";

    $content = $_FILES['content']['name'];
    $content_temp = $_FILES['content']['tmp_name'];
    move_uploaded_file($content_temp, "./content/$content");

    $sql = "INSERT INTO Admin (subject, unit, topic, thumbnail, content, subject_description)
            VALUES ('$subject', '$unitName', '$topic', '$thumbnail', '$content', '$desc')";

    if ($con->query($sql) === TRUE) {
       
        $response['status'] = 'success';
        $response['message'] = 'Data added successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error adding data: ' . $con->error;
    }

    // Send the JSON response
    echo json_encode($response);
}
?>
