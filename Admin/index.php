<?php include "./Backend/dbcon.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=PT+Sans&family=Roboto+Slab:wght@500&display=swap"
        rel="stylesheet">

    <title>Admin</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/phone.css">
</head>

<body>

    <div class="navbar" id="myNavbar">
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"> &#9776;</a>
        <div>
            <a href="#" class="logo">Cognifront</a>
        </div>

        <div class="nav">
            <a href="#home">Home</a>
            <a href="#add">Add Data</a>
            <a href="#display">View Data</a>
        </div>

    </div>



    <div class="tagline">
        <div class="heading">
            <h1>Inspire Your Classroom</h1>
            <p>Your students are distracted on their phones and with their friends. Most importantly distracted by their
                thoughts. Grab their attention.</p>
        </div>
        <div class="image">
            <img src="./images/section1.jpg" alt="#">
        </div>
    </div>



    <!-- Course Detail form -->
    <div class="addinfo" id="add">
        <h1>Add Course Details</h1>
        <form id="addForm" action="./Backend/add.php" method="post" enctype="multipart/form-data">
            <label for="subject">Select or Add Subject:</label>
            <select name="subject" id="subject" onchange="fetchUnits()">
                <option value="">Choose subject</option>

                <?php
                // Fetch unique subjects from the database
                $subjectQuery = "SELECT DISTINCT subject FROM Admin";
                $subjectResult = $con->query($subjectQuery);

                while ($row = $subjectResult->fetch_assoc()) {
                    echo "<option value='" . $row['subject'] . "'>" . $row['subject'] . "</option>";
                }
                ?>
                <option value="add_new_subject">Add New Subject</option>

            </select>
            <input type="text" name="new_subject" id="new_subject_input" placeholder="Enter new subject"
                style="display: none;">

            <label for="thumbnail_input" id="thumbnail_label" style="display: none;">Add Thumbnail:</label>
            <input type="file" name="course_thumbnail" id="thumbnail_input" accept="image/*" style="display: none;">
            <textarea name="subject_description" id="desc" rows="10" placeholder="Add description of subject"
                style="display: none;"></textarea>

            <label for="unit">Select or Add Unit:</label>
            <select name="unit" id="unit" onchange="toggleUnitInput()">
                <!-- Units will be dynamically populated based on the selected subject using JavaScript -->
                <option value="add_new_unit">Add new unit</option>
            </select>
            <input type="text" name="new_unit" id="new_unit_input" placeholder="Enter new unit" style="display: none;">

            <label for="topic">Add Topic:</label>
            <input type="text" name="topic" required>

            <label for="content">Add Content (Image, PDF, Video):</label>
            <input type="file" name="content" accept="image/*,application/pdf,video/*" required>

            <button type="submit" name="addData">Add to course</button>
        </form>



        <!-- Price detail form -->
        <h1>Add Price Details</h1>

        <form id="subjectPriceForm" action="./Backend/addPrice.php" method="post">
            <label for="subject">Subject Name:</label>
            <select name="subject" id="subject" onchange="fetchUnits()">
                <option value="">Choose subject</option>

                <?php
                // Fetch unique subjects from the database
                $subjectQuery = "SELECT DISTINCT subject FROM Admin";
                $subjectResult = $con->query($subjectQuery);

                while ($row = $subjectResult->fetch_assoc()) {
                    echo "<option value='" . $row['subject'] . "'>" . $row['subject'] . "</option>";
                }
                ?>

            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <button type="button" onclick="addSubjectPrice()">Add Price</button>

        </form>


    </div>
    <!-- Course Table -->
    <div class="table" id="display">
        <h1>Course Table</h1>
        <?php
    // Fetch data from the database
    $dataQuery = "SELECT * FROM Admin"; // Replace 'your_table_name' with your actual table name
    $dataResult = $con->query($dataQuery);
?>
        <table>
            <!-- Display data in a table format -->
            <thead>
                <tr>
                    <th>id</th>
                    <th>Subject</th>
                    <th>Unit</th>
                    <th>Topic</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            // Loop through the data and generate table rows
            while ($row = $dataResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['subject']}</td>";
                echo "<td>{$row['unit']}</td>";
                echo "<td>{$row['topic']}</td>";
                echo "<td>{$row['content']}</td>";
                echo "<td><button onclick=\"toggleDeleteConfirmation({$row['id']})\">Delete</button></td>"; // Assuming 'id' is the primary key
                echo "</tr>";
            }
        ?>
            </tbody>
        </table>
    
    <!-- Price table -->
    <div class="price">
        <h1>Price table</h1>
        <?php
         $PriceQuery = "SELECT * FROM Price"; // Replace 'your_table_name' with your actual table name
         $PriceResult = $con->query($PriceQuery);
        ?>

        <table id="subjectPriceTable">
            <thead>
                <tr>
                    <th>Sr no.</th>
                    <th>Subject Name</th>
                    <th>Price(Rs.)</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
            // Loop through the data and generate table rows
            while ($row = $PriceResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['subject']}</td>";
                echo "<td>{$row['price']}</td>";
                
                echo "<td><button onclick=\"toggleDeleteConfirmationPrice({$row['id']})\">Delete</button></td>"; // Assuming 'id' is the primary key
                echo "</tr>";
            }
        ?> </tbody>
        </table>
    </div>

    </div>
    <!-- Footer -->

    <div class="footer">
        <h5>#1, Trishala, Ramnagar, Behind Mahalakshmi Theatre, Panchawati, Nashik 422003Maharashtra, Bharat (India)
        </h5>
        <div class="line"></div>

    </div>



    <script src="./Javascript/admin.js"></script>


</body>

</html>