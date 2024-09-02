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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $new_filename = "GCASH_" . $last_name . "_" . $first_name . "_" . date("Ymd") . "." . $file_extension;

            // Build the new file path
            $new_file_path = $target_dir . $new_filename;

            // Rename the file
            if (rename($gcash_screenshot_path, $new_file_path)) {
                // File was renamed successfully, insert the data into the database
                $gcash_screenshot_path = $new_file_path;

                // Prepare and bind the SQL statement
                $stmt = $conn->prepare("INSERT INTO bookingform (first_name, middle_name, last_name, gender, address, contact_number, booking_date, amount_paid, gcash_reference, gcash_screenshot_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssss", $first_name, $middle_name, $last_name, $gender, $address, $contact_number, $booking_date, $amount_paid, $gcash_reference, $gcash_screenshot_path);

                // Execute the SQL statement
                if ($stmt->execute()) {
                    echo "Booking submitted successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Sorry, there was an error renaming your file.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();
?>
