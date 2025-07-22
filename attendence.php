<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = (int)$_POST['employee_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Validate date format (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        echo "Invalid date format.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $employee_id, $date, $status);

    if ($stmt->execute()) {
        echo "Attendance marked successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
