<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if form is submitted
    if (isset($_GET['email']) && isset($_GET['password'])) {
        // Retrieve form data
        $email = $_GET['email'];
        $password = $_GET['password'];

        // Perform any necessary processing or validation here

        // Output the submitted data
        echo "Email: " . $email . "<br>";
        echo "Password: " . $password . "<br>";

        // You can redirect the user to another page after form submission if needed
        // header('Location: success.php');
        // exit;
    }
}
?>
