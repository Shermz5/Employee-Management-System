<?php 
include 'db_connect.php';
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>EMS</title>
</head>
<body>
<div class="welcome-banner">
    <h1>WorkFlow</h1>
    <h3>The Future of Work, Managed</h3>   
    <h4>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></h4> 
    <div class="banner-buttons">
      <a href="logout.php">Logout</a>
    </div>
</div>

  <div class="section">
    <a href="leave_form.html"><h2>Apply for Leave</h2></a>
    <a href="timesheet.html"><h2>Record Time Sheet</h2></a>
    <a href="view_leaves.php"><h2>View Leave Schedule</h2></a>
  </div>
  
  <div class="section">
    <h2>Notifications / Alerts</h2>
    <ul>
      <?php
  
      $reminderDays = 7;
      $today = date('Y-m-d');
      $upcomingSql = "SELECT e.first_name, e.last_name, l.date_from
                      FROM leave_apps l
                      JOIN employees e ON l.employee_no = e.employee_no
                      WHERE l.status = 'approved'
                        AND l.date_from > ?
                        AND l.date_from <= DATE_ADD(?, INTERVAL ? DAY)
                      ORDER BY l.date_from ASC";
      $upcomingStmt = $conn->prepare($upcomingSql);
      $upcomingStmt->bind_param("ssi", $today, $today, $reminderDays);
      $upcomingStmt->execute();
      $upcomingResult = $upcomingStmt->get_result();
      if ($upcomingResult && $upcomingResult->num_rows > 0) {
        while ($row = $upcomingResult->fetch_assoc()) {
          $leave_date = strtotime($row['date_from']);
          $days_left = (int) ceil(($leave_date - strtotime($today)) / 86400);
          echo "<li style='color: orange;'>Reminder: " . htmlspecialchars($row['first_name'] . " " . $row['last_name']) .
               " starts leave in " . $days_left . " day" . ($days_left !== 1 ? 's' : '') .
               " (" . date("d/m/Y", $leave_date) . ")</li>";
        }
      }
      $upcomingStmt->close();
      // Fetch recently approved leave applications (e.g., last 7 days)
      $leaveSql = "SELECT e.first_name, e.last_name, l.date_from, l.date_to
                   FROM leave_apps l
                   JOIN employees e ON l.employee_no = e.employee_no
                   WHERE l.status = 'approved'
                   ORDER BY l.status DESC
                   LIMIT 10";
      $leaveResult = $conn->query($leaveSql);

      if ($leaveResult && $leaveResult->num_rows > 0) {
        while ($leave = $leaveResult->fetch_assoc()) {
          echo "<li>Leave Approved: " . htmlspecialchars($leave['first_name'] . " " . $leave['last_name']) .
               " (" . date("d/m/Y", strtotime($leave['date_from'])) . " to " . date("d/m/Y", strtotime($leave['date_to'])) . ")</li>";
        }
      } else {
        echo "<li>No recent approved leave applications.</li>";
      }
      ?>
    </ul>


  </div>

</body>
</html>