<?php
include("../connect.php");

// Check if the request is valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    $attendance_date = $_POST['date'];

    // Prepare statement to fetch attendance records
    $stmt = $connection->prepare("
        SELECT s.firstname, s.lastname, a.status_am, a.status_pm
        FROM attendance a 
        JOIN students_enrolled s ON a.student_id = s.student_id 
        WHERE a.attendance_date = ?
    ");
    $stmt->bind_param("s", $attendance_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendanceRecords = [];
    while ($row = $result->fetch_assoc()) {
        $attendanceRecords[] = [
            'fullname' => $row['firstname'] . ' ' . $row['lastname'],
            'status_am' => $row['status_am'],  'status_pm' => $row['status_pm']
        ];
    }

    $stmt->close();
    $connection->close();

    // Return the attendance records
    if (!empty($attendanceRecords)) {
        echo json_encode(["status" => "success", "data" => $attendanceRecords]);
    } else {
        echo json_encode(["status" => "error", "message" => "No attendance records found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
