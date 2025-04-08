<?php
include("db_connect.php");

if (isset($_POST['vehicle_id']) && isset($_POST['status'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $new_status = $_POST['status'] == 'active' ? 'inactive' : 'active';

    $update_query = "UPDATE vehicles_infom SET status='$new_status' WHERE vehicle_id=$vehicle_id";
    if (mysqli_query($conn, $update_query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
