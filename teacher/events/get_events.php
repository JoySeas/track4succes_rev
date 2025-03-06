<?php
// get_events.php
session_start();
require '../connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch events from the database
$sql = "SELECT title, start_date AS start, content FROM events";
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $events = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }

    echo json_encode($events);

    mysqli_stmt_close($stmt);
} else {
    echo json_encode([]);
}

mysqli_close($connection);
?>
