
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 350px;
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn {
            background: #00c6ff;
            color: #fff;
        }

        .register-btn {
            background: #00ff99;
            color: #333;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .social-links {
            margin-top: 25px;
        }

        .social-links a {
            color: #fff;
            margin: 0 10px;
            font-size: 20px;
            transition: 0.3s;
        }

        .social-links a:hover {
            color: #00ffcc;
            transform: scale(1.2);
        }

        .contact-btn {
            margin-top: 20px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .contact-btn:hover {
            background: #fff;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>User Management</h1>
        <p>Secure Login & Registration System</p>

        <button class="btn login-btn" onclick="login()">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>

        <button class="btn register-btn" onclick="register()">
            <i class="fas fa-user-plus"></i> Register
        </button>

        <div class="social-links">
            <a href="#"><i class="fab fa-github"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="https://wa.me/916398428250?text=Hello Visit The User Management System"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

    <script>
        function login() {
             window.location.href = "User%20Management%20System/User/index.php";
        }

        function register() {
            window.location.href = "User%20Management%20System/User/index.php";
        }

        function contact() {
            alert("Contact Page / Popup Open Karega");
        }
    </script>

</body>
</html>
