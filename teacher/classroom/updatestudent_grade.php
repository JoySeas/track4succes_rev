<?php
include("../connect.php");

// Check if the required POST data is available
if (
    isset($_POST['student_no']) &&
    isset($_POST['first_quarter']) &&
    isset($_POST['second_quarter']) &&
    isset($_POST['third_quarter']) &&
    isset($_POST['fourth_quarter']) &&
    isset($_POST['grade_id'])
) {
    // Sanitize the inputs
    $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
    $first_quarter = mysqli_real_escape_string($connection, $_POST['first_quarter']);
    $second_quarter = mysqli_real_escape_string($connection, $_POST['second_quarter']);
    $third_quarter = mysqli_real_escape_string($connection, $_POST['third_quarter']);
    $fourth_quarter = mysqli_real_escape_string($connection, $_POST['fourth_quarter']);
    $grade_id = mysqli_real_escape_string($connection, $_POST['grade_id']);

    // Check if a record exists for the given student_no and grade_id
    $check_query = "
        SELECT * 
        FROM student_grades 
        WHERE grade_id = '$grade_id' AND student_id = (SELECT student_id FROM students_enrolled WHERE student_no = '$student_no')
    ";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Define a function to determine the remarks based on the grade
        function getRemark($grade) {
            return ($grade >= 75) ? 'PASSED' : 'FAILED';
        }

        // Compute remarks for each quarter
        $first_quarter_remarks = getRemark($first_quarter);
        $second_quarter_remarks = getRemark($second_quarter);
        $third_quarter_remarks = getRemark($third_quarter);
        $fourth_quarter_remarks = getRemark($fourth_quarter);

        // Update the grades
        $update_query = "
            UPDATE student_grades 
            SET first_quarter = '$first_quarter', 
                first_quarter_remarks = '$first_quarter_remarks', 
                second_quarter = '$second_quarter', 
                second_quarter_remarks = '$second_quarter_remarks', 
                third_quarter = '$third_quarter', 
                third_quarter_remarks = '$third_quarter_remarks', 
                fourth_quarter = '$fourth_quarter', 
                fourth_quarter_remarks = '$fourth_quarter_remarks', 
                overall_grade = (COALESCE('$first_quarter', 0) + COALESCE('$second_quarter', 0) + COALESCE('$third_quarter', 0) + COALESCE('$fourth_quarter', 0)) / 4,
                overall_remarks = CASE
                    WHEN (COALESCE('$first_quarter', 0) + COALESCE('$second_quarter', 0) + COALESCE('$third_quarter', 0) + COALESCE('$fourth_quarter', 0)) / 4 >= 75 THEN 'PASSED'
                    ELSE 'FAILED'
                END
            WHERE grade_id = '$grade_id'
        ";

        if (mysqli_query($connection, $update_query)) {
            echo json_encode(["success" => true, "message" => "Grades updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating grades: " . mysqli_error($connection)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No grade record found for student_no $student_no."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Required data missing in the request."]);
}
?>
