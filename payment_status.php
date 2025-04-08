<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['customer_id'])) {
    die("❌ Please log in to view booking status.");
}

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
$query = "SELECT b.*, p.payment_id, p.amount, p.status as payment_status
          FROM bookrecord b
          LEFT JOIN payments p ON b.booking_id = p.booking_id
          WHERE b.booking_id = '$booking_id'";

$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    header("Location: customerdashbord.php"); // Redirect to home page
    exit(); // Stop further execution
}

$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Status</title>
</head>
<body>
    <h2>Booking Status</h2>
    <p><strong>Booking ID:</strong> <?php echo $booking["booking_id"]; ?></p>
    <p><strong>Status:</strong> <?php echo $booking["status"]; ?></p>
    <p><strong>Payment Status:</strong> <?php echo $booking["payment_status"] ?? "Not Paid"; ?></p>
    <p><strong>Amount Paid:</strong> ₹<?php echo number_format($booking["amount"] ?? 0, 2); ?></p>
</body>
</html>
