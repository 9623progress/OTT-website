<?php
session_start();
// echo "Session value: " . $_SESSION['user_email_address'];
$isLoggedIn = $_SESSION['user_email_address'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cognifront</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/phone.css">
</head>

<body>
    <!------------------------------------------- navbar------------------------------------------- -->
    <div class="navbar" id="myNavbar">
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"> &#9776;</a>
        <div>
            <a href="#" class="logo">Cognifront</a>
        </div>

        <div class="nav">
            <a href="#home">Home</a>
            <a href="#course">Courses</a>
            <a href="./subscription.php">My Courses</a>
            <?php
            if (isset($_SESSION['user_email_address'])) {
                ?>
                <a href="logout.php">Log out</a>
            <?php
            } else {
                ?>
                <a href="SignIn.php">SignIn</a>
            <?php
            }
            ?>

            <a class="cart-link" id="c_link" href="./cart.php">
                <img class="cart-img" src="./images/cart.png" alt="Cart">
            </a>
        </div>
    </div>
    <!-- -------------------------------------tagline------------------------------------------------------- -->
    <div class="tagline">
        <div class="heading">
            <h1>Inspire Your Classroom</h1>
            <p>Your students are distracted on their phones and with their friends. Most importantly distracted by their
                thoughts. Grab their attention.</p>
        </div>
        <div class="image">
            <img src="./images/img.png" alt="#">
        </div>
    </div>
    <!-- ----------------------------------why choose cognifront ------------------------------------------------->
    <div class="section">
        <h1>Why you Choose Cognifront ?</h1>
        <p>Cognifront is offering commendable service for the cause of technical education. If it works with the same
            passion, it may emerge as one of the value-added product development and service companies.</p>
    </div>

    <!------------------------------------ our courses----------------------------------------------------------------- -->
    <h1>Our Courses</h1>

    <div class="card" id="course">
        <?php
        // Assuming you have a database connection established
        include "./Backend/dbcon.php";

        // Fetch unique course names from the database
        $uniqueCourseQuery = "SELECT DISTINCT subject FROM Admin"; // Replace 'Admin' with your actual table name
        $uniqueCourseResult = $con->query($uniqueCourseQuery);

        // Loop through the unique course names and generate cards
        while ($row = $uniqueCourseResult->fetch_assoc()) {
            // Fetch additional details for the course based on the unique course name
            $courseDetailsQuery = "SELECT * FROM Admin WHERE subject = '" . $row['subject'] . "'";
            $courseDetailsResult = $con->query($courseDetailsQuery);
            $courseDetails = $courseDetailsResult->fetch_assoc();
            ?>
            <div class="course-card">
                <div class="thumbnail">
                  <!-- this path is taken from database  in admin folder actual file are stored in thumnail-->
                    <img src="<?php echo "../Admin/Backend/thumbnails/" . $courseDetails['thumbnail']; ?>"
                        alt="<?php echo $courseDetails['subject']; ?>">
                </div>
                <div class="course-details">
                    <div class="course-name">
                        <p><?php echo $courseDetails['subject']; ?></p>
                    </div>
                    <div class="price">
                        <?php
                        $subject = $courseDetails['subject'];
                        $priceQuery = "SELECT * FROM price WHERE subject = '$subject'";
                        $priceResult = $con->query($priceQuery);
                        if ($priceResult) {
                            // Fetch and process the data here
                            while ($row = $priceResult->fetch_assoc()) {
                                // Process each row of data
                                $priceValue = $row['price'];
                                // Do something with $priceValue
                                echo "Rs.";
                                echo $priceValue;
                            }
                        } else {
                            // Handle the case where the query fails
                            echo "Error executing price query: " . $con->error;
                        }
                        ?>
                    </div>
                    <!-- rating start from here -->
                    <div class="rating">
                        <div class="rating-section">
                            <div class="given">
                                <!-- <p>Overall rating</p> -->
                                <?php
                                $user_email = $isLoggedIn;
                                $subject_ratings = "SELECT AVG(rating) AS average_rating FROM rating WHERE subject_id ='$subject'";
                                $checksubjectRatings = mysqli_query($con, $subject_ratings);

                                if ($checksubjectRatings) {
                                    // Check if there are ratings for the subject
                                    if (mysqli_num_rows($checksubjectRatings) > 0) {
                                        $subjectR = mysqli_fetch_assoc($checksubjectRatings);
                                        $count = $subjectR['average_rating'];
                                    } else {
                                        // No ratings found for the subject
                                        $count = 0;
                                    }
                                } else {
                                    // Query execution failed
                                    $count = 0; // or handle the error as needed
                                }

                                $i = 0;

                                while ($i < 5) {
                                    if ($count != 0) {
                                        ?>
                                        <span class="mark">&#9733;</span>
                                    <?php
                                        $count--;
                                    } else {
                                        ?>
                                        <span class="unmark">&#9733;</span>
                                    <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="dropdown-btn" onclick="toggleDropdownOptions('<?php echo $subject; ?>')">
                                <button class="drop">^</button>
                            </div>
                        </div>
                        <div id="dropdownOptions_<?php echo $subject; ?>" class="dropdown-options">
                            <?php
                            $checkRatingQuery = "SELECT * FROM rating WHERE email = '$user_email' AND subject_id = '$subject'";
                            $checkRatingResult = mysqli_query($con, $checkRatingQuery);

                            if (mysqli_num_rows($checkRatingResult) > 0) {
                                $prevR = mysqli_fetch_assoc($checkRatingResult);
                                $count = $prevR['rating'];
                                $i = 0;
                                ?>
                                <div>
                                    <!-- if user already rating given then that dispaly -->
                                    <p>Your rating</p>
                                    <?php
                                    while ($i < 5) {
                                        if ($count != 0) {
                                            ?>
                                            <span class="mark">&#9733;</span>
                                        <?php
                                            $count--;
                                        } else {
                                            ?>
                                            <span class="unmark">&#9733;</span>
                                        <?php
                                        }
                                        $i++;
                                    }
                                    ?>
                                </div>
                            <?php
                            } else {
                                ?>
                                <!-- rating input taken -->
                                <p>Give rating</p>
                                <div class="rating">
                                    <form class="ratingForm" action="./Backend/rating.php" method="post">
                                        <div class="stars" data-subject-id="<?php echo $subject; ?>">
                                            <span data-rating="1">&#9733;</span>
                                            <span data-rating="2">&#9733;</span>
                                            <span data-rating="3">&#9733;</span>
                                            <span data-rating="4">&#9733;</span>
                                            <span data-rating="5">&#9733;</span>
                                        </div>
                                        <!-- Inside your form -->
                                        <input type="hidden" class="subjectIdInput" name="subject"
                                            value="<?php echo $subject; ?>">
                                        <input type="hidden" class="ratingInput" name="rating" value="">
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <button class="add-to-cart"
                        <?php echo $isLoggedIn ? 'onclick="addToCart(\'' . $courseDetails['subject'] . '\', \'' . $_SESSION['user_email_address'] . '\')"' : 'onclick="alert(\'Please login to add to cart.\')"'; ?>>Add
                        to Cart</button>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <script>
        var isLoggedIn = <?php echo isset($_SESSION['user_email_address']) ? 'true' : 'false'; ?>;
        function toggleDropdownOptions(subject) {
            var dropdownOptions = document.getElementById('dropdownOptions_' + subject);
            dropdownOptions.classList.toggle('show');
        }
    </script>

    <script src="./JavaScript/rating.js"></script> 
    <script src="./JavaScript/user.js"></script>
    
</body>

</html>
