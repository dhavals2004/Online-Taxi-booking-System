<?php 
session_start();
include("db_connect.php");

// Fetch all booking and payment details
$sql = "SELECT 
            b.booking_id, 
            c.fname AS customer_name, 
            COALESCE(d.fname, 'Not Assigned') AS driver_name, 
            v.model AS vehicle_name, 
            b.price, 
            b.status AS booking_status,
            p.payment_id,
            p.status AS payment_status,
            p.payment_date,
            p.amount AS paid_amount,
            b.price 
        FROM bookrecord b
        LEFT JOIN customer_regist c ON b.customer_id = c.customer_id
        LEFT JOIN driverre d ON b.driver_id = d.driver_id
        LEFT JOIN vehicles_infom v ON b.vehicle_id = v.vehicle_id
        LEFT JOIN payment p ON b.booking_id = p.booking_id  -- Join payment table
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
    <title>Admin Payment Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">All Payment Details</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Driver Name</th>
                <th>Vehicle Name</th>
                <th>Total Fare</th>
                
                <th>Payment ID</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
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
                        <td><?php echo "₹" . number_format($row['price'], 2); ?></td>
                        
                        <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                        <td>
                            <?php 
                            if ($row['payment_status'] == 'Paid') {
                                echo "<span class='badge bg-success'>Paid</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Unpaid</span>";
                            }
                            ?>
                        </td>
                        <td><?php echo !empty($row['payment_date']) ? date('d-m-Y H:i:s', strtotime($row['payment_date'])) : ''; ?></td>
                    </tr>
                <?php } 
            } else { 
                echo "<tr><td colspan='13' class='text-center'>No payment details found</td></tr>"; 
            } ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php 
$conn->close();
?>
