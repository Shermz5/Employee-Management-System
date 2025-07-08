<?php
include 'db_connect.php';

$allowed_per_year = 30;

$sql = "
    SELECT 
        e.first_name,
        e.last_name,
        e.employee_no,
        SUM(CASE WHEN l.leave_type = 'vacation' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS vacation_days,
        SUM(CASE WHEN l.leave_type = 'annual' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS annual_days,
        SUM(CASE WHEN l.leave_type = 'maternity' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS maternity_days,
        SUM(CASE WHEN l.leave_type = 'paternity' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS paternity_days,
        SUM(CASE WHEN l.leave_type = 'bereavement' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS bereavement_days,
        SUM(CASE WHEN l.leave_type = 'sick' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS sick_days,
        SUM(CASE WHEN l.leave_type = 'unpaid' THEN DATEDIFF(l.date_to, l.date_from) + 1 ELSE 0 END) AS unpaid_days
    FROM employees e
    LEFT JOIN leave_apps l ON e.employee_no = l.employee_no AND l.status = 'approved'
    GROUP BY e.employee_no
    ORDER BY e.last_name
";

$result = $conn->query($sql);
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
    <h1>Employee Leave Records</h1>
    <table>
            <tr>
                <th>Employee Name</th>
                <th>Employee No.</th>
                <th>Vacation</th>
                <th>Annual</th>
                <th>Maternity</th>
                <th>Paternity</th>
                <th>Bereavement</th>
                <th>Sick</th>
                <th>Unpaid</th>
                <th>Leave days per year</th>
                <th>Leave days taken</th>
                <th>Remaining Leave Days</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $total_taken = $row['vacation_days'] + $row['annual_days'] + $row['maternity_days'] +
                                $row['paternity_days'] + $row['bereavement_days'] + $row['sick_days'];
                    $balance = $allowed_per_year - $total_taken;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['employee_no']) ?></td>
                    <td><?= $row['vacation_days'] ?></td>
                    <td><?= $row['annual_days'] ?></td>
                    <td><?= $row['maternity_days'] ?></td>
                    <td><?= $row['paternity_days'] ?></td>
                    <td><?= $row['bereavement_days'] ?></td>
                    <td><?= $row['sick_days'] ?></td>
                    <td><?= $row['unpaid_days'] ?></td>
                    <td><?= $allowed_per_year ?></td>
                    <td><?= $total_taken ?></td>
                    <td><?= $balance ?></td>
                </tr>
            <?php endwhile; ?>
    </table>
</body>
</html>