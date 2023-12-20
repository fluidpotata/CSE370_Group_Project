<?php
session_start();
$mgr = $_SESSION['cusID'];
require_once("dbconnect.php");
$query = "select * from restaurant where mgr_ID='$mgr'";
$result = mysqli_query($connection, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$res = $rows[0]['resID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Restaurant History</title>
</head>

<body>
    <h1>Restaurant Order History</h1>
    <?php 
    // RES_ID as R1001
    // $resID = 'R1001';
    
    $resID = $res;


    $sql1 = "SELECT COUNT(DISTINCT orderID) AS orderCount
         FROM orders
         WHERE resID='$resID' and status != 'ready'";

    $resultCountOrders = mysqli_query($connection, $sql1);

    if ($resultCountOrders){
    $rowCountOrders = mysqli_fetch_assoc($resultCountOrders);
    $orderCount = $rowCountOrders['orderCount'];

        if ($orderCount > 0) {
            echo "Total Order(s) Made By Restaurant: " . $orderCount . "<br>";
        } else {
            echo "No orders recieved by the restaurant yet.<br>";
        }
    }

    $sql2 = "SELECT DISTINCT orderID
    FROM orders 
    WHERE resID='$resID' and status != 'ready'";
    $result_OIDs = mysqli_query($connection, $sql2);


    $orderIDs = array();


    while ($row = mysqli_fetch_assoc($result_OIDs)) {
    // Push the 'orderID' value into the array
    $orderIDs[] = $row['orderID'];
    } 
    
    foreach ($orderIDs as $orderID){
        echo "<u>ORDER ID:". $orderID . "</u><br>";

        $sql3 = "SELECT F.foodName, O.Quantity, CONCAT(C.fname, ' ', C.lname) AS CusName
        FROM Orders O, Food F, Customers C
        WHERE O.foodID = F.foodID AND O.cusID = C.cusID AND orderID = '$orderID' and status != 'ready'";
        $result_display = mysqli_query($connection, $sql3);
        $numRows = mysqli_num_rows($result_display);

        // SQL query with a variable for orderID
        $sql4 = "SELECT SUM(quantity * amount) as TP
        FROM orders
        WHERE orderID = '$orderID' and status != 'ready'";

        $result_TP = mysqli_query($connection, $sql4);
        // Fetch the result_TP
        $totalPriceRow = mysqli_fetch_assoc($result_TP);
        // Access and display the total price
        $totalPrice = $totalPriceRow['TP'];

        // Fetch and iterate through the results_display
        for ($i = 0; $i < $numRows; $i++) {
            // Fetch the current row
            $row = mysqli_fetch_assoc($result_display);
            // Conditionally print based on the value of $i
            if ($i == 0) {
                echo "made by Customer: " . $row['CusName'] . "<br>";
            }
            echo "Food name: " . $row['foodName'] . "<br>";
            echo "quantity ordered: " . $row['Quantity'] . "<br>";
        }
        echo "Total Sales in this Order in TK " . $totalPrice . "<br>";
        echo "---------------------------------------------------<br>";
    }
    
    ?>

</body>

</html>
