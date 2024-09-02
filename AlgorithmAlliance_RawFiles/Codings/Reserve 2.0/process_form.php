<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$servername = "localhost";
	$port = 3306;
	$username = "root";
	$password = "";
	$dbname = "resortdb";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Retrieve the stored values from the session or database
	session_start();
    $startDate = $_SESSION["check-in"];
    $endDate = $_SESSION["check-out"];
    $room = $_SESSION["room"];
    $adults = $_SESSION["adults"];
    $children = $_SESSION["children"];
    $promoCode = $_SESSION["promo"];
    $totalCost = $_SESSION["total-cost"];
    $numStays = $_SESSION["num-stays"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		echo "Connected successfully!";
	}

    $required_fields = array("first-name", "last-name", "gender", "address", "contact-number", "booking-date", "amount-paid", "gcash-reference");

    $missing_fields = array();
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        echo "Please fill in all required fields: " . implode(", ", $missing_fields);
        exit;
    }

    $first_name = $_POST["first-name"];
    $middle_name = $_POST["middle-name"];
    $last_name = $_POST["last-name"];
    $name = $first_name . " " . $middle_name . " " . $last_name;
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $contact_number = $_POST["contact-number"];
    $booking_date = $_POST["booking-date"];
    $amount_paid = $_POST["amount-paid"];
    $gcash_reference = $_POST["gcash-reference"];

    // Upload GCash screenshot
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gcash-screenshot"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["gcash-screenshot"]["tmp_name"]);
    if ($check === false) {
        // File is not an image
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        // File already exists
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["gcash-screenshot"]["size"] > 5000000) {
        // File size exceeds the limit
        $uploadOk = 0;
    }

    // Allow only specific file formats (e.g., JPEG, PNG)
    $allowedFormats = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        // File was not uploaded or did not meet the requirements
        echo "Sorry, your file was not uploaded.";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["gcash-screenshot"]["tmp_name"], $target_file)) {
            // File was uploaded successfully, insert the data into the database
            $gcash_screenshot_path = $target_file;

            // Extract file extension
            $file_extension = pathinfo($gcash_screenshot_path, PATHINFO_EXTENSION);

            // Generate new file name
            $new_filename = "GCASH_" . $last_name . "" . $first_name . "" . date("Ymd") . "." . $file_extension;

            // Build the new file path
            $new_file_path = $target_dir . $new_filename;

            // Rename the file
            if (rename($gcash_screenshot_path, $new_file_path)) {
                // File was renamed successfully, insert the data into the database
                $gcash_screenshot_path = $new_file_path;

                // Set booking time
                $booking_time = date("H:i:s");
                // Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO reservation (name, gender, address, contact_number, booking_date, booking_time, amount_paid, gcash_reference, start_date, end_date, number_of_days, room, adults, children, promo_code, total_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssdsssdiidi", $name, $gender, $address, $contact_number, $booking_date, $booking_time, $amount_paid, $gcash_reference, $startDate, $endDate, $numStays, $room, $adults, $children, $promoCode, $totalCost);

// Execute the SQL statement
if ($stmt->execute()) {
    echo "Booking submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}0

// Close statement
$stmt->close();
            } else {
                echo "Sorry, there was an error renaming your file.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    header("Location: Receipt.html");
    exit();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="urban_oasis_resort_transparent.png">
    <title>Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: serif;
            background-color: #F4F1ED;
        }

        /*
        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        */
        h2 {
            text-align: center;
            margin-top: -5px;
            color: #333;
        }

        .icon {
            width: 50px;
            height: 50px;
            vertical-align: middle;
            padding-bottom: 10px;
            padding-right: 20px;
        }

        .form-box {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        .radio-container {
            display: flex;
            align-items: center;
            padding-bottom: 10px;
        }

        .radio-container input[type="radio"] {
            display: none;
        }

        .radio-container label {
            display: flex;
            align-items: center;
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            font-size: 14px;
            color: #555;
            margin-right: 10px;
        }

        .radio-container label:before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: 2px solid #ccc;
            border-radius: 50%;
            margin-right: 5px;
        }

        .radio-container input[type="radio"]:checked + label:before {
            background-color: #6eb2a7;
            border-color: #6eb2a7;
        }

        input[type="text"],
        input[type="tel"],
        input[type="file"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 15px;
            background-color: #fff;
            background-image: linear-gradient(to bottom, transparent 50%, #aaa 50%);
            background-size: 100% 2px;
            background-repeat: no-repeat;
            background-position: bottom;
            padding-right: 20px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        }

        input[type="file"] {
            padding-right: 0; 
        }

        input[type="file"]::-webkit-file-upload-button {
            background-color: #6eb2a7;
            color: #fff;
            padding: 10px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            margin-right: 20px;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background-color: #4e938a;
        }

        input[type="file"]::-webkit-file-upload-button:active {
            background-color: #6eb2a7;
        }

        .date-input,
        .time-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 15px;
            background-color: #fff;
            background-image: linear-gradient(to bottom, transparent 50%, #aaa 50%);
            background-size: 100% 2px;
            background-repeat: no-repeat;
            background-position: bottom;
            padding-right: 20px; 
            font-family: serif; 
            text-align: left;
        }

        .date-input::-webkit-calendar-picker-indicator,
        .time-input::-webkit-calendar-picker-indicator {
            filter: invert(45%) sepia(82%) saturate(1200%) hue-rotate(180deg);
            width: 16px;
            height: 16px;
            margin-left: 5px;
            cursor: pointer;
        }

        .qr-code {
            display: block;
            margin: 0 auto;
            padding-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .button-container button,
        .button-container a {
            margin: 0 10px;
            background-color: #6eb2a7;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover,
        .button-container a:hover {
            background-color: #4e938a;
        }

        .back-btn {
            background-color: #6e6e6e;
        }

        .home-btn {
            background-color: #29a956;
        }

        #uploaded-photo {
            position: relative;
            display: none;
            text-align: center;
            margin-bottom: 15px;
        }

        #uploaded-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        #remove-photo {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ff5a5a;
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 5px 10px;
            font-size: 18px;
        }

        #remove-photo:hover {
            background-color: #e54747;
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        
        .button-container button,
        .button-container a {
            margin: 0 10px;
            background-color: #6eb2a7;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        
        .button-container button:hover,
        .button-container a:hover {
            background-color: #4e938a;
        }
        
        .back-btn {
            background-color: #6e6e6e;
        }
    </style>
</head>
<body>
    <!-- 
    <video id="video-background" autoplay loop muted>
        <source src="bg_vid.mp4" type="video/mp4">
    </video> -->

    <div class="form-box">
    <h2><img src="urban_oasis_resort_transparent.png" alt="Urban Oasis Resort Logo" class="icon">Urban Oasis Resort</h2>
        <h2 class="form-header">Booking Form</h2>
        <form action="process_form.php" method="POST" enctype="multipart/form-data">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" required>

            <label for="middle-name">Middle Name:</label>
            <input type="text" id="middle-name" name="middle-name" required>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" required>

            <label for="gender">Gender:</label>
            <div class="radio-container">
                <input type="radio" id="male" name="gender" value="male" required>
                <label for="male">Male</label>
            
                <input type="radio" id="female" name="gender" value="female" required>
                <label for="female">Female</label>
            
                <input type="radio" id="other" name="gender" value="other" required>
                <label for="other">Other</label>
            </div>           

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="email-address">Email Address:</label>
            <input type="text" id="email-address" name="email-address" required>

            <label for="contact-number">Contact Number:</label>
            <input type="tel" id="contact-number" name="contact-number" required>

            <label for="booking-date">Date Booked:</label>
            <input type="date" id="booking-date" name="booking-date" required class="date-input">

            <label for="booking-time">Time Booked:</label>
            <input type="time" id="booking-time" name="booking-time" required class="time-input">
            
            <label for="qr-code">Scan this:</label>
            <img src="qr_code.jpg" alt="QR Code" class="qr-code">

            <label for="amount-paid">Amount Paid:</label>
            <input type="text" id="amount-paid" name="amount-paid" required>

            <label for="gcash-reference">GCash Transaction Reference:</label>
            <input type="text" id="gcash-reference" name="gcash-reference" maxlength="9" required>

            <label for="gcash-screenshot">Upload GCash Screenshot:</label>
            <input type="file" id="gcash-screenshot" name="gcash-screenshot" accept="image/*" required>
            <span id="uploaded-photo" style="display: none;">
            <img id="uploaded-image" src="#" alt="Uploaded Screenshot">
            <button id="remove-photo" onclick="removeUploadedPhoto()">x</button>
            </span>

            <div class="button-container">
			    <input type="submit" value="Submit" name="submit-btn">
                <!-- <a href="receipt.html" id="submit-btn">Submit</a> -->

                <a href="Reserve.html" class="back-btn">Back</a>
                <button type="button" onclick="clearForm()">Clear</button>
            </div>
        </form>
    </div>
 <script>
   $(document).ready(function() {
        var reservation = JSON.parse(sessionStorage.getItem('reservation'));

        function previewPhoto(event) {
            var input = event.target;
            var preview = document.getElementById("uploaded-image");
            var removeButton = document.getElementById("remove-photo");

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    document.getElementById("uploaded-photo").style.display = "block";
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeUploadedPhoto() {
            var input = document.getElementById("gcash-screenshot");
            var preview = document.getElementById("uploaded-image");
            var removeButton = document.getElementById("remove-photo");

            input.value = "";
            preview.src = "";
            document.getElementById("uploaded-photo").style.display = "none";
        }

        function clearForm() {
            document.getElementById("first-name").value = "";
            document.getElementById("middle-name").value = "";
            document.getElementById("last-name").value = "";
            document.getElementById("address").value = "";
            document.getElementById("email-address").value = "";
            document.getElementById("contact-number").value = "";
            document.getElementById("booking-date").value = "";
            document.getElementById("booking-time").value = "";
            document.getElementById("gcash-reference").value = "";
            document.getElementById("gcash-screenshot").value = "";
            document.getElementById("uploaded-image").src = "";
            document.getElementById("uploaded-photo").style.display = "none";
        }

        document.getElementById("gcash-screenshot").addEventListener("change", previewPhoto);

       // Store the form values in sessionStorage
        function storeFormValues() {
        var name = document.getElementById("first-name").value + " " + document.getElementById("middle-name").value + " " + document.getElementById("last-name").value;
        var gender = document.querySelector('input[name="gender"]:checked').value;
        var address = document.getElementById("address").value;
        var emailAddress = document.getElementById("email-address").value;
        var contactNumber = document.getElementById("contact-number").value;
        var bookingDate = document.getElementById("booking-date").value;
        var bookingTime = document.getElementById("booking-time").value;
        var amountPaid = document.getElementById("amount-paid").value;
        var gcashReference = document.getElementById("gcash-reference").value;

        sessionStorage.setItem('name', name);
        sessionStorage.setItem('gender', gender);
        sessionStorage.setItem('address', address);
        sessionStorage.setItem('emailAddress', emailAddress);
        sessionStorage.setItem('contactNumber', contactNumber);
        sessionStorage.setItem('bookingDate', bookingDate);
        sessionStorage.setItem('bookingTime', bookingTime);
        sessionStorage.setItem('amountPaid', amountPaid);
        sessionStorage.setItem('gcashReference', gcashReference);
        }
        $("#submit-btn").click(function(event) {
    event.preventDefault(); // Prevent the default form submission

        $.ajax({
		  url: "process_form.php",
		  type: "POST",
		  data: formData,
		  success: function(response) {
			// Handle the response from the server
			console.log(response); // Replace with your own code
		  },
		  error: function(xhr, status, error) {
			// Handle errors
			console.log(error); // Replace with your own code
		  }
		  });
        document.getElementById("submit-btn").addEventListener("click", storeFormValues);
        });
	});
</script>
</body>
</html>
