<?php

include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $employee_no = $_POST['employee_no'];
    $calendar = $_POST['calendar'] ?? '';
    $time_in = $_POST['time_in'] ?? '';
    $time_out = $_POST['time_out'] ?? '';
    $main_activity = $_POST['main_activity'] ?? '';

    if (empty($first_name) ||empty($last_name) ||empty($employee_no) ||empty($calendar) || empty($time_in) || empty($time_out) || empty($main_activity)) {
        die("Please fill in all fields");
    }

    $stmt = $conn->prepare("INSERT INTO timesheets (first_name, last_name, employee_no, calendar, time_in, time_out, main_activity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssssss", $first_name, $last_name, $employee_no, $calendar, $time_in, $time_out, $main_activity);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: employee_home.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}

?>