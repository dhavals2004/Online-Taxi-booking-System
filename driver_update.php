<?php
session_start();
include 'db_connect.php';

// Ensure driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: Driver login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];

// Fetch existing driver details
$stmt = $conn->prepare("SELECT * FROM driverre WHERE Driver_id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Driver Information</title>
    
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

        <form action="update_driver_process.php" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="driver_id" value="<?= $driver['Driver_id'] ?>">

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" class="form-control" name="fname" value="<?= htmlspecialchars($driver['fname']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($driver['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($driver['phone']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($driver['username']) ?>" required>
            </div>

            <div class="mb-3">
                <label>New Password (Leave blank to keep old password)</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="mb-3">
                <label>Licence Number</label>
                <input type="text" class="form-control" name="licence_no" value="<?= htmlspecialchars($driver['licence_no']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea class="form-control" name="address" required><?= htmlspecialchars($driver['address']) ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update Information</button>
        </form>

        <div class="mt-3 text-center">
            <a href="driverdashbord.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
