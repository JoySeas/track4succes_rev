<?php
include("../connect.php");
session_start();

// Ensure user is logged in and the classroom ID exists
if (!isset($_POST['classroom_id']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$classroom_id = $_POST['classroom_id'];
$subject_name = $_POST['subject_name'];
$subject_teacher = $_POST['subject_teacher'];

// Capture subject days, start time, and end time
$subject_days = isset($_POST['subject_days']) ? implode(", ", $_POST['subject_days']) : '';
$subject_start_time = $_POST['subject_start_time'];
$subject_end_time = $_POST['subject_end_time'];

$subject_room = $_POST['subject_room'];
$subject_desc = $_POST['subject_desc'];
$subject_image = $_FILES['subject_image'];

// File upload logic
$upload_dir = "../uploads/subjects/";
$image_name = '';
if ($subject_image['name']) {
    $image_name = basename($subject_image['name']);
    $target_file = $upload_dir . $image_name;
    move_uploaded_file($subject_image['tmp_name'], $target_file);
}

// Insert subject into the database
$sql = "INSERT INTO subjects (classroom_id, subject_name, subject_teacher, subject_days, subject_start_time, subject_end_time, subject_room, subject_desc, subject_image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connection->prepare($sql);
$stmt->bind_param("issssssss", $classroom_id, $subject_name, $subject_teacher, $subject_days, $subject_start_time, $subject_end_time, $subject_room, $subject_desc, $image_name);

if ($stmt->execute()) {
    // Redirect or show success message
    header("Location: ../index.php?url=eachclass&classroom_id=" . $classroom_id);
} else {
    echo "Error: " . $connection->error;
}

$stmt->close();
$connection->close();
?>
