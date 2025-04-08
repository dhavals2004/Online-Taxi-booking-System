<?php
header("Content-Type: application/json");
include 'db_connect.php'; // Ensure this file correctly establishes a database connection

$sql = "SELECT 
            b.booking_id, 
            c.fname AS customer_name, 
            b.pickup_location, 
            b.drop_location, 
            b.price, 
            b.status 
        FROM bookrecord b
        JOIN customer_regist c ON b.customer_id = c.Customer_id
        WHERE b.status = 'Pending'";

$result = $conn->query($sql);
$rides = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }
}

echo json_encode($rides, JSON_PRETTY_PRINT);
$conn->close();
?>
