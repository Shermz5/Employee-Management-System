<?php
include 'db_connect.php';

if (isset($_POST['employee_no'])) {
    $employee_no = $_POST['employee_no'];

    // Move employee from former_employees back to employees (unsuspend)
    $copy_sql = "INSERT INTO employees (employee_no, first_name, last_name, position, department, email, mobile, status, date_joined)
                 SELECT employee_no, first_name, last_name, position, department, email, mobile, 'Active', date_joined
                 FROM former_employees WHERE employee_no = ?";
    $copy_stmt = $conn->prepare($copy_sql);
    $copy_stmt->bind_param("s", $employee_no);
    if ($copy_stmt->execute()) {
        // Delete from former_employees table
        $delete_sql = "DELETE FROM former_employees WHERE employee_no = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $employee_no);
        $delete_stmt->execute();
        $delete_stmt->close();
        header("Location: manage_staff.php?message=Unsuspended");
        exit();
    } else {
        echo "Error unsuspending employee: " . $copy_stmt->error;
    }
    $copy_stmt->close();
    $conn->close();
} else {
    echo "Invalid request: employee_no is missing.";
}
?>
