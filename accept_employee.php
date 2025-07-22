<?php
include('db_connect.php');

if (isset($_POST['approve'])) {
    $id = $_POST['id'];

    $fetchQuery = "SELECT * FROM pending_employees WHERE id=?";
    $stmt = $conn->prepare($fetchQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $tempUsername = "pending_" . $id;

        $insertQuery = "INSERT INTO employees (name, username, email, phone, qualification, experience, age)  
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssis", 
            $row['name'], 
            $tempUsername,
            $row['email'], 
            $row['phone'], 
            $row['qualification'], 
            $row['experience'], 
            $row['age']
        );

        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM pending_employees WHERE id=?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            echo "<script>alert('Employee approved! Manager must assign a username/password manually.'); 
            window.location.href='accept_employee.php';</script>";
        } else {
            echo "<script>alert('Error approving employee.');</script>";
        }
    }
}

if (isset($_POST['reject'])) {
    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM pending_employees WHERE id=?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Employee application rejected!'); window.location.href='accept_employee.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve New Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 1000px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        h2 {
            font-weight: 700;
            color: #333;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .btn-success, .btn-danger {
            width: 80px;
        }
        .btn-success:hover {
            background-color: #28a745;
        }
        .btn-danger:hover {
            background-color: #dc3545;
        }
        .back-btn {
            margin-top: 25px;
        }
        .back-btn a {
            background-color: #6c757d;
            border: none;
        }
        .back-btn a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📋 Approve New Employees</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col">👩‍💼 Name</th>
                    <th scope="col">📧 Email</th>
                    <th scope="col">📱 Phone</th>
                    <th scope="col" class="text-center">⚡ Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM pending_employees");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td class='text-center'>
                                    <form method='post' class='d-inline'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='approve' class='btn btn-success btn-sm'>✔ Approve</button>
                                        <button type='submit' name='reject' class='btn btn-danger btn-sm'>✖ Reject</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-muted'>No pending applications.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="text-center back-btn">
        <a href="manager_dashboard.php" class="btn btn-secondary btn-lg">🔙 Back to Dashboard</a>
    </div>
</div>

</body>
</html>
