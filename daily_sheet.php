<?php
include 'db_connect.php';


$selected_month = $_GET['month'] ?? date('F');
$month_number = date('m', strtotime($selected_month));

// Fetch employee timesheet data for the selected month

$sql = "
    SELECT 
        e.first_name, 
        e.last_name, 
        e.employee_no,
        e.department,
        t.calendar, 
        t.time_in, 
        t.time_out, 
        t.main_activity,
        TIMESTAMPDIFF(HOUR, t.time_in, t.time_out) AS hours_worked
    FROM timesheets t
    JOIN employees e ON t.employee_no = e.employee_no
    WHERE MONTH(t.calendar) = ?
    ORDER BY t.calendar DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $month_number);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="daily_sheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>
    <button><a href="reports.html">Reports</a></button>
    <h1>Employee Monthly Performance Records</h1>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by name or ID..." />
    </div>
    <form method="GET" action="">
        <label for="month">Month:</label>
    <select name="month" id="month" onchange="this.form.submit()">
         <?php
            $months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            foreach ($months as $month) {
                $selected = ($month == $selected_month) ? 'selected' : '';
                echo "<option value=\"$month\" $selected>$month</option>";
            }
            ?>
    </select>
    </form>
    
    
    <table id="timesheets">
        <thead>
            <tr>
            <th>Employee Name</th>
            <th>Employee No.</th>
            <th>Department</th>
            <th>Date</th>
            <th>Log in Time</th>
            <th>Log out Time</th>
            <th>Hours Worked</th>
            <th>Main Activity</th>
        </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $total_hours = 0;

                while ($row = $result->fetch_assoc()) {
                    $hours = (float)$row['hours_worked'];
                    $total_hours += $hours;

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['employee_no']) . "</td>";
                    echo "<td>". htmlspecialchars($row['department']) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row['calendar'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time_in']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time_out']) . "</td>";
                    echo "<td>" . htmlspecialchars($hours) . "</td>";
                    echo "<td>" . htmlspecialchars($row['main_activity']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found for $selected_month.</td></tr>";
            }
            ?>
        </tbody>
        
    </table>
    <script src="daily_sheet_search.js"></script>
</body>
</html>