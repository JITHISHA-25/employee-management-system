<?php
session_start();
include('db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

// Fetch Employee Name
$query = "SELECT name FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #e0f7fa, #f0f4c3); /* Light, calm background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 1000px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .card {
            transition: transform 0.3s;
            border: none;
            border-radius: 10px;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .logout-section {
            margin-top: 30px;
            text-align: center;
        }
        .logout-section a {
            margin: 0 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($employee['name']); ?> 👋</h2>

    <div class="row">
        <!-- View Employee Details -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-info text-white">👤 View Details</div>
                <div class="card-body">
                    <p>View your personal information.</p>
                    <a href="view_employee_details.php" class="btn btn-info">View Now</a>
                </div>
            </div>
        </div>

        <!-- View Salary -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-success text-white">💰 View Salary</div>
                <div class="card-body">
                    <p>Check your salary details.</p>
                    <a href="view_salary.php" class="btn btn-success">View Now</a>
                </div>
            </div>
        </div>

        <!-- Mark Attendance -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-primary text-white">🕒 Mark Attendance</div>
                <div class="card-body">
                    <p>Submit your daily attendance.</p>
                    <a href="mark_attendance.php" class="btn btn-primary">Submit Now</a>
                </div>
            </div>
        </div>

        <!-- View Attendance -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-secondary text-white">📊 View Attendance</div>
                <div class="card-body">
                    <p>Check your attendance records.</p>
                    <a href="view_attendance.php" class="btn btn-secondary">View Now</a>
                </div>
            </div>
        </div>

        <!-- View Feedback -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-warning text-dark">⭐ View Feedback</div>
                <div class="card-body">
                    <p>See feedback given by the manager.</p>
                    <a href="view_feedback.php" class="btn btn-warning">View Now</a>
                </div>
            </div>
        </div>

        <!-- Submit Complaint -->
        <div class="col-md-6 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-danger text-white">📢 Submit Complaint</div>
                <div class="card-body">
                    <p>Submit your complaints or issues.</p>
                    <a href="submit_complaint.php" class="btn btn-danger">Submit Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout and Back Buttons -->
    <div class="logout-section">
    <a href="employee_login.php" class="btn btn-danger btn-lg">🚪 Logout</a>
        <a href="login.php" class="btn btn-secondary">🔙 Back</a>
    </div>
</div>

</body>
</html>
