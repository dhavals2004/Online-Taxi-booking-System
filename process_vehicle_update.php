<?php
session_start();
include 'db_connect.php';

// Check if driver is logged in
$driver_id = $_SESSION['driver_id'] ?? null;
if (!$driver_id) {
    echo "<script>alert('Please login first!'); window.location.href='Driver login.php';</script>";
    exit;
}

// Get data from form
$vehicle_id = $_POST['vehicle_id'];
$model = $_POST['model'];
$number = $_POST['number'];
$insurance = $_POST['insurance'];
$puc = $_POST['puc'];
$prize_perkm = $_POST['prize_perkm'];
$status = $_POST['status'];

// Update query without file upload fields
$query = "UPDATE vehicles_infom SET model=?, number=?, insurance=?, puc=?, prize_perkm=?, status=? WHERE vehicle_id=? AND driver_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssdsii", $model, $number, $insurance, $puc, $prize_perkm, $status, $vehicle_id, $driver_id);

if ($stmt->execute()) {
    echo "<script>alert('Vehicle Updated Successfully!'); window.location.href='driverdashbord.php';</script>";
} else {
    echo "<script>alert('Error Updating Vehicle!'); history.back();</script>";
}

$stmt->close();
?>
