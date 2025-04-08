<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Overlay to improve readability */
        .overlay {
             /* background: rgba(0, 0, 0, 0.6); */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Navigation Bar */
        .topnav {
            background: black;
            padding: 10px 20px;
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
            height: 60px;
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

        /* Main Container */
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding-top: 120px;
        }

        .search {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            width: 350px;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Input and Select Styling */
        .search label {
            /* display: block; */
            font-size: 16px;
            margin: 10px 0 5px;
            text-align: left;
            color: white;
        }

        .search select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background: white;
            color: black;
            outline: none;
            transition: 0.3s;
        }

        .search select:focus {
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        /* Button Styling */
        .search button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
        }

        .search button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            background-color: black;
            padding: 10px;
            text-align: center;
            color: white;
            width: 100%;
            margin-top: auto;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <!-- Navigation Bar -->
    <div class="topnav">
        <img src="final logo.jpg" alt="Logo">
        
        <div>
            <a href="Customer signup.php">Registration</a>
            <a href="Customer login.php">Login</a>
            <a href="admin.php">Admin</a>
            <a href="driver.php">Driver</a>
            <a href="contact.html">Contact Us</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="search">
            <h2>Book Your Ride</h2>

            <label for="pickup">Pickup Location:</label>
            <select name="pickup" id="pickup" required>
                <option value="">-- Select Pickup Location --</option>
                <option value="Infocity Circle">Infocity Circle</option>
                <option value="Sector-1 Circle">Sector-1 Circle</option>
                <option value="Sector-2 Circle">Sector-2 Circle</option>
                <option value="Ch-0 Circle">Ch-0 Circle</option>
                <option value="Ch-3 Circle">Ch-3 Circle</option>
                <option value="Sector-16 Circle">Sector-16 Circle</option>
                <option value="Sector-21 Circle">Sector-21 Circle</option>
                <option value="Akshardham Circle">Akshardham Circle</option>
            </select>
    
            <label for="drop">Drop Location:</label>
            <select name="drop" id="drop" required>
                <option value="">-- Select Drop Location --</option>
                <option value="Infocity Circle">Infocity Circle</option>
                <option value="Sector-1 Circle">Sector-1 Circle</option>
                <option value="Sector-2 Circle">Sector-2 Circle</option>
                <option value="Ch-0 Circle">Ch-0 Circle</option>
                <option value="Ch-3 Circle">Ch-3 Circle</option>
                <option value="Sector-16 Circle">Sector-16 Circle</option>
                <option value="Sector-21 Circle">Sector-21 Circle</option>
                <option value="Akshardham Circle">Akshardham Circle</option>
            </select>

            <a href="Customer login.php">
                <button>Book Taxi</button>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Your Taxi Service. All rights reserved.</p>
        <p>Developed By: <a href="mailto:dhavalsatasiya7@gmail.com">Dhaval07</a></p>
    </footer>

</body>
</html>
