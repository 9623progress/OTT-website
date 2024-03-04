<?php
// Start the session and include the database connection file
session_start();
include "./Backend/dbcon.php";

// Assuming $userEmail is the logged-in user's email
$userEmail = $_SESSION['user_email_address'];

// Get the subject from the URL parameter
if (isset($_GET['subject'])) {
    $subject = $_GET['subject'];

    // Fetch distinct units for the subject from Admin table
    $distinctUnitsQuery = "SELECT DISTINCT unit FROM Admin WHERE subject = '$subject'";
    $distinctUnitsResult = $con->query($distinctUnitsQuery);

    // Check if the result is not null
    if ($distinctUnitsResult === false) {
        echo "Error fetching distinct units: " . $con->error;
        exit();
    }
} else {
    // Handle the case where subject is not provided
    echo "Subject not specified!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Content - <?php echo isset($subject) ? $subject : 'Undefined'; ?></title>
    <link rel="stylesheet" href="./CSS/display.css"> <!-- Include your styles here -->
</head>

<body>
    <button class="button">&#9776; Toggle Menu</button>
    <div class="container">
        <!-- Left section for navigation menu -->
        <div class="navigation-menu navigation-menu-hidden"> <!-- Initially hidden -->
            <a class="back" href="./index.php">&larr; Back to Home</a>
            <h2><?php echo isset($subject) ? $subject . ' - Navigation Menu' : 'Undefined - Navigation Menu'; ?></h2>
            <ul>
                <?php
                if (isset($distinctUnitsResult) && $distinctUnitsResult->num_rows > 0) {
                    while ($unitRow = $distinctUnitsResult->fetch_assoc()) {
                        $unit = $unitRow['unit'];
                        ?>
                        <div class="unit">
                            <?php
                            echo '<li><strong>' . $unit . '</strong></li>';
                            ?>
                        </div>
                        <?php
                        echo '<ul>';

                        // Fetch topics for the current unit
                        $topicsQuery = "SELECT topic FROM Admin WHERE subject = '$subject' AND unit = '$unit'";
                        $topicsResult = $con->query($topicsQuery);

                        while ($topicRow = $topicsResult->fetch_assoc()) {
                            ?>
                            <div class="topic">
                                <?php
                                echo '<li><a href="?subject=' . $subject . '&unit=' . $unit . '&topic=' . $topicRow['topic'] . '">' . $topicRow['topic'] . '</a></li>';
                                ?>
                            </div>
                        <?php
                        }

                        echo '</ul>';
                    }
                } else {
                    echo 'No distinct units found for the provided subject.';
                }
                ?>
            </ul>
        </div>

        <!-- Right section for content display -->
        <div class="content-display content-display-visible"> <!-- Initially visible -->
            <?php
            // Check if unit and topic are provided in the URL
            if (isset($_GET['unit']) && isset($_GET['topic'])) {
                $unit = $_GET['unit'];
                $topic = $_GET['topic'];

                // Fetch content for the selected unit and topic
                $contentQuery = "SELECT * FROM Admin WHERE subject = '$subject' AND unit = '$unit' AND topic = '$topic'";
                $contentResult = $con->query($contentQuery);

                while ($contentRow = $contentResult->fetch_assoc()) {
                    echo '<div class="content-item">';
                    echo '<h3>' . $contentRow['topic'] . '</h3>';

                    // Infer content type based on file extension
                    $contentPath = $contentRow['content'];
                    $contentType = pathinfo('../Update/' . $contentPath, PATHINFO_EXTENSION);

                    switch ($contentType) {
                        case 'mp4':
                            echo '<video controls width="100%" height="auto">';
                            echo '<source src="../Admin/Backend/content/' . $contentPath . '" type="video/mp4">';
                            echo 'Your browser does not support the video tag.';
                            echo '</video>';
                            break;

                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            echo '<img src="../Admin/Backend/content/' . $contentPath . '" alt="' . $contentRow['topic'] . '" style="width: 100%;">';
                            break;

                        case 'pdf':
                            echo '<object data="../Admin/Backend/content/' . $contentPath . '" type="application/pdf" width="100%" style="height: 100vh;"></object>';
                            break;

                        default:
                            echo 'Unsupported content type.';
                    }

                    echo '</div>';
                }
            } else {
                // Handle the case where unit and topic are not provided
                echo "Please select a unit and topic from the navigation menu.";
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.querySelector('.button');
            const navigationMenu = document.querySelector('.navigation-menu');
            const contentDisplay = document.querySelector('.content-display');

            button.addEventListener('click', function () {
                // Toggle classes for visibility
                navigationMenu.classList.toggle('navigation-menu-visible');
                navigationMenu.classList.toggle('navigation-menu-hidden');
                contentDisplay.classList.toggle('content-display-visible');
                contentDisplay.classList.toggle('content-display-hidden');
            });
        });
    </script>

</body>

</html>
