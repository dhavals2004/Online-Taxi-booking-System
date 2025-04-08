<?php
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: Customer_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxibooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerId = $_SESSION['customer_id'];

// Fetch booking history with vehicle information for the logged-in customer
$sql = "SELECT bookrecord.booking_id, bookrecord.pickup_time, bookrecord.price, bookrecord.status, 
               vehicles_infom.model, vehicles_infom.number 
        FROM bookrecord
        JOIN vehicles_infom ON bookrecord.vehicle_id = vehicles_infom.vehicle_id
        WHERE bookrecord.customer_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Booking Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: rgb(37, 37, 37);
            color: white;
        }

        .card-body {
            background-color: white;
        }

        table {
            width: 100%;
        }

        th, td {
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Customer Booking History</h2>

        <!-- Booking History Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Your Bookings</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Taxi Model</th>
                            <th>Vehicle Number</th>
                            <th>Pick-up Date/Time</th>
                            <th>Fare Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) > 0): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking['booking_id']; ?></td>
                                    <td><?php echo $booking['model']; ?></td>
                                    <td><?php echo $booking['number']; ?></td>
                                    <td><?php echo $booking['pickup_time']; ?></td>
                                    <td><?php echo number_format($booking['price'], 2); ?></td>
                                    <td><?php echo $booking['status']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

      
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
