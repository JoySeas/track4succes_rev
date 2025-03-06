<?php
session_start();
include '../connect.php';

$teacher_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$teacher_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Teacher ID not found in session.',
    ]);
    exit;
}

$sql = "SELECT DISTINCT attendance_date FROM attendance WHERE teacher_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('s', $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$dates = [];
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['attendance_date'];
}

echo json_encode([
    'status' => 'success',
    'dates' => $dates,
]);
?>
