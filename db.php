
<?php

//Student Name: WONG Tsz Fung
//Student No: 23043094S
//Class: SEHS4517 IA

// session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// database information
$servername = "";
$username = "root";
$password = "";
$dbname = "SEHS45171A";

$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check if database connection is successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
echo "Connected successfully"."<br>";