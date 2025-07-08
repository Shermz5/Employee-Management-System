<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$searchTerm = '';
$employees = [];

if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);

    $sql = "SELECT id, first_name, last_name, employee_no, position, department, mobile FROM employees WHERE 
            first_name LIKE ? OR 
            last_name LIKE ? OR 
            CAST(id AS CHAR) LIKE ? OR 
            position LIKE ? OR
            department LIKE ? OR
            mobile LIKE ?";

    $param = "%" . $searchTerm . "%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $param, $param, $param, $param, $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    $stmt->close();
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

    <div class="shortcuts-inline">
        <a href="reports.html" class="shortcut-button">Generate Reports</a>
        <a href="manage_staff.php" class="shortcut-button">Manage All Staff</a>
        <a href="add_employee.html" class="shortcut-button">Add New Employee</a>
        <a href="former_employees.php" class="shortcut-button">Former Employees</a>
    </div>
</div>

    <div class="section">
        <h2>Employee Quick Search</h2>
        <form id="searchEmployeeForm" method="GET" action="home.php">
          <input
            type="text"
            name="search"
            placeholder="Search by name, employee number, or contact number..."
            value="<?php echo htmlspecialchars($searchTerm); ?>"
            style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;"
          />
        <button id="searchEmployeeButton" type="submit" style="margin-top: 10px;">Search</button>
     </form>
      
    <div class="section">
    <h2>Search Results</h2>

    <?php if ($searchTerm && count($employees) === 0): ?>
      <p>No emloyees found matching "<?php echo htmlspecialchars($searchTerm); ?>"</p>
    <?php elseif (count($employees) > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Employee Number</th>
            <th>Position</th>
            <th>Department</th>
            <th>Mobile</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($employees as $employee): ?>
            <tr>
              <td><?php echo htmlspecialchars($employee['first_name']); ?></td>
              <td><?php echo htmlspecialchars($employee['last_name']); ?></td>
              <td><?php echo htmlspecialchars($employee['employee_no']); ?></td>
              <td><?php echo htmlspecialchars($employee['position']); ?></td>
              <td><?php echo htmlspecialchars($employee['department']); ?></td>
              <td><?php echo htmlspecialchars($employee['mobile']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Type something in the search box above to find employees.</p>
    <?php endif; ?>
  </div>

  <div class="section">
    <h2>Notifications / Alerts</h2>
    <ul>
      <?php
     
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
               " (" . htmlspecialchars($leave['date_from']) . " to " . htmlspecialchars($leave['date_to']) . ")</li>";
        }
      } else {
        echo "<li>No recent approved leave applications.</li>";
      }
      ?>
    </ul>
  </div>

  <?php

  $totalStaff = 0;
  $sql = "SELECT COUNT(*) AS total FROM employees";
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $totalStaff = $row['total'];
  }

  $newThisWeek = 0;
  $sql = "SELECT COUNT(*) AS total FROM employees WHERE YEARWEEK(date_joined, 1) = YEARWEEK(CURDATE(), 1)";
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $newThisWeek = $row['total'];
  }

  $workSchedulesToday = 0;
  $sql = "SELECT COUNT(*) AS total FROM timesheets WHERE DATE(submitted_at) = CURDATE()";
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $workSchedulesToday = $row['total'];
  }

  $activeUpdates = 0;
  $tables = [];
  $resultTables = $conn->query("SHOW TABLES");
  if ($resultTables) {
    while ($row = $resultTables->fetch_array()) {
      $tables[] = $row[0];
    }
  }

  $totalUpdates = 0;
  foreach ($tables as $table) {
    $resultCol = $conn->query("SHOW COLUMNS FROM `$table` LIKE 'updated_at'");
    if ($resultCol && $resultCol->num_rows > 0) {
      $sql = "SELECT COUNT(*) AS total FROM `$table` WHERE `updated_at` >= NOW() - INTERVAL 1 DAY";
      $result = $conn->query($sql);
      if ($result && $row = $result->fetch_assoc()) {
        $totalUpdates += $row['total'];
      }
    }
  }
  $activeUpdates = $totalUpdates;
  $result = $conn->query($sql);
  if ($result && $row = $result->fetch_assoc()) {
    $activeUpdates = $row['total'];
  }
  ?>

  <div class="section"> 
    <h2>System Statistics</h2>
    <ul>
    <li>Total Registered Staff Members: <?php echo $totalStaff; ?></li>
    <li>New Employees Added This Week: <?php echo $newThisWeek; ?></li>
    <li>Daily Work Schedules Logged Today: <?php echo $workSchedulesToday; ?></li>
    <li>Active Record Updates: <?php echo $activeUpdates; ?></li>
    </ul>
  </div>
  
  <script src="script.js"></script>
</body>
</html>