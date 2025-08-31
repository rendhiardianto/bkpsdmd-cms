<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM berita ORDER BY created_at DESC");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<h2>{$row['title']}</h2>";
    echo "<p>{$row['content']}</p>";
    echo "<small>{$row['created_at']}</small><hr>";
}
