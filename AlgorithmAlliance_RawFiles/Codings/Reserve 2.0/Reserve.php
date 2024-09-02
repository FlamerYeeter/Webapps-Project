<?php
session_start();

// Retrieve the values from the submitted form in process_form.html
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["check-in"];
    $endDate = $_POST["check-out"];
    $numStays = $_POST["num-stays"];
    $room = $_POST["room"];
    $adults = $_POST["adults"];
    $children = $_POST["children"];
    $promoCode = $_POST["promo"];
    $totalCost = $_POST["total-cost"];

    // Store the values in session variables
    $_SESSION["check-in"] = $startDate;
    $_SESSION["check-out"] = $endDate;
    $_SESSION["room"] = $room;
    $_SESSION["adults"] = $adults;
    $_SESSION["children"] = $children;
    $_SESSION["promo"] = $promoCode;
    $_SESSION["total-cost"] = $totalCost;
    $_SESSION["num-stays"] = $numStays;

    // Redirect to the process_form.php page
    header("Location: process_form.php");
    exit();
}
?>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="jsscript.js"></script>
</head>
<body>
    <header class="header">
      <div class="nav-bar">
        <ul class="menu">
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/Gallery/facilities.html" id="list" target="_top">Gallery</a></li>
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/AboutUs/About Us.html" target="_top" id="list">About Us</a></li>
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/Home/Home.html" id="list" target="_top">Home</a></li>
          <li class="logo-item" ><a href="" target="_top"><img src="/AlgorithmAlliance_RawFiles/Company Logo.png" alt="Logo"></a></li>
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/Reviews/Review.html" id="list" target="_top">Reviews</a></li>
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/Rooms/Rooms/Rooms.html" id="list">Rooms</a></li>
          <li><a href="/AlgorithmAlliance_RawFiles/Codings/Reserve/Reserve.html" id="list">Reserve</a></li>
        </ul>
      </div>
  </header>      

  <script>
      window.addEventListener("scroll", function() {
        var header = document.querySelector(".header");
        header.classList.toggle("scrolled", window.scrollY > 0);
      });
      </script>


  <script>
    // Create a function to load the navbar content
    function loadNavbar() {
      var navbar = document.querySelector('.nav-bar');
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '/Codings/navbar.html', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          navbar.innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    // Call the loadNavbar function immediately
    loadNavbar();
  </script>

    <div class="reminder-container">
        <p class="reminder">
          For personalized consultations on room types and availability and family offers, please contact urbanoasistarlac@gmail.com or call us on 0956 815 5257.
        </p>
      </div>
      
    <div class="container">
        <div class="calendar-container">
          <div id="calendar"></div>
        </div>
        
        <div class="reservation-container">
          <form class="reservation-form" action="Reserve.php" method="post">
			  <h2>Make a Reservation</h2>
			  <div class="form-row">
				<label for="check-in">Check-in Date:</label>
				<input type="text" id="check-in" name="check-in" readonly>
			  </div>
			  <div class="form-row">
				<label for="check-out">Check-out Date:</label>
				<input type="text" id="check-out" name="check-out" readonly>
			  </div>
			  <div class="form-row">
				<div id="stay-info">
				  <label>Number of Stays:</label>
				  <span id="num-stays">0</span>
				  <input type="hidden" name="num-stays" id="hidden-num-stays" value="">
				</div>
			  </div>
			  <div class="form-row">
				<label for="room">Room:</label>
				<select id="room" name="room">
				  <option value="">Select a room</option>
				  <option value="double-room">Double Room with Private Room (₱2,000)</option>
				  <option value="deluxe-standard">Deluxe Standard Bedroom (₱2,500)</option>
				  <option value="deluxe-pool">Deluxe with Pool View (₱3,000)</option>
				  <option value="deluxe-quadruple">Deluxe Quadruple Room with Balcony (₱3,500)</option>
				</select>
			  </div>
			  <div class="form-row">
				<label for="adults">Adults:</label>
				<input type="number" id="adults" name="adults" min="1" placeholder="Enter number of adults">
			  </div>
			  <div class="form-row">
				<label for="children">Children:</label>
				<input type="number" id="children" name="children" min="1" placeholder="Enter number of children">
			  </div>
			  <div class="form-row">
				<label for="promo">Promo Code:</label>
				<input type="text" id="promo" name="promo">
			  </div>
			  <div class="form-row">
				<label for="total-cost">Total Cost:</label>
				<div id="total-cost" class="value"></div>
				<input type="hidden" name="total-cost" id="hidden-total-cost" value="">
			  </div>
			  <div class="form-row custom-buttons">
				<button type="submit" id="submit-btn">Submit</button>
				<button type="reset" id="clear-btn">Clear</button>
			  </div>
			</form>
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
      </div> 

      <script>
$(document).ready(function() {
  // Hide the selected-adults, selected-children, others-adults, and others-children fields by default
  $("#selected-adults").hide();
  $("#selected-children").hide();
  $("#others-adults").hide();
  $("#others-children").hide();

  $("#visit-time").change(function() {
    var selectedVisitTime = $("#visit-time option:selected").val();

    if (selectedVisitTime === "day-visit" || selectedVisitTime === "night-visit") {
      $("#selected-adults").attr("required", true).show();
      $("#selected-children").attr("required", true).show();
      $("#others-adults").attr("required", true).show();
      $("#others-children").attr("required", true).show();
    } else {
      $("#selected-adults").removeAttr("required").hide();
      $("#selected-children").removeAttr("required").hide();
      $("#others-adults").removeAttr("required").hide();
      $("#others-children").removeAttr("required").hide();
    }
  });

  var reservationDetails = {};

  function calculateTotalCost() {
  var stayPrice = 600;
  var roomPrices = {
    "double-room": 2000,
    "deluxe-standard": 2500,
    "deluxe-pool": 3000,
    "deluxe-quadruple": 3500
  };
  var adultsPrice = 100;
  var childrenPrice = 80;
  var cottagePrices = {
    "cabana-half": 400,
    "cabana-whole": 700
  };
  var dayVisitAdultsPrice = 120;
  var dayVisitChildrenPrice = 80;
  var nightVisitAdultsPrice = 150;
  var nightVisitChildrenPrice = 100;

  var numStays = parseInt($("#num-stays").text());
  $("#hidden-num-stays").val(numStays); // Set the hidden input value
  var selectedRoom = $("#room option:selected").val();
  var adults = parseInt($("#adults").val()) || 0;
  var children = parseInt($("#children").val()) || 0;
  
  var stayCost = numStays * stayPrice;
  var roomCost = roomPrices[selectedRoom] || 0;
  var adultsCost = adults * adultsPrice;
  var childrenCost = children * childrenPrice;

  var totalCost = stayCost + roomCost + adultsCost + childrenCost; /*+ otherCost + visitAdultsCost + visitChildrenCost;*/
  $("#total-cost").text("₱" + totalCost.toLocaleString());
  $("#hidden-total-cost").val(totalCost); // Set the hidden input value
}

// Call the calculateTotalCost function initially
calculateTotalCost();

  // Call the calculateTotalCost function whenever an input value changes
  $(".reservation-form input, .reservation-form select").on("change", calculateTotalCost);

  $("#submit-btn").click(function() {
    var selectedRoom = $("#room option:selected").val();
    var selectedOther = $("#others option:selected").val();
    var enteredAdults = $("#adults").val();
    var enteredChildren = $("#children").val();
    var selectedVisitTime = $("#visit-time option:selected").val();
    var visitAdults = $("#others-adults").val();
    var visitChildren = $("#others-children").val();
    var enteredPromo = $("#promo").val();
    var startDate = $("#check-in").val();
    var endDate = $("#check-out").val();

    // ...

    var reservationDetails = {
        roomName: selectedRoom,
        otherName: selectedOther,
        adults: enteredAdults,
        children: enteredChildren,
        visitTime: selectedVisitTime,
        visitAdults: visitAdults,
        visitChildren: visitChildren,
        promoCode: enteredPromo,
        startDate: startDate,
        endDate: endDate
    };

    if (startDate === "" || endDate === "") {
        alert("Please fill in all the fields.");
        return;
    }
	var inclusions = "";
	// Update inclusions based on selected room
      if (selectedRoom === "double-room") {
        reservationDetails.inclusions =
          "1 double bed and 2 futons. Has a garden view, balcony/terrace, shower, kitchenette. Free breakfast for 2, parking space, free WiFi";
      } else if (selectedRoom === "deluxe-standard") {
        reservationDetails.inclusions =
          "1 double bed and sofa bed. Has a garden view, balcony/terrace, shower, kitchenette. Free breakfast for 2, parking space, welcome drink (coffee or tea), free WiFi, drinking water";
      } else if (selectedRoom === "deluxe-pool") {
        reservationDetails.inclusions =
          "2 queen-sized beds. Has a pool view, balcony/terrace, separate shower/bathtub, shared bathroom, access to private pool, kitchenette. Free breakfast for 2, parking space, welcome drink (coffee or tea), free WiFi, drinking water";
      } else if (selectedRoom === "deluxe-quadruple") {
        reservationDetails.inclusions =
          "4 bunk beds. Has a pool view, balcony/terrace, separate shower/bathtub, shared bathroom, access to private pool, kitchenette. Free breakfast for 2, parking space, welcome drink (coffee or tea), free WiFi, drinking water";
      } else {
        reservationDetails.inclusions = "Free WiFi, Toiletries, Water Bottles, Parking Space";
      }
	  
	sessionStorage.setItem("reservation", JSON.stringify(reservationDetails));
      window.location.href = "process_form.php";
    });
  });
  </script>
</body>
</html>
