<?php
include "db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);

    // check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location='admin_add.php';</script>";
        exit();
    }

    $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";
    if ($conn->query($sql)) {
        echo "<script>alert('User added successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding user.'); window.location='admin_add.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add New User</title>
  <style>
    body { font-family: Arial; background:#f4f6f9; padding:30px; }
    .form-box {
      max-width:400px;
      margin:auto;
      background:#fff;
      padding:20px;
      border-radius:12px;
      box-shadow:0 5px 15px rgba(0,0,0,0.1);
    }
    input, select {
      width:100%;
      padding:10px;
      margin:8px 0;
      border-radius:6px;
      border:1px solid #ccc;
    }
    button {
      width:100%;
      padding:12px;
      background:#2ecc71;
      border:none;
      border-radius:6px;
      color:white;
      font-weight:bold;
      cursor:pointer;
    }
    button:hover { background:#27ae60; }
    a { display:block; margin-top:15px; text-align:center; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Add New User</h2>
    <form method="POST">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Create User</button>
    </form>
    <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
