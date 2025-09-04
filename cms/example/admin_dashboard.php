<?php
include "db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial; background:#f4f6f9; padding:30px; }
    h2 { text-align:center; }
    .top-bar {
      max-width: 1000px;
      margin: auto;
      display:flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom:20px;
    }
    form { display:flex; gap:10px; }
    input, select {
      padding:8px;
      border-radius:6px;
      border:1px solid #ccc;
    }
    button {
      padding:8px 14px;
      border:none;
      border-radius:6px;
      background:#3498db;
      color:white;
      cursor:pointer;
    }
    button:hover { background:#2980b9; }
    #userTable { margin-top:20px; }
    .logout { display:block; margin-top:20px; text-align:center; }
  </style>
</head>
<body>
  <h2>👑 Admin Dashboard</h2>

  <div class="top-bar">
    <a href="admin_add.php" style="padding:8px 14px;background:#2ecc71;color:white;border-radius:6px;text-decoration:none;">➕ Add User</a>

    <form id="filterForm">
      <input type="text" name="search" id="search" placeholder="Search by name/email">
      <select name="role_filter" id="role_filter">
        <option value="">All Roles</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Filter</button>
    </form>
  </div>

  <div id="userTable">
    <!-- AJAX loads user table here -->
  </div>

  <a href="logout.php" class="logout">🚪 Logout</a>

  <script>
    // Handle Delete button
document.addEventListener("click", function(e) {
  if (e.target.classList.contains("delete-btn")) {
    const id = e.target.getAttribute("data-id");
    if (confirm("Are you sure you want to delete this user?")) {
      const formData = new FormData();
      formData.append("action", "delete");
      formData.append("id", id);

      fetch("admin_actions.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        loadUsers(); // reload table
      });
    }
  }
});

// Handle Edit button
document.addEventListener("click", function(e) {
  if (e.target.classList.contains("edit-btn")) {
    const id = e.target.getAttribute("data-id");

    // Prompt simple inline edit (can be replaced with a modal form)
    const fullname = prompt("Enter new full name:");
    const email = prompt("Enter new email:");
    const role = prompt("Enter role (admin/user):");

    if (fullname && email && role) {
      const formData = new FormData();
      formData.append("action", "edit");
      formData.append("id", id);
      formData.append("fullname", fullname);
      formData.append("email", email);
      formData.append("role", role);

      fetch("admin_actions.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        loadUsers(); // reload table
      });
    }
  }
});

    function loadUsers(page = 1) {
      const search = document.getElementById('search').value;
      const role = document.getElementById('role_filter').value;

      const xhr = new XMLHttpRequest();
      xhr.open("GET", "admin_fetch_users.php?page=" + page + "&search=" + encodeURIComponent(search) + "&role_filter=" + role, true);
      xhr.onload = function() {
        if (this.status === 200) {
          document.getElementById('userTable').innerHTML = this.responseText;
        }
      }
      xhr.send();
    }

    // On page load
    window.onload = function() {
      loadUsers();
    }

    // Filter submit
    document.getElementById('filterForm').addEventListener("submit", function(e) {
      e.preventDefault();
      loadUsers();
    });

    // Handle pagination clicks
    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("pagination-link")) {
        e.preventDefault();
        const page = e.target.getAttribute("data-page");
        loadUsers(page);
      }
    });
  </script>
</body>
</html>
