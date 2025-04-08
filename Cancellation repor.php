<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancellation Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Cancellation Repot</h2>

    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Cancellation ID</th>
                <th>Booking ID</th>
                <th>Driver Name</th>
                <th>Vehicle Name</th>
                <th>Reason</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="cancellationTable">
            <!-- Data will be loaded here dynamically -->
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    function fetchCancellations() {
        $.ajax({
            url: "fetch_cancellations.php",
            method: "GET",
            success: function (data) {
                let cancellations = JSON.parse(data);
                let tableContent = "";

                cancellations.forEach(cancellation => {
                    tableContent += `
                        <tr>
                            <td>${cancellation.cancellation_id}</td>
                            <td>${cancellation.booking_id}</td>
                            <td>${cancellation.driver_name}</td>
                            <td>${cancellation.vehicle_name}</td>
                            <td>${cancellation.reason}</td>
                            <td>${cancellation.cancellation_time}</td>
                        </tr>
                    `;
                });

                $("#cancellationTable").html(tableContent);
            }
        });
    }

    fetchCancellations(); // Load data on page load

    
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
