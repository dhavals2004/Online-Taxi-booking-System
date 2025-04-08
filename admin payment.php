<?php
session_start();
include 'db_connect.php'; // Database connection

// Fetch driver payments and ride details
$query = "SELECT d.id AS driver_id, d.fname AS driver_name, 
                 r.booking_id AS ride_id, r.price AS fare, 
                 r.status, r.payment_status 
          FROM driverre d 
          JOIN bookrecord r ON d.Driver_id = r.driver_id 
          ORDER BY r.booking_id DESC";
$result = mysqli_query($conn, $query);

if (isset($_POST['mark_paid'])) {
    $ride_id = $_POST['ride_id'];

    // Use prepared statement to prevent SQL injection
    $update_query = "UPDATE bookrecord SET payment_status = 'Paid' WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "i", $ride_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: admin_driver_payments.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Payments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Driver Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Driver Name</th>
                <th>Ride ID</th>
                <th>Fare</th>
                <th>Ride Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['driver_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['ride_id']); ?></td>
                    <td><?php echo number_format($row['fare'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                    <td>
                        <?php if ($row['payment_status'] == 'Pending') { ?>
                            <form method="POST">
                                <input type="hidden" name="ride_id" value="<?php echo $row['ride_id']; ?>">
                                <button type="submit" name="mark_paid">Mark as Paid</button>
                            </form>
                        <?php } else { ?>
                            <span style="color: green;">Paid</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
