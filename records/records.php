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
    <link rel="stylesheet" href="records.css">
    <title>GROUP 1_DB</title>
</head>
<body>
    <div class="container">
        <h2>STUDENT RECORDS</h2>
        <table>
            <tr>
                <th>Student Number</th>
                <th>Name</th>
                <th>Section</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["Student Number"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Section"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
