<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "group1_db");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$message = ""; // Initialize message variable
$messageClass = ""; // Initialize CSS class for the alert

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNumber = $_POST['student_number'];
    $name = $_POST['name'];
    $section = $_POST['section'];

    // Check if the student number already exists in the database
    $checkSql = "SELECT * FROM student_records WHERE `Student Number` = '$studentNumber'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        // Student number does not exist, proceed with the insert
        $insertSql = "INSERT INTO student_records (`Student Number`, Name, Section) VALUES ('$studentNumber', '$name', '$section')";
        if ($conn->query($insertSql) === TRUE) {
            $message = "Record added successfully";
            $messageClass = "success"; // Set alert color to green for success
        } else {
            $message = "Error adding record: " . $conn->error;
            $messageClass = "error"; // Set alert color to red for errors
        }
    } else {
        // Student number already exists, show invalid input alert
        $message = "Student Number already exists!";
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
    <style>
        /* Styling for the entire page */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f0f0;
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
            max-width: 500px;
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
            font-size: 36px;
            color: #800020;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
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
            background-color: #800020;
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
            background-color: #a83232;
        }
    </style>
    <title>Insert Student Record</title>
</head>
<body>
    <!-- Display alert message if any -->
    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Insert Record</h2>
        <form method="POST" action="">
            <label for="student_number">Student Number:</label>
            <input type="text" id="student_number" name="student_number" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="section">Section:</label>
            <input type="text" id="section" name="section" required>

            <input type="submit" value="Insert">
        </form>
        <!-- Back button to return to index page -->
        <a href="haha.php" class="back-button">Back</a>
    </div>
</body>
</html>
