<?php
// Start session and include the database connection file
session_start();
include("db_connect.php");

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Fetch customer details from the database
$query = "SELECT * FROM customer_regist WHERE Customer_id = '$customer_id'";
$result = mysqli_query($conn, $query);
$customer_data = mysqli_fetch_assoc($result);

// Update customer details if form is submitted
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $mobileno = $_POST['mobileno'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if password is updated
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT); // Encrypt password
    } else {
        $password = $customer_data['password']; // Keep existing password if not updated
    }

    // Update customer information in the database
    $update_query = "UPDATE customer_regist SET 
                        fname = '$fname', 
                        email = '$email', 
                        mobileno = '$mobileno', 
                        username = '$username', 
                        password = '$password' 
                    WHERE Customer_id = '$customer_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='customerdashbord.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Update Your Information</h2>

    <form method="POST" action="update_customer.php">
        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $customer_data['fname']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer_data['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="mobileno" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobileno" name="mobileno" value="<?php echo $customer_data['mobileno']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $customer_data['username']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="text-muted">Leave blank if you don't want to change your password.</small>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Information</button>
    </form>

    <div class="mt-3 text-center">
        <a href="customerdashbord.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
