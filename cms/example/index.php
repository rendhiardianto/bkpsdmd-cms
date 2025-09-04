<?php
// Load PHPMailer classes manually (no Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include "db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$showResend = false; // flag to control button visibility

// ---------------- LOGIN ----------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['verified'] == 0) {
            echo "<script>alert('Your email is not verified. Click Resend Verification.');</script>";
            $showResend = true; // show button now
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('Email not found! Please register.');</script>";
    }
}

// ---------------- RESEND VERIFICATION ----------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resend'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['verified'] == 1) {
            echo "<script>alert('Your account is already verified. Please login.');</script>";
        } else {
            $token = bin2hex(random_bytes(16));
            $conn->query("UPDATE users SET verifY_token='$token' WHERE email='$email'");

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ardianto.rendhi@gmail.com';  // 🔹 replace with your Gmail
                $mail->Password = 'jpkxofrdmykbzxui';   // 🔹 use Gmail App Password (not normal password!)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ardianto.rendhi@gmail.com', 'My App');
                $mail->addAddress($email, $user['fullname']);

                $verifyLink = "http://localhost/bkpsdmd-cms/cms/example/verify.php?token=$token";
                $mail->isHTML(true);
                $mail->Subject = "Verify Your Account";
                $mail->Body = "Hello {$user['fullname']},<br><br>
                               Click below to verify your account:<br>
                               <a href='$verifyLink'>$verifyLink</a>";

                $mail->send();
                echo "<script>alert('Verification email resent! Please check your inbox.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    } else {
        echo "<script>alert('No account found with that email. Please register again.');</script>";
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
    button { border:none; color:white; font-weight:bold; cursor:pointer; }
    .login-btn { background:#27ae60; }
    .login-btn:hover { background:#219150; }
    .resend-btn { background:#2980b9; }
    .resend-btn:hover { background:#21618c; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <p><a href="forgot_password.php">Forgot Password?</a></p>
      <button type="submit" name="login" class="login-btn">Login</button>

      <?php if ($showResend): ?>
  <p><a href="resend_verification.php?email=<?php echo urlencode($email); ?>" class="resend-btn">Resend Verification</a></p>
<?php endif; ?>
    </form>
    <p>No account? <a href="daftar.php">Sign Up</a></p>
  </div>
</body>
</html>

