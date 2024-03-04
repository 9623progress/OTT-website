<!-- courses.php -->
<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/phone.css">
     <!-- Include your styles here -->
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

            <a class="cart-link" id="c_link"href="./cart.php">
                <img class="cart-img" src="./images/cart.png" alt="Cart">
            </a>
        </div>

    </div>

<div class="card" id="subscritption_card">

    <?php
    // Your PHP code to fetch and display user's subscribed courses as cards
    include "./Backend/dbcon.php";

    // Assuming $userEmail is the logged-in user's email
    if(isset($_SESSION['user_email_address'])){
        $userEmail = $_SESSION['user_email_address'];
    }
    else{
        header('location:./signIn.php');
    }
    

    // Fetch subscribed subjects for the user
    $subscribedSubjectsQuery = "SELECT DISTINCT subject FROM Subscription WHERE email = '$userEmail'";
    $subscribedSubjectsResult = $con->query($subscribedSubjectsQuery);

    while ($subscribedSubject = $subscribedSubjectsResult->fetch_assoc()) {
        // Fetch details for the subscribed subject from Admin table
        $subject = $subscribedSubject['subject'];
        $courseDetailsQuery = "SELECT * FROM Admin WHERE subject = '$subject'";
        $courseDetailsResult = $con->query($courseDetailsQuery);
        $courseDetails = $courseDetailsResult->fetch_assoc();
        ?>

        <div class="course-card">
            <!-- ... Display course card details ... -->
            <div class="thumbnail">
                <img src="<?php echo "../Admin/Backend/thumbnails/".$courseDetails['thumbnail']; ?>"
                     alt="<?php echo $courseDetails['subject']; ?>">
            </div>
            <div class="course-details">
                <div class="course-name">
                    <p><?php echo $courseDetails['subject']; ?></p>
                </div>
                <div class="price">
                    <?php
                    $priceQuery = "SELECT * FROM price WHERE subject = '$subject'";
                    $priceResult = $con->query($priceQuery);
                    if ($priceResult) {
                        while ($row = $priceResult->fetch_assoc()) {
                            $priceValue = $row['price'];
                            echo "Rs.";
                            echo $priceValue;
                        }
                    } else {
                        echo "Error executing price query: " . $con->error;
                    }
                    ?>
                </div>
                <div class="rating">
                        <div class="rating-section">
                            <div class="given">
                                <!-- <p>Overall rating</p> -->
                                <?php
                               
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
                            $checkRatingQuery = "SELECT * FROM rating WHERE email = '$userEmail' AND subject_id = '$subject'";
                            $checkRatingResult = mysqli_query($con, $checkRatingQuery);

                            if (mysqli_num_rows($checkRatingResult) > 0) {
                                $prevR = mysqli_fetch_assoc($checkRatingResult);
                                $count = $prevR['rating'];
                                $i = 0;
                                ?>
                                <div>
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
                <button class="view-content" onclick="window.location.href='display.php?subject=<?php echo $courseDetails['subject']; ?>'">Explore Course</button>
            </div>
        </div>

    <?php
    }
    ?>

<!-- INSERT INTO subscription(email, subject) -->
<!-- VALUES ('user@example.com', 'Mathematics'); -->

</div>
    <script>
        var isLoggedIn = <?php echo isset($_SESSION['user_email_address']) ? 'true' : 'false'; ?>;
    </script>
    <script src="./JavaScript/rating.js"></script>
    <script src="./JavaScript/user.js"></script>
    <script>
        function toggleDropdownOptions(subject) {
            var dropdownOptions = document.getElementById('dropdownOptions_' + subject);
            dropdownOptions.classList.toggle('show');
        }
    </script>
</body>
</html>
