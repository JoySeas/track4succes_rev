<?php
// Database connection
include("../connect.php");

// Fetch classrooms from the database
$query = "SELECT c.class_name, c.section, c.description, c.class_image, t.firstname, t.lastname 
          FROM classrooms c 
          INNER JOIN teachers t ON c.teacher_id = t.teachers_id 
          ORDER BY c.created_at DESC";
$result = mysqli_query($connection, $query);

// Define the image directory path
$imagePath = "../uploads/class_images/";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $className = $row['class_name'];
        $section = $row['section'];
        $description = $row['description'];
        $classImage = $row['class_image'];  // This contains the filename, not the full path
        $teacherName = $row['firstname'] . ' ' . $row['lastname'];

        // If no image is provided, use a default image
        $classImageFullPath = (!empty($classImage)) ? $imagePath . $classImage : 'uploads/classes/default-class.png';
        
?>
        <!-- Classroom Card Template -->
             
        <div class="row">
        <div class="col-md-12">
        <div class="row" style="">
        <div class="col-xs-12 col-md-4">
            <a href="index.php?url=eachclass" style="text-decoration: none;">
                <div class="card" style="margin-bottom: 15px; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                    <img src="<?php echo $classImageFullPath; ?>" alt="Class Image" style="width: 100%; height: auto;">
                    <div class="box bg-info" style="background: #FFFFFF; box-shadow: 2px 3px 5px rgb(126, 142, 159);">
                        <div class="title">
                            <h5 style="font-weight: 600; font-size: 1.1rem;"><?php echo $className . ' - ' . $section; ?></h5>
                        </div>
                        <div class="content">
                            <h5 style="margin-top: 5px; font-weight: 500;">Teacher: <?php echo $teacherName; ?></h5>
                            <h6>
                                <?php echo (strlen($description) > 100) ? substr($description, 0, 100) . '...' : $description; ?>
                                <a href="#">See More</a>
                            </h6>
                        </div>
                        <div class="dboxicon">
                            <!-- You can add icons here if necessary -->
                        </div>
                    </div>
                </div>
            </a>
        </div>
        </div>
        </div>
        </div>
<?php
    }
} else {
    echo '<p>No classrooms available.</p>';
}

// Close the database connection
mysqli_close($connection);
?>
