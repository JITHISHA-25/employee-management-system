<?php
session_start();
include("db_connect.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supervisor_id'], $_POST['salary'], $_POST['increment'])) {
    $supervisor_id = $_POST['supervisor_id'];
    $base_salary = $_POST['salary'];
    $increment = $_POST['increment'];
    $final_salary = $base_salary + $increment;

    // Insert or Update salary for supervisor
    $stmt = $conn->prepare("INSERT INTO set_salaries (supervisor_id, role, base_salary, increment, final_salary) 
                            VALUES (?, 'supervisor', ?, ?, ?)
                            ON DUPLICATE KEY UPDATE base_salary = VALUES(base_salary), increment = VALUES(increment), final_salary = VALUES(final_salary)");
    $stmt->bind_param("iddd", $supervisor_id, $base_salary, $increment, $final_salary);

    if ($stmt->execute()) {
        $message = "✅ Salary set successfully!";
    } else {
        $message = "❌ Failed to set salary.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Supervisor Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="text-center mb-4">💼 Set Salary for Supervisor</h3>

        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="supervisor_id" class="form-label">Select Supervisor</label>
                <select name="supervisor_id" class="form-select" required>
                    <option value="" disabled selected>Choose Supervisor</option>
                    <?php
                    $supervisors = $conn->query("SELECT id, name FROM supervisors");
                    while ($row = $supervisors->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Base Salary</label>
                <input type="number" name="salary" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="increment" class="form-label">Performance Increment</label>
                <input type="number" name="increment" class="form-control" value="0">
            </div>

            <button type="submit" class="btn btn-success w-100">✅ Set Salary</button>
        </form>

        <div class="text-center mt-4">
            <a href="manager_dashboard.php" class="btn btn-secondary">🔙 Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
