<?php
require __DIR__ . '/../../vendor/autoload.php';

include("../connect.php");
session_start();
error_reporting(E_ALL);

use Mpdf\Mpdf;

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
$complete_final_grades = true;

while ($row = $result->fetch_assoc()) {
    $subject_id = $row['subject_id'];
    if (!isset($subjects[$subject_id])) continue;

    $grades[$subjects[$subject_id]] = [
        'q1' => $row['first_quarter'],
        'q2' => $row['second_quarter'],
        'q3' => $row['third_quarter'],
        'q4' => $row['fourth_quarter'],
    ];

    // Compute final grade only if all quarters are present
    if (!empty($row['first_quarter']) && !empty($row['second_quarter']) && !empty($row['third_quarter']) && !empty($row['fourth_quarter'])) {
        $grades[$subjects[$subject_id]]['final'] = round(
            ($row['first_quarter'] + $row['second_quarter'] + $row['third_quarter'] + $row['fourth_quarter']) / 4,
            2
        );
        $grades[$subjects[$subject_id]]['remarks'] = $row['overall_remarks'];
    } else {
        $grades[$subjects[$subject_id]]['final'] = '';
        $grades[$subjects[$subject_id]]['remarks'] = '';
        $complete_final_grades = false;
    }
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
        $complete_final_grades = false;
    }
}

// Generate MAPEH components separately
$mapeh_subjects = ['Music', 'Arts', 'PE', 'Health'];
$mapeh_grades = [];
$mapeh_final_scores = [];

$complete_mapeh_grades = true;

foreach ($mapeh_subjects as $subj) {
    if (isset($grades[$subj])) {
        $mapeh_grades[$subj] = $grades[$subj];

        if ($grades[$subj]['final'] !== '') {
            $mapeh_final_scores[] = $grades[$subj]['final'];
        } else {
            $complete_mapeh_grades = false;
        }
    } else {
        $mapeh_grades[$subj] = [
            'q1' => '',
            'q2' => '',
            'q3' => '',
            'q4' => '',
            'final' => '',
            'remarks' => ''
        ];
        $complete_mapeh_grades = false;
    }
}

// Compute MAPEH final grade and remarks only if all subjects have valid grades
if ($complete_mapeh_grades && count($mapeh_final_scores) === 4) {
    $mapeh_final = array_sum($mapeh_final_scores) / 4;
    $mapeh_remarks = ($mapeh_final >= 75) ? 'PASSED' : 'FAILED';
} else {
    $mapeh_final = '';
    $mapeh_remarks = '';
}


$total_final_grades = array_filter(array_merge(array_column($grades, 'final'), $mapeh_final_scores));

if ($complete_final_grades) {
    $general_average = count($total_final_grades) > 0
        ? array_sum($total_final_grades) / count($total_final_grades)
        : '';

    $general_remarks = ($general_average >= 75) ? 'PASSED' : 'FAILED';
} else {
    $general_average = '';
    $general_remarks = '';
}

// Generate PDF
$mpdf = new Mpdf();

$html = "<h4 style='text-align: center; background-color: darkblue; color: white; padding: 25px;'>REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</h4>";

$html .= "
<style>
  table tr:nth-child(even) { background-color: #d0e9ff; } 
  table tr:nth-child(odd) { background-color: #ffffff; }
</style>

<table border='1' width='100%' cellpadding='8' cellspacing='0' style='text-align: center; border-collapse: collapse;'>
        <tr style='background-color: #00bfff; color: white;'>
            <th rowspan='2' style='width: 40%;'>Learning Areas</th>
            <th colspan='4' style='width: 35%;'>Quarter</th>
            <th rowspan='2' style='width: 10%;'>Final Grade</th>
            <th rowspan='2' style='width: 15%;'>Remarks</th>
        </tr>
        <tr style='background-color: #d0e9ff;'>
            <th>1</th><th>2</th><th>3</th><th>4</th>
        </tr>";

// Print all subjects including MAPEH components
foreach ($grades as $subject => $score) {
    if (!in_array($subject, $mapeh_subjects)) {
        $html .= "<tr><td style='text-align: left;'>{$subject}</td>
                    <td>{$score['q1']}</td>
                    <td>{$score['q2']}</td>
                    <td>{$score['q3']}</td>
                    <td>{$score['q4']}</td>
                    <td>{$score['final']}</td>
                    <td>{$score['remarks']}</td>
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
        <tr style='background-color: #FFF;'><td>Outstanding</td><td>90-100</td><td>Passed</td></tr>
        <tr style='background-color: #FFF;'><td>Very Satisfactory</td><td>85-89</td><td>Passed</td></tr>
        <tr style='background-color: #FFF;'><td>Satisfactory</td><td>80-84</td><td>Passed</td></tr>
        <tr style='background-color: #FFF;'><td>Fairly Satisfactory</td><td>75-79</td><td>Passed</td></tr>
        <tr style='background-color: #FFF;'><td>Did not meet Expectations</td><td>Below 75</td><td>Failed</td></tr>
    </table>";

$mpdf->WriteHTML($html);
$mpdf->Output("student_report_{$student_no}.pdf", 'I');
