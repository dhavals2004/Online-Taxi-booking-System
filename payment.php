<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['customer_id'])) {
    die("❌ Please log in to proceed with payment.");
}

$customer_id = $conn->real_escape_string($_SESSION["customer_id"]);
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Ensure a valid booking ID is provided
if ($booking_id <= 0) {
    die("❌ Invalid booking ID.");
}

// Fetch booking details
$query = "SELECT b.*, c.fname AS customer_name, c.email AS customer_email 
          FROM bookrecord b
          JOIN customer_regist c ON b.customer_id = c.Customer_id
          WHERE b.booking_id = '$booking_id' AND b.customer_id = '$customer_id'";

$result = $conn->query($query);

if (!$result) {
    die("❌ Query Failed: " . $conn->error);
}

if ($result->num_rows == 0) {
    die("❌ No booking found or access denied.");
}

$booking = $result->fetch_assoc();

// Ensure the price exists before using it
$amount = isset($booking['price']) ? number_format($booking['price'], 2, '.', '') * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 600px; background: white; padding: 30px; border-radius: 9px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); text-align: center; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h2>💳 Payment</h2>

    <?php if ($amount > 0) { ?>
        <p><strong>Customer:</strong> <?php echo htmlspecialchars($booking["customer_name"]); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($booking["customer_email"]); ?></p>
        <p><strong>Amount:</strong> ₹<?php echo number_format($booking['price'], 2); ?></p>
        <button id="rzp-button1" class="btn btn-success">Pay Now</button>
    <?php } else { ?>
        <div class="alert alert-danger">❌ Booking price not found.</div>
    <?php } ?>
</div>

<script>
    var options = {
        "key": " ", //    Replace with your Razorpay Key
        "amount": "<?php echo $amount; ?>",
        "currency": "INR",
        "name": "TAXI GO Payment",
        "description": "Booking ID: <?php echo $booking_id; ?>",
        "image": "final logo.jpg",
        "handler": function (response) {
            fetch("payment_process.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "payment_id=" + response.razorpay_payment_id + "&booking_id=<?php echo $booking_id; ?>&amount=<?php echo $amount; ?>"
            })
            .then(response => response.text())
            .then(data => {
                alert("✅ Payment Successful!\nYour Ride Successfully Complated.");
                window.location.href = "payment_status.php?booking_id=<?php echo $booking_id; ?>";
            })
            .catch(error => console.error("Error:", error));
        },
        "theme": { "color": "#3399cc" }
    };

    var rzp1 = new Razorpay(options);
    document.getElementById("rzp-button1").onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };
</script>

</body>
</html>
