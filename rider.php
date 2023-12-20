<?php
session_start();
//seession start
require_once("dbconnect.php");



$riderID = $_SESSION['cusID'];




$riderQuery = "SELECT * FROM rider WHERE riderID = '$riderID'";
$riderResult = mysqli_query($connection, $riderQuery);

if ($riderResult && $riderDetails = mysqli_fetch_assoc($riderResult)) {

    echo "<div class='info'>";
    echo "<h2>Welcome, {$riderDetails['name']}</h2>";
    echo "<h2>Rider Availability: " . ($riderDetails['availability'] == 1 ? 'Available' : 'Unavailable') . "</h2>";
    echo "</div>";
} else {
    echo "Error fetching rider details.";
    exit();
}



$orderQuery = "SELECT o.*, r.availability, c.fname AS customer_name, c.lname AS customer_lastname, res.name AS restaurant_name 
               FROM orders o
               JOIN rider r ON o.riderID = r.riderID
               JOIN customers c ON o.cusID = c.cusID
               JOIN restaurant res ON o.resID = res.resID
               WHERE r.riderID = '$riderID' AND (o.status = 'pending' OR o.status = 'ready' OR o.status = 'ondel')";
$orderResult = mysqli_query($connection, $orderQuery);

if ($orderResult && $orderDetails = mysqli_fetch_assoc($orderResult)) {
    // show order details 
    echo "<div class='order-details'>";
    echo "<h2> Customer Order Details:</h2>";
    echo "<table border='1' style='width:100%; height:20%;'>";
    echo "<tr><th>Order ID</th><th>Customer Name</th><th>Restaurant Name</th><th>Status</th></tr>";
    echo "<tr>";
    echo "<td>" . $orderDetails['orderID'] . "</td>";
    echo "<td>" . $orderDetails['customer_name'] . " " . $orderDetails['customer_lastname'] . "</td>";
    echo "<td>" . $orderDetails['restaurant_name'] . "</td>";
    echo "<td>" . $orderDetails['status'] . "</td>";
    echo "</tr>";
    echo "</table>";
    //button
    echo "<div class='order-button'>";

    // if order status='' and show=''buttons
    if ($orderDetails['status'] == 'pending') {
        echo "<p>Wait for the manager to ready the food.</p>";
    } elseif ($orderDetails['status'] == 'ready') {
        echo "<form method='post' action='rider.php'>";
        echo "<button type='submit' name='orderPickedUp'>Order Picked Up</button>";
        echo "</form>";
    } elseif ($orderDetails['status'] == 'ondel') {
        echo "<form method='post' action='rider.php'>";
        echo "<button type='submit' name='orderDelivered'>Order Delivered</button>";
        echo "</form>";
    } elseif ($orderDetails['status'] == 'delivered') {
        echo "<p>No order to deliver.</p>";
    }

    echo "</div>";
} else {  //no order means availablity=0
    echo "<h2 style='margin-top: 40px; margin-right: 50px;'><p><b>No order to Deliver.</b></p></h2>";


}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderPickedUp'])) {
    // update order status=ondel
    $updateQuery = "UPDATE orders SET status = 'ondel' WHERE orderID = '{$orderDetails['orderID']}'";
    mysqli_query($connection, $updateQuery);

    // still rider availability=0
    $updateRiderQuery = "UPDATE rider SET availability = 0 WHERE riderID = '$riderID'";
    mysqli_query($connection, $updateRiderQuery);


    header("Location: rider.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderDelivered'])) {
    // Update order status='Delivered'
    $updateQuery = "UPDATE orders SET status = 'delivered' WHERE orderID = '{$orderDetails['orderID']}'";
    mysqli_query($connection, $updateQuery);


    $updateRiderQuery = "UPDATE rider SET availability = 1 WHERE riderID = '$riderID'";
    mysqli_query($connection, $updateRiderQuery);

    header("Location: rider.php");
    exit();
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>Rider Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            display: flex;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2%;
            background-color: var(--primaryColor);
            color: var(--whiteColor);
        }

        .logo {
            text-align: center;
            margin-bottom: 0px;
        }

        .sidebar-menus {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: baseline;
        }

        .sidebar-menus a {
            text-decoration: none;
            color: white;
            margin: 10px 0;
            display: flex;
            align-items: baseline;
        }

        .sidebar-menus a ion-icon {
            margin-right: 10px;
        }

        .sidebar-logout {
            text-decoration: none;
            color: white;
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .sidebar-logout a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            display: block;
            align-items: center;
            justify-content: center;
        }

        .main-navbar {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            align-items: end;
        }

        .main {
            width: 100%;
            min-height: 100vh;
            padding: 2%;
            background-color: azure;
            margin-left: 250px;
        }

        .profile {
            position: absolute;
            top: 8px;
            right: 16px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .info {
            background-color: azure;
            height: 200%;
            text-align:center;
            margin-left: 230px;
            padding: 20px;
            
        }

        .order-details {
            height: fit-content;
            text-align: left;
            background-color: azure;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th,
        .order-details td {
            text-align: left;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .order-button {
            margin-top: 10px;
        }

        .order-button button {
            display: flex;
            align-items: end;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .order-button button:hover {
            background-color: slategrey;
        }
    </style>
</head>

<body>
    <div class="rightsideinfo">
        <div class="sidebar">
            <h1 class="logo">QUICKEATS</h1>
            <div class="sidebar-menus">
                <a href="rider.php"><ion-icon name='storefront-outline'></ion-icon>Home</a>
                <a href="rider_his.php"><ion-icon name='wallet-outline'></ion-icon>Previous Orders</a>
                <!-- <a href="#"><ion-icon name='notifications-outline'></ion-icon>Notification</a>
                <a href="#"><ion-icon name='chatbubble-outline'></ion-icon>Contact Us</a>
                <a href="#"><ion-icon name='settings-outline'></ion-icon>Settings</a> -->
            </div>
            <div class="sidebar-logout">
                <a href="login.php"><ion-icon name='log-out-outline'></ion-icon>Logout</a>
            </div>
        </div>

        <div class="main">
            <div class="main-navbar">
                <div class="profile">
                    <a class="user" href="#"><ion-icon name='person-outline'></ion-icon></a>
                </div>
    </div>
</div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

