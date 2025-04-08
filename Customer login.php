<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if (!empty($user) && !empty($pass)) {
        $query = "SELECT Customer_id, username, password, approval_status FROM customer_regist WHERE username = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            if ($user_data['password'] == $pass) { 
                if ($user_data['approval_status'] == 'Approved') {
                    // ✅ **Correctly Store Session ID**
                    $_SESSION['customer_id'] = intval($user_data['Customer_id']); 
                    $_SESSION['username'] = $user_data['username'];

                    header("Location: customerdashbord.php");
                    exit;
                } else {
                    echo "<script>alert('Your account is not approved by the admin yet. Please wait for approval.');</script>";
                }
            } else {
                echo "<script>alert('Wrong username or password');</script>";
            }
        } else {
            echo "<script>alert('Wrong username or password');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter both username/email and password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    
    <div class="login-container">
        <h2>Customer Login</h2>
        <form method="POST">
        <input type="text" placeholder="Username or Email" name="username" required>
        <input type="password" placeholder="Password"name="password" required>
        <div class="btn2">
         <button type="submit">Login</button>
         <button type="reset">Clear</button> 
        </div>
        <p>Don't have an account? <a href="customer signup.php">Sign Up</a></p>
    </div>


</body>
</html>