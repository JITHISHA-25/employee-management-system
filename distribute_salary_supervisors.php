<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

$today = date("Y-m-d");
$month = date("F");
$year = date("Y");

$query = "SELECT s.id, s.name, sal.fixed_salary FROM supervisors s
JOIN salaries sal ON s.id = sal.user_id WHERE sal.role = 'supervisor'";

$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $stmt = $conn->prepare("INSERT INTO salary_distributions (user_id, role, distributed_by, amount, distribution_date, month, year) 
                            VALUES (?, 'supervisor', ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdsi", $row['id'], $_SESSION['manager_id'], $row['fixed_salary'], $today, $month, $year);
    $stmt->execute();
}
echo "Salary distributed to all supervisors for $month $year.";
?>
