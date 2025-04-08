<?php
include("connection.php");


function fetch_data($con, $query) {
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("Database Query Failed: " . mysqli_error($con)); 
    }
    return $result;
}

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $role = $_GET['role'];
    $table = ($role == "Customer") ? "customer_regist" : "driverre";
    $id_column = ($role == "Customer") ? "Customer_id" : "Driver_id";

    $query = "UPDATE $table SET approval_status='Approved' WHERE $id_column=$id";
    if (!mysqli_query($con, $query)) {
        die("Approval Failed: " . mysqli_error($con));
    }

    header("Location: admin_approval.php");
    exit;
}


if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $role = $_GET['role'];
    $table = ($role == "Customer") ? "customer_regist" : "driverre";
    $id_column = ($role == "Customer") ? "Customer_id" : "Driver_id";

    $query = "UPDATE $table SET approval_status='Rejected' WHERE $id_column=$id";
    if (!mysqli_query($con, $query)) {
        die("Rejection Failed: " . mysqli_error($con));
    }

    header("Location: admin_approval.php");
    exit;
}


$customers = fetch_data($con, "SELECT Customer_id, fname, email FROM customer_regist WHERE approval_status='Pending'");
$drivers = fetch_data($con, "SELECT Driver_id, fname, email FROM driverre  WHERE approval_status='Pending'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Pending Approvals</h2>

    <h3>Customers</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($customers)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['Customer_id']) ?></td>
            <td><?= htmlspecialchars($row['fname']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="?approve=<?= $row['Customer_id'] ?>&role=Customer" class="btn btn-success">Approve</a>
                <a href="?reject=<?= $row['Customer_id'] ?>&role=Customer" class="btn btn-danger">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h3>Drivers</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($drivers)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['Driver_id']) ?></td>
            <td><?= htmlspecialchars($row['fname']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="?approve=<?= $row['Driver_id'] ?>&role=Driver" class="btn btn-success">Approve</a>
                <a href="?reject=<?= $row['Driver_id'] ?>&role=Driver" class="btn btn-danger">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
