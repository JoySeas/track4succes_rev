<?php
include("../connect.php");
session_start();
error_reporting(E_ALL);

// Get the classroom_id from the URL
$classroom_id = isset($_GET['classroom_id']) ? $_GET['classroom_id'] : null;

if ($classroom_id) {
    $sql = "SELECT class_name, section, description, class_image FROM teachers_classroom WHERE classroom_id = $classroom_id";
    $result = mysqli_query($connection, $sql);
    $classroom = mysqli_fetch_assoc($result);

    if (!$classroom) {
        echo "<p>Classroom not found.</p>";
        exit;
    }
}

// Get the teacher's firstname from the session
$firstname = $_SESSION['firstname'];

// Query to get subjects for the specific classroom
$sql = "SELECT subject_id, subject_name, subject_days, subject_start_time, subject_end_time, subject_desc, subject_image FROM subjects WHERE classroom_id = $classroom_id";
$result = mysqli_query($connection, $sql);
$subjectsExist = mysqli_num_rows($result) > 0; // Check if subjects exist

// Function to format time from 24-hour to 12-hour format with AM/PM
function formatTime($time)
{
    return date("h:i A", strtotime($time));
}

// Function to format days to the desired abbreviations
function formatDays($days)
{
    $dayMap = [
        'Monday' => 'M',
        'Tuesday' => 'Tu',
        'Wednesday' => 'W',
        'Thursday' => 'Th',
        'Friday' => 'F',
        'Saturday' => 'Sa',
        'Sunday' => 'S'
    ];
    $dayArray = explode(', ', $days);
    $formattedDays = array_map(function ($day) use ($dayMap) {
        return $dayMap[$day] ?? $day;
    }, $dayArray);
    return implode('', $formattedDays);
}
function limitWords($text, $limit = 4)
{
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        $words = array_slice($words, 0, $limit);
        return implode(' ', $words) . '...';
    }
    return $text;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo "<script>
            Swal.fire({
                icon: '{$message['icon']}',
                title: '{$message['title']}',
                text: '{$message['text']}'
            });
          </script>";
    unset($_SESSION['message']); // Clear the message after displaying
}

// Fetch enrolled students
$students_query = "SELECT student_no, firstname, middlename, lastname FROM students_enrolled WHERE classroom_id = '$classroom_id'";
$students_result = mysqli_query($connection, $students_query);

