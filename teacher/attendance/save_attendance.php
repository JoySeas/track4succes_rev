<?php
session_start();
include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedDate'])) {
    $attendance_date = $_POST['selectedDate'];
    $am_attendance = $_POST['am'] ?? []; // AM checked values
    $pm_attendance = $_POST['pm'] ?? []; // PM checked values
    $teacher_id = $_SESSION['user_id'] ?? null;

    if (!$teacher_id) {
        echo json_encode(["status" => "error", "message" => "Teacher ID is missing. Please log in again."]);
        exit;
    }

    if (empty($attendance_date)) {
        echo json_encode(["status" => "error", "message" => "Attendance date is required."]);
        exit;
    }

    // Fetch only the students whose attendance was actually submitted
    $submitted_students = array_unique(array_merge(array_keys($am_attendance), array_keys($pm_attendance)));

    if (empty($submitted_students)) {
        echo json_encode(["status" => "error", "message" => "No attendance data was submitted."]);
        exit;
    }

    // Validate if submitted students are enrolled under the teacher
    $valid_students = [];
    $placeholders = implode(',', array_fill(0, count($submitted_students), '?'));
    $types = str_repeat('s', count($submitted_students));
    
    $stmt = $connection->prepare("
        SELECT s.student_id FROM students_enrolled s
        JOIN teachers_classroom tc ON s.classroom_id = tc.classroom_id
        WHERE tc.teacher_id = ? AND s.student_id IN ($placeholders)
    ");

    $stmt->bind_param("s$types", $teacher_id, ...$submitted_students);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $valid_students[] = $row['student_id'];
    }
    $stmt->close();

    if (empty($valid_students)) {
        echo json_encode(["status" => "error", "message" => "No valid students found in the submitted data."]);
        exit;
    }

    // Prepare SQL statement
    $stmt = $connection->prepare("
        INSERT INTO attendance (student_id, teacher_id, attendance_date, status_am, status_pm) 
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE status_am = VALUES(status_am), status_pm = VALUES(status_pm)
    ");

    foreach ($valid_students as $student_id) {
        // Check if this student was marked as "Present" in AM/PM
        $status_am = isset($am_attendance[$student_id]) ? "Present" : "Absent";
        $status_pm = isset($pm_attendance[$student_id]) ? "Present" : "Absent";

        // Debugging log (for error tracking)
        error_log("Saving attendance -> Student ID: $student_id, Date: $attendance_date, AM: $status_am, PM: $status_pm");

        $stmt->bind_param("issss", $student_id, $teacher_id, $attendance_date, $status_am, $status_pm);
        $stmt->execute();
    }

    $stmt->close();
    $connection->close();

    echo json_encode(["status" => "success", "message" => "Attendance saved successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
