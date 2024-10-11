<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_successful = false; // Flag to check if login is successful
$message = ''; // Variable to store error or success message

// Step 2: Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Check if the username exists
    $sql = "SELECT * FROM login WHERE username = '$input_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if the password matches
        if ($row['password'] == $input_password) {
            $login_successful = true; // Set login success flag
        } else {
            $message = "<p style='color: red; text-align: center;'>Password is not correct</p>";
        }
    } else {
        $message = "<p style='color: red; text-align: center;'>Username does not exist</p>";
    }
}

$conn->close();
?>

<!-- HTML for login form and success message -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            color: maroon;
            text-align: center;
        }
        .container {
            background-color: #ffeb99; /* Mustard background */
            border: 2px solid maroon;
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid maroon;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: maroon;
            color: #ffeb99; /* Mustard text color */
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #a94442; /* Darker maroon on hover */
        }
        .success-message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($login_successful) {
            // If login is successful, show the success message
            echo "<h2 class='success-message'>Access granted!!!</h2>";
        } else {
            // If login failed or hasn't been attempted, show the form
            echo "<h2>Login</h2>";
            echo '<form method="POST">';
            echo 'Username: <input type="text" name="username" required><br><br>';
            echo 'Password: <input type="password" name="password" required><br><br>';
            echo '<input type="submit" value="Login">';
            echo '</form>';
            echo $message; // Display any error messages
        }
        ?>
    </div>
</body>
</html>
