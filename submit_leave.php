<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $employee_no = $_POST['employee_no'];
    $date_from = $_POST['from'];
    $date_to = $_POST['to'];
    $leave_type = $_POST['leave_type'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO leave_apps
        (first_name, last_name, employee_no, date_from, date_to, leave_type, reason)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssss", $first_name, $last_name, $employee_no, $date_from, $date_to, $leave_type, $reason);

    if ($stmt->execute()) {
        header("Location: view_leaves.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
