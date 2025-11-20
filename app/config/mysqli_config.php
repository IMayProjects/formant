<?php

// credentials
$servername = "127.0.0.1";
$username = "groot";
$password = "groot";
$dbname = "formant";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
 die("connection failed" . $conn->connect_error);
}

echo "Connected successfully ";


// Close connection

$conn->close();

?>