<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Former Employees</title>
  <link rel="stylesheet" href="former_employees.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>

  <button><a href="home.php">Home</a></button>
  <h1>Former Employees</h1>

  <table>
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Employee Number</th>
        <th>Position</th>
        <th>Department</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Date Joined</th>
        <th>Date Suspended</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM former_employees");

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
              <td>" . htmlspecialchars($row['first_name']) . "</td>
              <td>" . htmlspecialchars($row['last_name']) . "</td>
              <td>" . htmlspecialchars($row['employee_no']) . "</td>
              <td>" . htmlspecialchars($row['position']) . "</td>
              <td>" . htmlspecialchars($row['department']) . "</td>
              <td>" . htmlspecialchars($row['email']) . "</td>
              <td>" . htmlspecialchars($row['mobile']) . "</td>
              <td>" . htmlspecialchars($row['date_joined'] ?? 'N/A') . "</td>
              <td>" . htmlspecialchars($row['date_suspended'] ?? 'N/A') . "</td>
              <td>" . htmlspecialchars($row['status'] ?? 'Suspended') . "</td>
              <td>
                <form action='unsuspend.php' method='POST' style='display:inline;'>
                  <input type='hidden' name='employee_no' value='" . htmlspecialchars($row['employee_no']) . "'>
                  <button type='submit'>Unsuspend</button>
                </form>
              </td>
            </tr>";
        }
      } else {
        echo "<tr><td colspan='9'>No suspended employees found.</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>

</body>
</html>
