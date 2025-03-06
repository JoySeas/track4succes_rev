<?php
include("../connect.php");
require '../../vendor/autoload.php';  // Include PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["attendanceFile"])) {
    $selectedDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : null;
    $teacher_id = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : null;

    // Validate input
    if (!$selectedDate || !$teacher_id) {
        echo json_encode(["status" => "error", "message" => "Selected date or teacher ID is missing."]);
        exit;
    }

    // Validate teacher ID
    $checkTeacherStmt = $connection->prepare("SELECT user_id FROM users WHERE user_id = ? AND usertype = 'TEACHER'");
    $checkTeacherStmt->bind_param("s", $teacher_id);
    $checkTeacherStmt->execute();
    $checkTeacherStmt->store_result();

    if ($checkTeacherStmt->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Invalid teacher ID."]);
        exit;
    }
    $checkTeacherStmt->close();

    // Get the uploaded file
    $file = $_FILES["attendanceFile"]["tmp_name"];

    try {
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();  // Convert sheet data to array

        // Prepare a statement to prevent SQL injection
        $stmt = $connection->prepare("INSERT INTO attendance (student_id, attendance_date, status_am, status_pm, teacher_id) VALUES (?, ?, ?, ?, ?)");

        $successCount = 0; // Count successful inserts
        $errorCount = 0; // Count errors

        // Loop through each row in the spreadsheet, skipping the header row
        foreach ($rows as $key => $row) {
            if ($key == 0) continue; // Skip header row

            $student_no = $row[0];  // Assuming student_no is in the first column
            $status_am = isset($row[2]) ? $row[2] : 'Present'; // Get A.M. status from the third column
            $status_pm = isset($row[3]) ? $row[3] : 'Present'; // Get P.M. status from the fourth column

            // Check if the student_no exists in students_enrolled
            $checkStmt = $connection->prepare("SELECT student_id FROM students_enrolled WHERE student_no = ?");
            $checkStmt->bind_param("s", $student_no);
            $checkStmt->execute();
            $checkStmt->bind_result($student_id);
            $checkStmt->fetch();
            $checkStmt->close();

            // If student_id exists, insert attendance record
            if ($student_id) {
                $stmt->bind_param("issss", $student_id, $selectedDate, $status_am, $status_pm, $teacher_id);
                if ($stmt->execute()) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            } else {
                $errorCount++;
            }
        }

        // Close the statement and connection
        $stmt->close();
        $connection->close();

        // Prepare a response message
        $message = "Successfully inserted $successCount attendance records.";
        if ($errorCount > 0) {
            $message .= " $errorCount errors occurred.";
        }

        // Return success message
        echo json_encode(["status" => "success", "message" => $message]);

    } catch (Exception $e) {
        // Handle any errors
        echo json_encode(["status" => "error", "message" => "An error occurred while processing the file: " . $e->getMessage()]);
    }
} else {
    // Handle the case where the form wasn't submitted properly
    echo json_encode(["status" => "error", "message" => "No file uploaded or wrong request method."]);
}
?>
