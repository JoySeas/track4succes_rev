<?php
include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get the POST data
    $subject_id = mysqli_real_escape_string($connection, $_POST['update_subject_id']);
    $subject_name = mysqli_real_escape_string($connection, $_POST['subject_name']);
    $subject_teacher = mysqli_real_escape_string($connection, $_POST['subject_teacher']);
    $subject_start_time = mysqli_real_escape_string($connection, $_POST['subject_start_time']);
    $subject_end_time = mysqli_real_escape_string($connection, $_POST['subject_end_time']);
    $subject_days = isset($_POST['subject_days']) ? $_POST['subject_days'] : [];
    $subject_room = mysqli_real_escape_string($connection, $_POST['subject_room']);
    $subject_desc = mysqli_real_escape_string($connection, $_POST['subject_desc']);

    // Process the days
    $subject_days_string = implode(',', $subject_days);

    // Handle file upload if a new image is provided
    $subject_image = '';
    if (isset($_FILES['subject_image']) && $_FILES['subject_image']['error'] === 0) {
        $target_dir = "../uploads/subjects/";
        $target_file = $target_dir . basename($_FILES["subject_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image
        $check = getimagesize($_FILES["subject_image"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
            exit;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["subject_image"]["size"] > 5000000) {
            echo json_encode(['status' => 'error', 'message' => 'File is too large.']);
            exit;
        }

        // Allow certain file formats (jpeg, jpg, png, gif)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.']);
            exit;
        }

        // Try to move the uploaded file
        if (move_uploaded_file($_FILES["subject_image"]["tmp_name"], $target_file)) {
            $subject_image = basename($_FILES["subject_image"]["name"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'There was an error uploading the image.']);
            exit;
        }
    }

    // Update query
    $sql = "UPDATE subjects 
            SET subject_name = '$subject_name', 
                subject_teacher = '$subject_teacher', 
                subject_start_time = '$subject_start_time', 
                subject_end_time = '$subject_end_time', 
                subject_days = '$subject_days_string', 
                subject_room = '$subject_room', 
                subject_desc = '$subject_desc'";

    // Append image update if a new one was uploaded
    if (!empty($subject_image)) {
        $sql .= ", subject_image = '$subject_image'";
    }

    $sql .= " WHERE subject_id = '$subject_id'";

    // Execute the query
    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Subject updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating the subject: ' . mysqli_error($connection)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
