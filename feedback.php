<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_id = $_POST['recipient_id'];
    $recipient_role = $_POST['recipient_role'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];
    $manager_id = $_SESSION['manager_id'];

    if (empty($recipient_id) || empty($recipient_role) || empty($rating) || empty($comments)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        $query = "INSERT INTO feedback (manager_id, recipient_id, recipient_role, rating, comments) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error preparing query: " . $conn->error);
        }

        $stmt->bind_param("iisss", $manager_id, $recipient_id, $recipient_role, $rating, $comments);
        
        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully!'); window.location.href='manager_dashboard.php';</script>";
        } else {
            die("Execution Error: " . $stmt->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Give Feedback</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            width: 100%;
            max-width: 600px;
            transition: 0.3s;
        }
        .card:hover {
            box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 25px;
            text-align: center;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-primary {
            background-color: #4b7bec;
            border: none;
        }
        .btn-primary:hover {
            background-color: #3867d6;
        }
        .btn-secondary {
            background-color: #a5b1c2;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #778ca3;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>📝 Give Feedback</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Select Employee/Supervisor:</label>
            <select name="recipient_id" id="recipient_id" class="form-select" required>
                <option value="">-- Select --</option>
                <?php
                $result = $conn->query("
                    SELECT id, name, 'employee' AS role FROM employees 
                    UNION 
                    SELECT id, name, 'supervisor' AS role FROM supervisors
                ");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}' data-role='{$row['role']}'>{$row['name']} ({$row['role']})</option>";
                }
                ?>
            </select>
            <input type="text" name="recipient_role" id="recipient_role" class="form-control mt-2" placeholder="Role will be selected automatically" readonly>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Rating (1-5):</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Comments:</label>
            <textarea name="comments" class="form-control" rows="4" required></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">✅ Submit Feedback</button>
            <a href="manager_dashboard.php" class="btn btn-secondary">🔙 Back</a>
        </div>
    </form>
</div>

<script>
    document.getElementById("recipient_id").addEventListener("change", function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById("recipient_role").value = selectedOption.getAttribute("data-role");
    });
</script>

</body>
</html>
