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
            <!-- <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" style="background: #5D9EFE; color: #FFF;">
                <img class="edit-icon1" src="assets/images/edit1.png"
                    style="width: 24px; height: 24px; cursor: pointer; color: #FFF"> Customize
            </button> -->
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item edit-icon" href="#" id="edit-icon">Update</a>
                <a class="dropdown-item text-danger" href="#" id="delete-subject">Delete</a>
            </div>
        </div>
    </div>

    <!-- Button to Trigger add grades Modal -->
    <div class="text-right">
        <!-- <button type="button" class="btn" data-toggle="modal" data-target="#mdladdGrade"
            data-subject_id="<?php echo $subject_id; ?>" style="background: #5D9EFE; color: #FFF;">
            <img class="edit-icon1" src="assets/images/upload.png"
                style="width: 24px; height: 24px; cursor: pointer; color: #FFF"> Upload Grades
        </button> -->
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
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['first_quarter']); ?></td>
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['second_quarter']); ?></td>
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['third_quarter']); ?></td>
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['fourth_quarter']); ?></td>
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['overall_grade']); ?></td>
                                <td style="text-align: center;">
                                    <?php echo htmlspecialchars($student['grades']['overall_remarks']); ?></td>
                                <td style="text-align: center;">
                                    <img src="assets/images/edit.png" alt="Update"
                                        style="width: 24px; height: 24px; cursor: pointer; color: #FFF" onclick="openUpdateModal('<?php echo htmlspecialchars($student['student_no']); ?>', 
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
                url: 'classarchive/upload_grades.php',
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
                url: 'classarchive/update_subject.php', // The server-side script to handle the update
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
                        url: 'classarchive/delete_subject.php', // The server-side script to handle deletion
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
</script>