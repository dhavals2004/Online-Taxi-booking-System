<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['driver_id'])) {
    header("Location: driver_login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];

// Fetch rides from the bookrecord table.
$query = "SELECT br.booking_id, br.pickup_location, br.drop_location, br.price, br.status, 
                 c.fname AS customer_name 
          FROM bookrecord br
          JOIN customer_regist c ON br.customer_id = c.Customer_id
          WHERE br.status IN ('Pending','Confirmed','Pickup','Drop')
          ORDER BY br.booking_id DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Driver Dashboard - Ride Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f4f9; font-family: 'Poppins', sans-serif; }
    .container { margin-top: 30px; }
    .action-btn { margin: 2px; }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4">Driver Dashboard - Ride Requests</h2>
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Booking ID</th>
          <th>Customer Name</th>
          <th>Pickup Location</th>
          <th>Drop-off Location</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="ride-list">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr id="ride-<?php echo $row['booking_id']; ?>">
              <td><?php echo $row['booking_id']; ?></td>
              <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
              <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
              <td><?php echo htmlspecialchars($row['drop_location']); ?></td>
              <td><?php echo number_format($row['price'], 2); ?></td>
              <td id="status-<?php echo $row['booking_id']; ?>"><?php echo $row['status']; ?></td>
              <td>
                <?php if ($row['status'] == 'Pending'): ?>
                  <button class="btn btn-success action-btn accept-btn" data-id="<?php echo $row['booking_id']; ?>">Accept</button>
                  <button class="btn btn-danger action-btn cancel-btn" data-id="<?php echo $row['booking_id']; ?>">Cancel</button>
                <?php elseif ($row['status'] == 'Confirmed'): ?>
                  <button class="btn btn-primary action-btn pickup-btn" data-id="<?php echo $row['booking_id']; ?>">Pickup</button>
                  <button class="btn btn-danger action-btn cancel-btn" data-id="<?php echo $row['booking_id']; ?>">Cancel</button>
                <?php elseif ($row['status'] == 'Pickup'): ?>
                  <button class="btn btn-warning action-btn drop-btn" data-id="<?php echo $row['booking_id']; ?>">Drop</button>
                <?php elseif ($row['status'] == 'Drop'): ?>
                  <button class="btn btn-success action-btn payment-btn" data-id="<?php echo $row['booking_id']; ?>">Payment</button>
                  <button class="btn btn-info action-btn complete-btn" data-id="<?php echo $row['booking_id']; ?>">Complete</button>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">No ride requests found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal for Payment Details -->
  <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="payment-details">
          <!-- Payment details will be injected here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
  
      function updateRideStatus(rideId, newStatus) {
        console.log("Updating status:", rideId, newStatus); // Debugging
        $.ajax({
          url: 'update_ride_status.php',
          method: 'POST',
          dataType: 'json',
          data: { ride_id: rideId, status: newStatus },
          success: function (response) {
            console.log("Update response:", response);
            if (response.success) {
              $('#status-' + rideId).text(newStatus);
              alert(response.message);
              location.reload();
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.log("AJAX Error:", xhr.responseText);
            alert("An error occurred: " + error);
          }
        });
      }

      function fetchPaymentDetails(rideId) {
        console.log("Fetching payment details for Booking ID:", rideId); // Debugging
        $.ajax({
          url: 'fetch_payment.php',
          method: 'POST',
          dataType: 'json',
          data: { booking_id: rideId },
          success: function (response) {
            console.log("Server response:", response);
            if (response.success) {
              // Show the payment details in the modal
              var paymentInfo = `
              <p><strong>Customer Name:</strong> ${response.customer_name}</p>
                <p><strong>Payment ID:</strong> ${response.payment_id}</p>
                <p><strong>Amount:</strong> ${response.amount}</p>
                <p><strong>Status:</strong> ${response.status}</p>
              `;
              $('#payment-details').html(paymentInfo);
              $('#paymentModal').modal('show');
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.log("AJAX Error:", xhr.responseText);
            alert("An error occurred: " + error);
          }
        });
      }

      $(document).on("click", ".accept-btn", function () {
        var rideId = $(this).data("id");
        updateRideStatus(rideId, "Confirmed");
      });

      $(document).on("click", ".cancel-btn", function () {
        var rideId = $(this).data("id");
        updateRideStatus(rideId, "Cancelled");
      });

      $(document).on("click", ".pickup-btn", function () {
        var rideId = $(this).data("id");
        updateRideStatus(rideId, "Pickup");
      });

      $(document).on("click", ".drop-btn", function () {
        var rideId = $(this).data("id");
        updateRideStatus(rideId, "Drop");
      });

      $(document).on("click", ".complete-btn", function () {
        var rideId = $(this).data("id");
        updateRideStatus(rideId, "Completed");
        
      });

      $(document).on("click", ".payment-btn", function () {
        var rideId = $(this).data("id");
        fetchPaymentDetails(rideId);
      });

    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
