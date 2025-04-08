<?php
include("db_connect.php");

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Fetch payment details and customer name based on booking_id
    $query = "SELECT p.payment_id, p.amount, p.status, c.fname AS customer_name
              FROM payment p
              JOIN bookrecord br ON p.booking_id = br.booking_id
              JOIN customer_regist c ON br.customer_id = c.Customer_id
              WHERE p.booking_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'payment_id' => $row['payment_id'],
            'amount' => $row['amount'],
            'status' => $row['status'],
            'customer_name' => $row['customer_name']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment details not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid booking ID.']);
}

$conn->close();
?>
