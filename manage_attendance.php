<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Fetch final verified attendance records
$fetchQuery = "SELECT e.name, a.date, a.status FROM attendance a 
               JOIN employees e ON a.employee_id = e.id 
               WHERE a.verified_by_supervisor = 1";
$result = $conn->query($fetchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1000px;
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 30px;
        }
        table {
            margin-top: 20px;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #6c757d;
            border: none;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
        }
        .present {
            background-color: #28a745;
            color: white;
        }
        .absent {
            background-color: #dc3545;
            color: white;
        }
        .on-duty {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">📋 Manage Employee Attendance</h2>

    <div class="card">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>
                            <?php
                                $status = $row['status'];
                                $badgeClass = '';
                                if ($status == 'Present') {
                                    $badgeClass = 'present';
                                } elseif ($status == 'Absent') {
                                    $badgeClass = 'absent';
                                } elseif ($status == 'On Duty Leave') {
                                    $badgeClass = 'on-duty';
                                }
                            ?>
                            <span class="status-badge <?php echo $badgeClass; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <a href="manager_dashboard.php" class="btn btn-back btn-lg">🔙 Back to Dashboard</a>
    </div>
</div>

</body>
</html>
