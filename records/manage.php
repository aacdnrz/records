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

// Step 2: Display login table records
$sql = "SELECT * FROM login";
$result = $conn->query($sql);

echo "<h2>Login Table Records</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Password</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["username"] . "</td><td>" . $row["password"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Step 3: Handle button actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        header('Location: add_record.php');
    } elseif (isset($_POST['delete'])) {
        header('Location: delete_record.php');
    } elseif (isset($_POST['exit'])) {
        exit();
    }
}

$conn->close();
?>

<!-- HTML for managing records -->
<!DOCTYPE html>
<html>
<head>
    <title>Manage Login Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }
        h2 {
            color: maroon;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            margin-bottom: 20px;
            background-color: #ffeb99; /* Mustard background */
        }
        table, th, td {
            border: 2px solid maroon;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: maroon;
            color: #ffeb99; /* Mustard text */
        }
        td {
            background-color: #fff8d1; /* Slightly lighter mustard for table cells */
        }
        input[type="submit"] {
            background-color: maroon;
            color: #ffeb99;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #a94442; /* Darker maroon on hover */
        }
    </style>
</head>
<body>
    <h2>Manage Login Records</h2>
    <form method="POST">
        <input type="submit" name="add" value="Add New Record">
        <input type="submit" name="delete" value="Delete Record">
        <input type="submit" name="exit" value="Exit">
    </form>
</body>
</html>
