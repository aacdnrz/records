<?php
$conn = mysqli_connect("localhost", "root", "", "group1_db");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
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

    th {
        background-color: #800020;
        color: white;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
        letter-spacing: 0.5px;
        text-transform: capitalize;
    }

    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
        color: #555;
    }

    tr:nth-child(even) {
        background-color: #f8f8f8;
    }

    tbody tr:hover {
    background-color: #f0f0f0;
    transform: scale(1.03);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }


    tbody tr:hover td {
        font-weight: bold;
    }

    td[colspan='3'] {
        text-align: center;
        color: #888;
        font-style: italic;
        padding: 20px;
    }
    </style>

    <title>GROUP 1_DB</title>
</head>
<body>
    <div class="container">
        <h2>STUDENT RECORDS</h2>
        <table>
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["Student Number"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Section"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
