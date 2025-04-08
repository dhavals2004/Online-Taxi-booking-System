<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_id = $conn->real_escape_string($_POST["payment_id"]);
    $booking_id = intval($_POST["booking_id"]);
    $amount = floatval($_POST["amount"]) / 100; // Convert from paise to rupees

    // Verify if booking exists and fetch customer_id
    $query = "SELECT customer_id FROM bookrecord WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row["customer_id"];

        // Store payment details in `payment` table
        $insert_query = "INSERT INTO payment (customer_id, booking_id, payment_id, amount, status) VALUES (?, ?, ?, ?, 'Paid')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iisd", $customer_id, $booking_id, $payment_id, $amount);

        if ($stmt->execute()) {
            // Update `bookrecord` status to 'Completed'
            $update_query = "UPDATE bookrecord SET status = 'Completed' WHERE booking_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();

            echo "✅ Payment recorded successfully!";
        } else {
            die("❌ Error inserting payment: " . $stmt->error);
        }
    } else {
        die("❌ Invalid booking ID or booking does not exist.");
    }
} else {
    die("❌ Invalid request.");
}
?>
