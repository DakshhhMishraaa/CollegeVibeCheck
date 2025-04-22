<?php
$servername = "localhost";
$username = "root";
$password = "";

// Step 1: Connect to MySQL server (without DB)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS collegevibecheck";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Step 3: Select the database
$conn = new mysqli($servername, $username, $password, "collegevibecheck");

// Check connection again
if ($conn->connect_error) {
    die("Connection to collegevibecheck failed: " . $conn->connect_error);
}

// Step 4: Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    college VARCHAR(100),
    branch VARCHAR(100),
    yearofstudy VARCHAR(100),
    identity VARCHAR(255),
    user_role VARCHAR(50)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
