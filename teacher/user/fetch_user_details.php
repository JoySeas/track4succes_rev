<?php
include("../connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$teachers_id = $_SESSION['user_id'];

// Query to fetch admin details
$sql = "SELECT * FROM teacher_details WHERE teacherdet_id = '$teachers_id'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $details = mysqli_fetch_assoc($result);
    echo json_encode([
        'status' => 'success',
        'details' => [
            'date_of_birth' => $details['date_of_birth'],
            'place_of_birth' => $details['place_of_birth'],
            'address' => $details['address'],
            'nationality' => $details['nationality'],
            'sex' => $details['sex'],
            'mobile_number' => $details['mobile_number'],
            'personal_email' => $details['personal_email']
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No details found']);
}

mysqli_close($connection);
?>
