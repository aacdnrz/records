<?php
// Step 1: Connect to the database
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "maestro"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize message variable
$messageClass = ""; // Initialize CSS class for the alert

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id']; // New field for user ID
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $checkSql = "SELECT * FROM login WHERE username = '$username'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        // Username does not exist, proceed with the insert
        $insertSql = "INSERT INTO login (id, username, password) VALUES ('$userId', '$username', '$password')";
        if ($conn->query($insertSql) === TRUE) {
            // Set a session variable for success message
            session_start();
            $_SESSION['message'] = "User Updated Successfully!";
            $_SESSION['messageClass'] = "success";
            // Redirect to manage.php
            header("Location: manage.php");
            exit();
        } else {
            $message = "Error adding user: " . $conn->error;
            $messageClass = "error"; // Set alert color to red for errors
        }
    } else {
        // Username already exists, show invalid input alert
        $message = "Username already exists!";
        $messageClass = "error"; // Set alert color to red for invalid input
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert User Record</title>
    <style>
        /* Styling for the entire page */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            flex-direction: column;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .alert {
            width: 100%;
            padding: 15px;
            color: white;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-weight: bold;
        }

        .alert.success {
            background-color: #4CAF50; /* Green background for success */
        }

        .alert.error {
            background-color: #f44336; /* Red background for error */
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: maroon;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        input[type="submit"], .back-button {
            width: 100%;
            padding: 10px;
            background-color: maroon;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        input[type="submit"]:hover, .back-button:hover {
            background-color: #a94442;
        }
    </style>
</head>
<body>
    <!-- Display alert message if any -->
    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Insert User Record</h2>
        <form method="POST" action="">
            <label for="user_id">ID:</label>
            <input type="text" id="user_id" name="user_id" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Insert">
        </form>
        <!-- Back button to return to the previous page -->
        <a href="manage.php" class="back-button">Back</a>
    </div>
</body>
</html>
