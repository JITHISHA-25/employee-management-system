<?php include('db_connect.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];
    $age = $_POST['age'];
    
    $query = "INSERT INTO pending_employees (name, email, phone, qualification, experience, age)
               VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssii", $name, $email, $phone, $qualification, $experience, $age);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration done successfully! Awaiting manager approval.');
                window.location.href='index.php';
              </script>";
    } else {
        echo "<script>alert('Error submitting application. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>New User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      background: linear-gradient(135deg, #8BC6EC 0%, #9599E2 100%);
      font-family: 'Segoe UI', sans-serif;
      color: #333;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .form-container {
      width: 85%;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      padding: 25px;
      margin: 15px auto;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
    
    .form-control {
      background-color: #f9f9f9;
      border: 1px solid #e1e1e1;
      padding: 8px 10px;
      border-radius: 8px;
      font-size: 14px;
    }
    
    .form-control:focus {
      border-color: #6a11cb;
      box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.2);
    }
    
    h2 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
      color: #6a11cb;
      font-size: 1.5rem;
    }
    
    .btn-primary {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      border: none;
      font-weight: 500;
      padding: 8px;
      font-size: 15px;
      border-radius: 8px;
    }
    
    .btn-outline-secondary {
      font-weight: 500;
      color: #6a11cb;
      border: 1px solid #6a11cb;
      padding: 8px;
      font-size: 15px;
      border-radius: 8px;
    }
    
    .btn-primary:hover {
      background: linear-gradient(to right, #5710a7, #1e60c8);
    }
    
    .input-group {
      position: relative;
      margin-bottom: 15px;
    }
    
    .input-icon {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #6a11cb;
      font-size: 14px;
    }
    
    .icon-input {
      padding-left: 32px;
    }
    
    .success-message {
      display: none;
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4CAF50;
      color: white;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: 500;
      font-size: 14px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
      z-index: 1000;
      animation: fadeInOut 4s ease;
    }
    
    @keyframes fadeInOut {
      0% { opacity: 0; }
      10% { opacity: 1; }
      80% { opacity: 1; }
      100% { opacity: 0; }
    }
    
    .title-icon {
      margin-right: 6px;
      color: #6a11cb;
    }
  </style>
</head>
<body>
  
  <div class="form-container">
    <h2><i class="fas fa-user-plus title-icon"></i>Registration</h2>
    <form method="post" id="registrationForm">
      <div class="input-group">
        <i class="fas fa-user input-icon"></i>
        <input type="text" name="name" class="form-control icon-input" placeholder="Full Name" required />
      </div>
      <div class="input-group">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" name="email" class="form-control icon-input" placeholder="Email" required />
      </div>
      <div class="input-group">
        <i class="fas fa-phone input-icon"></i>
        <input type="text" name="phone" class="form-control icon-input" placeholder="Phone Number" required />
      </div>
      <div class="input-group">
        <i class="fas fa-graduation-cap input-icon"></i>
        <input type="text" name="qualification" class="form-control icon-input" placeholder="Qualification" required />
      </div>
      <div class="input-group">
        <i class="fas fa-briefcase input-icon"></i>
        <input type="number" name="experience" class="form-control icon-input" placeholder="Experience (years)" required />
      </div>
      <div class="input-group">
        <i class="fas fa-birthday-cake input-icon"></i>
        <input type="number" name="age" class="form-control icon-input" placeholder="Age" required />
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-2">
        <i class="fas fa-check-circle me-1"></i>Apply
      </button>
      <a href="index.php" class="btn btn-outline-secondary w-100">
        <i class="fas fa-arrow-left me-1"></i>Back
      </a>
    </form>
  </div>
  
  <div id="successMessage" class="success-message">
    <i class="fas fa-check-circle me-1"></i>Registration successful!
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
      const successMessage = document.getElementById('successMessage');
      successMessage.style.display = 'block';
      
      setTimeout(function() {
        successMessage.style.display = 'none';
      }, 4000);
    });
  </script>
</body>
</html>