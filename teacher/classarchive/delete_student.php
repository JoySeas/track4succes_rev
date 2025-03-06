<?php
include("../connect.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_no'])) {
    $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);

    $delete_query = "DELETE FROM students_enrolled WHERE student_no = '$student_no'";
    if (mysqli_query($connection, $delete_query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete student.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
