<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $business_name = $_POST['business_name'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    $ifsc_code = $_POST['ifsc_code'];
    $branch_name = $_POST['branch_name'];

    // Handle file upload for bank passbook photo
    if (isset($_FILES['passbook_photo']) && $_FILES['passbook_photo']['error'] == 0) {
        $passbook_photo_name = $_FILES['passbook_photo']['name'];
        $passbook_photo_tmp = $_FILES['passbook_photo']['tmp_name'];
        $upload_dir = "uploads/";  // Make sure this directory exists
        $passbook_photo_path = $upload_dir . basename($passbook_photo_name);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($passbook_photo_tmp, $passbook_photo_path)) {
            // Validate other form fields
            if (!empty($business_name) && !empty($bank_name) && !empty($account_no) && !empty($ifsc_code) && !empty($branch_name)) {
                // Insert data into the database
                $query = "INSERT INTO business (business_name, bank_name, account_no, ifsc_code, branch_name, passbook_photo)
                          VALUES ('$business_name', '$bank_name', '$account_no', '$ifsc_code', '$branch_name', '$passbook_photo_path')";
                
                if (mysqli_query($con, $query)) {
                    echo "<script>alert('Successfully Registered!');</script>";
                    header("Location: vehicle.php");
                    exit();
                } else {
                    echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Please fill in all the fields correctly.');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload passbook photo.');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid passbook photo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank/Business Details</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div class="signup-container">
        <h2>Bank/Business Details</h2>
        <input type="text" name="business_name" placeholder="Business Name" required>
        <input type="text" name="bank_name" placeholder="Bank Name" required>
        <input type="text" name="account_no" placeholder="Account No" required>
        <input type="text" name="ifsc_code" placeholder="IFSC Code" required>
        <input type="text" name="branch_name" placeholder="Branch Name" required>

        <!-- Bank Passbook Photo Upload -->
        <label for="passbook_photo">Upload Bank Passbook Photo:</label>
        <input type="file" id="passbook_photo" name="passbook_photo" required>

        <div class="btn">
            <button type="submit">Next</button>
            <button type="reset">Clear</button>
        </div>
    </div>
</form>
</body>
</html>
