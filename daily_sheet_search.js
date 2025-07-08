document.getElementById('searchInput').addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll('#timesheets tbody tr');

  rows.forEach(row => {
    const employee_name = row.cells[0].textContent.toLowerCase();
    const employee_no = row.cells[1].textContent.toLowerCase();
    const department = row.cells[2].textContent.toLowerCase();

    if (employee_name.includes(filter) || employee_no.includes(filter) || department.includes(filter)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    } 
  });
});