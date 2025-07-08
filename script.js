function suspendEmployee(employeeNo) {
  if (confirm("Are you sure you want to suspend this employee?")) {
    window.location.href = "suspend_staff.php";
  }
}
