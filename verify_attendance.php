<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['supervisor_id'])) {
    header("Location: supervisor_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendance_id = $_POST['attendance_id'];
    $new_status = $_POST['attendance_status'];

    $updateQuery = "UPDATE attendance SET status = ?, verified_by_supervisor = 1 WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $new_status, $attendance_id);
    if ($stmt->execute()) {
        echo "<script>alert('Attendance updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating attendance!');</script>";
    }
}

$fetchQuery = "SELECT a.id, e.name, a.date, a.status FROM attendance a 
               JOIN employees e ON a.employee_id = e.id 
               WHERE a.verified_by_supervisor = 0";
$result = $conn->query($fetchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0e0e0;
            min-height: 100vh;
            padding: 30px 0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
            padding: 20px;
        }
        h2 {
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .form-select {
            font-size: 15px;
        }
        .btn-primary {
            font-weight: 600;
            padding: 8px 16px;
            font-size: 15px;
            border-radius: 8px;
        }
        .btn-secondary {
            font-weight: 600;
            margin-top: 30px;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 10px;
        }
        .back-btn {
            margin-top: 30px;
            text-align: center;
        }
        .table {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🗓️ Verify Attendance</h2>
        <div class="card shadow">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Current Status</th>
                        <th>New Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form method="POST" class="d-flex flex-column align-items-center">
                                    <input type="hidden" name="attendance_id" value="<?php echo $row['id']; ?>">
                                    <select name="attendance_status" class="form-select">
                                        <option value="Present">✅ Present</option>
                                        <option value="Absent">❌ Absent</option>
                                        <option value="On Duty Leave">📝 On Duty Leave</option>
                                    </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="back-btn">
                <a href="supervisor_dashboard.php" class="btn btn-secondary">🔙 Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
