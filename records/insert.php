<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$messageClass = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $checkSql = "SELECT * FROM login WHERE username = '$username'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        // Username does not exist, proceed with the insert
        if (empty($userId)) {
            // Insert without the id field to allow auto-increment
            $insertSql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
        } else {
            // Insert with the id field provided
            $insertSql = "INSERT INTO login (id, username, password) VALUES ('$userId', '$username', '$password')";
        }

        if ($conn->query($insertSql) === TRUE) {
            session_start();
            $_SESSION['message'] = "User added successfully!";
            $_SESSION['messageClass'] = "success";
            header("Location: manage.php");
            exit();
        } else {
            $message = "Error adding user: " . $conn->error;
            $messageClass = "error";
        }
    } else {
        $message = "Username already exists!";
        $messageClass = "error";
    }
}

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
    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Insert User Record</h2>
        <form method="POST" action="">
            <label for="user_id">ID (optional):</label>
            <input type="text" id="user_id" name="user_id">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Insert">
        </form>
        <a href="manage.php" class="back-button">Back</a>
    </div>
</body>
</html>
