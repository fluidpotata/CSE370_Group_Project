<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Riders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        #availableRiders {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: cornflowerblue;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkslateblue;
        }
    </style>
</head>
<body>

    <div id="availableRiders">
        <?php
        
        session_start();
        require_once("dbconnect.php");

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectRider'])) {
            $selectedRiderID = $_POST['selectRider'];

            // update rider availability only if the riderID is set
            if (!empty($selectedRiderID)) {
                $updateQuery = "UPDATE rider SET availability = 0 WHERE riderID = '$selectedRiderID'";
                mysqli_query($connection, $updateQuery);

                $_SESSION['selectedRiderID'] = $selectedRiderID;

                $updateOrderStatusQuery = "UPDATE orders SET status = 'pending' WHERE riderID = '$selectedRiderID' AND status = ''";
                mysqli_query($connection, $updateOrderStatusQuery);
                mysqli_commit($connection);

                header("Location: confirm-order.php");
                exit(); 
            }
        }

        // show available riders availablity=1
        $query = "SELECT Name, riderID, availability FROM rider WHERE availability = 1";
        $result = mysqli_query($connection, $query);

        // list of rider
        $rows = mysqli_num_rows($result);

        if ($rows > 0) {
            echo "<h2>Available Rider List:</h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Action</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td><form method='post'><button type='submit' name='selectRider' value='" . $row["riderID"] . "'>Select</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No available rider data</p>";
        }

        $connection->close();
        ?>
    </div>

</body>
</html>