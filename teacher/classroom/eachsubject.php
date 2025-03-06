<?php
include("../connect.php");

// Get the subject_id from the URL and sanitize it
$subject_id = isset($_GET['subject_id']) ? mysqli_real_escape_string($connection, $_GET['subject_id']) : null;

if ($subject_id) {
    // Fetch subject details, including classroom_id
    $sql = "SELECT subject_name, subject_days, subject_start_time, subject_teacher, subject_end_time, subject_room, subject_desc, subject_image, classroom_id 
            FROM subjects 
            WHERE subject_id = '$subject_id'"; // Make sure to use quotes around $subject_id
    $result = mysqli_query($connection, $sql);
    $subject = mysqli_fetch_assoc($result);

    if (!$subject) {
        echo "<p>Subject not found.</p>";
        exit;
    }

    // Map full day names to abbreviations
    $daysMap = [
        'Monday' => 'M',
        'Tuesday' => 'Tu',
        'Wednesday' => 'W',
        'Thursday' => 'Th',
        'Friday' => 'F',
        'Saturday' => 'Sa',
        'Sunday' => 'S'
    ];

    // Format days
    $daysArray = explode(',', $subject['subject_days']);
    $formattedDays = array_map(function ($day) use ($daysMap) {
        return trim($daysMap[ucfirst(trim($day))]);
    }, $daysArray);

    $daysString = implode('', $formattedDays); // No separator

    // Format times
    $startTime = date('h:i A', strtotime($subject['subject_start_time']));
    $endTime = date('h:i A', strtotime($subject['subject_end_time']));

    // Get the classroom_id from the subject data
    $classroom_id = $subject['classroom_id'];
} else {
    echo "<p>Invalid subject_id.</p>";
    exit;
}


// Fetch enrolled students based on the classroom_id (foreign key)
$students_query = "
    SELECT student_no, firstname, middlename, lastname 
    FROM students_enrolled 
    WHERE classroom_id = '$classroom_id'
";
$students_result = mysqli_query($connection, $students_query);

