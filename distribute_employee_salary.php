<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['supervisor_id'])) {
    header("Location: supervisor_login.php");
    exit();
}

// Handle salary distribution
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_salary'])) {
    foreach ($_POST['performance'] as $employee_id => $mark) {
        $base_salary = 70000;
        $increment = min(10, max(0, (int)$mark)) * 1000;
        $final_salary = $base_salary + $increment;

        $check = $conn->prepare("SELECT * FROM employee_salaries WHERE employee_id = ?");
        $check->bind_param("i", $employee_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $update = $conn->prepare("UPDATE employee_salaries SET performance_mark=?, increment=?, final_salary=? WHERE employee_id=?");
            $update->bind_param("iidi", $mark, $increment, $final_salary, $employee_id);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO employee_salaries (employee_id, base_salary, performance_mark, increment, final_salary) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("ididd", $employee_id, $base_salary, $mark, $increment, $final_salary);
            $insert->execute();
        }
    }

    $success = "Salaries successfully distributed/updated.";
}

// Fetch employee list
$query = "SELECT id, name FROM employees";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Distribute Employee Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 900px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        table {
            background-color: #fdfefe;
        }
        thead {
            background-color: #b2ebf2; /* Soft light blue header */
            color: #333333; /* Dark gray text */
        }
        tbody tr:nth-child(even) {
            background-color: #f1f8ff; /* very soft blue */
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff; /* white */
        }
        .btn-success {
            background-color: #66bb6a;
            border: none;
        }
        .btn-success:hover {
            background-color: #43a047;
        }
        .btn-secondary {
            background-color: #90a4ae;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #78909c;
        }
        h2 {
            color: #00796b;
        }
        .text-muted {
            color: #607d8b !important;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">💰 Distribute Employee Salaries</h2>

    <p class="text-muted text-center">Note: Fixed base salary is ₹70,000. Performance mark is used to calculate increments (e.g., 7 = ₹7000 increment).</p>

    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

    <form method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Performance (/10)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($employee = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        <td>
                            <input type="number" name="performance[<?php echo $employee['id']; ?>]" class="form-control" min="0" max="10" required>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <button type="submit" name="submit_salary" class="btn btn-success me-2">Distribute Salaries</button>
            <a href="supervisor_dashboard.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
