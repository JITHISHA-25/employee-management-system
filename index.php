<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #0a1a35, #143166);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }
    
    .bg-shapes {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }
    
    .shape {
      position: absolute;
      background-color: rgba(63, 97, 196, 0.1);
      border-radius: 50%;
    }
    
    .shape-1 {
      width: 400px;
      height: 400px;
      top: -200px;
      left: -100px;
    }
    
    .shape-2 {
      width: 300px;
      height: 300px;
      bottom: -150px;
      right: 10%;
    }
    
    .shape-3 {
      width: 200px;
      height: 200px;
      top: 70%;
      left: 5%;
      background-color: rgba(63, 97, 196, 0.05);
      border-radius: 40px;
      transform: rotate(30deg);
    }
    
    .shape-4 {
      width: 100px;
      height: 100px;
      top: 20%;
      right: 20%;
      background-color: rgba(63, 97, 196, 0.07);
      border-radius: 15px;
      transform: rotate(45deg);
    }
    
    .illustration-container {
      position: absolute;
      bottom: 0;
      left: 5%;
      z-index: 1;
      height: 80%;
      max-height: 600px;
      display: flex;
      align-items: flex-end;
    }
    
    .illustration-svg {
      height: 100%;
      width: auto;
    }
    
    .container-wrapper {
      position: relative;
      z-index: 2;
      display: flex;
      justify-content: flex-end;
      width: 100%;
      max-width: 1200px;
      padding-right: 5%;
    }
    
    .container-box {
      background-color: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      padding: 50px;
      width: 90%;
      max-width: 450px;
      text-align: center;
    }
    
    h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: #0a1a35;
      letter-spacing: 0.5px;
    }
    
    p {
      font-size: 1.1rem;
      margin-bottom: 30px;
      color: #4a5568;
    }
    
    .btn-custom {
      padding: 14px 24px;
      font-size: 1rem;
      border: none;
      width: 220px;
      margin: 12px 0;
      transition: all 0.3s ease;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    
    .btn-login {
      background: linear-gradient(90deg, #3182ce, #2c5282);
      color: #fff;
      border-radius: 50px;
    }
    
    .btn-login:hover {
      background: linear-gradient(90deg, #2c5282, #3182ce);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(44, 82, 130, 0.4);
    }
    
    .btn-newuser {
      background: transparent;
      color: #2c5282;
      border: 2px solid #3182ce;
      border-radius: 50px;
    }
    
    .btn-newuser:hover {
      background-color: rgba(49, 130, 206, 0.1);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(44, 82, 130, 0.2);
    }
    
    @media (max-width: 992px) {
      .container-wrapper {
        justify-content: center;
        padding: 0 20px;
      }
      
      .illustration-container {
        opacity: 0.2;
        left: 50%;
        transform: translateX(-50%);
      }
    }
  </style>
</head>
<body>
  <div class="bg-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
  </div>
  
  <div class="illustration-container">
    <svg class="illustration-svg" width="600" height="700" viewBox="0 0 600 700">
      <!-- Business people illustration -->
      <g transform="translate(0,50)">
        <!-- Man with laptop -->
        <ellipse cx="200" cy="500" rx="120" ry="30" fill="#0a1a35" opacity="0.2"/>
        <rect x="180" y="320" width="40" height="180" rx="10" fill="#143166" />
        <rect x="155" y="370" width="90" height="50" rx="5" fill="#3182ce" />
        <circle cx="200" cy="280" r="50" fill="#FFB6C1" />
        <rect x="170" y="260" width="60" height="60" rx="5" fill="#FFB6C1" />
        <rect x="140" y="410" width="30" height="90" rx="10" fill="#143166" />
        <rect x="230" y="410" width="30" height="90" rx="10" fill="#143166" />
        
        <!-- Woman standing -->
        <ellipse cx="350" cy="500" rx="70" ry="20" fill="#0a1a35" opacity="0.2"/>
        <rect x="330" y="320" width="40" height="180" rx="10" fill="#4299e1" />
        <path d="M350 300 L380 370 L320 370 Z" fill="#4299e1" />
        <circle cx="350" cy="260" r="40" fill="#FFDAB9" />
        <rect x="330" y="240" width="40" height="50" rx="5" fill="#FFDAB9" />
        <rect x="320" y="370" width="60" height="130" rx="5" fill="#4299e1" />
        

    </svg>
  </div>
  
  <div class="container-wrapper">
    <div class="container-box">
      <h1>Employee Management System</h1>
      <p>Manage employees, attendance, salaries and more</p>
      <a href="login.php" class="btn btn-login btn-custom">Login</a> <br>
      <a href="new_user.php" class="btn btn-newuser btn-custom">New Employee</a>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</body>
</html>