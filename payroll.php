<?php

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="leave_records.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>
     <button><a href="reports.html">Reports</a></button>
    <h1>Payroll</h1>
    <table>
        <tr>
            <th>Employee Name</th>
            <th>Employee No.</th>
            <th>Department</th>
            <th>Wage Rate</th>
            <th>Hours Worked</th>
            <th>Salary</th>
        </tr>
        <?php
        $sql = "SELECT e.first_name, e.last_name, e.employee_no, e.department, e.wage_rate, 
                       IFNULL(SUM(TIMESTAMPDIFF(HOUR, t.time_in, t.time_out)), 0) AS hours_worked
                FROM employees e
                LEFT JOIN timesheets t ON e.employee_no = t.employee_no
                GROUP BY e.employee_no";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $wage_rate = $row['wage_rate'];
            $hours_worked = $row['hours_worked'];
            $salary = $wage_rate * $hours_worked;
            echo "<tr>
                <td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>
                <td>" . htmlspecialchars($row['employee_no']) . "</td>
                <td>" . htmlspecialchars($row['department']) . "</td>
                <td>" . htmlspecialchars($wage_rate) . "</td>
                <td>" . htmlspecialchars($hours_worked) . "</td>
                <td>" . htmlspecialchars($salary) . "</td>
            </tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>