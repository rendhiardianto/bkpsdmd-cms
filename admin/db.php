<?php
$db_host = "localhost";
$db_user = "bkpsdmd_db";
$db_pass = "admin";
$db_name = "12345";
try
{    
    //create PDO connection 
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}