<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation Bar */
        .topnav {
            background:black;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .topnav img {
            height: 50px;
        }

        .topnav a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 18px;
            transition: 0.3s;
            border-radius: 5px;
        }

        .topnav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .container {
            
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding-top: 120px;
            flex-direction: column;
        }

        .container h2 {
            font-size: 28px;
            color: #007bff;
            margin-bottom: 5x;
        }

        .container p {
            font-size: 18px;
            color: #555;
        }

        /* Image Section */
        .admin-image {
            margin-top:20px;
            text-align: center;
        }

        .admin-image img {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color:black;
            padding: 10px;
            text-align: center;
            color: white;
            width: 100%;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <div class="topnav">
        <img src="final logo.jpg" alt="Logo">
        <div>
            <a href="Admin Login.php">Login</a>
            <a href="Admin signup.php">Signup</a>
            <a href="contact.html">Contact Us</a>
        </div>
    </div>

    <div class="container">
        <h2>Welcome, Admin</h2>
        <p>Login to manage your system efficiently.</p>
    </div>

    
    <div class="admin-image">
        <img src="yy.avif" alt="Admin Dashboard">
    </div>

    <footer>
        <p>&copy; 2025 Your Taxi Service. All rights reserved.</p>
        <p>Developed By: <a href="mailto:dhavalsatasiya7@gmail.com">Dhaval07</a></p>
    </footer>

</body>
</html>
