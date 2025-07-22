<?php
session_start();
include('db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['employee_id']) && !isset($_SESSION['supervisor_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$submitted_by_role = "";
$submitted_by_id = 0;

// Determine who is submitting the complaint
if (isset($_SESSION['employee_id'])) {
    $submitted_by_role = 'employee';
    $submitted_by_id = $_SESSION['employee_id'];
} elseif (isset($_SESSION['supervisor_id'])) {
    $submitted_by_role = 'supervisor';
    $submitted_by_id = $_SESSION['supervisor_id'];
}

// Handle Complaint Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_text = trim($_POST['complaint_text']);

    if (!empty($complaint_text)) {
        $query = "INSERT INTO complaints (submitted_by_role, submitted_by_id, complaint_text, status, date_submitted) 
                  VALUES (?, ?, ?, 'Pending', NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sis", $submitted_by_role, $submitted_by_id, $complaint_text);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>✅ Complaint submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>❌ Error submitting complaint. Please try again.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>⚠️ Complaint cannot be empty!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right,rgb(196, 185, 245), #e9ecef);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin: 30px 15px;
        }
        h3 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #343a40;
        }
        hr {
            margin-bottom: 30px;
            color: #dee2e6;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        textarea.form-control {
            border-radius: 8px;
            resize: none;
        }
        button.btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            font-size: 16px;
        }
        button.btn-danger:hover {
            background-color: #c82333;
        }
        a.btn-secondary {
            border-radius: 8px;
            margin-top: 15px;
            padding: 10px;
            font-weight: 500;
            font-size: 16px;
        }
        a.btn-secondary:hover {
            background-color: #6c757d;
        }
        .alert {
            border-radius: 8px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">📢 Submit a Complaint</h3>
    <hr>

    <?php echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your Complaint:</label>
            <textarea name="complaint_text" class="form-control" rows="4" placeholder="Write your complaint here..." required></textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100">✉️ Submit Complaint</button>
    </form>

    <?php if ($submitted_by_role == "employee"): ?>
        <a href="employee_dashboard.php" class="btn btn-secondary w-100 mt-3">🔙 Back to Dashboard</a>
    <?php else: ?>
        <a href="supervisor_dashboard.php" class="btn btn-secondary w-100 mt-3">🔙 Back to Dashboard</a>
    <?php endif; ?>
</div>

</body>
</html>
