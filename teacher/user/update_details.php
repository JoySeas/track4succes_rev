<?php
include("../connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$teachers_id = $_SESSION['user_id'];

// Retrieve the posted data and sanitize
$address = isset($_POST['address']) && $_POST['address'] !== '' ? mysqli_real_escape_string($connection, $_POST['address']) : null;
$date_of_birth = isset($_POST['date_of_birth']) && $_POST['date_of_birth'] !== '' ? mysqli_real_escape_string($connection, $_POST['date_of_birth']) : null;
$place_of_birth = isset($_POST['place_of_birth']) && $_POST['place_of_birth'] !== '' ? mysqli_real_escape_string($connection, $_POST['place_of_birth']) : null;
$nationality = isset($_POST['nationality']) && $_POST['nationality'] !== '' ? mysqli_real_escape_string($connection, $_POST['nationality']) : null;
$sex = isset($_POST['sex']) && $_POST['sex'] !== '' ? mysqli_real_escape_string($connection, $_POST['sex']) : null;
$mobile_number = isset($_POST['mobile_number']) && $_POST['mobile_number'] !== '' ? mysqli_real_escape_string($connection, $_POST['mobile_number']) : null;
$personal_email = isset($_POST['personal_email']) && $_POST['personal_email'] !== '' ? mysqli_real_escape_string($connection, $_POST['personal_email']) : null;

// Initialize an array to store the fields to be updated
$update_fields = [];

// Add only the fields that have non-null and non-empty values
if ($address !== null) $update_fields[] = "address = '$address'";
if ($date_of_birth !== null) $update_fields[] = "date_of_birth = '$date_of_birth'";
if ($place_of_birth !== null) $update_fields[] = "place_of_birth = '$place_of_birth'";
if ($nationality !== null) $update_fields[] = "nationality = '$nationality'";
if ($sex !== null) $update_fields[] = "sex = '$sex'";
if ($mobile_number !== null) $update_fields[] = "mobile_number = '$mobile_number'";
if ($personal_email !== null) $update_fields[] = "personal_email = '$personal_email'";

// Check if there are fields to update
if (count($update_fields) > 0) {
    // Join the fields with commas to form the SET part of the SQL query
    $update_fields_str = implode(", ", $update_fields);

    // Check if the user already has an entry in the teacher_details table
    $sql_check = "SELECT * FROM teacher_details WHERE teacherdet_id = '$teachers_id'";
    $result = mysqli_query($connection, $sql_check);

    if (mysqli_num_rows($result) > 0) {
        // If a record exists, update it
        $sql = "UPDATE teacher_details SET $update_fields_str WHERE teacherdet_id = '$teachers_id'";
    } else {
        // If no record exists, insert a new one
        $sql = "INSERT INTO teacher_details (teacherdet_id, address, date_of_birth, place_of_birth, nationality, sex, mobile_number, personal_email)
                VALUES ('$teachers_id', 
                    " . ($address !== null ? "'$address'" : "NULL") . ",
                    " . ($date_of_birth !== null ? "'$date_of_birth'" : "NULL") . ",
                    " . ($place_of_birth !== null ? "'$place_of_birth'" : "NULL") . ",
                    " . ($nationality !== null ? "'$nationality'" : "NULL") . ",
                    " . ($sex !== null ? "'$sex'" : "NULL") . ",
                    " . ($mobile_number !== null ? "'$mobile_number'" : "NULL") . ",
                    " . ($personal_email !== null ? "'$personal_email'" : "NULL") . ")";
    }

    // Execute the query
    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Details saved successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save details: ' . mysqli_error($connection)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data to update.']);
}

// Close the connection
mysqli_close($connection);
?>
