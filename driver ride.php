<?php
session_start();
include "db_connect.php";

// Ensure the database connection is valid
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['driver_id'])) {
    header("Location: driver_login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];

// Fetch Ride History with formatted pickup time
$sql = "SELECT booking_id, pickup_location, drop_location, price, DATE_FORMAT(pickup_time, '%Y-%m-%d %H:%i') AS formatted_pickup_time FROM bookrecord WHERE driver_id = ? AND status = 'Completed'";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("MySQL prepare error: " . $conn->error);
}

// Bind the parameter and execute the statement
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate Total Earnings (75% of Fare)
$total_earnings = 0;
$ride_history = [];

while ($row = $result->fetch_assoc()) {
    $ride_history[] = $row;
    $total_earnings += $row['price'] * 0.75; // 75% of fare
}
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
            background-color: #f8f9fa;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .earnings {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, Driver</h2>

        <div class="earnings">
            <h3>Total Earnings</h3>
            <p><?php echo number_format($total_earnings, 2); ?></p>
        </div>

        <h3>Ride History</h3>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Pickup</th>
                <th>Drop</th>
                <th>Fare</th>
                <th>Date</th>
            </tr>
            <?php foreach ($ride_history as $ride): ?>
                <tr>
                    <td><?php echo $ride['booking_id']; ?></td>
                    <td><?php echo $ride['pickup_location']; ?></td>
                    <td><?php echo $ride['drop_location']; ?></td>
                    <td><?php echo number_format($ride['price'], 2); ?></td>
                    <td><?php echo $ride['formatted_pickup_time']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
