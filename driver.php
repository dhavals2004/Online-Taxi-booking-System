<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            color: white;
        }

        .Drivertop {
            background-color: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .Drivertop img {
            height: 60px;
        }

        .Drivertop a {
            color: #f2f2f2;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px; 
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .Drivertop a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            
        }

        .home_container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
        
        }

        .abcde {
            display: flex;
            background-color:bisque;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
            max-width: 1000px;
            align-items: center;
            text-align: left;
        }

        .picd {
            margin-right: 30px;
        }

        .picd2 {
            width: 700px;
            height: auto;
            border-radius: 30px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .text {
            flex: 1;
            margin: 0;
            padding: 0;
            font-size: 1.2em;
            font-weight: bold;
            font-family: 'Times New Roman';
            line-height: 1.5;
            color: black;
        }

        .text p {
            margin-bottom: 10px;
        }

        .abcd {
            background-color: #ff9100;
            color:black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .abcd:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: black;
            padding: 10px;
            text-align: center;
            color: white;
            width: 100%;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <div class="Drivertop">
        <img src="final logo.jpg" width="150" height="70" alt="Logo">

        <div>
            <a href="Driver login.php">Login</a>
            <a href="Driver Signup.php">Signup</a>
            <a href="contact.html">Contact Us</a>
        </div>
    </div>

    <div class="home_container">
        <div class="abcde">
            <div class="picd">
                <img src="Admin.webp" class="picd2" alt="Driver Image">
            </div>

            <div class="text">
                <p>Drive when you</p>
                <p>want, make what</p>
                <p>you need...</p>
                <p>Earn on your own schedule</p>
                <button class="abcd">Get Started</button>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Your Taxi Service. All rights reserved.</p>
        <p>Developed By: <a href="mailto:dhavalsatasiya7@gmail.com">Dhaval07</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>