<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_id = intval($_POST['vehicle_id']);

    
    $check_query = "SELECT * FROM vehicles_infom WHERE vehicle_id = $vehicle_id";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
     
        $delete_query = "DELETE FROM vehicles_infom WHERE vehicle_id = $vehicle_id";
        if (mysqli_query($con, $delete_query)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
