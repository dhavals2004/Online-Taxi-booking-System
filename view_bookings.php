<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['customer_id'])) {
    die("Error: Customer ID is not set.");
}

$customer_id = $_SESSION['customer_id']; 


$booking_query = "SELECT b.booking_id, b.pickup_location, b.drop_location, b.price, b.status, d.fname AS driver_name, d.phone AS driver_contact
                  FROM bookrecord b 
                  LEFT JOIN driverre d ON b.driver_id = d.driver_id 
                  WHERE b.customer_id = ?";
$stmt = $conn->prepare($booking_query);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Pickup Location</th>
                <th>Drop Location</th>
                <th>Price</th>
                <th>Status</th>
                <th>Driver Name</th>
                <th>Driver Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['drop_location']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['driver_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['driver_contact']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
