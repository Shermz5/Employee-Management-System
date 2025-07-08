<?php
include 'db_connect.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    if (in_array($status, ['approved', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE leave_apps SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

header("Location: leave_applications.php");
exit();
