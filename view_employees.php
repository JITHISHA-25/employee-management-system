<?php
session_start();
include('db_connect.php');

// Redirect if not logged in as Manager
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Handle Delete Employee Request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Employee deleted successfully!'); window.location.href='view_employees.php';</script>";
    } else {
        echo "<script>alert('Error deleting employee!');</script>";
    }
}

// Fetch Employee Details
$query = "SELECT e.id, e.name, e.email, e.phone, e.qualification, e.experience, e.age, 
                 IFNULL(d.department_name, 'HUMAN RESOURCES') AS department_name, 
                 IFNULL(s.name, 'Bob Smith') AS supervisor_name 
          FROM employees e
          LEFT JOIN departments d ON e.department_id = d.id
          LEFT JOIN supervisors s ON e.supervisor_id = s.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #fce4ec);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 1200px;
            animation: fadeIn 0.5s ease-in-out;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #00796b;
        }
        .table th {
            background: #80deea;
            color: #004d40;
            text-transform: uppercase;
            font-size: 14px;
        }
        .table td {
            vertical-align: middle;
            font-size: 15px;
            color: #555;
        }
        .btn-danger {
            background-color: #e53935;
            border: none;
            padding: 5px 15px;
            font-size: 14px;
            border-radius: 6px;
        }
        .btn-danger:hover {
            background-color: #c62828;
        }
        .btn-secondary {
            background-color: #00897b;
            border: none;
            margin-top: 20px;
            padding: 10px 25px;
            border-radius: 8px;
            font-size: 16px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-secondary:hover {
            background-color: #00695c;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="container">
    <h2>👥 Employee Details</h2>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Qualification</th>
                    <th>Experience</th>
                    <th>Age</th>
                    <th>Department</th>
                    <th>Supervisor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                    <td><?php echo htmlspecialchars($row['experience']); ?> years</td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['supervisor_name']); ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this employee?');">❌ Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="manager_dashboard.php" class="btn btn-secondary">🔙 Back to Dashboard</a>
</div>

</body>
</html>
