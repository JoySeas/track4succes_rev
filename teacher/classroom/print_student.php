<?php
require __DIR__ . '/../../vendor/autoload.php';

include("../connect.php");
session_start();
error_reporting(E_ALL);

use Mpdf\Mpdf;

// Ensure required parameters are provided
if (!isset($_GET['classroom_id']) || !isset($_GET['student_no'])) {
    die('Classroom ID and Student Number are required.');
}

$classroom_id = intval($_GET['classroom_id']);
$student_no = htmlspecialchars($_GET['student_no']);

// Get student_id based on student_no
$sql = "SELECT student_id FROM students_enrolled WHERE student_no = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $student_no);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die('Student not found.');
}

$student_id = $student['student_id'];

// Fetch all subjects for the given classroom
$sql = "SELECT subject_id, subject_name FROM subjects WHERE classroom_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $classroom_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[$row['subject_id']] = $row['subject_name'];
}

// Fetch student grades
$sql = "SELECT * FROM student_grades WHERE student_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$grades = [];
while ($row = $result->fetch_assoc()) {
    $subject_id = $row['subject_id'];
    if (!isset($subjects[$subject_id])) continue;

    $grades[$subjects[$subject_id]] = [
        'q1' => $row['first_quarter'],
        'q2' => $row['second_quarter'],
        'q3' => $row['third_quarter'],
        'q4' => $row['fourth_quarter'],
        'final' => $row['overall_grade'],
        'remarks' => $row['overall_remarks']
    ];
}

// Ensure all subjects are included, even if no grades exist
foreach ($subjects as $subject_id => $subject_name) {
    if (!isset($grades[$subject_name])) {
        $grades[$subject_name] = [
            'q1' => '',
            'q2' => '',
            'q3' => '',
            'q4' => '',
            'final' => '',
            'remarks' => ''
        ];
    }
}

// Generate MAPEH components separately
$mapeh_subjects = ['Music', 'Arts', 'PE', 'Health'];
$mapeh_grades = [];
$mapeh_final_scores = [];

foreach ($mapeh_subjects as $subj) {
    if (isset($grades[$subj])) {
        $mapeh_grades[$subj] = $grades[$subj];
        $mapeh_final_scores[] = $grades[$subj]['final'];
    }
}

// Compute MAPEH final grade
$mapeh_final = (!empty($mapeh_final_scores) && array_sum($mapeh_final_scores) > 0)
    ? array_sum($mapeh_final_scores) / count($mapeh_final_scores)
    : '';
$mapeh_remarks = ($mapeh_final !== '' && $mapeh_final > 0)
    ? ($mapeh_final >= 75 ? 'PASSED' : 'FAILED')
    : '';

// Compute overall general average
$total_final_grades = array_filter(array_merge(array_column($grades, 'final'), $mapeh_final_scores));
$general_average = count($total_final_grades) > 0 ? array_sum($total_final_grades) / count($total_final_grades) : '';
$general_remarks = ($general_average >= 75) ? 'PASSED' : 'FAILED';

// Generate PDF
$mpdf = new Mpdf();
$html = "<h4 style='text-align: center; background-color: darkblue; color: white; padding: 15px;'>REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</h4>";

$html .= "<table border='1' width='100%' cellpadding='8' cellspacing='0' style='text-align: center; border-collapse: collapse;'>
        <tr style='background-color: #00bfff; color: white;'>
            <th rowspan='2' style='width: 40%;'>Learning Areas</th>
            <th colspan='4' style='width: 30%;'>Quarter</th>
            <th rowspan='2' style='width: 15%;'>Final Grade</th>
            <th rowspan='2' style='width: 15%;'>Remarks</th>
        </tr>
        <tr style='background-color: #d0e9ff;'>
            <th>1</th><th>2</th><th>3</th><th>4</th>
        </tr>";

// Print all subjects including MAPEH components
foreach ($grades as $subject => $score) {
    if (!in_array($subject, $mapeh_subjects)) {
        $html .= "<tr><td style='text-align: left;'>{$subject}</td>
                    <td style='font-size: 12px;'>{$score['q1']}</td>
                    <td style='font-size: 12px;'>{$score['q2']}</td>
                    <td style='font-size: 12px;'>{$score['q3']}</td>
                    <td style='font-size: 12px;'>{$score['q4']}</td>
                    <td style='font-size: 12px;'>{$score['final']}</td>
                    <td style='font-size: 12px;'>{$score['remarks']}</td>
                  </tr>";
    }
}

// Print MAPEH components
if (!empty($mapeh_grades)) {
    $html .= "<tr><td style='text-align: left;'>MAPEH</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td> {$mapeh_final}</td>
    <td>{$mapeh_remarks}</td>
  </tr>";
    foreach ($mapeh_grades as $subj => $score) {
        $html .= "<tr><td style='text-align: center;'>{$subj}</td>
                    <td>{$score['q1']}</td>
                    <td>{$score['q2']}</td>
                    <td>{$score['q3']}</td>
                    <td>{$score['q4']}</td>
                    <td>{$score['final']}</td>
                    <td>{$score['remarks']}</td>
                  </tr>";
    }
}

$html .= "<tr style='background-color: #4169e1; color: white; font-weight: bold;'>
            <td colspan='5'>General Average</td>
            <td>{$general_average}</td>
            <td>{$general_remarks}</td>
          </tr>";
$html .= "</table>";

// Descriptors Table
$html .= "<br>
    <table border='1' width='100%' cellpadding='8' cellspacing='0' style='text-align: center; border-collapse: collapse;'>
        <tr style='background-color: #0093af; color: white;'>
            <th style='width: 50%;'>Descriptors</th>
            <th style='width: 25%;'>Grading Scale</th>
            <th style='width: 25%;'>Remarks</th>
        </tr>
        <tr><td>Outstanding</td><td>90-100</td><td>Passed</td></tr>
        <tr style='background-color: #f2f2f2;'><td>Very Satisfactory</td><td>85-89</td><td>Passed</td></tr>
        <tr><td>Satisfactory</td><td>80-84</td><td>Passed</td></tr>
        <tr style='background-color: #f2f2f2;'><td>Fairly Satisfactory</td><td>75-79</td><td>Passed</td></tr>
        <tr><td>Did not meet Expectations</td><td>Below 75</td><td>Failed</td></tr>
    </table>";

$mpdf->WriteHTML($html);
$mpdf->Output("student_report_{$student_no}.pdf", 'I');
