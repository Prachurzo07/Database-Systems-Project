<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khabar Dabar - Cafeteria Management System</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Hind Siliguri', sans-serif;
        }
        
        .bg-container {
            height: 100%;
            background-image: url('images3.png'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;
            height: 100vh; 
            margin: 0; 
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        
        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 400px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }
        
        .login-box::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(to right, #228B22, #FF4500);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .logo {
            max-width: 150px;
        }
        
        .login-form input, .login-form select {
            border-radius: 30px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        
        .login-form input:focus, .login-form select:focus {
            box-shadow: 0 0 0 0.2rem rgba(34, 139, 34, 0.25);
            border-color: #228B22;
        }
        
        .login-form .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            border-radius: 30px 0 0 30px;
        }
        
        .login-form input.form-control, .login-form select.form-control {
            border-left: none;
            border-radius: 0 30px 30px 0;
        }
        
        .btn-login {
            background-color: #228B22;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: #1a661a;
            transform: translateY(-2px);
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #666;
            font-size: 14px;
            text-decoration: none;
        }
        
        .forgot-password a:hover {
            color: #228B22;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 14px;
        }
        
        .login-register {
            margin-top: 15px;
            text-align: center;
        }
        
        .login-register a {
            color: #228B22;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-register a:hover {
            text-decoration: underline;
        }
        
        .language-selector {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .language-selector select {
            border: none;
            background-color: transparent;
            color: #666;
            font-size: 14px;
        }
        
        /* Bangla text styling */
        .bangla-text {
            font-family: 'Hind Siliguri', sans-serif;
        }
        
        @media (max-width: 576px) {
            .login-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-container">
        <div class="language-selector">
            <select class="form-select form-select-sm">
                <option value="en">English</option>
                <option value="bn">বাংলা</option>
            </select>
        </div>
        
        <div class="login-container">
            <div class="login-box">
                <div class="logo-container">
                    <img src="images.png" alt="Khabar Dabar Logo" class="logo">
                    <h3 class="mt-3 bangla-text">খাবার দাবার</h3>
                    <p class="text-muted">Online Cafeteria System</p>
                    <p class="text-muted"> Welcome to Portal</p>
                </div>
                <!-- Add this right before the form -->
                <?php
                if(isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $message = "";
                    
                    switch($error) {
                        case 'invalid_username':
                            $message = "Username does not exist.";
                            break;
                        case 'invalid_password':
                            $message = "Incorrect password.";
                            break;
                        case 'invalid_mobile':
                            $message = "Mobile number does not match.";
                            break;
                        case 'missing_fields':
                            $message = "Please fill in all fields.";
                            break;
                        default:
                            $message = "Login failed. Please try again.";
                    }
                    
                    echo '<div class="alert alert-danger text-center mb-3">' . $message . '</div>';
                }
                ?>


                <form class="login-form" action="login.php" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Username" style="margin: 0;" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Password" style="margin: 0;" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" name="mobile" placeholder="Mobile Number" style="margin: 0;" required>
                    </div>
                    
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select class="form-control" name="role" style="margin: 0;" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="student">user</option>
                            <option value="staff">host</option>
                           
                        </select>
                    </div> -->
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" style="padding: 0;" id="remember">
                                <label class="form-check-label" for="remember">Remember me </label>
                            </div>
                        </div>
                        <div class="col-6 forgot-password">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Login</button>
                    </div>
                    
                    <div class="login-register">
                        <p>Don't have an account? <a href="registration.php">Register</a></p>
                    </div>
                </form>
                
                <div class="login-footer">
                    <p>&copy; 2025 খাবার দাবার. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>