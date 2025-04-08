<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$database = "taxibooking"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cancellations with driver name and vehicle name
$sql = "
    SELECT 
        c.cancellation_id, 
        c.booking_id, 
        c.customer_id, 
        c.driver_id, 
        c.reason, 
        c.cancellation_time, 
        d.fname AS driver_name, 
        v.model AS vehicle_name
    FROM cancellation c
    LEFT JOIN driverre d ON c.driver_id = d.Driver_id
    LEFT JOIN bookrecord b ON c.booking_id = b.booking_id
    LEFT JOIN vehicles_infom v ON b.vehicle_id = v.vehicle_id
    ORDER BY c.cancellation_id DESC";

$result = $conn->query($sql);
$cancellations = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cancellations[] = $row;
    }
    echo json_encode($cancellations);
} else {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
}

$conn->close();
?>
