<?php
session_start();
include('db_connect.php'); // Ensure this file correctly connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check login for Manager
    $stmt = $conn->prepare("SELECT id, name, password FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {  // Replace with password_verify($password, $row['password']) if using hashed passwords
            $_SESSION['manager_id'] = $row['id'];
            $_SESSION['manager_name'] = $row['name'];
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inline CSS Styling -->
    <style>
        body {
            background: linear-gradient(to right, #f8fbff, #e2ebf5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-box {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            font-weight: 700;
            margin-bottom: 25px;
            color: #3b5998;
        }

        .form-control {
            height: 48px;
            border-radius: 8px;
            background-color: #f1f4f8;
            border: 1px solid #ced4da;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #4a69bd;
            box-shadow: 0 0 0 0.2rem rgba(74, 105, 189, 0.25);
        }

        .btn-primary {
            background-color: #4a69bd;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #3b5998;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert-danger {
            border-radius: 8px;
            padding: 10px;
            font-size: 15px;
        }

        .d-flex .btn {
            width: 48%;
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-box">
            <h2 class="text-center">👨‍💼 Manager Login</h2>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">🔙 Back</button>
                    <button type="submit" class="btn btn-primary">🔐 Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
