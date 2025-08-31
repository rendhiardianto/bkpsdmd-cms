<?php
include 'db.php'; // koneksi database

$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO pengumuman (title, content) VALUES ('$title', '$content')";
mysqli_query($conn, $sql);

header("Location: dashboard.php");
