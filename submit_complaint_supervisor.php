<?php
session_start();
include('db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['supervisor_id'])) {
    header("Location: supervisor_login.php");
    exit();
}

$supervisor_id = $_SESSION['supervisor_id'];
$message = "";

// Handle Complaint Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_text = trim($_POST['complaint_text']);

    if (!empty($complaint_text)) {
        $query = "INSERT INTO complaints (submitted_by_id, submitted_by_role, complaint_text, status, date_submitted) 
                  VALUES (?, 'supervisor', ?, 'Pending', NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $supervisor_id, $complaint_text);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Complaint submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error submitting complaint. Please try again.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Complaint cannot be empty!</div>";
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
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: #ffffff;
            max-width: 600px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        h3 {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .btn-danger {
            background-color: #e63946;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-danger:hover {
            background-color: #d62828;
        }
        .btn-secondary {
            margin-top: 15px;
            background-color: #6c757d;
            transition: background-color 0.3s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        textarea.form-control {
            resize: none;
            border-radius: 8px;
        }
        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
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
            <textarea name="complaint_text" class="form-control" rows="5" placeholder="Describe your complaint..." required></textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100">Submit Complaint</button>
    </form>

    <a href="supervisor_dashboard.php" class="btn btn-secondary w-100">🔙 Back to Dashboard</a>
</div>

</body>
</html>
