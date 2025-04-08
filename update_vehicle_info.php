<?php
session_start();
include 'db_connect.php';

// Check if driver is logged in
$driver_id = $_SESSION['driver_id'] ?? null;
if (!$driver_id) {
    echo "<script>alert('Please login first!'); window.location.href='Driver login.php';</script>";
    exit;
}

// Fetch selected vehicle ID
$vehicle_id = $_GET['vehicle_id'] ?? null;
if (!$vehicle_id) {
    echo "<script>alert('No vehicle selected!'); window.location.href='update_vehicle.php';</script>";
    exit;
}

// Fetch vehicle data for the selected vehicle
$query = "SELECT * FROM vehicles_infom WHERE vehicle_id = ? AND driver_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $vehicle_id, $driver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Vehicle not found!'); window.location.href='update_vehicle.php';</script>";
    exit;
}

$vehicle = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vehicle Information</title>
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
    <h2 class="text-center">Update Vehicle Information</h2>
    
    <!-- Vehicle Update Form -->
    <form action="process_vehicle_update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="vehicle_id" value="<?= $vehicle['vehicle_id'] ?>">
        
        <div class="mb-3">
            <label for="model" class="form-label">Vehicle Model</label>
            <input type="text" class="form-control" id="model" name="model" value="<?= $vehicle['model'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="number" class="form-label">Vehicle Number</label>
            <input type="text" class="form-control" id="number" name="number" value="<?= $vehicle['number'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="insurance" class="form-label">Insurance</label>
            <input type="text" class="form-control" id="insurance" name="insurance" value="<?= $vehicle['insurance'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="puc" class="form-label">PUC</label>
            <input type="text" class="form-control" id="puc" name="puc" value="<?= $vehicle['puc'] ?>" required>
        </div>
        
      
        
        <div class="mb-3">
            <label for="prize_perkm" class="form-label">Price per KM</label>
            <input type="number" class="form-control" id="prize_perkm" name="prize_perkm" value="<?= $vehicle['prize_perkm'] ?>" step="0.01" required>
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="active" <?= $vehicle['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $vehicle['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Vehicle</button>
    </form>
    <div class="mt-3 text-center">
        <a href="driverdashbord.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
