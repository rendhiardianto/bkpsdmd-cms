<?php
session_start();
if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // simple example, you can hash the password
    if ($username == "admin" && $password == "12345") {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        echo "Login failed!";
    }
}
?>
<form method="POST">
  <input type="text" name="username" placeholder="Username"><br>
  <input type="password" name="password" placeholder="Password"><br>
  <button type="submit">Login</button>
</form>
