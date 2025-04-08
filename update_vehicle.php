<?php
session_start();
include 'db_connect.php';

// Check if driver is logged in
$driver_id = $_SESSION['driver_id'] ?? null;
if (!$driver_id) {
    echo "<script>alert('Please login first!'); window.location.href='Driver login.php';</script>";
    exit;
}

// Fetch vehicles for the logged-in driver
$query = "SELECT vehicle_id, model, number FROM vehicles_infom WHERE driver_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('No vehicles found!'); window.location.href='driverdashbord.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vehicle Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Select Vehicle to Update</h2>
    
    <!-- Vehicle selection form -->
    <form action="update_vehicle_info.php" method="GET">
        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Select Vehicle</label>
            <select name="vehicle_id" id="vehicle_id" class="form-select">
                <option value="">Choose a vehicle</option>
                <?php while ($vehicle = $result->fetch_assoc()) { ?>
                    <option value="<?= $vehicle['vehicle_id'] ?>"><?= $vehicle['model'] ?> (<?= $vehicle['number'] ?>)</option>
                <?php } ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Select Vehicle</button>
    </form>
</div>

</body>
</html>
