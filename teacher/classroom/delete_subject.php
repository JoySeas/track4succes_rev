<?php
include("../connect.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_id'])) {
    $subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);

    $delete_query = "DELETE FROM subjects WHERE subject_id = '$subject_id'";
    if (mysqli_query($connection, $delete_query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete student.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>