$students = []; // Initialize an array to store student data
while ($row = mysqli_fetch_assoc($students_result)) {
    $full_name = trim($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']);
    // Store both the full name and student_no for deletion
    $students[] = [
        'student_no' => $row['student_no'], // Assuming student_no is the identifier
        'full_name' => $full_name
    ];
}

?>


<head>
    <link rel="stylesheet" type="text/css" href="dashboard/dashboard.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <!-- Include SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>



        <style>
            body {
                margin: 0;
                font-family: 'Poppins', sans-serif;
            }

            .banner-container {
                position: relative;
                width: 103.5%;
                /* Full width to match .col-xs-12 */
                height: auto;
                /* Responsive height */
                margin: -20px 0 50px;
            }

            .banner-container img {
                width: 100%;
                /* Ensure full width of the banner */
                height: auto;
                display: block;
            }

            .overlay {
                position: absolute;
                top: 50%;
                left: 5%;
                transform: translateY(-50%);
                color: white;
                font-size: 30px;
                text-align: left;
            }

            .profile {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .profile img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                border: 5px solid white;
                object-fit: cover;
            }

            .profile-info {
                display: flex;
                flex-direction: column;
            }

            .username {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .map-marker {
                margin-top: 5px;
                font-size: 20px;
            }

            @media (max-width: 768px) {
                .overlay {
                    font-size: 24px;
                }

                .profile img {
                    width: 80px;
                    height: 80px;
                }
            }

            @media (max-width: 480px) {
                .overlay {
                    font-size: 18px;
                }

                .profile img {
                    width: 60px;
                    height: 60px;
                }
            }

            .nav-tabs .nav-link.active {
                border-bottom: 3px solid #679DFF;
            }

            .btn-custom {
                background-color: #5D9EFE;
                border-color: #5D9EFE;
                color: #fff;
            }

            .plus-icon {
                width: 200px;
                /* Adjust width as needed */
                height: 200px;
                /* Adjust height as needed */
                display: flex;
                justify-content: center;
                align-items: center;
                border: 2px dashed #5D9EFE;
                border-radius: 50%;
                background-color: #fff;
                margin: 20px auto;
                /* Center horizontally and add margin */
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .custom-list {
                list-style: none;
                /* Remove default list styles */
                padding: 0;
                margin: 0;
            }

            .custom-list-item {
                padding: 10px;
                margin: 5px 0;
                border-radius: 5px;
                /* Optional: Add some border-radius */
            }

            .color-1 {
                background-color: #F0EBE3;
                /* First color */
            }

            .color-2 {
                background-color: #F4F6FF;
                /* Second color */
            }
        </style>
</head>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="banner-container" style="position: relative;">
                    <!-- Banner Image -->
                    <img src="../assets/images/classroom-banner.png" alt="banner" style="width: 100%;">

                    <!-- Overlay Section with Classroom Information -->
                    <div class="overlay">
                        <div class="profile">
                            <div class="profile-info">
                                <div class="username">
                                    <h2 style="color: #FFF;"><?php echo $classroom['class_name']; ?> -
                                        <?php echo $classroom['section']; ?>
                                    </h2>
                                </div>
                                <h5 style="color: #FFF;">Teacher <?php echo htmlspecialchars($firstname); ?></h5>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown" style="position: absolute; top: 10px; right: 50px;">
                        <button class="btn d-flex align-items-center" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="background-color: #5D9EFE; border: none; color: #FFF; padding: 8px 16px; border-radius: 5px;">
                            <!-- Image positioned first -->
                            <img class="edit-icon" src="assets/images/edit1.png"
                                style="width: 16px; height: 16px; cursor: pointer; margin-right: 8px;">
                            <!-- Spacing added with margin-right -->
                            Customize
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item edit-classroom" href="#" id="edit-classroom">Update</a>
                            <a class="dropdown-item text-danger" href="#" id="delete-classroom">Delete</a>
                            <!-- <a class="dropdown-item" href="#" id="archive-classroom">Archive</a> -->
                            <a class="dropdown-item" href="#" id="archive-classroom" data-classroom-id="<?php echo $classroom_id; ?>">Archive</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-12">
        <div class="card" style="margin-bottom: 15px;">
            <div class="box bg-info1" style="background: #FFFFFF; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="subject-tab" data-toggle="tab" href="#subject" role="tab"
                            aria-controls="subject" aria-selected="true">Subject</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="student-behavior" data-toggle="tab" href="#behavior" role="tab"
                            aria-controls="behavior" aria-selected="false">Student Behavior Rating</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="people-tab" data-toggle="tab" href="#people" role="tab"
                            aria-controls="people" aria-selected="false">People</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                        <?php if (!$subjectsExist): ?>
                            <div class="row">
                                <div class="col-12 text-center" style="margin-top: 80px;">
                                    <img src="../assets/images/admin/newpost.png" alt="">
                                </div>
                                <div class="col-12 text-center">
                                    <p>This is where you’ll view and manage subjects</p>
                                </div>
                                <div class="col-12 text-center" style="margin-bottom: 100px;">
                                    <button class="btn"
                                        style="background: #2C4E80; border-radius: 10px; color: #FFFFFF; margin-top: 10px;"
                                        data-toggle="modal" data-target="#mdladdsubject">Add Subject</button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row" style="margin-top: 10px;">
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <div class="col-12 col-md-3">
                                        <div class="card"
                                            style="margin-bottom: 15px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">

                                            <!-- Wrap the card content in an anchor tag -->
                                            <a href="./index.php?url=eachsubject&subject_id=<?php echo $row['subject_id']; ?>"
                                                style="text-decoration: none; color: inherit;">
                                                <?php
                                                $classImagePath = 'uploads/subjects/' . $row['subject_image'];
                                                ?>
                                                <img src="<?php echo $classImagePath; ?>"
                                                    alt="<?php echo htmlspecialchars($row['subject_name']); ?>"
                                                    style="width: 100%; height: auto;">
                                                <!-- <div class="card" style="margin-bottom: 15px; box-shadow: 2px 3px 5px rgb(126, 142, 159); height: 350px; display: flex; flex-direction: column;"> -->
                                                <div class="box bg-info"
                                                    style="background: #FFFFFF; box-shadow: 2px 3px 5px rgb(126, 142, 159);  height: 140px; display: flex; flex-direction: column;">
                                                    <div class="title">
                                                        <h5 style="font-weight: 600; font-size: 1.1rem;">
                                                            <?php echo htmlspecialchars($row['subject_name']); ?>
                                                        </h5>
                                                    </div>
                                                    <div class="content">
                                                        <h6 style="font-weight: 300; font-size: 1rem;">
                                                            <?php echo htmlspecialchars(formatDays($row['subject_days'])); ?>
                                                        </h6>
                                                        <h6 style="font-weight: 300; font-size: 1rem;">
                                                            <?php echo formatTime($row['subject_start_time']); ?> -
                                                            <?php echo formatTime($row['subject_end_time']); ?>
                                                        </h6>
                                                        <h5 style="margin-top: 20px;">
                                                            <?php echo htmlspecialchars(limitWords($row['subject_desc'])); ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div class="col-12 col-md-3">
                                    <div class="card" style="margin-bottom: 15px;">
                                        <div class="box bg-info" style="background: #FFFFFF;">
                                            <div class="plus-icon" data-toggle="modal" data-target="#mdladdsubject">
                                                <i class="fas fa-plus" style="font-size: 2rem"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php endif; ?>
                    </div>
                    <!-- Student Behavior Rating Tab -->
                    <div class="tab-pane fade" id="behavior" role="tabpanel" aria-labelledby="student-behavior">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Student Behavior Rating</h5>
                                        <div class="d-flex align-items-center">
                                            <!-- Dropdown for Filtering Quarters -->
                                            <select id="quarterFilter" class="form-control"
                                                style="width: 150px; margin-right: 10px;">
                                                <option value="all">All Quarters</option>
                                                <option value="1st" <?php if (isset($_GET['quarter']) && $_GET['quarter'] == '1st')
                                                    echo 'selected'; ?>>1st Quarter</option>
                                                <option value="2nd" <?php if (isset($_GET['quarter']) && $_GET['quarter'] == '2nd')
                                                    echo 'selected'; ?>>2nd Quarter</option>
                                                <option value="3rd" <?php if (isset($_GET['quarter']) && $_GET['quarter'] == '3rd')
                                                    echo 'selected'; ?>>3rd Quarter</option>
                                                <option value="4th" <?php if (isset($_GET['quarter']) && $_GET['quarter'] == '4th')
                                                    echo 'selected'; ?>>4th Quarter</option>
                                            </select>
                                            <button class="btn btn-primary"
                                                style="background: #2C4E80; border-radius: 5px;" data-toggle="modal"
                                                data-target="#uploadModal">
                                                Upload Ratings
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // PHP logic to filter based on selected quarter
                                        $selected_quarter = isset($_GET['quarter']) ? $_GET['quarter'] : null;

                                        if (in_array($selected_quarter, ['1st', '2nd', '3rd', '4th'])) {
                                            // Query to fetch ratings for the selected quarter
                                            $ratings_query = "
                        SELECT 
                            CONCAT(s.firstname, ' ', IFNULL(s.middlename, ''), ' ', s.lastname) AS full_name, 
                            r.R1, r.R2, r.R3, r.R4, r.R5, r.R6, r.R7, r.R8, r.R9, r.R10, r.R11, r.R12, r.R13
                        FROM students_enrolled s
                        LEFT JOIN student_behavior_ratings r 
                            ON s.student_no = r.student_no 
                            AND r.quarter = ? 
                            AND s.classroom_id = r.classroom_id
                        WHERE s.classroom_id = ?";
                                            $stmt = $connection->prepare($ratings_query);
                                            $stmt->bind_param("si", $selected_quarter, $classroom_id);
                                        } else {
                                            // Default query for all quarters
                                            $ratings_query = "
                        SELECT 
                            CONCAT(s.firstname, ' ', IFNULL(s.middlename, ''), ' ', s.lastname) AS full_name, 
                            r.R1, r.R2, r.R3, r.R4, r.R5, r.R6, r.R7, r.R8, r.R9, r.R10, r.R11, r.R12, r.R13,
                            r.quarter
                        FROM students_enrolled s
                        LEFT JOIN student_behavior_ratings r 
                            ON s.student_no = r.student_no
                            AND s.classroom_id = r.classroom_id
                        WHERE s.classroom_id = ?";
                                            $stmt = $connection->prepare($ratings_query);
                                            $stmt->bind_param("i", $classroom_id);
                                        }

                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        // Check if there are students enrolled
                                        if ($result->num_rows == 0): ?>
                                            <p class="text-center">No students enrolled in this class.</p>
                                        <?php else: ?>
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <!-- Table for Student Behavior Rating -->
                                                <table class="table table-bordered text-center">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                style="width: 240px; background-color: #C2ECFF !important; font-weight: bolder;">
                                                                Name</th>
                                                            <!-- Generate 13 additional columns with fixed width for each rating (R1 to R13) -->
                                                            <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                <th
                                                                    style="width: 30px; background-color: #C2ECFF !important; font-weight:bolder;">
                                                                    R<?php echo $i; ?></th>
                                                            <?php endfor; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $result->fetch_assoc()): ?>
                                                            <tr>
                                                                <td
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                    <?php echo htmlspecialchars($row['full_name'] ?? 'No Name Available'); ?>
                                                                </td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td><?php echo htmlspecialchars($row["R$i"] ?? 'No Rating'); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body">
    <i>
        <p style="font-size: 15px; display: block; margin: 0;">R1 - Regular in Attendance</p>
        <p style="font-size: 15px; display: block; margin: 0;">R2 - Punctual in coming to school</p>
        <p style="font-size: 15px; display: block; margin: 0;">R3 - Participates in making the classroom and school clean</p>
        <p style="font-size: 15px; display: block; margin: 0;">R4 - Participates in school activities</p>
        <p style="font-size: 15px; display: block; margin: 0;">R5 - Maintain a good disposition inside the classroom</p>
        <p style="font-size: 15px; display: block; margin: 0;">R6 - Shows respect for teachers and co-students</p>
        <p style="font-size: 15px; display: block; margin: 0;">R7 - Shows discipline and decorum in school</p>
        <p style="font-size: 15px; display: block; margin: 0;">R8 - Shows focus on his/her studies</p>
        <p style="font-size: 15px; display: block; margin: 0;">R9 - Neat and Organized</p>
        <p style="font-size: 15px; display: block; margin: 0;">R10 - Honest in words and deeds</p>
        <p style="font-size: 15px; display: block; margin: 0;">R11 - Shows patriotism in everyday life</p>
        <p style="font-size: 15px; display: block; margin: 0;">R12 - Adheres to school rules and regulations</p>
        <p style="font-size: 15px; display: block; margin: 0;">R13 - Respects sacred places of worship</p>
    </i>

    <!-- Centered Table -->
    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <table style="border: 1px solid #ddd; border-collapse: collapse; text-align: center;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; font-weight:800;">Marking</th>
                <th style="border: 1px solid #ddd; padding: 8px;font-weight:800; ">Non-Numerical Rating</th>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">A</td>
                <td style="border: 1px solid #ddd; padding: 8px;">Always</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">B</td>
                <td style="border: 1px solid #ddd; padding: 8px;">Sometimes</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">C</td>
                <td style="border: 1px solid #ddd; padding: 8px;">Never</td>
            </tr>
        </table>
    </div>
</div>

                            </div>
                        </div>
                    </div>

                    <!-- JavaScript to Handle Filter Action -->
                    <script>
                        document.getElementById('quarterFilter').addEventListener('change', function () {
                            const selectedQuarter = this.value;
                            const url = new URL(window.location.href);
                            if (selectedQuarter === "all") {
                                url.searchParams.delete("quarter");
                            } else {
                                url.searchParams.set("quarter", selectedQuarter);
                            }
                            window.location.href = url.toString();
                        });
                    </script>




                    <!--Tab for students-->
                    <div class="tab-pane fade" id="people" role="tabpanel" aria-labelledby="people-tab">
                        <?php if (empty($students)): ?>
                            <!-- Display this section if there are no students enrolled -->
                            <div class="row">
                                <div class="col-12 text-center" style="margin-top: 80px;">
                                    <img src="../assets/images/admin/newpost.png" alt="">
                                </div>
                                <div class="col-12 text-center">
                                    <p>Enroll Student to this class</p>
                                </div>
                                <div class="col-12 text-center" style="margin-bottom: 100px;">
                                    <button class="btn"
                                        style="background: #2C4E80; border-radius: 10px; color: #FFFFFF; margin-top: 10px;"
                                        data-toggle="modal" data-target="#mdladdstudent">Enroll Student</button>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Display this section if there are students enrolled -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div class="ml-auto">
                                                <button class="btn"
                                                    style="background: #2C4E80; border-radius: 10px; color: #FFFFFF; margin-top: 10px;"
                                                    data-toggle="modal" data-target="#mdladdstudent">Add Student</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="custom-list">
                                                <?php
                                                foreach ($students as $index => $student):
                                                    // Get the student ID from your data
                                                    $studentId = $student['student_no']; // Using the unique identifier
                                                    $fullName = htmlspecialchars($student['full_name']);
                                                    // Alternate between the two colors
                                                    $colorClass = $index % 2 === 0 ? 'color-1' : 'color-2';
                                                    ?>
                                                    <li class="custom-list-item <?php echo $colorClass; ?>">
                                                        <?php echo $fullName; ?>
                                                        <span class="delete-icon"
                                                            style="cursor: pointer; color: red; float: right;"
                                                            onclick="confirmDeletion('<?php echo $studentId; ?>')">
                                                            <!-- <i class="fas fa-trash-alt"></i> Font Awesome trash icon -->
                                                            <img src="classroom/delete.png" alt="Delete"
                                                                style="width: 20px; height: 20px;">
                                                        </span>

                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="modal fade" id="mdladdsubject" tabindex="-1" role="dialog"
                    aria-labelledby="mdladdsubjectLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="mdladdsubjectLabel">Add Subject</h5>
                            </div>
                            <div class="modal-body">
                                <!-- Add your form or content here -->
                                <form action="classroom/add_subject.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="classroom_id" value="<?php echo $classroom_id; ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject_name"
                                            placeholder="Subject Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject_teacher"
                                            placeholder="Subject Teacher" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_start_time">Start Time</label>
                                        <input type="time" class="form-control" name="subject_start_time"
                                            placeholder="Start Time" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_end_time">End Time</label>
                                        <input type="time" class="form-control" name="subject_end_time"
                                            placeholder="End Time" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="subject_days">Days</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Monday"> Monday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Tuesday"> Tuesday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Wednesday"> Wednesday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Thursday"> Thursday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Friday"> Friday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Saturday"> Saturday
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="subject_days[]"
                                                value="Sunday"> Sunday
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject_room" placeholder="Room"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="subject_desc" rows="3"
                                            placeholder="Subject Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="subject_image"
                                            accept="image/*">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-custom">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Uploading Ratings -->
                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Upload Student Ratings</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="uploadRatingsForm" enctype="multipart/form-data">
                                <input type="hidden" name="classroom_id" value="<?php echo $classroom_id; ?>">
                                <div class="modal-body">
                                    <!-- Dropdown for selecting the quarter -->
                                    <div class="form-group">
                                        <label for="quarterSelect">Select Quarter</label>
                                        <select name="quarter" id="quarterSelect" class="form-control" required>
                                            <option value="1st">1st Quarter</option>
                                            <option value="2nd">2nd Quarter</option>
                                            <option value="3rd">3rd Quarter</option>
                                            <option value="4th">4th Quarter</option>
                                        </select>

                                    </div>
                                    <!-- File input for ratings file -->
                                    <div class="form-group">
                                        <input type="file" name="ratingsFile" class="form-control" accept=".xlsx, .xls"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <!--ADD STUDENT MODAL-->
                <div class="modal fade" id="mdladdstudent" tabindex="-1" role="dialog"
                    aria-labelledby="mdladdstudentLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="mdladdstudentLabel">Enroll Students via
                                    Excel</h5>
                            </div>
                            <div class="modal-body">
                                <form id="enrollStudentsForm" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="classroom_id" value="<?php echo $classroom_id; ?>">

                                    <div class="form-group">
                                        <label for="student_excel">Upload Excel File</label>
                                        <input type="file" class="form-control-file" name="student_excel"
                                            accept=".xlsx, .xls" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-custom">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for updating classroom -->
    <div class="modal fade" id="mdlUpdateClassroom" tabindex="-1" role="dialog"
        aria-labelledby="mdlUpdateClassroomLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" id="mdlUpdateClassroomLabel">Update Classroom</h5>
                </div>
                <div class="modal-body">
                    <form id="updateClassroomForm" enctype="multipart/form-data">
                        <input type="hidden" name="update_classroom_id" id="classroom_id">
                        <div class="form-group">
                            <input type="text" class="form-control" name="class_name" id="update_class_name"
                                placeholder="Classroom Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="section" id="update_section"
                                placeholder="Section">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="update_description"
                                placeholder="Class Description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="startYear">School Year Start</label>
                            <select id="startYear" name="start_year" class="form-control">
                                <option value="" disabled selected>Select Start Year</option>
                                <?php
                                for ($year = 2000; $year <= 2100; $year++) {
                                    echo "<option value='$year'>$year</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="endYear">School Year End</label>
                            <select id="endYear" name="end_year" class="form-control">
                                <option value="" disabled selected>Select End Year</option>
                                <?php
                                for ($year = 2000; $year <= 2100; $year++) {
                                    echo "<option value='$year'>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Current Classroom Image:</label><br>
                            <?php
                            $image_path = "uploads/class_images/" . htmlspecialchars($classroom['class_image']);
                            if (!empty($classroom['class_image']) && file_exists($image_path)): ?>
                                <img src="<?php echo $image_path; ?>" id="current_class_image" alt="Classroom Image"
                                    style="max-width: 100px; height: auto;">
                            <?php else: ?>
                                <img src="assets/images/default.png" alt="No Image Available"
                                    style="max-width: 100px; height: auto;">
                            <?php endif; ?>
                        </div>

                        <!-- Input field for image upload -->
                        <div class="form-group">
                            <label for="class_image">Upload New Classroom Image</label>
                            <input type="file" class="form-control" name="class_image" id="class_image">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-custom">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (required for tab functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FontAwesome for Plus Icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#enrollStudentsForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this);

                $.ajax({
                    url: 'classroom/enrollstudents.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("AJAX Response: ", response); // Log the response for debugging
                        var result = JSON.parse(response);

                        // Check if the response is valid and structured correctly
                        if (result && result.status) {
                            if (result.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: result.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#mdladdstudent').modal('hide');
                                        // Optionally refresh the page
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: result.message, // Display the error message here
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload(); // Optional: Reload the page after clicking OK on the error message
                                    }
                                });
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Invalid response from the server.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred: ' + textStatus,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Optional: Reload the page after clicking OK on the error message
                            }
                        });
                    }
                });
            });
        });

        function confirmDeletion(studentId) {
    const classroomId = "<?php echo $classroom_id; ?>"; // Replace with the current classroom ID

    Swal.fire({
        title: "Are you sure you want to unenroll this student?",
        text: "You will not be able to recover this record!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX call to delete the student
            $.ajax({
                url: 'classroom/delete_student.php',
                type: 'POST',
                data: {
                    student_no: studentId,
                    classroom_id: classroomId // Pass the classroom ID
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire("Deleted!", "The student has been unenrolled successfully.", "success")
                            .then(() => {
                                location.reload(); // Reload the page to see the changes
                            });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    Swal.fire("Error!", "There was an issue deleting the student.", "error");
                }
            });
        }
    });
}


        $(document).ready(function () {
            // When the edit button is clicked, show the modal and populate the form fields
            $('.edit-classroom').on('click', function () {
                $('#mdlUpdateClassroom').modal('show');

                // Populate the modal form with the classroom data
                $('#classroom_id').val('<?php echo $classroom_id; ?>');
                $('#update_class_name').val('<?php echo htmlspecialchars($classroom["class_name"]); ?>');
                $('#update_section').val('<?php echo htmlspecialchars($classroom["section"]); ?>');
                $('#update_description').val('<?php echo htmlspecialchars($classroom["description"]); ?>');
            });

            // Handle form submission
            $('#updateClassroomForm').on('submit', function (e) {
                e.preventDefault();  // Prevent default form submission

                let formData = new FormData(this);  // Collect form data, including files

                $.ajax({
                    url: 'classroom/update_classroom.php',  // Path to the PHP script that processes the update
                    type: 'POST',
                    data: formData,
                    contentType: false,  // Required for file uploads
                    processData: false,  // Required for file uploads
                    success: function (response) {
                        // Success response handling
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Classroom updated successfully!',
                            showConfirmButton: true,
                            timer: 1500
                        });

                        // Optionally, reload the page or update the displayed data without reloading
                        setTimeout(function () {
                            location.reload();  // Reload to show updated classroom info
                        }, 1500);
                    },
                    error: function (xhr, status, error) {
                        // Error response handling
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Please try again later.'
                        });
                    }
                });
            });

            $('#delete-classroom').on('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX call to delete the classroom
                        $.ajax({
                            url: 'classroom/delete_classroom.php', // The server-side script to handle deletion
                            type: 'POST',
                            data: { classroom_id: '<?php echo $classroom_id; ?>' },
                            success: function (response) {
                                var jsonResponse = JSON.parse(response);
                                if (jsonResponse.status === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'The classroom has been deleted.',
                                        'success'
                                    ).then(() => {
                                        window.location.href = 'index.php?url=classroom'; // Redirect after deletion
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        jsonResponse.message,
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });

        });
        $(document).ready(function () {
    $('#archive-classroom').on('click', function (e) {
        e.preventDefault(); // Prevent default action

        const classroomId = $(this).data('classroom-id'); // Fetch classroom ID dynamically

        Swal.fire({
            title: 'Are you sure?',
            text: "This classroom will be archived!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX call to archive the classroom
                $.ajax({
                    url: 'classroom/archive_classroom.php', // Server-side script for archiving
                    type: 'POST',
                    data: { classroom_id: classroomId },
                    success: function (response) {
                        const jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            Swal.fire(
                                'Archived!',
                                'The classroom has been archived.',
                                'success'
                            ).then(() => {
                                window.location.href = 'index.php?url=classroom'; // Redirect after archiving
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                jsonResponse.message || 'Failed to archive the classroom.',
                                'error'
                            );
                        }
                    },
                    error: function () {
                        Swal.fire(
                            'Error!',
                            'An unexpected error occurred.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});


        $(document).ready(function () {
            $('#uploadRatingsForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this);

                // Add the selected quarter to the form data
                var selectedQuarter = $('#quarterSelect').val();


                $.ajax({
                    url: 'classroom/upload_ratings.php', // The PHP script for uploading ratings
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("AJAX Response: ", response); // Log the response for debugging
                        var result = JSON.parse(response);

                        // Check if the response is valid and structured correctly
                        if (result && result.status) {
                            if (result.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: result.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#uploadModal').modal('hide'); // Close the modal
                                        location.reload(); // Optionally reload the page
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: result.message, // Display the error message here
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Invalid response from the server.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred: ' + textStatus,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Optionally reload the page after clicking OK on the error message
                            }
                        });
                    }
                });
            });
        });


    </script>

    </body>