$students = []; // Initialize an array to store student data
while ($row = mysqli_fetch_assoc($students_result)) {
    $full_name = trim($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']);
    $students[] = [
        'student_no' => $row['student_no'],
        'full_name' => $full_name
    ];
}

foreach ($students as &$student) {
    // Get the grades for this student
    $student_no = mysqli_real_escape_string($connection, $student['student_no']);
    $grades_query = "
        SELECT grade_id, first_quarter, second_quarter, third_quarter, fourth_quarter, overall_grade, overall_remarks
        FROM student_grades 
        WHERE student_id = (SELECT student_id FROM students_enrolled WHERE student_no = '$student_no' LIMIT 1) 
        AND subject_id = '$subject_id'
    ";
    $grades_result = mysqli_query($connection, $grades_query);
    $grades = mysqli_fetch_assoc($grades_result);

    // Store grades in the student array, including grade_id
    $student['grades'] = $grades ? $grades : [
        'grade_id' => null,
        'first_quarter' => null,
        'second_quarter' => null,
        'third_quarter' => null,
        'fourth_quarter' => null,
        'overall_grade' => null,
        'overall_remarks' => null
    ];
}
    

?>


<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<!-- Include SweetAlert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<style type="text/css">
    .Iclass {
        font-family: 'Poppins';
        font-size: 1.3rem;
        cursor: pointer;
        font-weight: 500;
    }

    ul.pagination {
        display: inline-block;
        padding: 0;
        margin: 0;
    }

    ul.pagination li {
        cursor: pointer;
        display: inline;
        color: #3a4651 !important;
        font-weight: 600;
        padding: 4px 8px;
        border: 1px solid #CCC;
    }

    .pagination li:first-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination li:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    ul.pagination li:hover {
        background-color: #3a4651;
        color: white !important;
    }

    .pagination .active {
        background-color: #3a4651;
        color: white !important;
    }

    .table thead th,
    .table th {
        background-color: #C2ECFF !important;
        color: #2C4E80;
    }

    .table th,
    .table thead th {
        color: #2C4E80;
    }

    .swal2-icon {
        margin-bottom: 10px !important;
    }

    .modalpaddingnew {
        padding-left: 10px;
        margin-bottom: 10px;
    }

    .btn-custom {
        background-color: #5D9EFE;
        border-color: #5D9EFE;
        color: #fff;
    }
</style>

<div class="container-fluid"
    style="padding: 15px 15px; background-color: white; min-height: 540px; margin-top: 15px; border-radius: 5px; border: 1px solid;">
    <div class="d-flex justify-content-between align-items-center mb-4" style="position: relative;">
        <div>
            <h3 class="header" style="color: #2c2b2e; font-weight:600;">
                Subject Information
            </h3>
            <h5 style="margin-top: 10px;">Subject Name: <?php echo htmlspecialchars($subject['subject_name']); ?></h5>
            <h5 style="margin-top: 10px;">Schedule: <?php echo htmlspecialchars($daysString); ?> |
                <?php echo htmlspecialchars($startTime); ?> - <?php echo htmlspecialchars($endTime); ?></h5>
            <h5 style="margin-top: 10px;">Room: <?php echo htmlspecialchars($subject['subject_room']); ?></h5>
            <h5 style="margin-top: 10px;"><?php echo htmlspecialchars($subject['subject_desc']); ?></h5>
        </div>

        <div class="dropdown" style="position: absolute; top: 0; right: 0;">
            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" style="background: #5D9EFE; color: #FFF;">
                <img class="edit-icon1" src="assets/images/edit1.png"
                    style="width: 24px; height: 24px; cursor: pointer; color: #FFF"> Customize
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item edit-icon" href="#" id="edit-icon">Update</a>
                <a class="dropdown-item text-danger" href="#" id="delete-subject">Delete</a>
            </div>
        </div>
    </div>

    <!-- Button to Trigger add grades Modal -->
    <div class="text-right">
        <button type="button" class="btn" data-toggle="modal" data-target="#mdladdGrade"
            data-subject_id="<?php echo $subject_id; ?>" style="background: #5D9EFE; color: #FFF;">
            <img class="edit-icon1" src="assets/images/upload.png"
                style="width: 24px; height: 24px; cursor: pointer; color: #FFF"> Upload Grades
        </button>
        <button type="button" class="btn" style="background: #5D9EFE; color: #FFF;">
    <img class="download-icon" src="assets/images/download.png"
        style="width: 24px; height: 24px; cursor: pointer; color: #FFF"> Download Records
</button>

    </div>

    <div class="row" style="margin-top: 5px;">
        <div class="col-12">
            <div class="mb-3" style="border-radius: 10px;">
                <table data-height="350" class="table table-bordered fixTable table-hover" style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;"> No. </th>
                            <th style="width: 15%; text-align: center;"> Student ID </th>
                            <th style="width: 15%; text-align: center;"> Student Name </th>
                            <th style="width: 3%; text-align: center;"> 1st Quarter</th>
                            <th style="width: 3%; text-align: center;"> 2nd Quarter </th>
                            <th style="width: 3%; text-align: center;"> 3rd Quarter </th>
                            <th style="width: 3%; text-align: center;"> 4th Quarter </th>
                            <th style="width: 3%; text-align: center;"> Overall Grade</th>
                            <th style="width: 5%; text-align: center;"> Remarks </th>
                            <th style="width: 5%; text-align: center;"> Option </th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($students as $index => $student): ?>
        <tr>
            <td style="text-align: center;"><?php echo $index + 1; ?></td>
            <td style="text-align: center;"><?php echo htmlspecialchars($student['student_no']); ?></td>
            <td style="text-align: center;"><?php echo htmlspecialchars($student['full_name']); ?></td>
            <td style="text-align: center; color: <?php echo ($student['grades']['first_quarter'] >= 75) ? 'green' : 'red'; ?>;">
    <?php echo htmlspecialchars($student['grades']['first_quarter']); ?>
</td>
<td style="text-align: center; color: <?php echo ($student['grades']['second_quarter'] >= 75) ? 'green' : 'red'; ?>;">
    <?php echo htmlspecialchars($student['grades']['second_quarter']); ?>
</td>
<td style="text-align: center; color: <?php echo ($student['grades']['third_quarter'] >= 75) ? 'green' : 'red'; ?>;">
    <?php echo htmlspecialchars($student['grades']['third_quarter']); ?>
</td>
<td style="text-align: center; color: <?php echo ($student['grades']['fourth_quarter'] >= 75) ? 'green' : 'red'; ?>;">
    <?php echo htmlspecialchars($student['grades']['fourth_quarter']); ?>
</td>


            <!-- Check for completeness of grades -->
            <?php 
                $gradesComplete = isset($student['grades']['first_quarter'], 
                                         $student['grades']['second_quarter'], 
                                         $student['grades']['third_quarter'], 
                                         $student['grades']['fourth_quarter']);
            ?>

            <td style="text-align: center;">
                <?php if ($gradesComplete): ?>
                    <?php echo htmlspecialchars($student['grades']['overall_grade']); ?>
                <?php else: ?>
                    <span style="color: gray;">Not yet computed</span>
                <?php endif; ?>
            </td>
            <td style="text-align: center;">
                <?php if ($gradesComplete): ?>
                    <?php if ($student['grades']['overall_remarks'] === 'PASSED'): ?>
                        <span style="color: green; font-weight: bold;">PASSED</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;">FAILED</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="color: gray;">Not yet Computed</span>
                <?php endif; ?>
            </td>
            <td style="text-align: center;">
                <img src="assets/images/edit.png" alt="Update"
                    style="width: 24px; height: 24px; cursor: pointer; color: #FFF" 
                    onclick="openUpdateModal('<?php echo htmlspecialchars($student['student_no']); ?>', 
                                             '<?php echo htmlspecialchars($student['grades']['first_quarter']); ?>', 
                                             '<?php echo htmlspecialchars($student['grades']['second_quarter']); ?>', 
                                             '<?php echo htmlspecialchars($student['grades']['third_quarter']); ?>', 
                                             '<?php echo htmlspecialchars($student['grades']['fourth_quarter']); ?>', 
                                             '<?php echo htmlspecialchars($student['grades']['grade_id']); ?>')" />
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Update each student Grades Modal -->
<div class="modal fade" id="mdlupdateGrade" tabindex="-1" role="dialog" aria-labelledby="mdlupdateGradeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <h5 class="modal-title text-center w-100" id="mdlupdateGradeLabel">Update Grades</h5>
            </div>
            <div class="modal-body">
                <form id="updateStudentGrade" method="POST" action="classroom/updatestudent_grade.php">
                    <input type="hidden" name="student_no" id="student_no" value="">
                    <input type="hidden" name="grade_id" id="grade_id" value=""> <!-- Hidden input for grade_id -->
                    <div class="form-group">
                        <label for="first_quarter">1st Quarter</label>
                        <input type="number" class="form-control" name="first_quarter" id="first_quarter" value="">
                    </div>
                    <div class="form-group">
                        <label for="second_quarter">2nd Quarter</label>
                        <input type="number" class="form-control" name="second_quarter" id="second_quarter" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="third_quarter">3rd Quarter</label>
                        <input type="number" class="form-control" name="third_quarter" id="third_quarter" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="fourth_quarter">4th Quarter</label>
                        <input type="number" class="form-control" name="fourth_quarter" id="fourth_quarter" value="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Update Grades</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal updating subject -->
