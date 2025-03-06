<?php
include("../connect.php");
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    $subject_id = $_POST['subject_id'];
    $quarter = $_POST['quarter'];
    $allowedExtensions = ['xls', 'xlsx'];

    if (!isset($_FILES['grade_file'])) {
        throw new Exception("File not uploaded.");
    }

    // Check if subject_id exists in the subject table
    $sqlCheckSubject = "SELECT COUNT(*) FROM subjects WHERE subject_id = ?";
    $stmtCheckSubject = mysqli_prepare($connection, $sqlCheckSubject);
    mysqli_stmt_bind_param($stmtCheckSubject, "i", $subject_id);
    mysqli_stmt_execute($stmtCheckSubject);
    mysqli_stmt_bind_result($stmtCheckSubject, $subjectExists);
    mysqli_stmt_fetch($stmtCheckSubject);
    mysqli_stmt_close($stmtCheckSubject);

    if ($subjectExists == 0) {
        throw new Exception("Subject ID $subject_id not found in the subject table.");
    }

    $file = $_FILES['grade_file'];
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExtensions)) {
        throw new Exception("Invalid file type.");
    }

    $spreadsheet = IOFactory::load($fileTmp);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Determine the current quarter column
    $quarter_column = match($quarter) {
        'first_quarter' => 'first_quarter',
        'second_quarter' => 'second_quarter',
        'third_quarter' => 'third_quarter',
        'fourth_quarter' => 'fourth_quarter',
        default => throw new Exception("Invalid quarter selected.")
    };

    // Determine the remarks column for the current quarter
    $remarks_column = "{$quarter}_remarks";

    // Start from the second row to skip the title row
    foreach (array_slice($sheetData, 1) as $row) {
        $student_no = $row['A']; // Assuming student_no is in column A
        $gradeValue = $row['C']; // Assuming the grade is in column C

        // Fetch student_id based on student_no
        $sqlStudent = "SELECT student_id FROM students_enrolled WHERE student_no = ?";
        $stmtStudent = mysqli_prepare($connection, $sqlStudent);
        mysqli_stmt_bind_param($stmtStudent, "s", $student_no);
        mysqli_stmt_execute($stmtStudent);
        mysqli_stmt_bind_result($stmtStudent, $student_id);
        mysqli_stmt_fetch($stmtStudent);
        mysqli_stmt_close($stmtStudent);

        if (!$student_id) {
            error_log("Student with student_no $student_no not found."); // Log error instead of throwing
            continue; // Skip to the next iteration
        }

        // Determine the remarks based on the current quarter grade
        $remarks = $gradeValue >= 75 ? "PASSED" : "FAILED";

        // Check if a grade record exists for this student and subject
        $sqlCheckGrade = "SELECT grade_id, first_quarter, second_quarter, third_quarter, fourth_quarter 
                          FROM student_grades WHERE student_id = ? AND subject_id = ?";
        $stmtCheckGrade = mysqli_prepare($connection, $sqlCheckGrade);
        mysqli_stmt_bind_param($stmtCheckGrade, "ii", $student_id, $subject_id);
        mysqli_stmt_execute($stmtCheckGrade);
        mysqli_stmt_bind_result($stmtCheckGrade, $grade_id, $first_quarter, $second_quarter, $third_quarter, $fourth_quarter);
        mysqli_stmt_fetch($stmtCheckGrade);
        mysqli_stmt_close($stmtCheckGrade);

        // Calculate the sum of grades and count valid grades
        $grades = [$first_quarter, $second_quarter, $third_quarter, $fourth_quarter, $gradeValue]; // Include the current quarter's grade
        $validGrades = array_filter($grades); // Filter out NULL values
        $totalGrade = array_sum($validGrades); // Sum of valid grades
        $numQuarters = count($validGrades); // Count valid quarters

        // Calculate overall grade (divide total by the number of quarters)
        $overallGrade = $numQuarters > 0 ? $totalGrade / $numQuarters : null;

        // Determine overall remarks based on the overall grade
        $overallRemarks = $overallGrade >= 75 ? "PASSED" : "FAILED";

        if ($grade_id) {
            // Update the existing grade record for the specific quarter
            $sqlUpdate = "UPDATE student_grades SET $quarter_column = ?, $remarks_column = ?, overall_grade = ?, overall_remarks = ? WHERE grade_id = ?";
            $stmtUpdate = mysqli_prepare($connection, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "dsdsd", $gradeValue, $remarks, $overallGrade, $overallRemarks, $grade_id);
            mysqli_stmt_execute($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
        } else {
            // If no record exists, insert a new one
            $sqlInsert = "INSERT INTO student_grades (student_id, subject_id, $quarter_column, $remarks_column, overall_grade, overall_remarks) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = mysqli_prepare($connection, $sqlInsert);
            mysqli_stmt_bind_param($stmtInsert, "iidsds", $student_id, $subject_id, $gradeValue, $remarks, $overallGrade, $overallRemarks);
            mysqli_stmt_execute($stmtInsert);
            mysqli_stmt_close($stmtInsert);
        }
    }

    echo json_encode(["success" => true, "message" => "Grades uploaded successfully."]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
