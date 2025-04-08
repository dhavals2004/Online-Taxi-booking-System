<?php 

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$database = "taxibooking";  

$conn = new mysqli($host, $user, $password, $database);  


if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  


$sql = "SELECT 
            b.booking_id, 
            c.fname AS customer_name, 
            COALESCE(d.fname, 'Not Assigned') AS driver_name, 
            v.model AS vehicle_name, 
            b.pickup_location, 
            b.drop_location, 
            b.pickup_time, 
            b.drop_time, 
            b.price, 
            b.status
        FROM bookrecord b
        LEFT JOIN customer_regist c ON b.customer_id = c.customer_id
        LEFT JOIN driverre d ON b.driver_id = d.driver_id
        LEFT JOIN vehicles_infom v ON b.vehicle_id = v.vehicle_id
        ORDER BY b.booking_id DESC";  

$result = $conn->query($sql);  

if (!$result) {     
    die("Query failed: " . $conn->error); 
} 
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Booking List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Driver Name</th>
                <th>Vehicle Name</th>
                <th>Pickup Location</th>
                <th>Drop Location</th>
                <th>Pickup Date/Time</th>
                <th>Drop Date/Time</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) { 
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['driver_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicle_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['drop_location']); ?></td>
                        <td><?php echo !empty($row['pickup_time']) ? date('d-m-Y H:i:s', strtotime($row['pickup_time'])) : 'N/A'; ?></td>
                        <td><?php echo !empty($row['drop_time']) ? date('d-m-Y H:i:s', strtotime($row['drop_time'])) : 'N/A'; ?></td>
                        <td><?php echo "₹" . number_format($row['price'], 2); ?></td>
                        <td>
                            <?php 
                            switch ($row['status']) {
                                case 'Completed':
                                    echo "<span class='badge bg-success'>Completed</span>";
                                    break;
                                case 'Confirmed':
                                    echo "<span class='badge bg-primary'>Confirmed</span>";
                                    break;
                                case 'Pending':
                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                    break;
                                case 'Cancelled':
                                    echo "<span class='badge bg-danger'>Cancelled</span>";
                                    break;
                                case 'Pickup':
                                    echo "<span class='badge bg-info'>Pickup</span>";
                                    break;
                                case 'Drop':
                                    echo "<span class='badge bg-secondary'>Drop</span>";
                                    break;
                                default:
                                    echo "<span class='badge bg-secondary'>Unknown</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } 
            } else { 
                echo "<tr><td colspan='10' class='text-center'>No bookings found</td></tr>"; 
            } ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php 
$conn->close(); 
?>
