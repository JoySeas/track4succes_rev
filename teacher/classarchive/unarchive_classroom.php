<?php
session_start();
include '../connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classroom_id = $_POST['classroom_id'];

    if (empty($classroom_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Classroom ID is required']);
        exit;
    }

    // Update the classroom status to 'ARCHIVE'
    $stmt = $connection->prepare("UPDATE teachers_classroom SET status = 'ACTIVE' WHERE classroom_id = ?");
    $stmt->bind_param("i", $classroom_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to archive the classroom']);
    }

    $stmt->close();
    $connection->close();
}
?>
