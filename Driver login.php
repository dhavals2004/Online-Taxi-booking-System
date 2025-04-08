<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (!empty($user) && !empty($pass) && !is_numeric($user)) {
        $query = "SELECT * FROM driverre WHERE username = '$user' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] == $pass) {
                    if ($user_data['approval_status'] == 'Approved') { 
                        $_SESSION['driver_id'] = $user_data['Driver_id'];
                        $_SESSION['username'] = $user_data['username'];
                        header("Location: driverdashbord.php");
                        die;
                    } else {
                        echo "<script type='text/javascript'>alert('Your account is not approved by the admin yet. Please wait for approval.');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
            }
        }
    } else {
        echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Login</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="login-container">
        <h2>Driver Login</h2>
        <form method="POST">
        <input type="text" name='username' placeholder="Username or Email" required>
        <input type="password" name='password' placeholder="Password" required>
        <div class="btn2">
          <button type="submit">Login</button>
          <button type="reset">Clear</button> 
        </div>
        <p>Don't have an account? <a href="Driver Signup.php">Sign Up</a></p>
</body>
</html>