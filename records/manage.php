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
        $successMessage = "Selected records deleted successfully"; // Set success message
    } else {
        $errorMessage = "Error deleting records: " . $conn->error; // Set error message
    }
}

// Retrieve user records from the login table, ordered by ID
$sql = "SELECT id, username, password FROM login ORDER BY id ASC"; // Keep this as is for numeric order
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your CSS remains the same */
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
            position: relative; /* Add position relative to body for absolute positioning */
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

        /* Notification styles */
        .notification {
            position: absolute; /* Position it absolutely */
            top: 20px; /* Adjust top spacing */
            right: 20px; /* Adjust right spacing */
            margin-top: 10px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: none; /* Initially hidden */
            z-index: 1000; /* Ensure it's on top of other elements */
        }

        .success {
            color: green;
            background-color: #e6ffe6; /* Light green background */
        }

        .error {
            color: red;
            background-color: #ffe6e6; /* Light red background */
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
                    <th>Select</th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='user_ids[]' value='" . $row["id"] . "'></td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>"; // Be careful with displaying passwords!
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

    <!-- Notification div to show messages -->
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
        // Show the notification if there is a message and hide it after 5 seconds
        window.onload = function() {
            const notification = document.getElementById('notification');
            if (notification.innerHTML) {
                notification.style.display = 'block'; // Show the notification
                setTimeout(function() {
                    notification.style.display = 'none'; // Hide after 5 seconds
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
