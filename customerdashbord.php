<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <!-- <link rel="stylesheet" href="home.css"> -->
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        /* Header Section - DO NOT CHANGE */
        .header {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 15px;
            border-radius: 5px;
            margin: 0 10px;
            display: inline-block;
            font-weight: bold;
        }
       
        .header a.logout {
            background-color: red;
        }
        .header .update-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            border-radius: 5px;
            font-weight: bold;
        }


        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            text-align: center;
        }

        .container h2 {
            font-size: 26px;
            color: #333;
        }

        .container p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
           
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            width: 45%;
            text-align: center;
        }

        .card h3 {
            font-size: 20px;
            color: #444;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            color: black;
            text-decoration: none;
            border-radius: 5px;
        }

        .book-taxi-card {
            background-color: #28a745;
        }

        .history-card {
            background-color: #ff9800;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="final logo.jpg" width="150" height="70">
    <h2>Customer Dashboard</h2>
    <div>
    
        <a href="update_customer.php" class="update-button">Update Profile</a>
        <a href="index.php" class="logout">Logout</a>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="container">
    <h2>Welcome Customer!</h2>
    <p>Manage your taxi bookings easily. Book a ride or view your booking history below.</p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Book a Ride</h3>
            <p>Find a taxi and reach your destination quickly.</p>
            <a href="booking.php" class="book-taxi-card">Book Now</a>
        </div>

        <div class="card">
            <h3>Booking History</h3>
            <p>View all your past taxi rides and details.</p>
            <a href="customer_history.php" class="history-card">View History</a>
        </div>
    </div>
</div>

</body>
</html>
