<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Employee Management System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f9f9f9, #e0f7fa, #e0f2f1); /* Light pastel background */
      color: #333333;
    }
    
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    
    .login-card {
      background-color: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(5px);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      width: 100%;
      max-width: 420px;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .login-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
      background: linear-gradient(to right, #00c6ff, #0072ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    .login-subtitle {
      font-size: 1.1rem;
      color: #555555;
      margin-bottom: 30px;
    }
    
    .role-btn {
      position: relative;
      padding: 16px;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 12px;
      margin-bottom: 15px;
      border: none;
      transition: all 0.3s ease;
      text-align: left;
      padding-left: 60px;
    }
    
    .role-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    
    .role-btn .icon {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.4rem;
    }
    
    .manager-btn {
      background: linear-gradient(135deg, #aed9e0, #89c2d9);
      color: #003049;
    }
    
    .supervisor-btn {
      background: linear-gradient(135deg, #ffe0ac, #ffc482);
      color: #6b3e26;
    }
    
    .employee-btn {
      background: linear-gradient(135deg, #dcedc8, #a8e6cf);
      color: #2e7d32;
    }
    
    .back-btn {
      background: transparent;
      border: 1px solid #ccc;
      color: #555;
      border-radius: 12px;
      padding: 12px;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    
    .back-btn:hover {
      background-color: #f0f0f0;
      border-color: #999;
    }
    
    @media (max-width: 480px) {
      .login-card {
        padding: 30px 20px;
      }
      
      .role-btn {
        padding: 14px 14px 14px 50px;
      }
      
      .role-btn .icon {
        left: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1 class="login-title"><i class="fas fa-lock"></i> Login</h1>
        <p class="login-subtitle">Select your role to access the system</p>
      </div>
      
      <div class="role-buttons">
        <a href="manager_login.php" class="btn role-btn manager-btn d-block">
          <span class="icon"><i class="fas fa-user-tie"></i></span>
          Manager
        </a>
        
        <a href="supervisor_login.php" class="btn role-btn supervisor-btn d-block">
          <span class="icon"><i class="fas fa-user-cog"></i></span>
          Supervisor
        </a>
        
        <a href="employee_login.php" class="btn role-btn employee-btn d-block">
          <span class="icon"><i class="fas fa-user"></i></span>
          Employee
        </a>
      </div>
      
      <!-- Back Button -->
      <a href="index.php" class="btn back-btn d-block">
        <i class="fas fa-arrow-left"></i> Back to Home
      </a>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
