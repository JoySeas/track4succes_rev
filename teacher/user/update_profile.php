<?php
include("../connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$teachers_id = $_SESSION['user_id'];

// Verify database connection
if (!$connection) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// Default SQL query
$sql = "UPDATE users SET ";
$fieldsToUpdate = [];
$params = [];
$types = '';

// Check for each field individually and add to the query if present

// Handle file upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $fileType = $_FILES['image']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . uniqid() . '.' . $fileExtension;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $fieldsToUpdate[] = "profile_image = ?";
            $params[] = $dest_path;
            $types .= 's';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type or size.']);
        exit();
    }
}

// Update firstname if provided
if (isset($_POST['firstname']) && !empty($_POST['firstname'])) {
    $fieldsToUpdate[] = "firstname = ?";
    $params[] = $_POST['firstname'];
    $types .= 's';
}

// Update middlename if provided
if (isset($_POST['middlename']) && !empty($_POST['middlename'])) {
    $fieldsToUpdate[] = "middlename = ?";
    $params[] = $_POST['middlename'];
    $types .= 's';
}

// Update lastname if provided
if (isset($_POST['lastname']) && !empty($_POST['lastname'])) {
    $fieldsToUpdate[] = "lastname = ?";
    $params[] = $_POST['lastname'];
    $types .= 's';
}

// Ensure there are fields to update
if (count($fieldsToUpdate) > 0) {
    $sql .= implode(", ", $fieldsToUpdate) . " WHERE user_id = ?";
    $params[] = $teachers_id;
    $types .= 's'; // 's' for integer (teachers_id)

    // Prepare and execute the statement
    $stmt = $connection->prepare($sql);
    $stmt->bind_param($types, ...$params); // Bind the parameters dynamically

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No fields to update.']);
}

$connection->close();
?>
