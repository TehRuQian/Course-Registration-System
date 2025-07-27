<?php 
   error_reporting(E_ALL);
   ini_set('display_errors', 1);

include 'headermain.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Registration System</title>
    <style>
        .top-half {
            height: 60vh; 
            background: url('img/login_bg2.jpg') center top no-repeat; 
            background-size: cover; 

        }

        .bottom-half {
            height: 40vh; 
            background: white; 
        }
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
        }

        .top {
            padding: 2rem 0;
            text-align: center;
        }

        .login-container {
            width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.5rem;
            font-style: normal;
            font-weight: bold;
            color: white;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        h4 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-floating {
            margin-bottom: 1.2rem;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.8rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25);
        }

        .btn-primary {
            background: #764ba2;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 2rem;
            color: white;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #667eea;
            transform: translateY(-2px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #764ba2;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #667eea;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="top-half" >
        <div style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 3rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); font-weight: bold;">
            Course Registration System
        </div>
        <div class="login-container" style="margin-top: 250px;">
            <div class="container">
                <h4 class="text-center">Log In</h4>
                <form method="post" action="login_process.php">
                    <div class="form-floating">
                        <input type="text" name="uid" class="form-control" id="floatingInput" placeholder="User ID" required>
                        <label for="floatingInput">User ID</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="u_pwd" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
                    <div class="forgot-password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>