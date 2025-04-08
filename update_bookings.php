<?php
header("Content-Type: application/json");
include("db_connect.php"); 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   
    $ride_id = filter_input(INPUT_POST, 'ride_id', FILTER_VALIDATE_INT);
    $status  = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    if (!empty($ride_id) && !empty($status)) {
        
        if ($status === "Pickup") {
            $query = "UPDATE bookrecord SET status = ?, pickup_time = NOW() WHERE booking_id = ?";
        } elseif ($status === "Completed") {
            $query = "UPDATE bookrecord SET status = ?, drop_time = NOW() WHERE booking_id = ?";
        } else {
            $query = "UPDATE bookrecord SET status = ? WHERE booking_id = ?";
        }

        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $status, $ride_id);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["success" => true, "message" => "Status updated successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Database update failed: " . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["success" => false, "message" => "SQL statement preparation failed: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid data provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

mysqli_close($conn);
?>
