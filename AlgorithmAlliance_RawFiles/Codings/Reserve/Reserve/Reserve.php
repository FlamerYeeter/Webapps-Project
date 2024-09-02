<?php
$servername = "localhost";
$port = 3306;
$username = "root";
$password = "";
$dbname = "resortdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $checkIn = $_POST["check-in"];
    $checkOut = $_POST["check-out"];
    $room = $_POST["room"];
    $adults = $_POST["adults"];
    $children = $_POST["children"];
    $promoCode = $_POST["promo-code"];
    $others = $_POST["others"];
    $visitTime = $_POST["visit-time"];
    $othersAdults = $_POST["others-adults"];
    $othersChildren = $_POST["others-children"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO reservations (check_in, check_out, room, adults, children, promo_code, others, visit_time, others_adults, others_children) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $checkIn, $checkOut, $room, $adults, $children, $promoCode, $others, $visitTime, $othersAdults, $othersChildren);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "Reservation submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
