<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

// Fetch employee name
$stmt = $conn->prepare("SELECT name FROM employees WHERE id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$employee_name = $employee['name'];
$stmt->close();

// Fetch salary info
$stmt = $conn->prepare("SELECT base_salary, performance_mark, increment, final_salary FROM employee_salaries WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$salary = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.4px;
        }
        .salary-box {
            max-width: 650px;
            margin: 60px auto;
            background: #e8f0fe; /* Light soft blue background */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .salary-box h3 {
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }
        .salary-details {
            margin-bottom: 25px;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
            color: #555;
        }
        .detail-item strong {
            color: #222;
            min-width: 220px;
            text-align: left;
            font-weight: 600;
        }
        .detail-item span {
            color: #333;
            font-weight: 500;
        }
        .note {
            font-style: italic;
            color: #777;
            font-size: 14px;
            margin-top: 20px;
        }
        .btn-back {
            margin-top: 30px;
            padding: 10px 24px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<div class="salary-box">
    <h3 class="text-center">💵 Salary Details</h3>

    <div class="salary-details">
        <div class="detail-item">
            <strong>Employee Name:</strong> 
            <span><?php echo htmlspecialchars($employee_name); ?></span>
        </div>

        <?php if ($salary): ?>
            <div class="detail-item">
                <strong>Base Salary:</strong> 
                <span>₹<?php echo number_format($salary['base_salary'], 2); ?></span>
            </div>

            <div class="detail-item">
                <strong>Performance Mark (out of 10):</strong> 
                <span><?php echo $salary['performance_mark']; ?></span>
            </div>

            <div class="detail-item">
                <strong>Increment:</strong> 
                <span>₹<?php echo number_format($salary['increment'], 2); ?></span>
            </div>

            <div class="detail-item">
                <strong>Final Salary:</strong> 
                <span class="text-success fw-bold">₹<?php echo number_format($salary['final_salary'], 2); ?></span>
            </div>

            <p class="note">
                Note: Your performance score determines the increment (e.g., 7/10 = ₹7000 extra).
            </p>

        <?php else: ?>
            <div class="alert alert-warning mt-4">
                Salary details have not yet been assigned by your supervisor.
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <a href="employee_dashboard.php" class="btn btn-secondary btn-back">🔙 Back to Dashboard</a>
    </div>
</div>

</body>
</html>
