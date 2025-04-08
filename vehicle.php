<?php
session_start();
include("connection.php");

if (!isset($_SESSION['driver_id'])) {
    die("Error: Driver ID not found in session.");
}

$driver_id = $_SESSION['driver_id'];
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $vehicle_model = mysqli_real_escape_string($con, $_POST['model']);
    $rc_number = mysqli_real_escape_string($con, $_POST['number']);
    $insurance_no = mysqli_real_escape_string($con, $_POST['insurance']);
    $puc_no = mysqli_real_escape_string($con, $_POST['puc']);
    $prize_perkm = mysqli_real_escape_string($con, $_POST['prize_perkm']);

    // File upload handling
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowed_types = ["jpg", "jpeg", "png", "pdf"];

    // RC Book Upload
    $rc_book_ext = strtolower(pathinfo($_FILES["rc_book"]["name"], PATHINFO_EXTENSION));
    if (!in_array($rc_book_ext, $allowed_types)) {
        die("Invalid RC Book file type! Only JPG, JPEG, PNG, and PDF are allowed.");
    }
    $rc_book_path = $uploadDir . time() . "_RC_" . basename($_FILES["rc_book"]["name"]);

    // PUC Certificate Upload
    $puc_cert_ext = strtolower(pathinfo($_FILES["puc_cert"]["name"], PATHINFO_EXTENSION));
    if (!in_array($puc_cert_ext, $allowed_types)) {
        die("Invalid PUC Certificate file type! Only JPG, JPEG, PNG, and PDF are allowed.");
    }
    $puc_cert_path = $uploadDir . time() . "_PUC_" . basename($_FILES["puc_cert"]["name"]);

    // Validate form inputs and file uploads
    if (!empty($vehicle_model) && !empty($rc_number) && !empty($insurance_no) && !empty($puc_no) &&
        !empty($prize_perkm) && !empty($_FILES["puc_cert"]["name"]) && !empty($_FILES["rc_book"]["name"])) {

        // Move uploaded files
        if (move_uploaded_file($_FILES["puc_cert"]["tmp_name"], $puc_cert_path) &&
            move_uploaded_file($_FILES["rc_book"]["tmp_name"], $rc_book_path)) {

            // Insert data into the table
            $query = "INSERT INTO vehicles_infom (driver_id, model, number, insurance, puc, puc_cert, rc_book, prize_perkm) 
                      VALUES ('$driver_id', '$vehicle_model', '$rc_number', '$insurance_no', '$puc_no', '$puc_cert_path', '$rc_book_path', '$prize_perkm')";

            if (mysqli_query($con, $query)) {
                echo "<script>
                alert('Driver Registered Successfully!');
                window.location.href = 'Driver.php'; 
              </script>";
            } else {
                die("Database Error: " . mysqli_error($con));
            }
        } else {
            die("File Upload Failed!");
        }
    } else {
        die("Please enter valid information and upload required files.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details</title>
    <link rel="stylesheet" href="home.css">
   
</head>

<body onload="<?php if (!empty($success_message)) echo 'redirectToLogin();' ?>">
<form method="post" enctype="multipart/form-data">
    <div class="signup-container">
        <h2>Vehicle Details</h2>
        
        <?php if (!empty($success_message)): ?>
            <p style="color: green; font-weight: bold;"><?= $success_message; ?></p>
        <?php endif; ?>
        
        <input type="text" name="model" placeholder="Vehicle Model" required>
        <input type="text" name="number" placeholder="RC Book Number" required>
        
        <label>Upload RC Book:</label>
        <input type="file" name="rc_book" required>
        
        <input type="text" name="insurance" placeholder="Insurance No" required>
        <input type="text" name="puc" placeholder="PUC No" required>
        
        <label>Upload PUC Certificate:</label>
        <input type="file" name="puc_cert" required>
        <input type="text" name="prize_perkm" placeholder="Price per KM" required>

        <div class="btn">
            <button type="submit">Submit</button>
            <button type="reset">Clear</button>      
        </div>
    </div>
</form>
</body>
</html>
