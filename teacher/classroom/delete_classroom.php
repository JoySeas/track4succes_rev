<?php
include("../connect.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['classroom_id'])) {
    $classroom_id = mysqli_real_escape_string($connection, $_POST['classroom_id']);
    
    // First, check if there are subjects associated with this classroom
    $subject_check_query = "SELECT COUNT(*) as subject_count FROM subjects WHERE classroom_id = '$classroom_id'";
    $subject_check_result = mysqli_query($connection, $subject_check_query);
    $subject_check_row = mysqli_fetch_assoc($subject_check_result);

    if ($subject_check_row['subject_count'] > 0) {
        // Notify the user that the classroom cannot be deleted because subjects exist
        echo json_encode([
            'status' => 'error',
            'message' => 'Cannot delete the classroom because it has associated subjects. Please delete the subjects first.'
        ]);
    } else {
        // Proceed with classroom deletion if no subjects exist
        $delete_query = "DELETE FROM teachers_classroom WHERE classroom_id = '$classroom_id'";
        if (mysqli_query($connection, $delete_query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete classroom.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
