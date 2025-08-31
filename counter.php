<?php
$file = "counter.txt";

// Read
$count = file_exists($file) ? (int)file_get_contents($file) : 0;

// Increment
$count++;

// Save
file_put_contents($file, $count);

// Show
echo $count;
?>
