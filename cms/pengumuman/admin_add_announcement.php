<?php
include "auth.php"; 
requireRole('admin'); // only admin can add announcements

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $created_by = $_SESSION['fullname'];

    $sql = "INSERT INTO announcements (title, content, created_by) 
            VALUES ('$title', '$content', '$created_by')";
    if ($conn->query($sql)) {
        echo "<script>alert('✅ Announcement added!'); window.location='announcements.php';</script>";
    } else {
        echo "<script>alert('❌ Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Announcement</title>
  <style>
    body { font-family: Arial; background:#f4f6f9; padding:30px; }
    .form-box { max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
    input, textarea, button { width:100%; padding:12px; margin:8px 0; border-radius:6px; border:1px solid #ccc; }
    button { background:#27ae60; border:none; color:white; font-weight:bold; cursor:pointer; }
    button:hover { background:#219150; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Add Announcement</h2>
    <form method="POST">
      <input type="text" name="title" placeholder="Announcement Title" required>
      <textarea name="content" rows="5" placeholder="Write announcement..." required></textarea>
      <button type="submit">Publish</button>
    </form>
    <p><a href="announcements.php">🔙 Back to Announcements</a></p>
  </div>
</body>
</html>
