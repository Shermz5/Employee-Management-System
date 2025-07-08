<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_no = $_POST['employee_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $national_id = $_POST['national_id'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $wage_rate = $_POST['wage_rate'];
    $gender = $_POST['gender'];
    $kin = $_POST['kin'];
    $kin_contact = $_POST['kin_contact'];

    $sql = "UPDATE employees SET first_name=?, last_name=?, national_id=?, dob=?, address=?, mobile=?, email=?, position=?, department=?, wage_rate=?, gender=?, kin=?, kin_contact=? WHERE employee_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssssss', $first_name, $last_name, $national_id, $dob, $address, $mobile, $email, $position, $department, $wage_rate, $gender, $kin, $kin_contact, $employee_no);

    if ($stmt->execute()) {
        header('Location: manage_staff.php?message=Employee+updated');
        exit();
    } else {
        echo 'Error updating employee: ' . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request.';
}
?>
