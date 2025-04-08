<?php
header("Content-Type: application/json");
session_start();
include("db_connect.php");

// Ensure the driver is logged in (for actions that require a driver)
if (!isset($_SESSION['driver_id'])) {
    echo json_encode(["success" => false, "message" => "You must be logged in."]);
    exit;
}

$driver_id = $_SESSION['driver_id'];

// Get POST data
$ride_id = filter_input(INPUT_POST, 'ride_id', FILTER_VALIDATE_INT);
$status  = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

if (!$ride_id || empty($status)) {
    echo json_encode(["success" => false, "message" => "Invalid data provided."]);
    exit;
}

// Build query based on new status.
if ($status === "Pickup") {
    $query = "UPDATE bookrecord SET status = ?, pickup_time = NOW(), driver_id = ? WHERE booking_id = ?";
} elseif ($status === "Completed") {
    $query = "UPDATE bookrecord SET status = ?, drop_time = NOW() WHERE booking_id = ?";
} else {
    // For statuses like 'Confirmed', 'Cancelled', and 'Drop'
    // When a ride is accepted (status 'Confirmed'), store driver_id.
    if ($status === "Confirmed") {
        $query = "UPDATE bookrecord SET status = ?, driver_id = ? WHERE booking_id = ?";
    } else {
        $query = "UPDATE bookrecord SET status = ? WHERE booking_id = ?";
    }
}

$stmt = $conn->prepare($query);

if ($stmt) {
    if ($status === "Pickup") {
        $stmt->bind_param("sii", $status, $driver_id, $ride_id);
    } elseif ($status === "Completed") {
        $stmt->bind_param("si", $status, $ride_id);
    } elseif ($status === "Confirmed") {
        $stmt->bind_param("sii", $status, $driver_id, $ride_id);
    } else {
        $stmt->bind_param("si", $status, $ride_id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Your Ride Complated  '{$status}' successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "SQL statement preparation failed: " . $conn->error]);
}

$conn->close();
?>
