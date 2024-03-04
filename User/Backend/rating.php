<?php
include 'dbcon.php';
session_start();
echo " on rating";

if (isset($_POST['subject'])) {
    // Assuming that the 'subject_id' is passed as a hidden input field in your form
    $subject = $_POST['subject'];
    $new_rating = $_POST['rating'];
    $user_email =$_SESSION['user_email_address'];
    echo $subject;
    

    // Debugging: index received subject id and rating
    // error_log("received subject id and rating: $subject, $new_rating");


    if (!$new_rating || !is_numeric($new_rating) || $new_rating < 1 || $new_rating > 5) {
        ?>
        <script>
            alert("Invalid rating");
            window.location.href = '../index.php';
        </script>
        <?php
        exit(); // Ensure that the script stops after the redirect
    } else {
        $checkRatingQuery = "SELECT * FROM rating WHERE email = '$user_email' AND subject_id = '$subject'";
        $checkRatingResult = mysqli_query($con, $checkRatingQuery);

        if (!$checkRatingResult) {
            ?>
            <script>
                alert("Error checking existing rating: <?php echo mysqli_error($con); ?>");
                window.location.href = '../index.php';
            </script>
            <?php
            exit();
        }

        if (mysqli_num_rows($checkRatingResult) > 0) {
            $prevR = mysqli_fetch_assoc($checkRatingResult);
            ?>
            <script>
                alert("Rating already given: <?php echo $prevR['rating']; ?>");
                // window.location.href = '../index.php';
            </script>
            <?php
            exit();
        } else {
            $insertRatingQuery = "INSERT INTO rating (subject_id, email, rating) VALUES ('$subject', '$user_email', '$new_rating')";
            $insertRatingResult = mysqli_query($con, $insertRatingQuery);
            echo "inserted";

            if (!$insertRatingResult) {
                ?>
                <script>
                    alert("Error inserting rating: <?php echo mysqli_error($con); ?>");
                    // window.location.href = '../index.php';
                </script>
                <?php
                exit();
            }
        }
    }
}
else{
    echo "notset";
}

header("location:../index.php");
exit();
?>