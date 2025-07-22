<?php
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $age = (int)$_POST['age'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Prepared statement to insert data securely
    $stmt = $conn->prepare("INSERT INTO employees 
        (name, phone, email, qualification, experience, age, password, role) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssss", 
        $name, $phone, $email, $qualification, 
        $experience, $age, $password, $role
    );

    if ($stmt->execute()) {
        echo "New user registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close resources
    $stmt->close();
    $conn->close();
}
?>
