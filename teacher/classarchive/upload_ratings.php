<?php
// Include necessary files for database and file handling
require_once '../connect.php';
require_once '../../vendor/autoload.php'; // PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['ratingsFile'])) {
    // Fetch the classroom_id and quarter from the POST request
    $classroom_id = $_POST['classroom_id'];
    $quarter = $_POST['quarter'];
    $file = $_FILES['ratingsFile'];

    // Ensure the file is uploaded and has a valid size
    if ($file['error'] == UPLOAD_ERR_OK && $file['size'] > 0) {
        $filePath = $file['tmp_name'];

        // Load the Excel file using PhpSpreadsheet
        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Loop through each row in the spreadsheet, skipping the header row
            foreach ($rows as $index => $row) {
                if ($index == 0) continue; // Skip header row

                $student_no = $row[0]; // Student number is in the first column (index 0)
                $ratings = array_slice($row, 2, 13); // Skip column 2 (Fullname) and capture ratings from R1 to R13

                // Query the student by student_no to get student_id
                $sql = "SELECT student_id FROM students_enrolled WHERE student_no = ? AND classroom_id = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("si", $student_no, $classroom_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $student = $result->fetch_assoc();

                if ($student) {
                    $student_id = $student['student_id'];

                    // Fetch the student_no based on student_id (if not already in $student_no)
                    $sqlStudentNo = "SELECT student_no FROM students_enrolled WHERE student_id = ?";
                    $stmtStudentNo = $connection->prepare($sqlStudentNo);
                    $stmtStudentNo->bind_param("i", $student_id);
                    $stmtStudentNo->execute();
                    $resultStudentNo = $stmtStudentNo->get_result();
                    $studentDetails = $resultStudentNo->fetch_assoc();
                    $student_no = $studentDetails['student_no'];

                    // Prepare the SQL for INSERT only (no update on duplicate)
                    $insertSql = "INSERT INTO student_behavior_ratings
                    (student_id, student_no, classroom_id, quarter, R1, R2, R3, R4, R5, R6, R7, R8, R9, R10, R11, R12, R13, date_added)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

                    $stmtInsert = $connection->prepare($insertSql);

                    // Bind parameters dynamically
                    $bindParams = array_merge([$student_id, $student_no, $classroom_id, $quarter], $ratings);
                    $stmtInsert->bind_param(
                        str_repeat("s", count($bindParams)), // Create types string
                        ...$bindParams
                    );
                    $stmtInsert->execute();
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Student with student_no $student_no not found in classroom $classroom_id.";
                    echo json_encode($response);
                    exit();
                }
            }

            // If successful, return a success response
            $response['status'] = 'success';
            $response['message'] = 'Ratings have been uploaded successfully.';
            echo json_encode($response);
        } catch (Exception $e) {
            // Handle any errors related to file reading or processing
            $response['status'] = 'error';
            $response['message'] = 'Error uploading file: ' . $e->getMessage();
            echo json_encode($response);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: Please upload a valid Excel file.';
        echo json_encode($response);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
    echo json_encode($response);
}
