<?php
session_start();
include('db_connect.php'); // Ensure database connection

// Check if Manager is logged in
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Check if employee ID is provided
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Delete employee from the database
    $query = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee deleted successfully!'); window.location.href='view_employees.php';</script>";
    } else {
        echo "<script>alert('Error deleting employee!'); window.location.href='view_employees.php';</script>";
    }
} else {
    header("Location: view_employees.php");
    exit();
}
?>
