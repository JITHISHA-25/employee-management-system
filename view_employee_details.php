<?php
session_start();
include('db_connect.php'); 

// Redirect if not logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: employee_login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

// Fetch Employee Details
$query = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background: #e8f0fe; 
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.5px;
        }
        .container { 
            max-width: 600px; 
            margin: auto; 
            margin-top: 50px; 
            padding: 30px; 
            background: #ffffff; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.1); 
            border-radius: 12px;
        }
        h3 {
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
        }
        .details {
            margin-top: 20px;
        }
        .detail-item {
            font-size: 16px;
            color: #444;
            margin-bottom: 15px;
            display: flex;
            align-items: baseline;
        }
        .detail-item strong {
            width: 150px;
            color: #222;
            font-weight: 600;
            letter-spacing: 0.7px;
        }
        .detail-item span {
            margin-left: 8px;
            color: #555;
            font-weight: 400;
        }
        .btn-back {
            margin-top: 30px;
            background-color: #6c757d;
            border: none;
            padding: 10px 22px;
            font-weight: 500;
            transition: background 0.3s;
            letter-spacing: 0.5px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">👤 Employee Details</h3>
    <hr>
    <div class="details">
        <div class="detail-item"><strong>Name:</strong> <span><?php echo htmlspecialchars($employee['name']); ?></span></div>
        <div class="detail-item"><strong>Email:</strong> <span><?php echo htmlspecialchars($employee['email']); ?></span></div>
        <div class="detail-item"><strong>Phone:</strong> <span><?php echo htmlspecialchars($employee['phone']); ?></span></div>
        <div class="detail-item"><strong>Qualification:</strong> <span><?php echo htmlspecialchars($employee['qualification']); ?></span></div>
        <div class="detail-item"><strong>Experience:</strong> <span><?php echo htmlspecialchars($employee['experience']); ?></span></div>
        <div class="detail-item"><strong>Age:</strong> <span><?php echo htmlspecialchars($employee['age']); ?></span></div>
    </div>
    
    <a href="employee_dashboard.php" class="btn btn-secondary btn-back">🔙 Back to Dashboard</a>
</div>

</body>
</html>
