<?php
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      padding: 50px;
      text-align: center;
    }
    .box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      display: inline-block;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #f44336;
      color: white;
      text-decoration: none;
      border-radius: 8px;
    }
    a:hover {
      background: #e53935;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>Welcome, <?php echo $_SESSION['fullname']; ?> 🎉</h1>
    <p>You are now logged in to your dashboard.</p>
    <p><a href="profile.php">👤 View / Edit Profile</a></p>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
