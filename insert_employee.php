<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $national_id = $_POST['national_id'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $employee_no = $_POST['employee_no'];
    $wage_rate = $_POST['wage_rate'];
    $gender = $_POST['gender'];
    $kin = $_POST['kin'];
    $kin_contact = $_POST['kin_contact'];

    $sql = "INSERT INTO employees (
        first_name, last_name, national_id, dob, address, mobile, email,
        position, department, employee_no, wage_rate, gender, kin, kin_contact
    ) VALUES (
        '$first_name', '$last_name', '$national_id', '$dob', '$address', '$mobile', '$email',
        '$position', '$department', '$employee_no', '$wage_rate', '$gender', '$kin', '$kin_contact'
    )";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_staff.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
