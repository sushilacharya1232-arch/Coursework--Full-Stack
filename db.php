<?php
$mysqli = new mysqli("localhost","2436752","Sushil#123","db2436752");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
?>
