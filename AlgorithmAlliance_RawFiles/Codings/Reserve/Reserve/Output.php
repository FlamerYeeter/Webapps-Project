<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="urban_oasis_resort_transparent.png">
    <title>Reservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="reserve.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="jsscript.js"></script>
</head>
<body>
    <header class="header" id="header">
        <div class="nav-bar">
          <ul class="menu">
            <li><a href="Gallery.html">Gallery</a></li>
            <li><a href="About Us.html">About Us</a></li>
            <li><a href="Home.html">Home</a></li>
            <li class="logo-item"><a href="#"><img src="urban_oasis_resort_transparent.png" alt="Logo"></a></li>
            <li><a href="Review.html">Reviews</a></li>
            <li><a href="Rooms.html">Rooms</a></li>
            <li><a href="Reserve.html">Reserve</a></li>
          </ul>
        </div>
        <h1 class="title_p">Reserve</h1>
      </header>

    <div class="container">
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
        <div class="reservation-container">
            <div class="reservation-form">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $first_name = $_POST["first-name"];
                    $middle_name = $_POST["middle-name"];
                    $last_name = $_POST["last-name"];
                    $gender = $_POST["gender"];
                    $address = $_POST["address"];
                    $contact_number = $_POST["contact-number"];
                    $booking_date = $_POST["booking-date"];
                    $amount_payed = $_POST["amount-payed"];
                    $gcash_reference = $_POST["gcash-reference"];

                    echo "<h2>Reservation Details</h2>";
                    echo "<div class='form-row'><label>First Name:</label><span>$first_name</span></div>";
                    echo "<div class='form-row'><label>Middle Name:</label><span>$middle_name</span></div>";
                    echo "<div class='form-row'><label>Last Name:</label><span>$last_name</span></div>";
                    echo "<div class='form-row'><label>Gender:</label><span>$gender</span></div>";
                    echo "<div class='form-row'><label>Address:</label><span>$address</span></div>";
                    echo "<div class='form-row'><label>Contact Number:</label><span>$contact_number</span></div>";
                    echo "<div class='form-row'><label>Booking Date:</label><span>$booking_date</span></div>";
                    echo "<div class='form-row'><label>Amount Payed:</label><span>$amount_payed</span></div>";
                    echo "<div class='form-row'><label>GCash Reference:</label><span>$gcash_reference</span></div>";
                }
                ?>
            </div>
        </div>
    </div>
    
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color available"></div>
                <span class="legend-text">Available</span>
            </div>
            <div class="legend-item">
                <div class="legend-color reserved"></div>
                <span class="legend-text">Fully Booked</span>
            </div>
        </div>    
</body>
</html>
