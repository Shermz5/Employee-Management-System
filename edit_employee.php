<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$employee_id = $_GET['id'];

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $stmt = $conn->prepare("UPDATE employees SET first_name=?, last_name=?, national_id=?, dob=?, address=?, mobile=?, email=?, position=?, department=?, wage_rate=?, gender=?, kin=?, kin_contact=? WHERE id=?");
    $stmt->bind_param("sssssssssssssi", $first_name, $last_name, $national_id, $dob, $address, $mobile, $email, $position, $department, $wage_rate, $gender, $kin, $kin_contact, $employee_id);

    if ($stmt->execute()) {
        header("Location: manage_staff.php?message=Employee+updated");
        exit();
    } else {
        echo "Error updating employee: " . $stmt->error;
    }
}

// Fetch current employee data
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
if (!$employee) {
    echo "Employee not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Employee</title>
  <link rel="stylesheet" href="add_employee.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <a href="home.php" class="home-button">Home</a>
    <h1>Edit Employee Information</h1>
    <form method="POST">
        <label>First Name:<input type="text" name="first_name" value="<?= htmlspecialchars($employee['first_name']) ?>" required></label>
        <label>Last Name:<input type="text" name="last_name" value="<?= htmlspecialchars($employee['last_name']) ?>" required></label>
        <label>National ID:<input type="text" name="national_id" value="<?= htmlspecialchars($employee['national_id']) ?>" required></label>
        <label>Date of Birth:<input type="date" name="dob" value="<?= htmlspecialchars($employee['dob']) ?>" required></label>
        <label>Address:<input type="text" name="address" value="<?= htmlspecialchars($employee['address']) ?>" required></label>
        <label>Mobile Number:<input type="text" name="mobile" value="<?= htmlspecialchars($employee['mobile']) ?>" required></label>
        <label>Email Address:<input type="email" name="email" value="<?= htmlspecialchars($employee['email']) ?>" required></label>
        <label>Position:<input type="text" name="position" value="<?= htmlspecialchars($employee['position']) ?>" required></label>
        <label>Department:<input type="text" name="department" value="<?= htmlspecialchars($employee['department']) ?>" required></label>
        <label>Wage Rate:<input type="text" name="wage_rate" value="<?= htmlspecialchars($employee['wage_rate']) ?>" required></label>
        <label>Gender:
        <select name="gender" required>
            <option value="" disabled>Select your gender</option>
            <option value="male" <?= $employee['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $employee['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
        </select>
        </label>
        <label>Next of Kin:<input type="text" name="kin" value="<?= htmlspecialchars($employee['kin']) ?>" required></label>
        <label>Next of Kin's Contact:<input type="text" name="kin_contact" value="<?= htmlspecialchars($employee['kin_contact']) ?>" required></label>
        <button type="submit">Update Employee</button>
    </form>
</body>
</html>
