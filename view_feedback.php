<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['employee_id']) && !isset($_SESSION['supervisor_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['employee_id'] ?? $_SESSION['supervisor_id'];
$role = isset($_SESSION['employee_id']) ? 'employee' : 'supervisor';

$query = "SELECT f.rating, f.comments, m.name AS manager_name, f.created_at 
          FROM feedback f 
          JOIN managers m ON f.manager_id = m.id 
          WHERE f.recipient_id = ? AND f.recipient_role = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $role);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feedback</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 60px;
        }
        .card {
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .table {
            margin-bottom: 0;
        }
        thead {
            background-color: #0d6efd;
            color: white;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #6c757d;
            color: white;
            width: 100%;
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
        <h2 class="text-center">📝 Your Feedback</h2>
        <div class="card p-4">
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Manager</th>
                            <th>Rating</th>
                            <th>Comments</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['manager_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['rating']); ?> ⭐</td>
                                <td><?php echo htmlspecialchars($row['comments']); ?></td>
                                <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['created_at']))); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center p-3">
                    <p class="text-muted">No feedback received yet.</p>
                </div>
            <?php endif; ?>
            <a href="employee_dashboard.php" class="btn btn-back">🔙 Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