<div class="modal fade" id="mdlUpdateSubject" tabindex="-1" role="dialog" aria-labelledby="mdlUpdateSubjectLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="mdlUpdateSubjectLabel">Update Subject</h5>
            </div>
            <div class="modal-body">
                <form id="updateSubjectForm" enctype="multipart/form-data">
                    <input type="hidden" name="update_subject_id" id="subject_id">
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject_name" id="update_subject_name"
                            placeholder="Subject Name" required>
                    </div>
                    <div class="form-group">
                        <!-- <input type="text" class="form-control" name="subject_teacher" id="update_subject_teacher" placeholder="Subject Teacher" required> -->
                    </div>
                    <div class="form-group">
                        <label for="subject_start_time">Start Time</label>
                        <input type="time" class="form-control" name="subject_start_time" id="update_subject_start_time"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="subject_end_time">End Time</label>
                        <input type="time" class="form-control" name="subject_end_time" id="update_subject_end_time"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="subject_days">Days</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Monday"> Monday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Tuesday">
                            Tuesday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Wednesday">
                            Wednesday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Thursday">
                            Thursday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Friday"> Friday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Saturday">
                            Saturday
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="subject_days[]" value="Sunday"> Sunday
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject_room" id="update_subject_room"
                            placeholder="Subject Room">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="subject_desc" id="update_subject_desc"
                            placeholder="Subject Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Current Subject Image:</label><br>
                        <?php
                        $image_path = "uploads/subjects/" . htmlspecialchars($subject['subject_image']);
                        if (!empty($subject['subject_image']) && file_exists($image_path)): ?>
                            <img src="<?php echo $image_path; ?>" id="current_subject_image" alt="Subject Image"
                                style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            <img src="uploads/subjects/default.png" alt="No Image Available"
                                style="max-width: 100px; height: auto;">
                        <?php endif; ?>
                    </div>

                    <!-- Input field for image upload -->
                    <div class="form-group">
                        <label for="subject_image">Upload New Subject Image</label>
                        <input type="file" class="form-control" name="subject_image" id="subject_image">
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
<!-- Add Grades Modal -->
<div class="modal fade" id="mdladdGrade" tabindex="-1" role="dialog" aria-labelledby="mdladdGradeLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="mdladdGradeLabel">Upload Grades</h5>
            </div>
            <div class="modal-body">
                <form id="uploadGradesForm" enctype="multipart/form-data" method="POST" action="upload_grades.php">
                    <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                    <div class="form-group">
                        <label for="quarter">Select Quarter</label>
                        <select class="form-control" name="quarter" id="quarter" required>
                            <option value="">Select Quarter</option>
                            <option value="first_quarter">1st Quarter</option>
                            <option value="second_quarter">2nd Quarter</option>
                            <option value="third_quarter">3rd Quarter</option>
                            <option value="fourth_quarter">4th Quarter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="grade_file">Upload Grade File (Excel)</label>
                        <input type="file" class="form-control" name="grade_file" id="grade_file" accept=".xls,.xlsx"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Upload Grades</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    function openUpdateModal(studentNo, firstQuarter, secondQuarter, thirdQuarter, fourthQuarter, gradeId) {
        // Set the values in the modal
        document.getElementById('student_no').value = studentNo;
        document.getElementById('first_quarter').value = firstQuarter;
        document.getElementById('second_quarter').value = secondQuarter;
        document.getElementById('third_quarter').value = thirdQuarter;
        document.getElementById('fourth_quarter').value = fourthQuarter;
        document.getElementById('grade_id').value = gradeId;  // Set grade_id here

        // Show the modal
        $('#mdlupdateGrade').modal('show');
    }
    // Handle form submission
