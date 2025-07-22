<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION["supervisor_id"])) {
    header("Location: supervisor_login.php");
    exit();
}

// Fetch Supervisor Name
$supervisor_id = $_SESSION["supervisor_id"];
$query = "SELECT name FROM supervisors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $supervisor_id);
$stmt->execute();
$result = $stmt->get_result();
$supervisor = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .dashboard-card {
            transition: transform 0.3s ease-in-out;
            border-radius: 10px;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .dashboard-card .card-header {
            font-weight: bold;
            font-size: 1.2rem;
        }
        .buttons-container {
            margin-top: 50px;
        }
        .buttons-container a {
            margin: 5px;
        }
        .welcome-text {
            font-size: 1.2rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Supervisor Dashboard</a>
        <span class="navbar-text text-white welcome-text">Welcome, <?php echo htmlspecialchars($supervisor['name']); ?></span>
    </div>
</nav>

<!-- Main Container -->
<div class="container mt-5">
    <div class="row justify-content-center g-4">
        <!-- Dashboard Cards -->
        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-info text-white">👤 View Details</div>
                <div class="card-body">
                    <p>View your personal information.</p>
                    <a href="view_supervisor_details.php" class="btn btn-info">View Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-primary text-white">✅ Verify Attendance</div>
                <div class="card-body">
                    <p>Approve or reject attendance records.</p>
                    <a href="verify_attendance.php" class="btn btn-primary">Verify Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-warning text-dark">⭐ View Feedback</div>
                <div class="card-body">
                    <p>See feedback provided by the manager.</p>
                    <a href="view_feedback_supervisor.php" class="btn btn-warning text-white">View Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-danger text-white">📢 Submit Complaint</div>
                <div class="card-body">
                    <p>Raise complaints regarding work-related issues.</p>
                    <a href="submit_complaint_supervisor.php" class="btn btn-danger">Submit Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-success text-white">💰 View My Salary</div>
                <div class="card-body">
                    <p>Check your salary fixed by the manager.</p>
                    <a href="view_supervisor_salary.php" class="btn btn-success">View Salary</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card text-center shadow">
                <div class="card-header bg-secondary text-white">📊 Salary for Employees</div>
                <div class="card-body">
                    <p>Rate employee performance and distribute salaries.</p>
                    <a href="distribute_employee_salary.php" class="btn btn-secondary">Manage Salaries</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout and Back Buttons -->
    <div class="text-center buttons-container">
    <a href="supervisor_login.php" class="btn btn-danger btn-lg">🚪 Logout</a>
        <a href="login.php" class="btn btn-dark btn-lg">🔙 Back</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
