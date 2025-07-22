<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Salaries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
        }
        .container {
            margin-top: 40px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-5">📊 All Salary Details</h2>

    <!-- Supervisor Salaries Section -->
    <div class="mb-5">
        <h4 class="text-primary mb-3">Supervisor Salaries (Set by Manager)</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Supervisor Name</th>
                    <th>Base Salary</th>
                    <th>Increment</th>
                    <th>Final Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("
                    SELECT s.name, ss.base_salary, ss.increment, ss.final_salary
                    FROM set_salaries ss
                    JOIN supervisors s ON ss.supervisor_id = s.id
                    WHERE ss.role = 'supervisor'
                ");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>₹<?php echo number_format($row['base_salary']); ?></td>
                    <td>₹<?php echo number_format($row['increment']); ?></td>
                    <td>₹<?php echo number_format($row['final_salary']); ?></td>
                </tr>
                <?php endwhile; $stmt->close(); ?>
            </tbody>
        </table>
    </div>

    <!-- Employee Salaries Section -->
    <div>
        <h4 class="text-success mb-3">Employee Salaries (Distributed by Supervisor)</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Employee Name</th>
                    <th>Performance (/10)</th>
                    <th>Base Salary</th>
                    <th>Increment</th>
                    <th>Final Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("
                    SELECT e.name AS employee_name, es.performance_mark, es.base_salary, es.increment, es.final_salary
                    FROM employee_salaries es
                    JOIN employees e ON es.employee_id = e.id
                ");
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                    <td><?php echo $row['performance_mark']; ?>/10</td>
                    <td>₹<?php echo number_format($row['base_salary']); ?></td>
                    <td>₹<?php echo number_format($row['increment']); ?></td>
                    <td>₹<?php echo number_format($row['final_salary']); ?></td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr><td colspan="5" class="text-center">No employee salary records found.</td></tr>
                <?php endif; $stmt->close(); ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="manager_dashboard.php" class="btn btn-dark">🔙 Back to Dashboard</a>
    </div>
</div>

</body>
</html>
