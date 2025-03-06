<?php
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $className = $_POST['className'];
    $section = $_POST['section'];
    $description = $_POST['description'];
    $startYear = $_POST['start_year'];
    $endYear = $_POST['end_year'];
    $classImage = null;

    if (isset($_SESSION['user_id'])) {
        $teacher_id = $_SESSION['user_id'];
    } else {
        echo "Error: No teacher logged in.";
        exit;
    }

    if (isset($_FILES['classImage']) && $_FILES['classImage']['error'] == 0) {
        $uploadDir = '../uploads/class_images/';
        $fileName = basename($_FILES['classImage']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['classImage']['tmp_name'], $filePath)) {
            $classImage = $fileName;
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    $sql = "INSERT INTO teachers_classroom (teacher_id, class_name, section, description, start_year, end_year, class_image, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssss", $teacher_id, $className, $section, $description, $startYear, $endYear, $classImage);

    if ($stmt->execute()) {
        echo "Class created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>
