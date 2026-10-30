<?php


//Student Name: WONG Tsz Fung
//Student No: 23043094S
//Class: SEHS4517 IA



// Start the session
session_start();

// Include the database connection file
include 'db.php';

$servername = "";
$username = "root";
$password = "";
$dbname = "SEHS45171A";

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$timeslotArray = [
    "1" => "09:00 - 12:00",
    "2" => "12:00 - 15:00",
    "3" => "15:00 - 18:00",
    "4" => "18:00 - 21:00",
];

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle login
if (isset($_POST['login'])) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Simple authentication
    if ($username === 'admin' && $password === 'CHANGE_ME') {
        $_SESSION['admin_logged_in'] = true;
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}

// Check if the session variable for admin login is set
if (!isset($_SESSION['admin_logged_in'])) {
    // Display login form if not logged in
    ?>
    <form method="post" action="admin.php">
        <input type="text" name="username" placeholder="Username" required></br>
        <input type="password" name="password" placeholder="Password" required></br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php
    exit(); // Stop further execution of the script
}

if (isset($_SESSION['admin_logged_in'])) {
    // Search form
    ?>
    <form method="get" action="admin.php">
        <input type="text" name="studentid" placeholder="Enter Student ID to search">
        <input type="submit" value="Search">
    </form>
    <hr>
    <?php

    // If a search for a student ID is made
    if (isset($_GET['studentid']) && !empty($_GET['studentid'])) {
        $studentid = sanitize($_GET['studentid']);
        // Query to search records by student ID
        $query = "SELECT * FROM booking WHERE sid = ? ORDER BY date DESC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $studentid);
    } else {
        // Query to view all records
        $query = "SELECT * FROM booking ORDER BY id ASC";
        $stmt = mysqli_prepare($conn, $query);
    }

    // Execute the query and display the records
    mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>ID</th><th>Name</th><th>Student ID</th><th>Email</th><th>Campus</th><th>Date</th><th>Time Slot</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $timeSlotValue = isset($timeslotArray[$row['slot']]) ? $timeslotArray[$row['slot']] : "Unknown time slot";
        
        echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['fname'] . "</td>
            <td>" . $row['sid'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . $row['campus'] . "</td>
            <td>" . $row['date'] . "</td>
            <td>" . $timeSlotValue . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>