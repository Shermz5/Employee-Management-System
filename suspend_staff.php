<?php
include 'db_connect.php';

if (isset($_POST['employee_no'])) {
    $employee_no = $_POST['employee_no'];
    $suspend_date = date('Y-m-d');

    $sql = "INSERT INTO former_employees (first_name, last_name, employee_no, position, department, email, mobile, status, date_suspended, date_joined)
                 SELECT first_name, last_name, employee_no, position, department, email, mobile, 'Suspended', ?, date_joined
                 FROM employees WHERE employee_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $suspend_date, $employee_no);
    if ($stmt->execute()) {
        $delete_sql = "DELETE FROM employees WHERE employee_no = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $employee_no);
        $delete_stmt->execute();
        $delete_stmt->close();
        header("Location: former_employees.php");
        exit();
    } else {
        echo "Error suspending employee: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request: employee_no is missing.";
}
?>
