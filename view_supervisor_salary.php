<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION["supervisor_id"])) {
    header("Location: supervisor_login.php");
    exit();
}

$supervisor_id = $_SESSION["supervisor_id"];

$query = "SELECT name FROM supervisors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $supervisor_id);
$stmt->execute();
$result = $stmt->get_result();
$supervisor = $result->fetch_assoc();
$stmt->close();

// Fetch salary details
$query = "SELECT base_salary, increment, final_salary FROM set_salaries WHERE supervisor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $supervisor_id);
$stmt->execute();
$result = $stmt->get_result();
$salary = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center text-success mb-4">💼 Salary Details for <?php echo htmlspecialchars($supervisor['name']); ?></h3>

        <?php if ($salary): ?>
            <p><strong>Base Salary:</strong> ₹<?php echo number_format($salary['base_salary']); ?></p>
            <p><strong>Increment:</strong> ₹<?php echo number_format($salary['increment']); ?></p>
            <p><strong>Final Salary:</strong> ₹<?php echo number_format($salary['final_salary']); ?></p>
            <div class="alert alert-info mt-3">
                Note: Salary is set by manager based on performance.
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Salary details have not been assigned yet.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="supervisor_dashboard.php" class="btn btn-secondary">🔙 Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
