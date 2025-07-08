<?php
include 'db_connect.php';

$sql = "SELECT l.id, l.employee_no, e.first_name, e.last_name, l.leave_type, l.date_from, l.date_to, l.reason, l.status
        FROM leave_apps l
        JOIN employees e ON l.employee_no = e.employee_no
        ORDER BY l.date_from DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="leave_applications.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>
    <button><a href="reports.html">Reports</a></button>
    <h1>Leave Applications</h1>
     <table>
        <thead>
            <tr>
            <th>Employee Name</th>
            <th>Employee No.</th>
            <th>Type of Leave</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                <td><?= $row['employee_no'] ?></td>
                <td><?= $row['leave_type'] ?></td>
                <td><?= date("d/m/Y", strtotime($row['date_from'])) ?></td>
                <td><?= date("d/m/Y", strtotime($row['date_to'])) ?></td>
                <td><?= $row['reason'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td class="action-buttons">
                  <?php if ($row['status'] == 'pending'): ?>
                    <a class="approved" href="update_status.php?id=<?= $row['id'] ?>&status=approved">Approve</a>
                    <a class="rejected" href="update_status.php?id=<?= $row['id'] ?>&status=rejected">Reject</a>
                  <?php endif; ?>
                  <?php if ($result->num_rows === 0): ?>
                    <tr>
                      <td colspan="8">No leave applications found.</td>
                    </tr>
                  <?php endif; ?>

                </td>
              </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>