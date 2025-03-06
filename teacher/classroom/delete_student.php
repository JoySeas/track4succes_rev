<?php
include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_no']) && isset($_POST['classroom_id'])) {
    $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
    $classroom_id = mysqli_real_escape_string($connection, $_POST['classroom_id']);

    // Check if the student exists in the specified classroom
    $check_query = "SELECT * FROM students_enrolled WHERE student_no = '$student_no' AND classroom_id = '$classroom_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $delete_query = "DELETE FROM students_enrolled WHERE student_no = '$student_no' AND classroom_id = '$classroom_id'";
        if (mysqli_query($connection, $delete_query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete student from the classroom.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student not found in this classroom.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
