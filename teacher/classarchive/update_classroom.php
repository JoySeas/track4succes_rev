<?php
session_start();
include '../connect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classroom_id = $_POST['update_classroom_id'];
    $className = $_POST['class_name'];
    $section = $_POST['section'];
    $description = $_POST['description'];
    $startYear = $_POST['start_year']; // New field
    $endYear = $_POST['end_year']; // New field
    $classImage = null;

    // Handle file upload (if any)
    if (isset($_FILES['class_image']) && $_FILES['class_image']['error'] == 0) {
        $uploadDir = '../uploads/class_images/';
        $fileName = basename($_FILES['class_image']['name']);
        $filePath = $uploadDir . $fileName;

        // Move uploaded file to the server
        if (move_uploaded_file($_FILES['class_image']['tmp_name'], $filePath)) {
            $classImage = $fileName; // Store only the filename
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Prepare the SQL query to update data
    $sql = "UPDATE teachers_classroom SET class_name=?, section=?, description=?, start_year=?, end_year=?"
          . ($classImage ? ", class_image=?" : "") . " WHERE classroom_id=?";
    $stmt = $connection->prepare($sql);

    // Bind parameters
    if ($classImage) {
        $stmt->bind_param("sssiisi", $className, $section, $description, $startYear, $endYear, $classImage, $classroom_id);
    } else {
        $stmt->bind_param("sssiii", $className, $section, $description, $startYear, $endYear, $classroom_id);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo "Classroom updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
}
?>
