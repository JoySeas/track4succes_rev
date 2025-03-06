<?php
session_start();
include '../connect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classroom_id = $_POST['classroom_id'];

    $stmt = $connection->prepare("SELECT class_name, section, description, start_year, end_year FROM teachers_classroom WHERE classroom_id = ?");
    $stmt->bind_param("i", $classroom_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $classroom = $result->fetch_assoc();
        echo json_encode($classroom);
    } else {
        echo json_encode(["error" => "Classroom not found"]);
    }

    $stmt->close();
    $connection->close();
}
?>
