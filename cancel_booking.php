<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['customer_id'])) {
    die("❌ Please log in to cancel a ride.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $conn->real_escape_string($_POST['booking_id']);
    $customer_id = $conn->real_escape_string($_SESSION["customer_id"]);
    $driver_id = $conn->real_escape_string($_POST['driver_id']); 
    $reason = $conn->real_escape_string($_POST['reason']);

  
    $query = "UPDATE bookrecord SET status = 'Cancelled' WHERE booking_id = '$booking_id' AND customer_id = '$customer_id'";

    if ($conn->query($query) === TRUE) {
   
        $cancel_query = "INSERT INTO cancellation (booking_id, customer_id, driver_id, cancellation_time, reason) 
                         VALUES ('$booking_id', '$customer_id', '$driver_id', NOW(), '$reason')";
        $conn->query($cancel_query);

    
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Cancellation Successful</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: "Poppins", sans-serif;
                    background-color: #f4f4f9;
                    padding: 20px;
                }
                .message-container {
                    max-width: 600px;
                    margin: auto;
                    background: white;
                    padding: 30px;
                    border-radius: 9px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                    text-align: center;
                }
            </style>
            <script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "customerdashbord.php";
                }, 3000); // Redirect after 3 seconds
            </script>
        </head>
        <body>
            <div class="message-container">
                <h2>✅ Cancellation Successful</h2>
                <p>Your ride has been successfully cancelled.</p>
                <p>You will be redirected to your dashboard shortly...</p>
            </div>
        </body>
        </html>';
    } else {
        echo "Error cancelling booking: " . $conn->error;
    }
} elseif (isset($_GET['booking_id'])) {
    
    $booking_id = $conn->real_escape_string($_GET['booking_id']);
    
    // Fetch booking details to get the driver_id
    $booking_query = "SELECT driver_id FROM bookrecord WHERE booking_id = '$booking_id'";
    $booking_result = $conn->query($booking_query);
    $booking = $booking_result->fetch_assoc();
    $driver_id = $booking['driver_id'];

    if (!$driver_id) {
        die("No driver assigned to this booking.");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cancel Ride</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Cancel Ride</h2>
            <form method="post" action="">
                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Cancellation:</label>
                    <textarea name="reason" id="reason" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger">❌ Cancel Ride</button>
                <a href="customerdashbord.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "No booking ID provided.";
}

$conn->close();
?>
