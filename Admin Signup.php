<?php
session_start();
include("connection.php");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $afullname = mysqli_real_escape_string($con, $_POST['fname']);
    $agmail = mysqli_real_escape_string($con, $_POST['email']);
    $anumber = mysqli_real_escape_string($con, $_POST['mobileno']);
    $auser = mysqli_real_escape_string($con, $_POST['username']);
    $apass = mysqli_real_escape_string($con,$_POST['password']); // Secure password
    $aadds = mysqli_real_escape_string($con, $_POST['addresh']);

    if (!empty($agmail) && !empty($_POST['password']) && !is_numeric($agmail)) {
        // Check if email already exists
        $check_query = "SELECT * FROM admin_regis WHERE email='$agmail'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            $query = "INSERT INTO admin_regis (fname, email, mobileno, username, password, address) 
                      VALUES ('$afullname', '$agmail', '$anumber', '$auser', '$apass', '$aadds')";

            if (mysqli_query($con, $query)) {
                echo "<script>alert('Successfully Registered'); window.location.href='panel.php';</script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
        echo "<script>alert('Please enter valid information');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <form method="POST">
        <div class="signup-container">
            <h2>Admin Registration</h2>
            <input type="text" name="fname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="mobileno" placeholder="Mobile No" required pattern="[0-9]{10}">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="addresh" placeholder="Address" required>
            <div class="btn">
                <button type="submit">Register</button>
                <button type="reset">Clear</button>    
            </div>
        </div>
    </form>
</body>
</html>
