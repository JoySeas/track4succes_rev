<?php
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

    // Fetch the classroom(s) associated with the teacher with status 'ACTIVE'
    $classrooms_sql = "SELECT classroom_id 
                       FROM teachers_classroom 
                       WHERE teacher_id = '$teacher_id' 
                       AND status = 'ACTIVE'";
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
            $messages[] = "No active classroom found.";
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
                    $messages[] = "No subjects found.";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Schedule</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style type="text/css">
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container-fluid {
            padding: 15px;
            background-color: white;
            margin-top: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Timetable container */
        .timetable {
            display: grid;
            grid-template-columns: 80px repeat(6, 1fr);
            /* One column for time, five for days */
            grid-template-rows: repeat(22, 30px);
            /* 30-minute increments from 7:00 AM to 6:00 PM */
            gap: 3px;
            margin: 0 auto;
            width: 100%;
            max-width: 900px;
        }

        /* Time column */
        .time {
            grid-column: 1;
            text-align: right;
            padding-right: 15px;
            border-right: 1px solid #ddd;
            font-weight: bold;
        }

        /* Day column */
        .day {
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        /* Subject block */
        .class-block {
            background-color: rgba(100, 150, 250, 0.7);
            border-radius: 5px;
            color: black;
            text-align: center;
            padding: 3px;
            font-size: 0.7rem;
            position: relative;
            display: flex;
            /* Make it a flex container */
            flex-direction: column;
            /* Stack children vertically */
            justify-content: center;
            /* Center content vertically */
            align-items: center;
            /* Center content horizontally */
            margin: 0;
            /* Remove any spacing around the block */
            gap: 1px;
            /* Small gap between text elements */
        }

        .class-block h4 {
            margin: 0;
            /* Remove any default margins */
            padding: 0;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            /* Remove any default paddings */
        }

        .class-block p {
            margin: 0;
            /* Remove any default margins */
            padding: 0;
            /* Remove any default paddings */
        }

        /* Time labels (on the left) */
        .time-label {
            grid-column: 1;
            text-align: right;
            padding-right: 1px;
            border-right: 1px solid #ddd;
            font-weight: bold;
        }

        /* Each 30-minute block */
        .slot {
            background-color: rgba(100, 150, 250, 0.8);
            padding: 5px;
            text-align: center;
            border-radius: 4px;
            color: white;
        }

        /* Subject colors */
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

        /* Style the print button */
        .print-button {
            text-align: right;
            margin-bottom: 15px;
        }

        .print-button button {
            padding: 10px 20px;
            background-color: #5D9EFE;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-button button:hover {
            background-color: #1e3a63;
        }

        /* Add styles for the scrollable timetable */
        .timetable-container {
            overflow-x: auto;
            /* Allows horizontal scrolling */
            width: 100%;
        }

        .timetable {
            min-width: 700px;
            /* Minimum width for the timetable to ensure grid layout is preserved */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .timetable {
                grid-template-columns: repeat(6, 1fr);
                /* Adjust to fit smaller screens */
                grid-template-rows: repeat(22, 40px);
            }

            .time {
                font-size: 0.8rem;
                /* Adjust time font size */
            }

            .day {
                font-size: 0.8rem;
                /* Adjust day font size */
            }

            .class-block {
                font-size: 0.8rem;
                /* Adjust subject block font size */
            }
        }

        .print-button {
            float: right;
            /* Align to the right */
            padding: 5px 15px;
            background-color: #5D9EFE;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            /* Space between title and button */
            font-size: 1rem;
            /* Adjust font size as needed */
        }

        .print-button:hover {
            background-color: #1e3a63;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 0.5rem; /* Reduce overall font size for printing */
            }

            .container-fluid {
                padding: 5px; /* Reduce padding for print */
                margin: 0; /* Remove margin for print */
            }

            .timetable {
                grid-template-rows: repeat(20, 25px); /* Adjust row height for print */
            }

            .class-block {
                padding: 2px; /* Reduce padding for print */
                font-size: 0.5rem; /* Smaller font size for print */
            }

            .day {
                font-size: 0.5rem; /* Smaller day labels for print */
            }

            .time-label {
                font-size: 0.5rem; /* Smaller time labels for print */
            }

            /* Optional: Hide buttons when printing */
            #generate-pdf {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="padding: 15px; background-color: white; min-height: 540px; margin-top: 15px; border-radius: 5px; border: 1px solid;">
        <h3>Subject Schedule
        <button id="generate-sched" class="print-button"><img class="edit-icon" src="assets/images/download.png" style="width: 16px; height: 16px; cursor: pointer; margin-right: 8px;">Download</button>
        </h3>

        <table class="table table-bordered table-hover" id="schedule-table">
            <thead class="title" style="background-color: #C2ECFF;">
                <tr>
                    <th style="width: 30%; text-align: center;">Subject</th>
                    <th style="width: 20%; text-align: center;">Days</th>
                    <th style="width: 20%; text-align: center;">Time</th>
                    <th style="width: 20%; text-align: center; color: #FFF;">Room</th>
                </tr>
            </thead>
            <tbody id="tblschedlist">
    <?php
    if (isset($subjects_array) && count($subjects_array) > 0) {
        // Display each subject in the table
        foreach ($subjects_array as $subject) {
            $days = $subject['subject_days'];
            $start_time = date("h:i A", strtotime($subject['subject_start_time']));
            $end_time = date("h:i A", strtotime($subject['subject_end_time']));
            $time = $start_time . ' - ' . $end_time;
            echo "<tr>";
            echo "<td>{$subject['subject_name']}</td>";
            echo "<td>{$days}</td>";
            echo "<td>{$time}</td>";
            echo "<td>{$subject['subject_room']}</td>";
            echo "</tr>";
        }
    } else {
        // If no subjects are found, display "No data posted"
        echo "<tr><td colspan='4' style='text-align: center;'>No data posted</td></tr>";
    }
    ?>
</tbody>

        </table>

    </div>
    <div class="container-fluid">
        <h3>Timetable
            <button id="generate-pdf" class="print-button"><img class="edit-icon" src="assets/images/printer.png" style="width: 16px; height: 16px; cursor: pointer; margin-right: 8px;">Print Timetable</button>
        </h3>
        <!-- Scrollable container for the timetable -->
        <div class="timetable-container">
            <div class="timetable">
                <!-- Days of the week -->
                <div class="time"></div> <!-- Empty top-left corner -->
                <div class="day">Monday</div>
                <div class="day">Tuesday</div>
                <div class="day">Wednesday</div>
                <div class="day">Thursday</div>
                <div class="day">Friday</div>
                <div class="day">Saturday</div>

                <!-- Time Labels -->
                <div class="time-label">7:00 AM</div>
                <div class="time-label">7:30 AM</div>
                <div class="time-label">8:00 AM</div>
                <div class="time-label">8:30 AM</div>
                <div class="time-label">9:00 AM</div>
                <div class="time-label">9:30 AM</div>
                <div class="time-label">10:00 AM</div>
                <div class="time-label">10:30 AM</div>
                <div class="time-label">11:00 AM</div>
                <div class="time-label">11:30 AM</div>
                <div class="time-label">12:00 PM</div>
                <div class="time-label">12:30 PM</div>
                <div class="time-label">1:00 PM</div>
                <div class="time-label">1:30 PM</div>
                <div class="time-label">2:00 PM</div>
                <div class="time-label">2:30 PM</div>
                <div class="time-label">3:00 PM</div>
                <div class="time-label">3:30 PM</div>
                <div class="time-label">4:00 PM</div>
                <div class="time-label">4:30 PM</div>
                <div class="time-label">5:00 PM</div>
                <div class="time-label">5:30 PM</div>

                <!-- Dynamic Subject Blocks -->
                <?php
                foreach ($subjects_array as $subject) {
                    // Extract subject data
                    $days = array_map('trim', explode(",", $subject['subject_days']));
                    $start_time = strtotime($subject['subject_start_time']);
                    $end_time = strtotime($subject['subject_end_time']);

                    // Calculate the starting and ending rows based on 30-minute intervals
                    $start_row = ($start_time - strtotime('07:00:00')) / 1800 + 2;
                    $end_row = ($end_time - strtotime('07:00:00')) / 1800 + 2;

                    // Prepare display time
                    $time = date("h:i A", $start_time) . ' - ' . date("h:i A", $end_time);

                    foreach ($days as $day) {
                        // Determine grid column for each day
                        switch ($day) {
                            case 'Monday':
                                $grid_column = 2;
                                break;
                            case 'Tuesday':
                                $grid_column = 3;
                                break;
                            case 'Wednesday':
                                $grid_column = 4;
                                break;
                            case 'Thursday':
                                $grid_column = 5;
                                break;
                            case 'Friday':
                                $grid_column = 6;
                                break;
                            case 'Saturday':
                                $grid_column = 7;
                                break;
                            default:
                                continue 2; // Skip if the day isn't valid
                        }

                        // Assign a color class based on the subject
                        $subject_class = strtolower(str_replace(' ', '', $subject['subject_name']));

                        // Display the subject block in the correct time slot
                        echo "<div class='class-block $subject_class' style='grid-column: $grid_column; grid-row: $start_row / $end_row;'>";
                        echo "<h4>{$subject['subject_name']}</h4>";
                        echo "<p>{$time}</p>";
                        echo "<p>Room: {$subject['subject_room']}</p>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
   <script>
    document.getElementById('generate-pdf').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'pt', 'letter'); // Letter size
    pdf.setFontSize(16); // Set font size for the title
    pdf.setFont("Poppins", "bold"); // Set the font to bold

    // Calculate the center position for the title
    const pageWidth = pdf.internal.pageSize.getWidth();
    const title = 'Class Schedule';
    const textWidth = pdf.getTextWidth(title);
    const titleX = (pageWidth - textWidth) / 2;

    // Set some margins for better spacing
    const margin = { top: 20, left: 20, bottom: 30 };
    
    // Center the title text
    pdf.text(title, titleX, margin.top);

    const timetable = document.querySelector('.timetable');
    const timetableHTML = timetable.outerHTML;

    pdf.html(timetableHTML, {
        callback: function (doc) {
            doc.save('timetable.pdf');
        },
        x: margin.left,
        y: margin.top + 40, // Add more space below the title
        width: 800, // Set width to fit in letter size
        // Scale content down for smaller fit
        html2canvas: {
            scale: 0.7 // Reduce scaling to make content smaller
        },
    });
});
document.getElementById('generate-sched').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'pt', 'letter'); // Portrait, Letter size

        // Add centered title "Class Schedule"
        pdf.setFontSize(18); // Font size for title
        pdf.text('Class Schedule', pdf.internal.pageSize.getWidth() / 2, 40, { align: 'center' }); // Centered title

        // Get the table
        const table = document.querySelector('#schedule-table');

        // Use html2canvas to render the table to an image
        html2canvas(table).then(function (canvas) {
            const imgData = canvas.toDataURL('image/png'); // Convert canvas to image
            const imgWidth = 500; // Set image width
            const imgHeight = (canvas.height * imgWidth) / canvas.width; // Maintain aspect ratio

            pdf.addImage(imgData, 'PNG', 50, 60, imgWidth, imgHeight); // Add the image below the title
            pdf.save('subject-schedule.pdf'); // Save the PDF with a file name
        });
    });

   </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>