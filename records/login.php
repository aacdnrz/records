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
            // Redirect to manage.php after successful login
            header('Location: manage.php');
            exit(); // Terminate script after redirection
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
            background: linear-gradient(135deg, #ffffff, #ffe8e5, #ffd2cb, #ffbbb1, #ffa399, #ff8b81, #ff7169, #ff5353);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            color: maroon;
            text-align: center;
            font-weight: bolder;
            font-size:2.2rem;
        }
        .container {
            border-radius: 10px;
            padding: 25px;
            width: 350px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        h3{
            font-weight: bold;
            font-size: 1.1rem;
            color:#000;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-style: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            box-shadow: 0px 0px 15px rgba(152, 43, 28, 0.5); /* Change shadow on focus */
            border: 1px solid #982B1C; /* Add border on focus */
            outline: none; /* Remove default outline */
        }
        input[type="submit"] {
            background-color: maroon;
            color: #f2f2f2;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.2rem;
        }
        input[type="submit"]:hover {
            background-color: #ff5353; /* Darker maroon on hover */
            color:#000;
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
        if (!$login_successful) {
            // If login failed or hasn't been attempted, show the form
            echo "<h2>Log In</h2>";
            echo '<form method="POST">';
            echo '<h3>Username: <input type="text" name="username" required><br><br></h3>';
            echo '<h3>Password: <input type="password" name="password" required><br><br></h3>';
            echo '<input type="submit" value="Log in">';
            echo '</form>';
            echo $message; // Display any error messages
        }
        ?>
    </div>
</body>
</html>
