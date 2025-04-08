<?php
session_start();
include("db_connect.php");

// Simulate a logged-in customer (for demo purposes, must be set)
if (!isset($_SESSION['customer_id'])) {
    die("❌ Please login to view your booking.");
}
$customer_id = $conn->real_escape_string($_SESSION["customer_id"]);

// Fetch only active vehicles from vehicles_infom
$vehicle_query = "SELECT vehicle_id, model FROM vehicles_infom WHERE status='active'";
$vehicle_result = $conn->query($vehicle_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Taxi Booking System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background-color: white;
      padding: 30px;
      border-radius: 9px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 600px;
      text-align: center;
    }
    select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      font-size: 16px;
    }
    button {
      background: rgb(19, 65, 20);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover { background: rgb(34, 4, 2); }
    .message {
      font-weight: bold;
      margin-top: 10px;
    }
    .success { color: green; }
    .error { color: red; }
  </style>
</head>
<body>
<div class="form-container">
  <h2> Book a Taxi</h2>
  <form id="bookingForm">
    <!-- Hidden field for customer id -->
    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

    <label for="pickup">Pickup Location:</label>
    <select name="pickup" id="pickup" required>
      <option value="">-- Select Pickup Location --</option>
      <option value="Sector-1">Sector-1</option>
<option value="Sector-2">Sector-2</option>
<option value="Sector-2 Circle">Sector-2 Circle</option>
<option value="Sector-3">Sector-3</option>
<option value="Sector-4">Sector-4</option>
<option value="Sector-5">Sector-5</option>
<option value="Sector-6">Sector-6</option>
<option value="Sector-7">Sector-7</option>
<option value="Sector-8">Sector-8</option>
<option value="Sector-9">Sector-9</option>
<option value="Sector-10">Sector-10</option>
<option value="Sector-11">Sector-11</option>
<option value="Sector-12">Sector-12</option>
<option value="Sector-13">Sector-13</option>
<option value="Sector-14">Sector-14</option>
<option value="Sector-15">Sector-15</option>
<option value="Sector-16">Sector-16</option>
<option value="Sector-17">Sector-17</option>
<option value="Sector-18">Sector-18</option>
<option value="Sector-19">Sector-19</option>
<option value="Sector-20">Sector-20</option>
<option value="Sector-21">Sector-21</option>
<option value="Sector-22">Sector-22</option>
<option value="Sector-23">Sector-23</option>
<option value="Sector-24">Sector-24</option>
<option value="Sector-25">Sector-25</option>
<option value="Sector-26">Sector-26</option>
<option value="Sector-27">Sector-27</option>
<option value="Sector-28">Sector-28</option>
<option value="Sector-29">Sector-29</option>
<option value="Sector-30">Sector-30</option>
<option value="GIFT City">GIFT City</option>
<option value="Infocity">Infocity</option>
<option value="DAIICT">DAIICT</option>
<option value="PDPU">PDPU</option>
<option value="Kudasan">Kudasan</option>
<option value="Sargasan">Sargasan</option>
<option value="Gujarat High Court">Gujarat High Court</option>
<option value="Gujarat Police Bhavan">Gujarat Police Bhavan</option>


    </select>

    <label for="drop">Drop Location:</label>
    <select name="drop" id="drop" required>
      <option value="">-- Select Drop Location --</option>
      <option value="Sector-1">Sector-1</option>
<option value="Sector-2">Sector-2</option>
<option value="Sector-2 Circle">Sector-2 Circle</option>
<option value="Sector-3">Sector-3</option>
<option value="Sector-4">Sector-4</option>
<option value="Sector-5">Sector-5</option>
<option value="Sector-6">Sector-6</option>
<option value="Sector-7">Sector-7</option>
<option value="Sector-8">Sector-8</option>
<option value="Sector-9">Sector-9</option>
<option value="Sector-10">Sector-10</option>
<option value="Sector-11">Sector-11</option>
<option value="Sector-12">Sector-12</option>
<option value="Sector-13">Sector-13</option>
<option value="Sector-14">Sector-14</option>
<option value="Sector-15">Sector-15</option>
<option value="Sector-16">Sector-16</option>
<option value="Sector-17">Sector-17</option>
<option value="Sector-18">Sector-18</option>
<option value="Sector-19">Sector-19</option>
<option value="Sector-20">Sector-20</option>
<option value="Sector-21">Sector-21</option>
<option value="Sector-22">Sector-22</option>
<option value="Sector-23">Sector-23</option>
<option value="Sector-24">Sector-24</option>
<option value="Sector-25">Sector-25</option>
<option value="Sector-26">Sector-26</option>
<option value="Sector-27">Sector-27</option>
<option value="Sector-28">Sector-28</option>
<option value="Sector-29">Sector-29</option>
<option value="Sector-30">Sector-30</option>
<option value="GIFT City">GIFT City</option>
<option value="Infocity">Infocity</option>
<option value="DAIICT">DAIICT</option>
<option value="PDPU">PDPU</option>
<option value="Kudasan">Kudasan</option>
<option value="Sargasan">Sargasan</option>
<option value="Gujarat High Court">Gujarat High Court</option>
<option value="Gujarat Police Bhavan">Gujarat Police Bhavan</option>

    </select>

    <label for="vehicle">Select a Vehicle:</label>
    <select name="vehicle_id" id="vehicle" required>
      <option value="">-- Choose a Vehicle --</option>
      <?php
      if ($vehicle_result && $vehicle_result->num_rows > 0) {
          while ($row = $vehicle_result->fetch_assoc()) {
              echo "<option value='" . htmlspecialchars($row["vehicle_id"]) . "'>🚘 " 
              . htmlspecialchars($row["model"]) . "  4</option>";
          }
      } else {
          echo "<option value=''>⚠ No active vehicles available</option>";
      }
      ?>
    </select>

    <button type="submit">Book Ride</button>
  </form>
  <div id="message" class="message"></div>
</div>

<script>
// Handle form submission with AJAX
document.getElementById("bookingForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const messageDiv = document.getElementById("message");
    messageDiv.textContent = "Please wait, confirming your booking...";
    messageDiv.className = "message";

    fetch("process_booking.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        messageDiv.textContent = data.message;
        messageDiv.className = data.success ? "message success" : "message error";
        if (data.success) {
            
            setTimeout(() => { window.location.href = "booking_status.php"; }, 2000);
        }
    })
    .catch(error => {
        messageDiv.textContent = "An error occurred. Please try again.";
        messageDiv.className = "message error";
    });
});
</script>
</body>
</html>
<?php $conn->close(); ?>
