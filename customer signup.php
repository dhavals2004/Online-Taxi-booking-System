<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = mysqli_real_escape_string($con, trim($_POST['fname']));
    $gmail = mysqli_real_escape_string($con, trim($_POST['email']));
    $number = mysqli_real_escape_string($con, trim($_POST['mobileno']));
    $user = mysqli_real_escape_string($con, trim($_POST['username']));
    $pass = mysqli_real_escape_string ($con,trim($_POST['password']));

    if (!preg_match("/^[0-9]{10}$/", $number)) {
        echo "<script>alert('Mobile number must be exactly 10 digits');</script>";
    } elseif (!empty($gmail) && !empty($_POST['password']) && !is_numeric($gmail)) {
        $query = "INSERT INTO customer_regist(fname, email, mobileno, username, password) 
                  VALUES ('$fullname', '$gmail', '$number', '$user', '$pass')";

        if (mysqli_query($con, $query)) {
            echo "<script>
                    alert('Customer Registered Successfully!');
                    window.location.href = 'index.php'; 
                  </script>";
            exit();
        } else {
            echo "<script>alert('Registration Failed. Try again!');</script>";
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
    <title>signup</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <form method="post">
    <div class="signup-container">
        <h2>Customer Registration</h2>
        <input type="text" name="fname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobileno" placeholder="Mobile No" pattern="[0-9]{10}" required title="Mobile number must be 10 digits">

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <div class="btn">
             
            <button type="submit">Sign up</button>
            <button type="reset">Clear</button> 
        </div>
    </div>
</form>
</body>
</html>
