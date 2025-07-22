<?php
session_start();
include('db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['supervisor_id'])) {
    header("Location: supervisor_login.php");
    exit();
}

$supervisor_id = $_SESSION['supervisor_id'];

// Fetch Supervisor Details
$query = "SELECT name, email, phone, qualification, experience, date_of_joining FROM supervisors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $supervisor_id);
$stmt->execute();
$result = $stmt->get_result();
$supervisor = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0e0e0; /* Slightly darker grey */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 15px;
        }
        .details-card {
            margin-top: 20px;
        }
        h3, h4 {
            font-weight: 600;
            color: #333;
        }
        p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }
        .btn-secondary {
            margin-top: 25px;
            font-weight: 600;
            padding: 10px;
            font-size: 16px;
        }
        hr {
            border-top: 2px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">Supervisor Details</h3>
    <h4 class="text-center text-muted">Human Resources</h4>
    <hr>

    <div class="details-card">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($supervisor['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($supervisor['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($supervisor['phone']); ?></p>
        <p><strong>Qualification:</strong> <?php echo htmlspecialchars($supervisor['qualification']); ?></p>
        <p><strong>Experience:</strong> <?php echo htmlspecialchars($supervisor['experience']); ?> years</p>
        <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($supervisor['date_of_joining']); ?></p>
    </div>

    <a href="supervisor_dashboard.php" class="btn btn-secondary w-100">🔙 Back to Dashboard</a>
</div>

</body>
</html>
