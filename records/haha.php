<?php
$conn = mysqli_connect("localhost", "root", "", "group1_db");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_numbers'])) {
    $studentNumbers = $_POST['student_numbers'];
    $studentNumbersList = implode("','", $studentNumbers);
    
    $sql = "DELETE FROM student_records WHERE `Student Number` IN ('$studentNumbersList')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Selected records deleted successfully</p>";
    } else {
        echo "<p class='error'>Error deleting records: " . $conn->error . "</p>";
    }
}

$sql = "SELECT `Student Number`, Name, Section FROM student_records ORDER BY Name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 36px;
            color: #800020;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 10px;
            overflow-x: auto;
            border-radius: 8px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            color: #555;
        }

        th {
            background-color: #800020;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f0f0f0;
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.4s ease, box-shadow 0.4s ease;
        }

        tr:hover td {
            font-weight: bold;
        }

        td[colspan='4'] {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        .button-container button {
            background-color: #800020;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #a83232;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .success, .error {
            margin-top: 10px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
    <title>GROUP 4_DB</title>
</head>
<body>
    <div class="container">
        <h2>STUDENT RECORDS</h2>
        <form method="POST" action="">
            <table>
                <tr>
                    <th>Select</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Section</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='student_numbers[]' value='" . $row["Student Number"] . "'></td>";
                        echo "<td>" . $row["Student Number"] . "</td>";
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Section"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </table>

            <div class="button-container">
                <button type="button" onclick="location.href='insert.php'">INSERT</button>
                <button type="button" onclick="location.href='update.php'">UPDATE</button>
                <button type="submit">DELETE</button>
            </div>
        </form>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
