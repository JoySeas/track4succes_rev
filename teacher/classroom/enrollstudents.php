<?php
session_start(); // Start session management
include("../connect.php");
require '../../vendor/autoload.php';  // Ensure Composer autoloader is included

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['student_excel'])) {
    $file = $_FILES['student_excel']['tmp_name'];
    $classroom_id = $_POST['classroom_id'];

    // Check if the classroom ID exists
    $classroom_check_sql = "SELECT COUNT(*) FROM teachers_classroom WHERE classroom_id = '$classroom_id'";
    $classroom_check_result = mysqli_query($connection, $classroom_check_sql);
    $classroom_exists = mysqli_fetch_row($classroom_check_result)[0];

    if ($classroom_exists == 0) {
        $response['status'] = 'error';
        $response['message'] = "The classroom ID \"$classroom_id\" does not exist.";
        echo json_encode($response);
        exit;
    }

    // Load the uploaded Excel file using PhpSpreadsheet
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();

    $rowCounter = 0;
    $studentsAlreadyEnrolled = []; // Track students already enrolled
    $enrollmentSuccessful = false; // Variable to track enrollment success

    foreach ($sheet->getRowIterator() as $row) {
        $rowCounter++;

        if ($rowCounter === 1) {
            continue; // Skip header row
        }

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        // Extract student data
        $studentData = [];
        foreach ($cellIterator as $cell) {
            $studentData[] = $cell->getValue();
        }

        if (count($studentData) === 4) {
            $student_no = mysqli_real_escape_string($connection, $studentData[0]);
            $firstname = mysqli_real_escape_string($connection, $studentData[1]);
            $middlename = mysqli_real_escape_string($connection, $studentData[2]);
            $lastname = mysqli_real_escape_string($connection, $studentData[3]);

            // Check if the student is already enrolled in this classroom
            $check_student_sql = "SELECT COUNT(*) FROM students_enrolled 
                                  WHERE student_no = '$student_no' AND classroom_id = '$classroom_id'";
            $check_student_result = mysqli_query($connection, $check_student_sql);
            $student_already_enrolled = mysqli_fetch_row($check_student_result)[0];

            if ($student_already_enrolled > 0) {
                // Record the student number of already enrolled students
                $studentsAlreadyEnrolled[] = $student_no;
                continue; // Skip this student
            }

            // Insert the student into the classroom if not already enrolled
            $sql = "INSERT INTO students_enrolled (student_no, firstname, middlename, lastname, classroom_id)
                    VALUES ('$student_no', '$firstname', '$middlename', '$lastname', '$classroom_id')";

            if (mysqli_query($connection, $sql)) {
                $enrollmentSuccessful = true; // Set success flag to true if insertion is successful
            } else {
                $response['status'] = 'error';
                $response['message'] .= mysqli_error($connection) . " ";
            }
        } else {
            // Optionally handle invalid row format
            $response['message'] .= "Invalid row format at row $rowCounter. ";
        }
    }

    if (!empty($studentsAlreadyEnrolled)) {
        // If some students were already enrolled, include this in the message
        $response['status'] = 'error';
        $response['message'] .= "Students with a student number " . implode(", ", $studentsAlreadyEnrolled) . " are already enrolled in this classroom.";
    }

    if ($enrollmentSuccessful && empty($studentsAlreadyEnrolled)) {
        $response['status'] = 'success';
        $response['message'] = 'Students enrolled successfully!';
    }

    echo json_encode($response);
    exit;
}

mysqli_close($connection);
?>
