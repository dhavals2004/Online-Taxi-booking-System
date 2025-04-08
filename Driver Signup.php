<?php
session_start();
include("connection.php"); 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $dfullname = mysqli_real_escape_string($con, $_POST['fname']);
    $dgmail = mysqli_real_escape_string($con, $_POST['email']);
    $dphone = mysqli_real_escape_string($con, $_POST['phone']);
    $duser = mysqli_real_escape_string($con, $_POST['username']);
    $dpass = mysqli_real_escape_string($con, $_POST['password']); 
    $dliceno = mysqli_real_escape_string($con, $_POST['licence_no']);
    $daddress = mysqli_real_escape_string($con, $_POST['address']);
    $upload_dir = "uploads/";

    if (!preg_match("/^[0-9]{10}$/", $dphone)) {
        die("Error: Mobile number must be exactly 10 digits.");
    }

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    function uploadFile($file, $upload_dir) {
        $filename = time() . "_" . basename($file["name"]);
        $target_file = $upload_dir . $filename;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ["jpg", "jpeg", "png", "pdf"];
        if (!in_array($file_type, $allowed_types)) {
            return false;
        }

        return move_uploaded_file($file["tmp_name"], $target_file) ? $target_file : false;
    }

    $photo_path = uploadFile($_FILES['photo'], $upload_dir);
    $licence_photo_path = uploadFile($_FILES['licence_photo'], $upload_dir);
    if (!$photo_path || !$licence_photo_path) {
        die("Error: Invalid file type for photo or licence.");
    }

    $check_query = "SELECT * FROM driverre WHERE email = '$dgmail' OR username = '$duser' OR licence_no = '$dliceno'";
    $result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($result) > 0) {
        die("Error: Email, Username, or Licence Number already registered.");
    }

    $query = "INSERT INTO driverre (fname, email, phone, username, password, licence_no, licence_photo, address, photo, approval_status) 
              VALUES ('$dfullname', '$dgmail', '$dphone', '$duser', '$dpass', '$dliceno', '$licence_photo_path', '$daddress', '$photo_path', 'Pending')";

    if (mysqli_query($con, $query)) {
        $_SESSION['driver_id'] = mysqli_insert_id($con); 
        // echo "<script>alert('Successfully Registered! Redirecting to Bank Details...');</script>";
        echo "<script>window.location.href = 'bank.php';</script>";
        exit();
    } else {
        die("Error: " . mysqli_error($con));
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Signup</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="signup-container">
        <h2>Driver Registration</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="fname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Mobile No" pattern="[0-9]{10}" required title="Mobile number must be 10 digits">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="licence_no" placeholder="Driving Licence No" required>
            <label for="licence_photo">Upload Licence Photo:</label>
            <input type="file" id="licence_photo" name="licence_photo" required>
            <input type="text" name="address" placeholder="Address" required>
            <label for="photo">Upload Your Photo:</label>
            <input type="file" id="photo" name="photo" required>

            <div class="btn">
                <button type="submit">Next</button>
                <button type="reset">Clear</button>
            </div>
        </form>
    </div>
</body>
</html>
