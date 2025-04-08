<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
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

    
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Main Content Styling */
        .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4);
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
            justify-content: space-between; /* Keeps all cards in one line */
            gap: 20px;
            margin-top: 20px;
            flex-wrap: nowrap; /* Prevents wrapping */
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            width: 30%; /* Ensures all cards fit in one line */
            text-align: center;
            transition: 0.3s;
        }

        .card h3 {
            font-size: 20px;
            color: #444;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        /* Button Styling - Set Text Color to Black */
        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            color: black; 
        }

        .add-taxi-card {
            background-color: #28a745;
        }

        .ride-request-card {
            background-color: #007bff;
        }

        .ride-history-card {
            background-color: #ffc107;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .dashboard-cards {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 80%;
            }
        }

    </style>
</head>
<body>
<div class="header">
    <img src="final logo.jpg" width="150" height="70">
    <h2>Driver Dashboard</h2>
    <div class="actions">
        <div class="dropdown">
            <button>Update Profile</button>
            <div class="dropdown-content">
                <a href="driver_update.php">Registration </a>
                <a href=update_vehicle.php>Vehicle</a>
            </div>
        </div>
        <a href="Driver.php" class="logout">Logout</a>
    </div>
</div>



<!-- Main Dashboard Content -->
<div class="container">
    <h2>Welcome, Driver!</h2>
    <p>Manage your taxi, check ride requests, and track your ride history conveniently.</p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Add a Taxi</h3>
            <p>Register your vehicle for ride bookings.</p>
            <a href="vehicle.php" class="add-taxi-card">Add Now</a>
        </div>

        <div class="card">
            <h3>Ride Requests</h3>
            <p>View and accept incoming ride requests.</p>
            <a href="driver_dashboard.php" class="ride-request-card">Check Requests</a>
        </div>

        <div class="card">
            <h3>Ride History</h3>
            <p>View all your completed ride details.</p>
            <a href="driver_history.php" class="ride-history-card">View History</a>
        </div>
    </div>
</div>

</body>
</html>
