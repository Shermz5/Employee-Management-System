<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM leave_apps");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view_leaves.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>

<h2>All Leave Requests</h2>

<table>
  <tr>
    <th>Employee Name</th>
    <th>Employee No</th>
    <th>Leave Type</th>
    <th>Date From</th>
    <th>Date To</th>
    <th>Status</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
      <td><?= $row['employee_no'] ?></td>
      <td><?= $row['leave_type'] ?></td>
      <td><?= $row['date_from'] ?></td>
      <td><?= $row['date_to'] ?></td>
      <td><?= ucfirst($row['status']) ?></td>
    </tr>
  <?php endwhile; ?>

</table>

</body>
</html>
