<?php 
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manage_staff.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>
    <button><a href="home.php">Home</a></button>
    <h1>Manage All Staff</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Department</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM employees");
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>
                    <td>" . htmlspecialchars($row['position']) . "</td>
                    <td>" . htmlspecialchars($row['department']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['mobile']) . "</td>
                    <td>" . htmlspecialchars($row['status'] ?? 'Active') . "</td>
                    <td class='action-buttons'>
                        <a href='edit_employee.php?id=" . urlencode($row['id']) . "'>Edit</a>
                        <form action='suspend_staff.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='employee_no' value='" . htmlspecialchars($row['employee_no']) . "'>
                            <button type='submit' class='suspendEmployee-Button' onclick='return confirm(\"Are you sure you want to suspend this employee?\");'>Suspend</button>
                        </form>
                    </td>
                </tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>