<?php
session_start();

// Check if the driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: Driver login.php");
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

$driverId = $_SESSION['driver_id'];

// Fetch booking history for the logged-in driver
$sql = "SELECT * FROM bookrecord WHERE driver_id = ? AND status = 'Completed'";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    // If the query preparation fails, print an error
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $driverId);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
$totalEarnings = 0;

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
    $totalEarnings += $row['price'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Booking History</title>
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
        <h2 class="text-center">Driver Booking History</h2>

        <!-- Booking History Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Completed Bookings</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer Name</th>
                            <th>Ride Date</th>
                            <th>Fare Amount</th>
                            <!-- <th>Driver's 75% Payment</th> -->
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) > 0): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking['booking_id']; ?></td>
                                    <td><?php echo $booking['customer_id']; ?></td>
                                    <td><?php echo $booking['pickup_time']; ?></td>
                                    <td><?php echo number_format($booking['price'], 2); ?></td>
                                    <!-- <td><?php echo number_format($booking['price'] * 0.75, 2); ?></td> -->
                                    <td><?php echo $booking['status']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No completed bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Summary Section -->
        <div class="card">
            <div class="card-header">
                <h4>Payment Summary</h4>
            </div>
            <div class="card-body">
                <!-- Display Total Earnings -->
                <div class="d-flex justify-content-between">
                    <span>Total Earnings:</span>
                    <span><?php echo number_format($totalEarnings, 2); ?></span>
                </div>

                <!-- Display 75% of Total Earnings (Driver Payment) -->
                <!-- <div class="d-flex justify-content-between mt-2">
                    <span>Your Total Payment (75%):</span>
                    <span><?php echo number_format($totalEarnings * 0.75, 2); ?></span>
                </div> -->
            </div>
        </div>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
