<?php
session_start();
include('db_connect.php');

// Redirect if not logged in
if (!isset($_SESSION['supervisor_id'])) {
    header("Location: supervisor_login.php");
    exit();
}

$supervisor_id = $_SESSION['supervisor_id'];

// Fetch feedback including date and time
$feedback_query = "SELECT comments AS feedback_text, rating, created_at FROM feedback WHERE recipient_id = ? AND recipient_role = 'supervisor' ORDER BY created_at DESC";

$stmt = $conn->prepare($feedback_query);
$stmt->bind_param("i", $supervisor_id);
$stmt->execute();
$feedback_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback - Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: #dfefff; /* Light pastel blue background */
            min-height: 100vh;
            padding: 30px 0;
            font-family: 'Poppins', sans-serif;
        }
        .container { 
            max-width: 600px; 
            background: white; 
            padding: 25px; 
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1); 
            border-radius: 15px; 
        }
        .feedback-box { 
            background: #fff7d6; /* Soft yellow background inside box */
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 8px;
            border: 1px solid #ffe58f;
        }
        .rating-stars { 
            color: #ffc107; /* Gold color for stars */
        }
        .timestamp { 
            font-size: 0.9em; 
            color: #777; 
        }
        h3 {
            font-weight: bold;
            color: #333;
        }
        .btn-secondary {
            font-weight: bold;
            font-size: 16px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">⭐ Feedback from Manager</h3>
    <hr>

    <?php if ($feedback_result->num_rows > 0): ?>
        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
            <div class="feedback-box">
                <p><strong>Feedback:</strong> <?php echo htmlspecialchars($feedback['feedback_text']); ?></p>
                <p><strong>Rating:</strong> <?php echo str_repeat("⭐", $feedback['rating']); ?></p>
                <p class="timestamp"><strong>Date & Time:</strong> <?php echo date("d-m-Y h:i A", strtotime($feedback['created_at'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">No feedback available.</p>
    <?php endif; ?>

    <a href="supervisor_dashboard.php" class="btn btn-secondary w-100 mt-3">🔙 Back to Dashboard</a>
</div>

</body>
</html>
