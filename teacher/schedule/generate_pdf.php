<?php
require_once '../../vendor/autoload.php'; // Path to mPDF

// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();
include("../connect.php");
session_start();

// Initialize an array to store messages
$messages = [];

// Ensure the teacher_id is available in the session
if (!isset($_SESSION['user_id'])) {
    $messages[] = "Please log in to view the schedule.";
} else {
    // Get the teacher_id from the session
    $teacher_id = $_SESSION['user_id'];

    // Get the search query from the request
    $search_query = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

    // Fetch the classroom(s) associated with the teacher
    $classrooms_sql = "SELECT classroom_id FROM teachers_classroom WHERE teacher_id = '$teacher_id'";
    $classrooms_result = mysqli_query($connection, $classrooms_sql);

    if (!$classrooms_result) {
        $messages[] = "Database query failed: " . mysqli_error($connection);
    } else {
        // Fetch classroom IDs
        $classroom_ids = [];
        while ($row = mysqli_fetch_assoc($classrooms_result)) {
            $classroom_ids[] = $row['classroom_id'];
        }

        // Check if any classrooms were found
        if (empty($classroom_ids)) {
            $messages[] = "No classroom added";
        } else {
            // Create a comma-separated list of classroom IDs for the query
            $classroom_ids_str = implode(',', $classroom_ids);

            // Fetch subjects associated with the teacher's classrooms
            $subjects_sql = "SELECT s.subject_name, s.subject_days, s.subject_start_time, s.subject_end_time, s.subject_room
                             FROM subjects s
                             JOIN teachers_classroom c ON s.classroom_id = c.classroom_id
                             WHERE c.classroom_id IN ($classroom_ids_str)
                             AND s.subject_name LIKE '%$search_query%'";

            // Execute the query and handle errors
            $subjects_result = mysqli_query($connection, $subjects_sql);
            if (!$subjects_result) {
                $messages[] = "Error fetching subjects: " . mysqli_error($connection);
            } else {
                // Store subjects in an array for later use
                $subjects_array = [];
                while ($subject = mysqli_fetch_assoc($subjects_result)) {
                    $subjects_array[] = $subject; // Store each subject
                }

                // Check if there are any subjects
                if (count($subjects_array) === 0) {
                    $messages[] = "No subjects added";
                }
            }
        }
    }
}
// HTML content for the timetable
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Schedule PDF</title>
    <style type="text/css">
        body {
            font-family: "Poppins", sans-serif;
        }

        .container-fluid {
            padding: 15px;
            background-color: white;
            margin-top: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .time-label {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
        }

        .class-block {
            background-color: rgba(100, 150, 250, 0.7);
            border-radius: 5px;
            color: black;
            padding: 5px;
            font-size: 0.8rem;
            text-align: center;
        }

        .class-block h4, .class-block p {
            margin: 0;
            padding: 0;
        }

        .english {
            background-color: #FFB1B1;
        }

        .science {
            background-color: #E6D9A2;
        }

        .math {
            background-color: #B4D6CD;
        }

        .filipino {
            background-color: #FFC7ED;
        }

        .ap {
            background-color: #FFB4C2;
        }

        .tle {
            background-color: #FF5722;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h3>Timetable</h3>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
            </thead>
            <tbody>
';

// PHP to dynamically generate timetable rows with 30-minute intervals
for ($i = 7; $i <= 17; $i++) {
    $times = [
        "$i:00" => "$i:00 - " . date("h:i A", strtotime("$i:30")),
        "$i:30" => "$i:30 - " . date("h:i A", strtotime(($i + 1) . ":00"))
    ];

    foreach ($times as $start_time_str => $end_time_str) {
        $start_time = date("h:i A", strtotime($start_time_str));
        $end_time = date("h:i A", strtotime($end_time_str));

        $html .= "<tr>
                    <td class='time-label'>{$start_time_str}</td>";

        // Loop through each day
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($days as $day) {
            $subject_found = false;

            // Loop through the subjects to find one that matches the current day and time range
            foreach ($subjects_array as $subject) {
                $subject_days = array_map('trim', explode(",", $subject['subject_days']));
                $subject_start_time = strtotime($subject['subject_start_time']);
                $subject_end_time = strtotime($subject['subject_end_time']);

                // Check if the subject falls within the current time range and day
                if (in_array($day, $subject_days) &&
                    $subject_start_time <= strtotime($end_time_str) &&
                    $subject_end_time >= strtotime($start_time_str)) {

                    // Assign a color class based on the subject name
                    $subject_class = strtolower(str_replace(' ', '', $subject['subject_name']));

                    $html .= "<td class='class-block {$subject_class}'>
                                <h4>{$subject['subject_name']}</h4>
                                <p>{$start_time} - {$end_time}</p>
                                <p>Room: {$subject['subject_room']}</p>
                              </td>";

                    $subject_found = true;
                    break;
                }
            }

            if (!$subject_found) {
                $html .= "<td></td>";
            }
        }

        $html .= "</tr>";
    }
}

$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output('timetable.pdf', 'D');

?>
