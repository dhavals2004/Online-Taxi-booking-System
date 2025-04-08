<?php
session_start();
include("db_connect.php");


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["customer_id"])) {
        die(json_encode(["success" => false, "message" => "❌ Please log in to book a ride."]));
    }

   
    $customer_id = $conn->real_escape_string($_SESSION["customer_id"]);
    $pickup      = $conn->real_escape_string($_POST["pickup"]);
    $drop        = $conn->real_escape_string($_POST["drop"]);
    $vehicle_id  = $conn->real_escape_string($_POST["vehicle_id"]);

    $price = rand(50, 200);
    $pickup_time = date("Y-m-d H:i:s");
    $drop_time   = date("Y-m-d H:i:s", strtotime("+1 hour"));

    
    $insert_query = "INSERT INTO bookrecord 
        (pickup_location, drop_location, price, status, vehicle_id, customer_id, pickup_time, drop_time, driver_id)
        VALUES ('$pickup', '$drop', '$price', 'Pending', '$vehicle_id', '$customer_id', '$pickup_time', '$drop_time', NULL)";

    if ($conn->query($insert_query) === TRUE) {
        echo json_encode(["success" => true, "message" => "🚖 Booking submitted! Waiting for a driver to accept."]);
    } else {
        error_log("Booking Insertion Error: " . $conn->error);
        echo json_encode(["success" => false, "message" => "❌ Booking failed: " . $conn->error]);
    }
}

$conn->close();
?>
