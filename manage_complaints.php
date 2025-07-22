<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Resolve Complaint
if (isset($_GET['resolve_id'])) {
    $resolve_id = intval($_GET['resolve_id']);
    $update_query = "UPDATE complaints SET status = 'Resolved' WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $resolve_id);
    if ($stmt->execute()) {
        echo "<script>alert('Complaint resolved successfully!'); window.location.href='manage_complaints.php';</script>";
    } else {
        echo "<script>alert('Error resolving complaint.');</script>";
    }
}

// Fetch Complaints
$query = "SELECT c.id, c.submitted_by_role, c.submitted_by_id, c.complaint_text, c.date_submitted, c.status,
          CASE 
            WHEN c.submitted_by_role = 'employee' THEN e.name 
            WHEN c.submitted_by_role = 'supervisor' THEN s.name 
            ELSE 'Unknown' 
          END AS submitted_by_name
          FROM complaints c
          LEFT JOIN employees e ON c.submitted_by_role = 'employee' AND c.submitted_by_id = e.id
          LEFT JOIN supervisors s ON c.submitted_by_role = 'supervisor' AND c.submitted_by_id = s.id
          WHERE c.status = 'Pending'";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
            min-height: 100vh;
            padding: 30px;
        }
        .container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 0 auto;
        }
        h2 {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .table {
            margin-top: 10px;
            background: #fafafa;
        }
        .table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
        }
        .btn-resolve {
            background: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-resolve:hover {
            background: #218838;
        }
        .btn-back {
            background: #6c757d;
            color: white;
            border-radius: 6px;
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .btn-back:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">📢 Manage Complaints</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>From</th>
                <th>Complaint</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo ucfirst($row['submitted_by_role']) . ": " . htmlspecialchars($row['submitted_by_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['complaint_text']); ?></td>
                        <td><?php echo isset($row['date_submitted']) ? $row['date_submitted'] : 'Not Available'; ?></td>
                        <td>
                            <a href="?resolve_id=<?php echo $row['id']; ?>" class="btn btn-resolve">Resolve</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No pending complaints.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="manager_dashboard.php" class="btn btn-back">🔙 Back to Dashboard</a>
</div>

</body>
</html>
