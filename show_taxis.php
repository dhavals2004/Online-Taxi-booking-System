<?php
session_start();
include("connection.php");


$query = "SELECT * FROM vehicles_infom";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Taxis</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">All Taxis</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Vehicle ID</th>
                <th>Model</th>
                <th>RC Number</th>
                <th>Insurance No</th>
                <th>PUC No</th>
                <th>Price per KM</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr id="row_<?php echo $row['vehicle_id']; ?>">
                <td><?php echo $row['vehicle_id']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['number']; ?></td>
                <td><?php echo $row['insurance']; ?></td>
                <td><?php echo $row['puc']; ?></td>
                <td><?php echo $row['prize_perkm']; ?> ₹</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteTaxi(<?php echo $row['vehicle_id']; ?>)">
                        Delete
                    </button>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>


<script>
function deleteTaxi(vehicleId) {
    if (confirm("Are you sure you want to delete this taxi?")) {
        fetch('delete_taxi.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'vehicle_id=' + vehicleId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('row_' + vehicleId).remove();
                alert("Taxi deleted successfully!");
            } else {
                alert("Error deleting taxi!");
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>

</body>
</html>
