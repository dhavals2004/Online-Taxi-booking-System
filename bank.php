<?php
session_start();
include("connection.php");


if (!isset($_SESSION['driver_id'])) {
    die("Error: Driver ID not found in session. Please complete registration first.");
}

$driver_id = $_SESSION['driver_id']; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);
    $account_no = mysqli_real_escape_string($con, $_POST['account_no']);
    $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc_code']);
    $branch_name = mysqli_real_escape_string($con, $_POST['branch_name']);

    if (!empty($bank_name) && !empty($account_no) && !empty($ifsc_code) && !empty($branch_name)) {
        if (isset($_FILES['passbook_photo']) && $_FILES['passbook_photo']['error'] == 0) {
            $upload_dir = "uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_ext = strtolower(pathinfo($_FILES['passbook_photo']['name'], PATHINFO_EXTENSION));
            $allowed_types = ["jpg", "jpeg", "png", "pdf"];
            if (!in_array($file_ext, $allowed_types)) {
                die("Invalid file type! Only JPG, JPEG, PNG, and PDF files are allowed.");
            }

            $passbook_photo_name = time() . "_" . basename($_FILES['passbook_photo']['name']);
            $passbook_photo_path = $upload_dir . $passbook_photo_name;

            if (move_uploaded_file($_FILES['passbook_photo']['tmp_name'], $passbook_photo_path)) {
                $query = "INSERT INTO bankingss (driver_id, bank_name, account_no, ifsc_code, branch_name, passbook_photo) 
                          VALUES ('$driver_id', '$bank_name', '$account_no', '$ifsc_code', '$branch_name', '$passbook_photo_path')";

                if (mysqli_query($con, $query)) {
                    echo "<script>alert('Successfully Registered! Redirecting to Vehicle Details...');</script>";
                    header("Location: vehicle.php");
                    exit();
                } else {
                    die("Query Error: " . mysqli_error($con));
                }
            } else {
                die("File Upload Error!");
            }
        } else {
            die("Please upload a valid passbook photo.");
        }
    } else {
        die("Please fill in all the fields correctly.");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Details</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div class="signup-container">
        <h2>Bank Details</h2>
        
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
