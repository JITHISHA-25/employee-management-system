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
$stmt->close();

// Fetch Attendance Records
$query = "SELECT date, status FROM attendance WHERE employee_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #e9f7ef; /* Light greenish background */
            padding: 20px;
        }
        .container { 
            max-width: 850px; 
            margin: auto; 
            padding: 30px; 
            background: #ffffff; /* White container */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); 
            border-radius: 12px; 
            margin-top: 50px;
        }
        h3 {
            font-weight: bold;
            color: #2e8b57; /* Dark green */
            margin-bottom: 20px;
            text-align: center;
        }
        table { 
            width: 100%; 
            margin-top: 20px;
            border-collapse: collapse;
        }
        th {
            background: #4CAF50; /* Green table header */
            color: white;
            font-size: 18px;
            padding: 12px;
            text-align: center;
        }
        td {
            text-align: center; 
            padding: 12px;
            font-size: 16px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light alternate row */
        }
        .status-present {
            color: #28a745;
            font-weight: bold;
        }
        .status-absent {
            color: #dc3545;
            font-weight: bold;
        }
        .status-onleave {
            color: #ffc107;
            font-weight: bold;
        }
        .btn-back {
            margin-top: 25px;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>📊 Attendance Records for <?php echo htmlspecialchars($employee['name']); ?></h3>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'Present'): ?>
                                <span class="status-present">✔ Present</span>
                            <?php elseif ($row['status'] == 'Absent'): ?>
                                <span class="status-absent">✖ Absent</span>
                            <?php elseif ($row['status'] == 'On Duty Leave'): ?>
                                <span class="status-onleave">🟠 On Duty Leave</span>
                            <?php else: ?>
                                <span>Unknown</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="employee_dashboard.php" class="btn btn-back w-100">🔙 Back to Dashboard</a>
</div>

</body>
</html>
