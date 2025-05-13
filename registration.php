<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>খাবার দাবার - Registration</title>
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
            background-image: url('image2.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center;
            height: 100vh; 
            margin: 0; 
        }
        
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        
        .register-box {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
            padding: 25px;
            max-width: 450px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }
        
        .register-box::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, #228B22, #FF4500);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .logo {
            max-width: 100px;
        }
        
        .register-form input, .register-form select {
            border-radius: 30px;
            padding: 10px 20px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            background-color: #ffffff;
        }
        
        .register-form input:focus, .register-form select:focus {
            box-shadow: 0 0 0 0.2rem rgba(34, 139, 34, 0.25);
            border-color: #228B22;
        }
        
        .register-form .input-group-text {
            background-color: #ffffff;
            border-right: none;
            border-radius: 30px 0 0 30px;
        }
        
        .register-form input.form-control, .register-form select.form-control {
            border-left: none;
            border-radius: 0 30px 30px 0;
        }
        
        .btn-register {
            background-color: #228B22;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: #1a661a;
            transform: translateY(-2px);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 12px;
        }
        
        .login-link {
            margin-top: 12px;
            text-align: center;
        }
        
        .login-link a {
            color: #228B22;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
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
        
        .form-text {
            font-size: 12px;
            color: #666;
        }
        
        @media (max-width: 576px) {
            .register-box {
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
        
        <div class="register-container">
            <div class="register-box">
                <div class="logo-container">
                    <img src="images.png" alt="খাবার দাবার Logo" class="logo">
                    <h3 class="mt-3 bangla-text">খাবার দাবার</h3>
                    <p class="text-muted">Online Cafeteria System</p>
                    <p class="text-muted">Create Your Account</p>
                </div>
                
                <form class="register-form" action="insert_user.php" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Username" style="margin: 0;" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="Password" placeholder="Password" style="margin: 0;" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="Confirm_Password" placeholder="Confirm Password" style="margin: 0;" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" name="mobile" placeholder="Mobile Number (11 digits)" pattern="[0-9]{11}" style="margin: 0;" required>
                    </div>
                    <div class="mb-3">
                        <small class="form-text">Mobile number must be 11 digits</small>
                    </div>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select class="form-control" name="role" style="margin: 0;" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="user">user</option>
                            <option value="host">host</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" style="padding: 0;" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-register">Register</button>
                    </div>
                    
                    <div class="login-link">
                        <p>Already have an account? <a href="firstpage.php">Login</a></p>
                    </div>
                </form>
                
                <div class="register-footer">
                    <p>&copy; 2025 খাবার দাবার. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS from CDN -->
    <script>
        // Form validation for password match and mobile number
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.register-form');
            
            form.addEventListener('submit', function(event) {
                const password = document.getElementById('Password').value;
                const confirmPassword = document.querySelector('input[name="Confirm_Password"]').value;
                const mobileNumber = document.querySelector('input[name="Mobile"]').value;
                
                // Check if passwords match
                if (password !== confirmPassword) {
                    event.preventDefault();
                    alert('Passwords do not match. Please try again.');
                    return;
                }
                
                // Check if mobile number is exactly 11 digits
                if (mobileNumber.length !== 11 || !/^\d+$/.test(mobileNumber)) {
                    event.preventDefault();
                    alert('Mobile number must be exactly 11 digits.');
                    return;
                }
                
                // Check if role is selected
                const role = document.querySelector('select[name="role"]').value;
                if (!role) {
                    event.preventDefault();
                    alert('Please select a role.');
                    return;
                }
            });
        });
    </script>
</body>
</html>