<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Ride System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Pending Rides</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Pickup Location</th>
                    <th>Drop-off Location</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ride-list">
               
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            function loadRides() {
                $.getJSON("fetch_bookings.php", function(data) {
                    $("#ride-list").empty();
                    if (data.length === 0) {
                        $("#ride-list").html("<tr><td colspan='5' class='text-center'>No pending rides</td></tr>");
                    } else {
                        data.forEach(ride => {
                            $("#ride-list").append(`
                                <tr id="ride-${ride.booking_id}">
                                    <td>${ride.customer_name}</td>
                                    <td>${ride.pickup_location}</td>
                                    <td>${ride.drop_location}</td>
                                    <td>${ride.price}</td>
                                    <td>
                                        <button class="btn btn-success accept-ride" data-id="${ride.booking_id}">Accept</button>
                                        <button class="btn btn-danger reject-ride" data-id="${ride.booking_id}">Reject</button>
                                        <button class="btn btn-primary pickup-btn" data-id="${ride.booking_id}" style="display: none;">Picked Up</button>
                                        <button class="btn btn-warning dropoff-btn" data-id="${ride.booking_id}" style="display: none;">Dropped Off</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            }

            loadRides();

            // Accept Ride
            $(document).on("click", ".accept-ride", function() {
                let rideId = $(this).data("id");
                updateRideStatus(rideId, "Confirmed");
                $(this).siblings(".pickup-btn").show();
                $(this).siblings(".reject-ride").hide();
                $(this).hide();
            });

            // Reject Ride
            $(document).on("click", ".reject-ride", function() {
                let rideId = $(this).data("id");
                updateRideStatus(rideId, "Cancelled");
                $(`#ride-${rideId}`).remove();
            });

            // Picked Up
            $(document).on("click", ".pickup-btn", function() {
                let rideId = $(this).data("id");
                updateRideStatus(rideId, "Pickup");
                $(this).siblings(".dropoff-btn").show();
                $(this).hide();
            });

            // Dropped Off (Completed Ride)
            $(document).on("click", ".dropoff-btn", function() {
                let rideId = $(this).data("id");
                updateRideStatus(rideId, "Completed"); // Set final status to "Completed"
                $(`#ride-${rideId}`).remove();
            });

            function updateRideStatus(rideId, status) {
                $.post(".php", { ride_id: rideId, status: status }, function(response) {
                    console.log(response);
                });
            }
        });
    </script>
</body>
</html>
