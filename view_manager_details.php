<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

$manager_id = $_SESSION['manager_id'];

// Fetch manager details
$query = "SELECT name, email, phone, qualification, experience, date_of_joining FROM managers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
$manager = $result->fetch_assoc();

if (!$manager) {
    die("Manager details not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fce4ec); /* Very light pastel background */
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }
        .details-box {
            background: #ffffff; /* Pure white box inside */
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            animation: fadeIn 0.5s ease-in-out;
        }
        .details-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #00695c;
        }
        .list-group-item {
            background: transparent;
            border: none;
            font-size: 17px;
            padding: 12px 0;
            color: #555;
        }
        .btn-primary {
            background-color: #00796b;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #00695c;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="details-box">
    <h2>👨‍💼 Manager Details</h2>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($manager['name']); ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($manager['email']); ?></li>
        <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($manager['phone']); ?></li>
        <li class="list-group-item"><strong>Qualification:</strong> <?php echo htmlspecialchars($manager['qualification']); ?></li>
        <li class="list-group-item"><strong>Experience:</strong> <?php echo htmlspecialchars($manager['experience']); ?> years</li>
        <li class="list-group-item"><strong>Date of Joining:</strong> <?php echo htmlspecialchars($manager['date_of_joining']); ?></li>
    </ul>
    <div class="text-center">
        <a href="manager_dashboard.php" class="btn btn-primary">🔙 Back to Dashboard</a>
    </div>
</div>

</body>
</html>
