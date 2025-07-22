<?php
include('db_connect.php');

$role = $_GET['role'] ?? '';
$name = $_GET['name'] ?? '';

if (!$role || !$name) {
    echo "Invalid access.";
    exit;
}

if ($role == 'employee') {
    $stmt = $conn->prepare("SELECT name, email, phone, qualification, experience FROM employees WHERE name = ?");
} else {
    $stmt = $conn->prepare("SELECT name, email, phone, qualification, experience FROM supervisors WHERE name = ?");
}
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h3 class="text-center">👁 User Details</h3>
        <table class="table table-bordered mt-4">
            <?php foreach ($user as $key => $value): ?>
                <tr>
                    <th><?php echo ucfirst($key); ?></th>
                    <td><?php echo htmlspecialchars($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="text-center">
            <a href="set_salaries.php" class="btn btn-primary">← Back</a>
        </div>
    </div>
</body>
</html>
