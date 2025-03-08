<?php
session_start();
include '../connect.php';

$teacher_id = $_SESSION['user_id'] ?? null;
$selected_date = $_POST['date'] ?? null;

if (!$teacher_id || !$selected_date) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing teacher ID or selected date.',
    ]);
    exit;
}

// Fetch students and their attendance for the given date
$sql = "
    SELECT DISTINCT s.student_id, s.firstname, s.lastname,
        a.status_am, a.status_pm, a.status_excuse
    FROM students_enrolled s
    JOIN teachers_classroom ca ON s.classroom_id = ca.classroom_id
    LEFT JOIN attendance a ON s.student_id = a.student_id AND a.attendance_date = ?
    WHERE ca.teacher_id = ?
";

$stmt = $connection->prepare($sql);
$stmt->bind_param('ss', $selected_date, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = [
        'id' => $row['student_id'],
        'fullname' => $row['firstname'] . ' ' . $row['lastname'],
        'status_am' => $row['status_am'] ?? null,
        'status_pm' => $row['status_pm'] ?? null,
        'status_excuse' => $row['status_excuse'] ?? null // Added this line
    ];
}

echo json_encode([
    'status' => 'success',
    'students' => $students,
]);

$stmt->close();
$connection->close();
?>
