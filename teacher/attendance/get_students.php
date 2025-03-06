<?php
session_start();
include '../connect.php';

$teacher_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$selected_date = isset($_POST['date']) ? $_POST['date'] : null;

if (!$teacher_id || !$selected_date) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing teacher ID or selected date.',
    ]);
    exit;
}

// Fetch distinct students assigned to the teacher, avoiding duplicates
$sql = "
    SELECT DISTINCT s.student_id, s.firstname, s.lastname,
        (SELECT a.status_am FROM attendance a 
         WHERE a.student_id = s.student_id AND a.attendance_date = ? 
         ORDER BY a.attendance_id DESC LIMIT 1) AS status_am,
        (SELECT a.status_pm FROM attendance a 
         WHERE a.student_id = s.student_id AND a.attendance_date = ? 
         ORDER BY a.attendance_id DESC LIMIT 1) AS status_pm
    FROM students_enrolled s
    JOIN teachers_classroom ca ON s.classroom_id = ca.classroom_id
    WHERE ca.teacher_id = ?
";

$stmt = $connection->prepare($sql);
$stmt->bind_param('sss', $selected_date, $selected_date, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
$student_ids = []; // Prevents duplicate records

while ($row = $result->fetch_assoc()) {
    if (!in_array($row['student_id'], $student_ids)) {
        $students[] = [
            'id' => $row['student_id'],
            'fullname' => $row['firstname'] . ' ' . $row['lastname'],
            'status_am' => $row['status_am'] ?? null,
            'status_pm' => $row['status_pm'] ?? null
        ];
        $student_ids[] = $row['student_id'];
    }
}

echo json_encode([
    'status' => 'success',
    'students' => $students,
]);

$stmt->close();
$connection->close();
?>
