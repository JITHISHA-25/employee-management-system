<?php
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Logout function
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: manager_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard-box {
            background: #fff;
            border-radius: 15px;
            padding: 30px 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 800px;
            text-align: center;
        }
        .dashboard-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
        }
        .grid-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .dashboard-button {
            padding: 20px;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 15px;
            text-decoration: none;
            color: #333; /* Darker text for light buttons */
            background-color:rgba(46, 118, 220, 0.52); /* Light blue shade */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
        }
        .dashboard-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            background-color: #bde8f6; /* Slightly darker on hover */
        }
        .btn-back-logout {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn-back-logout a {
            width: 48%;
        }
        @media (max-width: 768px) {
            .grid-buttons {
                grid-template-columns: repeat(2, 1fr);
            }
            .dashboard-button {
                height: 100px;
                font-size: 16px;
            }
        }
        @media (max-width: 480px) {
            .grid-buttons {
                grid-template-columns: 1fr;
            }
            .dashboard-button {
                height: 90px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-box">
    <div class="dashboard-title">👨‍💼 Manager Dashboard</div>

    <div class="grid-buttons">
        <a href="view_manager_details.php" class="dashboard-button">ℹ️ Manager Details</a>
        <a href="view_employees.php" class="dashboard-button">👥 Employee Details</a>
        <a href="manage_attendance.php" class="dashboard-button">📅 Manage Attendance</a>

        <a href="accept_employee.php" class="dashboard-button">✔️ Accept Employees</a>
        <a href="feedback.php" class="dashboard-button">⭐ Provide Feedback</a>
        <a href="manage_complaints.php" class="dashboard-button">📢 Manage Complaints</a>

        <a href="set_salaries.php" class="dashboard-button">💰 Set Salary</a>
        <a href="view_all_salaries.php" class="dashboard-button">📄 View All Salaries</a>
        <a href="#" class="dashboard-button">🔧 More</a>
    </div>

    <div class="btn-back-logout">
        <a href="login.php" class="btn btn-secondary btn-lg">🔙 Back</a>
        <a href="?logout=true" class="btn btn-danger btn-lg">🚪 Logout</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
