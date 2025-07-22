<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];
$date = date("Y-m-d");

// Check if attendance already exists for today
$checkQuery = "SELECT status FROM attendance WHERE employee_id = ? AND date = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("is", $employee_id, $date);
$stmt->execute();
$result = $stmt->get_result();
$attendance = $result->fetch_assoc();
$alreadyMarked = ($attendance !== null);

// Handle Attendance Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$alreadyMarked) {
    $status = $_POST['attendance_status'];

    // Validate attendance status
    $valid_statuses = ["Present", "Absent", "On Duty Leave"];
    if (!in_array($status, $valid_statuses)) {
        echo "<script>alert('Invalid attendance status!'); window.location.href='mark_attendance.php';</script>";
        exit();
    }

    // Insert attendance record
    $insertQuery = "INSERT INTO attendance (employee_id, date, status, verified_by_supervisor) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $employee_id, $date, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance marked successfully!'); window.location.href='mark_attendance.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error marking attendance. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .attendance-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #00796b;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            color: #555;
        }
        .btn-submit {
            background-color:rgb(94, 228, 105);
            border: none;
        }
        .btn-submit:hover {
            background-color: #004d40;
        }
        .btn-back {
            margin-top: 15px;
            background-color: #78909c;
            border: none;
        }
        .btn-back:hover {
            background-color: #546e7a;
        }
        .status-message {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 20px;
            color: #388e3c;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="attendance-container">
    <h3>📅 Mark Attendance</h3>
    <hr>

    <?php if ($alreadyMarked): ?>
        <div class="status-message">
            ✅ Attendance already marked as <strong><?php echo htmlspecialchars($attendance['status']); ?></strong> for today!
        </div>
    <?php else: ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="attendance_status" class="form-select" required>
                    <option value="Present">✅ Present</option>
                    <option value="Absent">❌ Absent</option>
                    <option value="On Duty Leave">🟡 On Duty Leave</option>
                </select>
            </div>

            <button type="submit" class="btn btn-submit w-100">Submit Attendance</button>

        </form>
    <?php endif; ?>

    <a href="employee_dashboard.php" class="btn btn-back w-100">🔙 Back to Dashboard</a>
</div>

</body>
</html>
