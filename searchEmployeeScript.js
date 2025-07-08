function searchEmployee() {
    const searchEmployeeForm = document.getElementById('searchEmployeeForm');
    searchEmployeeForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the default form submission

        const searchTerm = document.querySelector('input[name="search"]').value.trim();
        if (searchTerm) {
            window.location.href = `home.php?search=${encodeURIComponent(searchTerm)}`;
        } else {
            alert('Please enter a valid search term.');
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
  const activityList = document.getElementById("recent-activity-list");
  if (activityList) {
    activityList.innerHTML = "";
    recentActivity.forEach(item => {
      const li = document.createElement("li");
      li.textContent = `${item.description}: ${item.date}`;
      activityList.appendChild(li);
    });
  }
});