document.getElementById('updateStudentGrade').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Optionally, reload the page or update the table
                location.reload();
            });
        } else {
            // Show error message
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});
    $(document).ready(function () {
        $('#uploadGradesForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var fileInput = $('#uploadGradesForm input[type="file"]')[0];

            if (fileInput.files.length === 0) {
                Swal.fire('Error!', 'Please select a file to upload.', 'error');
                return;
            }

            $.ajax({
                url: 'classroom/upload_grades.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Assuming response is a JSON object
                    if (response.success) {
                        Swal.fire('Success!', response.message, 'success');
                        $('#mdladdGrade').modal('hide');
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire('Error!', 'Failed to upload grades. ' + errorThrown, 'error');
                }
            });
        });


        // Set up modal to populate subject_id when shown
        $('#mdladdGrade').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var subjectId = button.data('subject_id'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('input[name="subject_id"]').val(subjectId); // Set the subject_id value
        });
    });

    $(document).ready(function () {
        // When the edit icon is clicked, show the modal
        $('.edit-icon').on('click', function () {
            $('#mdlUpdateSubject').modal('show');

            // Populate the modal form with the subject data
            $('#subject_id').val('<?php echo $subject_id; ?>');
            $('#update_subject_name').val('<?php echo htmlspecialchars($subject["subject_name"]); ?>');
            $('#update_subject_start_time').val('<?php echo htmlspecialchars($subject["subject_start_time"]); ?>');
            $('#update_subject_end_time').val('<?php echo htmlspecialchars($subject["subject_end_time"]); ?>');
            $('#update_subject_room').val('<?php echo htmlspecialchars($subject["subject_room"]); ?>');
            $('#update_subject_desc').val('<?php echo htmlspecialchars($subject["subject_desc"]); ?>');

            // Populate the checkboxes for the subject days
            let days = '<?php echo htmlspecialchars($subject["subject_days"]); ?>'.split(',');
            $('.form-check-input').each(function () {
                let dayValue = $(this).val();
                if (days.includes(dayValue)) {
                    $(this).prop('checked', true);
                }
            });
        });

        // Handle form submission
        $('#updateSubjectForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: 'classroom/update_subject.php', // The server-side script to handle the update
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Show a success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucess',
                        text: 'Subject updated successfully.',
                        showConfirmButton: true,
                        timer: 1500
                    });

                    // Optionally, reload the page or update the displayed data without reloading
                    setTimeout(function () {
                        location.reload(); // Reload the page to show the updated details
                    }, 1500);
                },
                error: function (xhr, status, error) {
                    // Show an error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'Please try again later.'
                    });
                }
            });
        });


        // Handle subject deletion when 'Delete' is clicked
        $('#delete-subject').on('click', function () {
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
                    // Make an AJAX call to delete the subject
                    $.ajax({
                        url: 'classroom/delete_subject.php', // The server-side script to handle deletion
                        type: 'POST',
                        data: { subject_id: '<?php echo $subject_id; ?>' },
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'The subject has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.href = 'index.php?url=eachclass&classroom_id=<?php echo $classroom_id; ?>'; // Redirect after deletion
                            });
                        }
                    });
                }
            });
        });
    });
 
    const subjectName = "<?php echo htmlspecialchars($subject['subject_name']); ?>";

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.download-icon').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title and subject name to the PDF
            doc.setFontSize(14);
            doc.text('Student Grade Records', 14, 10);
            doc.setFontSize(10);
            doc.text(`Subject: ${subjectName}`, 14, 16);

            // Extract table data but exclude the last column (Option)
            const table = document.querySelector('table');
            const rows = table.querySelectorAll('tr');
            
            // Remove last column (Option) from each row
            rows.forEach(row => {
                const cells = row.querySelectorAll('th, td');
                cells[cells.length - 1].remove(); // Remove the last column
            });

            // Generate PDF with updated table data (without the last column)
            doc.autoTable({
                html: table,
                startY: 25, // Positioning the table
                theme: 'grid', // Options: 'striped', 'grid', 'plain'
                styles: {
                    fontSize: 8,
                    halign: 'center',
                },
                headStyles: {
                    fillColor: [93, 158, 254], // Matches your button color
                },
            });

            // Save the PDF
            doc.save(`${subjectName}_Grade_Records.pdf`);
        });
    });



</script>