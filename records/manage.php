<?php
// Connect to the new database
$conn = mysqli_connect("localhost", "root", "", "maestro");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Initialize message variables
$successMessage = '';
$errorMessage = '';

// Handle record deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_ids'])) {
    $userIds = $_POST['user_ids'];
    $userIdsList = implode(",", $userIds);
    
    // Adjust the SQL to delete from the login table using the new structure
    $sql = "DELETE FROM login WHERE id IN ($userIdsList)";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Selected records deleted successfully"; 
    } else {
        $errorMessage = "Error deleting records: " . $conn->error;
    }
}

$sql = "SELECT id, username, password FROM login ORDER BY id ASC"; 
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
            font-size: 40px;
            color: #1F1F1F; /*4th*/
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: center;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #F5F5F5; /*1st*/
            padding: 35px;
            border-radius: 8px;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
            margin: auto;  
            margin-top: 10px; 
            margin-bottom: 10px; 
        }

        table {
            width: 100%;
            max-width: 700px;
            border-collapse: collapse;
            background-color: #F5F5F5; /*1st*/
            margin: auto; 
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 10px 10px 15px rgba(126, 0, 1, 0.3);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1.5px solid rgba(126, 0, 1, 0.1);
            font-size: 15px;
            color: black;
        }

        th {
            background-color: #b00000;
            color: #F5F5F5; /*1st*/
            font-size: 18px;
        }

        th:nth-child(1), td:nth-child(1) {
            width: 5%; /* select */
        }

        th:nth-child(2), td:nth-child(2) {
            width: 20%; /* id */
        }

        th:nth-child(3), td:nth-child(3) {
            width: 50%; /* username */
        }

        th:nth-child(4), td:nth-child(4) {
            width: 25%; /* pass*/
        }

        tr:nth-child(even) {
            background-color: white;
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
            background-color: #b00000; /*4th*/
            color: #F5F5F5; /*1st*/
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .button-container button:hover {
            box-shadow: 10px 15px 15px rgba(126, 0, 1, 0.3);
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .notification {
            position: absolute; 
            top: 20px; 
            right: 20px; 
            margin-top: 10px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: none; 
            z-index: 1000; 
        }

        .success {
            color: green;
            background-color: #e6ffe6; 
        }

        .error {
            color: red;
            background-color: #ffe6e6; 
        }
    </style>
    <title>MAESTRO_DB</title>
</head>
<body>
    <div class="container">
        <h2>USER RECORDS</h2>
        <form method="POST" action="" onsubmit="return confirmDeletion()">
            <table>
                <tr>
                    <th>SELECT</th>
                    <th>ID</th>
                    <th>USERNAME</th>
                    <th>PASSWORD</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='user_ids[]' value='" . $row["id"] . "'></td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>"; 
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
                <button type="button" onclick="location.href='login.php'">EXIT</button> 
            </div>
        </form>
    </div>

    <div id="notification" class="notification <?php echo $successMessage ? 'success' : ($errorMessage ? 'error' : ''); ?>">
        <?php
        if ($successMessage) {
            echo $successMessage;
        } elseif ($errorMessage) {
            echo $errorMessage;
        }
        ?>
    </div>

    <script>
        window.onload = function() {
            const notification = document.getElementById('notification');
            if (notification.innerHTML) {
                notification.style.display = 'block'; 
                setTimeout(function() {
                    notification.style.display = 'none'; 
                }, 2000);
            }
        };

        function confirmDeletion() {
            const checked = document.querySelectorAll('input[name="user_ids[]"]:checked').length;
            if (checked > 0) {
                return confirm("Are you sure you want to delete the selected records?");
            } else {
                alert("Please select at least one record to delete.");
                return false;
            }
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html>
