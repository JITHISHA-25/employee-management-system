<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP MySQL password is empty
$database = "employee_management_system";

// Create Connection
$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
