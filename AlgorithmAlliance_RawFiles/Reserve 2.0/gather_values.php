<?php
// Retrieve the values from the submitted form in process_form.html
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];
    $numberOfDays = $_POST["number-of-days"];
    $room = $_POST["selected-room"];
    $roomCost = $_POST["room-cost"];
    $adults = $_POST["adults"];
    $children = $_POST["children"];
    $others = $_POST["selected-others"];
    $visitTime = $_POST["selected-visit-time"];
    $visitAdults = $_POST["visit-adults"];
    $visitChildren = $_POST["visit-children"];
    $promoCode = $_POST["promo-code"];
    $totalCost = $_POST["total-cost"];

    // Store the values in a session or database
    // You can use either session variables or insert the values into a database to store them temporarily

    // Example using session variables
    session_start();
    $_SESSION["start_date"] = $startDate;
    $_SESSION["end_date"] = $endDate;
    $_SESSION["number_of_days"] = $numberOfDays;
    $_SESSION["room"] = $room;
    $_SESSION["room_cost"] = $roomCost;
    $_SESSION["adults"] = $adults;
    $_SESSION["children"] = $children;
    $_SESSION["others"] = $others;
    $_SESSION["visit_time"] = $visitTime;
    $_SESSION["visit_adults"] = $visitAdults;
    $_SESSION["visit_children"] = $visitChildren;
    $_SESSION["promo_code"] = $promoCode;
    $_SESSION["total_cost"] = $totalCost;

    // Redirect to the SQL processing page
    header("Location: reserve.php");
    exit();
}
?>
