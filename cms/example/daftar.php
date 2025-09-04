<?php include "db.php"; ?>

<?php
// Load PHPMailer classes manually (no Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(16));

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, role, verified, verify_token) 
                VALUES ('$fullname', '$email', '$password', 'user', 0, '$token')";
        if ($conn->query($sql)) {

            // ✅ Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ardianto.rendhi@gmail.com';  // 🔹 replace with your Gmail
                $mail->Password = 'jpkxofrdmykbzxui';   // 🔹 use Gmail App Password (not normal password!)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('yourgmail@gmail.com', 'My App');
                $mail->addAddress($email, $fullname);

                // Content
                $verifyLink = "http://localhost/bkpsdmd-cms/cms/example/verify.php?token=$token";
                $mail->isHTML(true);
                $mail->Subject = "Verify your email";
                $mail->Body = "Hello $fullname,<br><br>Please verify your email by clicking this link:<br>
                              <a href='$verifyLink'>$verifyLink</a><br><br>
                              Thanks,<br>Tim Pusdatin BKPSDMD Kab. Merangin";

                $mail->send();
                echo "<script>alert('Check your Gmail inbox for the verification link!');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <style>
    body { font-family: Arial; background:#f4f6f9; padding:30px; }
    .form-box { max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
    input, button { width:100%; padding:12px; margin:8px 0; border-radius:6px; border:1px solid #ccc; }
    button { background:#3498db; border:none; color:white; font-weight:bold; cursor:pointer; }
    button:hover { background:#2980b9; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>
  </div>
</body>
</html>