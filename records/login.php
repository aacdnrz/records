<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maestro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_successful = false; 
$message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$input_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $input_password) {
            $login_successful = true; 
            header("Location: manage.php"); 
            exit(); 
        } else {
            $message = "<p style='color: red; font-weight: bold; text-align: center; margin: 20px;'>Password is not correct</p>";
        }
    } else {
        $message = "<p style='color: red; font-weight: bold; text-align: center; margin: 20px;'>Username does not exist</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * {
            font-family:  'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: linear-gradient(rgba(255, 255, 255, 1), rgba(195, 136, 137, 1),  rgba(181,11,12,1));
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            font-size: 40px; 
            color: #7E0001; /*4th*/
            text-shadow: 5px 2px 5px rgba(126, 0, 1, 0.3);
            font-weight: bolder;
            text-align: center;
            margin-bottom: 25px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px;
        }

        .container {
            width: 100%;
            max-width: 400px; 
            background-color: #FFFFFF; /*1st*/
            border: 2px solid #7E0001;
            border-radius: 15px;
            padding: 35px; 
            box-shadow: 10px 10px 15px rgba(126, 0, 1, 0.3); 
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1.5px solid black;
            border-radius: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #7E0001; /*4th*/
            color:  #FFFFFF; /*1st*/
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 150px;
            margin-left: 95px;
            font-size: 15px;
            font-weight: bold;  
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            box-shadow: 10px 15px 15px rgba(126, 0, 1, 0.3);
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px; 
        }

        </style>
        </head>

<body>
<div class="container">
        <?php
        if ($login_successful) {
            echo "<h2 class='success-message'>Access granted!!!</h2>";
        } else {
            echo "<h2>Log in</h2>";
            echo '<form method="POST">';
            echo 'Username: <input type="text" name="username" required><br><br>';
            echo 'Password: <input type="password" name="password" required><br><br>';
            echo '<input type="submit" value="Login">';
            echo '</form>';
            echo $message; 
        }
        ?>
    </div>
</body>
</html>        
