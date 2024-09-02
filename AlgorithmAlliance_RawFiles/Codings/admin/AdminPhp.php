<?php
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form is submitted
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Create a MySQL connection
        $conn = new mysqli('localhost', 'root', '', 'resortdb');

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result !== false) {
            // Check if the query returns a row
            if ($result->num_rows > 0) {
                // Redirect to the dashboard
                header('Location: /AlgorithmAlliance_RawFiles/Codings/admin/DashBoard.html');
                exit;
            } else {
                $error = "Invalid email or password";
            }
        } else {
            echo "Query execution failed: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="AdminLog.css">

    <title>AdminLog</title>
</head>
<body>
    <div class="container">
        <div class="outerline">
        <label class="admin">Admin</label>
    <div class="login-box">
        <img src="Company Logo.png" alt="Logo">
        <h2>LogIn</h2>
        <form method="POST" action="AdminPhp.php">
          <label class="email">Email
              <input type="email" name="email" autocomplete="on" required>
          </label>
          <label class="pass">Password
              <input type="password" name="password" autocomplete="on" required>
          </label>
          <button type="submit">Log In</button>
        </form>
        <?php if ($error !== "") { ?>
        <p><?php echo $error; ?></p>
        <?php } ?>
    </div>
      </div>
    </div>

</body>
</html>