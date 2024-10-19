<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

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
<html>
<head>
    <title>Add New Record</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(rgba(255, 255, 255, 1), rgba(195, 136, 137, 1),  rgba(181,11,12,1));
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            flex-direction: column;
        }

        h2 {
           text-align: center;
            font-size: 30px;
            color: #1F1F1F; /*4th*/
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }
         
        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: #FFFFFF; /*1st*/
            border: 2px solid #7E0001;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 10px 10px 15px rgba(126, 0, 1, 0.3);
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid black;
            border-radius: 10px;
            box-sizing: border-box;
            align-items: center;
            justify-content: center;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .cancel-btn, .insert-btn {
            margin-top: 20px;
            width: 130px;
            padding: 15px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
        }

        .cancel-btn {
            background-color: #000;
            color: white;
            transition: 0.3s;
        }

        .insert-btn {
            background-color: #b00000;
            color: white;
            transition: 0.3s;
        }

        .cancel-btn:hover, .insert-btn:hover {
            box-shadow: 10px 15px 15px rgba(126, 0, 1, 0.3);
        }

        p {
            text-align: center;
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

            <div class="button-group">
            <button type="button" class="cancel-btn" onclick="window.location.href='manage.php';">Cancel</button>
                <button type="submit" class="insert-btn">Insert</button>
            </div>
        </form>
    </div>
</body>
</html>
