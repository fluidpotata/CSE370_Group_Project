<?php
session_start();
$cus = $_SESSION['cusID'];
require_once("dbconnect.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Order History</title>
</head>

<body>
    <h1>Customer Order History</h1>
    <?php

    $cusID = $cus;
    
    $sql1 = "SELECT COUNT(DISTINCT orderID) AS orderCount
                    FROM orders
                    WHERE cusID='$cusID' and status != 'pending'";

    $resultCountOrders = mysqli_query($connection, $sql1);

    if ($resultCountOrders) {
        $rowCountOrders = mysqli_fetch_assoc($resultCountOrders);
        $orderCount = $rowCountOrders['orderCount'];
        echo "Total Orders: " . $orderCount ."<br>";
    } 

    $sql2 = "SELECT DISTINCT orderID
    FROM orders 
    WHERE cusID = '$cusID' and status != 'pending'";
    $result_OIDs = mysqli_query($connection, $sql2);

    // (later loop chalabo one div for one order with info)
    $orderIDs = array();

    while ($row = mysqli_fetch_assoc($result_OIDs)) {
    // Push the 'orderID' value into the array
    $orderIDs[] = $row['orderID'];
    } 
    
    foreach ($orderIDs as $orderID){
        echo "<u>ORDER ID:". $orderID . "</u><br>";
        $sql3 = "SELECT foodName, name, Quantity, amount
                 FROM Orders O, Food F, Restaurant R
                 WHERE O.foodID = F.foodID AND O.resID = R.resID AND orderID = '$orderID' and status !='pending'";

        $result_display = mysqli_query($connection, $sql3);

        $sql4 = "SELECT SUM(Quantity * amount) as TP
        FROM orders
        WHERE orderID = '$orderID' and status != 'pending'";

        $result_TP = mysqli_query($connection, $sql4);

        $totalPriceRow = mysqli_fetch_assoc($result_TP);

        $totalPrice = $totalPriceRow['TP'];

        // Fetch and iterate through the results_display
        while ($row = mysqli_fetch_assoc($result_display)) {
            echo "Food Name: " . $row['foodName'] . "<br>";
            echo "from restaurant: " . $row['name'] . "<br>";
            echo "quantity ordered: " . $row['Quantity'] . "<br>";
            echo "unit price in TK: " . $row['amount']. "<br>";
            echo "<br>";
        }
        echo "Total Price this Order in TK " . $totalPrice . "<br>";
        echo "---------------------------------------------------<br>";
    }
    
    
    ?>

</body>

</html>
