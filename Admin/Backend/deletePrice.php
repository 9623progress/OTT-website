<?php
include "dbcon.php";


header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $rowId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if (!empty($rowId)) {
        error_log("DELETE request received for ID: " . $rowId);

        $deleteQuery = "DELETE FROM Price WHERE id = ?";
        $stmtDelete = $con->prepare($deleteQuery);
        $stmtDelete->bind_param('i', $rowId);

        if ($stmtDelete->execute()) {
            $response = array('status' => 'success', 'message' => 'Record deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error deleting record');
        }

        $stmtDelete->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid or missing ID');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method');
}

$con->close();
echo json_encode($response);
?>
