<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['customer_id'])) {
    die("❌ Please log in to view your booking.");
}
$customer_id = $conn->real_escape_string($_SESSION["customer_id"]);

// Fetch latest booking details for the logged-in customer
$query = "SELECT b.*, 
                 d.fname AS driver_name, d.phone AS driver_phone, 
                 v.model AS vehicle_model, v.number AS vehicle_number
          FROM bookrecord b 
          LEFT JOIN driverre d ON b.driver_id = d.Driver_id 
          LEFT JOIN vehicles_infom v ON b.vehicle_id = v.vehicle_id
          WHERE b.customer_id = '$customer_id' 
          ORDER BY b.booking_id DESC 
          LIMIT 1";

$result = $conn->query($query);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

$booking = $result->fetch_assoc();
$status = isset($booking) ? strtolower(trim($booking['status'])) : null;

if ($status === "cancelled") {
    echo "<script>
        alert('❌ Your ride has been cancelled by the driver.');
        window.location.href = 'booking.php';
    </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booking Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f9;
      padding: 20px;
    }
    .status-container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 9px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      text-align: center;
    }
    h2, h3 {
      text-align: center;
    }
    .btn-group {
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="status-container">
  <?php if ($booking): ?>
    <h2>🚖 Booking Status</h2>
    <p><strong>Pickup Location:</strong> <?php echo htmlspecialchars($booking["pickup_location"]); ?></p>
    <p><strong>Drop Location:</strong> <?php echo htmlspecialchars($booking["drop_location"]); ?></p>
    <p><strong>Price:</strong> ₹<?php echo number_format($booking["price"], 2); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($booking["status"])); ?></p>

    <?php if (!empty($booking["driver_id"])): ?>
      <hr>
      <h3>Driver Details</h3>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($booking["driver_name"]); ?></p>
      <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking["driver_phone"]); ?></p>

      <hr>
      <h3>Vehicle Details</h3>
      <p><strong>Model:</strong> <?php echo htmlspecialchars($booking["vehicle_model"]); ?></p>
      <p><strong>Number:</strong> <?php echo htmlspecialchars($booking["vehicle_number"]); ?></p>

      <div class="btn-group">
        <?php if (!in_array($status, ['pickup', 'drop', 'completed'])): ?>
          <a href="cancel_booking.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-danger">❌ Cancel Ride</a>
        <?php else: ?>
          <p><em> You cannot cancel a ride after pickup.</em></p>
        <?php endif; ?>

        <?php if (in_array($status, ['drop', 'completed'])): ?>
          <a href="payment.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-success"> Proceed to Payment</a>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <p><em>⏳ Waiting for driver assignment...</em></p>
    <?php endif; ?>

  <?php else: ?>
    <h2>No Booking Found</h2>
    <p>You have not booked a ride yet.</p>
    <a href="booking.php" class="btn btn-primary"> Book a Ride Now</a>
  <?php endif; ?>
</div>
</body>
</html>
<?php $conn->close(); ?>
