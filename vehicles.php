<?php
include("db_connect.php");

// Fetch all vehicles
$query = "SELECT * FROM vehicles_infom";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">🚖 Vehicle Management</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Number</th>
                    <th>Insurance</th>
                    <th>PUC</th>
                    <th>Price per KM</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['vehicle_id']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['number']; ?></td>
                        <td><?php echo $row['insurance']; ?></td>
                        <td><?php echo $row['puc']; ?></td>
                        <td><?php echo $row['prize_perkm']; ?> ₹</td>
                        <td>
                            <span class="status <?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm <?php echo $row['status'] == 'active' ? 'btn-danger' : 'btn-success'; ?>" 
                                    onclick="toggleStatus(<?php echo $row['vehicle_id']; ?>, '<?php echo $row['status']; ?>')">
                                <?php echo $row['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleStatus(vehicle_id, current_status) {
    $.ajax({
        url: "update_status.php",
        type: "POST",
        data: { vehicle_id: vehicle_id, status: current_status },
        success: function (response) {
            if (response.trim() === "success") {
                location.reload();
            } else {
                alert("Failed to update status.");
            }
        }
    });
}

    </script>
</body>
</html>
