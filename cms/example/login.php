<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['verified'] == 0) {
            echo "<script>alert('Please verify your email before logging in.'); window.location='login.php';</script>";
            exit();
        }

        if (password_verify($password, $user['password'])) {
            // ✅ Ensure session is active
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // ✅ Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found!'); window.location='login.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body { font-family: Arial; background:#f4f6f9; padding:30px; }
    .form-box { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
    input, button { width:100%; padding:12px; margin:8px 0; border-radius:6px; border:1px solid #ccc; }
    button { background:#27ae60; border:none; color:white; font-weight:bold; cursor:pointer; }
    button:hover { background:#219150; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <p><a href="forgot_password.php">Forgot Password?</a></p>
      <button type="submit">Login</button>
    </form>
    <p>No account? <a href="index.php">Sign Up</a></p>
  </div>
</body>
</html>
