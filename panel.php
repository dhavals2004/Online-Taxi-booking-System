<?php
// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "taxibooking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_bookings = "SELECT COUNT(*) AS total_bookings FROM bookrecord";
$result_bookings = $conn->query($sql_bookings);
$total_bookings = ($result_bookings->num_rows > 0) ? $result_bookings->fetch_assoc()["total_bookings"] : 0;

$sql_cancellations = "SELECT COUNT(*) AS total_cancellations FROM cancellation";
$result_cancellations = $conn->query($sql_cancellations);
$total_cancellations = ($result_cancellations->num_rows > 0) ? $result_cancellations->fetch_assoc()["total_cancellations"] : 0;

$sql_drivers = "SELECT COUNT(*) AS total_drivers FROM driverre";
$result_drivers = $conn->query($sql_drivers);
$total_drivers = ($result_drivers->num_rows > 0) ? $result_drivers->fetch_assoc()["total_drivers"] : 0;

$sql_customers = "SELECT COUNT(*) AS total_customers FROM customer_regist";
$result_customers = $conn->query($sql_customers);
$total_customers = ($result_customers->num_rows > 0) ? $result_customers->fetch_assoc()["total_customers"] : 0;

$sql_vehicles = "SELECT COUNT(*) AS total_vehicles FROM vehicles_infom";
$result_vehicles = $conn->query($sql_vehicles);
$total_vehicles = ($result_vehicles->num_rows > 0) ? $result_vehicles->fetch_assoc()["total_vehicles"] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxi Booking Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color:black;
            color: white;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 15px;
            background-color: #007bff;
            border-radius: 5px;
            margin: 0 10px;
        }
        .header a.logout {
            background-color: red;
        }
        .header a:hover {
            opacity: 0.8;
        }
        .sidebar {
            height: 100vh;
            background-color:rgb(13, 15, 17);
            color: white;
            position: fixed;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: background 0.3s ease-in-out;
            cursor: pointer;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #495057;
            font-weight: bold;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h5 {
            font-size: 18px;
        }
        .card p {
            font-size: 22px;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="header">
    
    <img src="final logo.jpg" width="150" height="70">
    <h2>Admin Dashbord</h2>
    
        
    <div>
        <a href="admin.php" class="logout" >Logout</a>

    </div>
</div>
<div class="sidebar">
    <h2 class="text-center py-3">Admin Panel</h2>
    <a href=""><i class="fas fa-tachometer-alt"></i> Dashboard</a>

    <!-- Booking Management Section -->
    <a href="#bookingMenu" data-bs-toggle="collapse">
        <i class="fas fa-book"></i> Booking Management <i class="fas fa-chevron-down float-end"></i>
    </a>
    <div class="collapse" id="bookingMenu">
        <a href="booking repot.php" class="ps-4"><i class="fas fa-file-alt"></i> Booking Report</a>
        <a href="Cancellation repor.php" class="ps-4"><i class="fas fa-file-alt"></i> Cancellation Report</a>
    </div>

    <!-- User Management Section -->
    <a href="#userMenu" data-bs-toggle="collapse">
        <i class="fas fa-users"></i> User Management <i class="fas fa-chevron-down float-end"></i>
    </a>
    <div class="collapse" id="userMenu">
        <a href="Customer Signup.php" class="ps-4"><i class="fas fa-user-plus"></i> Add Customer</a>
        <a href="Driver Signup.php" class="ps-4"><i class="fas fa-user-tie"></i> Add Driver</a>
        <a href="admin_approval.php" class="ps-4"><i class="fas fa-user-check"></i> Manage Users</a>
        <a href="admin Signup.php" class="ps-4"><i class="fas fa-user-plus"></i> Add Admin</a>
    </div>

    <!-- Taxi Management Section -->
    <a href="#taxiMenu" data-bs-toggle="collapse">
        <i class="fas fa-taxi"></i> Taxi Management <i class="fas fa-chevron-down float-end"></i>
    </a>
    <div class="collapse" id="taxiMenu">
        <!-- <a href="vehicle.php" class="ps-4"><i class="fas fa-car"></i> Add Taxi</a> -->
        <a href="show_taxis.php" class="ps-4"><i class="fas fa-trash-alt"></i> Delete Taxi</a>
         <a href="vehicles.php" class="ps-4"><i class="fas fa-edit"></i> Edit Taxi</a>
    </div>
    <a href="#paymentMenu" data-bs-toggle="collapse">
    <i class="fas fa-credit-card"></i> Payment Management <i class="fas fa-chevron-down float-end"></i>
</a>
<div class="collapse" id="paymentMenu">
    <a href="payment_details.php" class="ps-4"><i class="fas fa-file-invoice"></i> Payment Report</a>
</div>

</div>
    <div class="main-content">
        <section id="dashboard">
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-bg-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Bookings</h5>
                            <p class="card-text"><?php echo $total_bookings; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-success">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Drivers</h5>
                            <p class="card-text"><?php echo $total_drivers; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-info">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Customers</h5>
                            <p class="card-text"><?php echo $total_customers; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-dark">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Vehicles</h5>
                            <p class="card-text"><?php echo $total_vehicles; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-warning">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cancellation Rides</h5>
                            <p class="card-text"><?php echo $total_cancellations; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
