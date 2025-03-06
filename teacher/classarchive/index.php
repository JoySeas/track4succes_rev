<?php
// Fetch classrooms for the logged-in teacher
include("../connect.php");  // Make sure to include your database connection
session_start();

$teacher_id = $_SESSION['user_id']; // Assuming teacher_id is stored in session

// Query to check if the teacher has any classrooms
$query = "SELECT * FROM teachers_classroom WHERE teacher_id = '$teacher_id'  AND status = 'ARCHIVE'";
$result = mysqli_query($connection, $query);
$classroom_count = mysqli_num_rows($result);

?>

<link href="https://fonts.googleapis.com/css?family=Poppins|Montserrat" rel="stylesheet">
<style type="text/css">
    .Iclass {
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
        background-color: #9e9e9e !important;
    }

    .swal2-icon {
        margin-bottom: 10px !important;
    }

    .modalpaddingnew {
        padding-left: 5px;
        margin-bottom: 10px;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .modal-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
    }

    .modal-header h2 {
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        font-size: 1.75rem;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn-primary1 {
        background-color: #2C4E80;
    }

    .btn-primary1:hover {
        background-color: #2C4E80;
    }

    .btn-secondary {
        background-color: #6c757d;
    }

    /* .btn-primary:hover, .btn-secondary:hover {
        opacity: 0.8;
    } */
    .btn-custom {
        background-color: #5D9EFE;
        border-color: #5D9EFE;
        color: #fff;
    }
</style>

<!-- Shows this only when the logged-in teacher has NO classroom -->
<?php if ($classroom_count == 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-bottom: 0px;">
                <div class="card-body"
                    style="padding: .5rem; border-radius: 5px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                    <div class="row page-titles rowpageheaderpadd">
                        <div class="col-md-6 col-6 align-self-center" style="padding-left:10px;">
                            <h3 style="font-weight: 400; font-family: 'Poppins'; font-size: 1.75rem;">Classroom</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center" style="margin-top: 80px;">
                            <img src="assets/images/no-classroom.png" alt="">
                        </div>
                        <div class="col-12 text-center" style="font-weight: 900;">
                            <p>NO CLASSES ARCHIVED</p>
                        </div>
                        <!-- <div class="col-12 text-center" style="margin-bottom: 100px;">
                            <button class="btn btn-primary1" style="margin-top: 10px;" onclick="openClassroomModal()">Create
                                Class</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- Shows this only when the logged-in teacher has classrooms -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-bottom: 0px;">
                <div class="card-body"
                    style="padding-top: .5rem; padding-bottom: .5rem; border-radius: 5px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                    <div class="row page-titles rowpageheaderpadd"
                        style="padding-bottom: 0px; display: flex; justify-content: space-between; align-items: center;">
                        <div class="col-md-6 col-6" style="padding-left: 1rem;">
                            <h3
                                style="font-family: 'Poppins'; font-weight: 500; font-size: 2rem; margin-bottom: 2rem; margin-top: 1rem;">
                                Classroom</h3>
                        </div>
                        <!-- <div class="col-md-6 col-6 text-right" style="padding-right: 1rem;">
                            <button class="btn btn-primary1" style="margin-top: 10px;" onclick="openClassroomModal()">Create
                                Class</button>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <div class="col-xs-12 col-md-4">
                                        <!-- <a href="index.php?url=eachclassarchive" style="text-decoration: none;"> -->
                                        <a href="./index.php?url=eachclassarchive&classroom_id=<?php echo $row['classroom_id']; ?>"
                                            style="text-decoration: none;">
                                            <div class="card"
                                                style="margin-bottom: 15px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                                                <?php
                                                $classImagePath = 'uploads/class_images/' . $row['class_image'];
                                                ?>
                                                <img src="<?php echo $classImagePath; ?>" alt="Class Image"
                                                    style="width: 100%; height: auto;">
                                                <div class="box bg-info"
                                                    style="background: #FFFFFF; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                                                    <div class="title">
                                                        <h5 style="font-weight: 600; font-size: 1.1rem;">
                                                            <?php echo $row['class_name']; ?> - <?php echo $row['section']; ?>
                                                        </h5>
                                                    </div>
                                                    <div class="content">
                                                        <h5> <?php echo $row['description']; ?></h5>
                                                        <h6>
                                                            <a
                                                                href="./index.php?url=eachclassarchive&classroom_id=<?php echo $row['classroom_id']; ?>">See
                                                                More</a>
                                                        </h6>
                                                    </div>
                                                    <div class="dboxicon">
                                                        <!-- <i class="fas fa-users"></i> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openClassroomModal() {
        document.getElementById('classroomModal').style.display = 'block';
    }

    function closeClassroomModal() {
        document.getElementById('classroomModal').style.display = 'none';
    }

    $(document).ready(function () {
        // Initialize the year dropdowns
        const startYearDropdown = $('#startYear');
        const endYearDropdown = $('#endYear');

        // Populate the start year dropdown
        for (let year = 2000; year <= 2100; year++) {
            startYearDropdown.append(`<option value="${year}">${year}</option>`);
        }

        // Event listener for startYear to adjust endYear options
        startYearDropdown.on('change', function() {
            const selectedStartYear = parseInt(this.value);
            
            // Reset and populate end year dropdown
            endYearDropdown.empty().append('<option value="" disabled selected>Select End Year</option>');
            for (let year = selectedStartYear; year <= 2100; year++) {
                endYearDropdown.append(`<option value="${year}">${year}</option>`);
            }
        });

        // Form submission with Ajax
        $('#classroomForm').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: 'classarchive/class.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            closeClassroomModal();
                            location.reload();  // Optional: Reload the page after successful creation
                        }
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while creating the class: ' + error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
