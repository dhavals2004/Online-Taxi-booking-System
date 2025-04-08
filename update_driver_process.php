<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $licence_no = $_POST['licence_no'];
    $address = $_POST['address'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null; // Plaintext password (Not Secure)

    // Build query dynamically
    $query = "UPDATE driverre SET fname=?, email=?, phone=?, username=?, licence_no=?, address=?";
    if ($password) $query .= ", password=?";  // Update password only if provided
    $query .= " WHERE Driver_id=?";

    $stmt = $conn->prepare($query);

    // Bind parameters dynamically
    if ($password) {
        $stmt->bind_param("sssssssi", $fname, $email, $phone, $username, $licence_no, $address, $password, $driver_id);
    } else {
        $stmt->bind_param("ssssssi", $fname, $email, $phone, $username, $licence_no, $address, $driver_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='driverdashbord.php';</script>";
    } else {
        echo "<script>alert('Error Updating Profile!'); history.back();</script>";
    }

    $stmt->close();
}
?>
