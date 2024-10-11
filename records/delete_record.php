<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; // Variable to store success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete_username = $_POST['username'];

    // Check if the username exists
    $check_user_sql = "SELECT * FROM login WHERE username = '$delete_username'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result->num_rows > 0) {
        $sql = "DELETE FROM login WHERE username = '$delete_username'";
        if ($conn->query($sql) === TRUE) {
            $message = "<p style='color: green; text-align: center;'>Record deleted successfully</p>";
        } else {
            $message = "<p style='color: red; text-align: center;'>Error: " . $conn->error . "</p>";
        }
    } else {
        $message = "<p style='color: red; text-align: center;'>Username does not exist</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
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
        input[type="text"] {
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
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Record</h2>
        <form method="POST">
            Username: <input type="text" name="username" required><br><br>
            <input type="submit" value="Delete">
        </form>
        <?php
        if (!empty($message)) {
            echo $message; // Display the success or error message
        }
        ?>
    </div>
</body>
</html>
