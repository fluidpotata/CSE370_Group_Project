<?php
session_start();
$rdr = $_SESSION['cusID'];
require_once("dbconnect.php");

// $sql = "SELECT *
//         FROM RIDERS
//         WHERE CUSID = '$rdr'";
// $exec = mysqli_query($connection, $sql);
// $rider = mysqli_fetch_all($exec, MYSQLI_ASSOC);
// $riderID = $rider[0]['riderID'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Delivery History</title>
</head>

<body>
    <h1>Rider Order Delivery History</h1>
    <?php
    // Rider ID as C1003
    $riderID = $rdr;
    
    // Query to get distinct order ids for definite no of orders
    $sql1= "SELECT COUNT(DISTINCT orderID) 
            AS orderCount 
            FROM orders 
            WHERE riderID ='$riderID'and status = 'delivered'";

    $resultCountOrders = mysqli_query($connection, $sql1);

    if ($resultCountOrders){
        $rowCountOrders = mysqli_fetch_assoc($resultCountOrders);
        $orderCount = $rowCountOrders['orderCount'];
    
            if ($orderCount > 0) {
                echo "Total Order(s) delivered: " . $orderCount . "<br>";
            } else {
                echo "No orders delivered yet.<br>";
            }
        }


    $sql2 = "SELECT DISTINCT orderID
    FROM orders 
    WHERE riderID = '$riderID'and status = 'delivered'";
    $result_OIDs = mysqli_query($connection, $sql2);


    $orderIDs = array();


    while ($row = mysqli_fetch_assoc($result_OIDs)) {

    $orderIDs[] = $row['orderID'];
    } 
    
    foreach ($orderIDs as $orderID){
        echo "<u>ORDER ID:". $orderID . "</u><br>";

        $sql3 = "SELECT CONCAT(fname, ' ', lname) AS CusName, C.address as C_address,R.name as Res_name, R.address as Res_address
        FROM Orders O, Customers C, Restaurant R
        WHERE O.cusID = C.cusID AND O.resID = R.resID AND orderID = '$orderID' and status = 'delivered'";
        $result_display = mysqli_query($connection, $sql3);
        $numRows = mysqli_num_rows($result_display);


        $sql4 = "SELECT SUM(Quantity * amount) as TP
        FROM orders
        WHERE orderID = '$orderID' and status = 'delivered'";

        $result_TP = mysqli_query($connection, $sql4);

        $totalPriceRow = mysqli_fetch_assoc($result_TP);

        $totalPrice = $totalPriceRow['TP'];


        for ($i = 0; $i < $numRows; $i++) {

            $row = mysqli_fetch_assoc($result_display);

            if ($i == 0) {
                echo "from Restaurant: " . $row['Res_name'] . "<br>";
                echo "located at: " . $row['Res_address'] . "<br>";
            }
            if ($i == 0) {
                echo "to Customer: " . $row['CusName'] . "<br>";
                echo "dwelling at: " . $row['C_address'] . "<br>";
            }
        }
        echo "Total Bill collected in TK " . $totalPrice . "<br>";
        echo "---------------------------------------------------<br>";
    }
    
    
    ?>

</body>

</html>
