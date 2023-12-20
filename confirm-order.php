<?php
session_start();
require_once("dbconnect.php");

$cusID = $_SESSION['cusID'];
$sql = "SELECT count(DISTINCT orderID) as ordcount
        FROM orders 
        WHERE cusID='$cusID'";
$query = mysqli_query($connection, $sql);
$cusdata = mysqli_fetch_all($query, MYSQLI_ASSOC);
$ordernum = $cusdata[0]['ordcount'] + 1;
$ordID = $cusID.$ordernum;
$riderID =  $_SESSION['selectedRiderID'];


$sql = "SELECT * 
        FROM cart 
        WHERE cusID='$cusID'";
$query = mysqli_query($connection, $sql);
$results = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo '<script>';  
echo 'alert("Order confirmed")';  
echo '</script>';

foreach ($results as $rows){
    $cusID =  $rows['cusID'];
    $resID = $rows['resID'];
    $foodID =  $rows['foodID'];
    $quantity = $rows['quantity'];
    $price = $rows['price'];
    $insertSql = "INSERT INTO orders (orderID, cusID, foodID, resID, riderID, quantity, amount, status) 
                VALUES ('$ordID', '$cusID', '$foodID', '$resID', '$riderID', '$quantity', '$price*$quantity', 'pending')";
    $insert = mysqli_query($connection, $insertSql);
    $delsql = "DELETE
               FROM cart
               WHERE cusID='$cusID'";
    $del = mysqli_query($connection, $delsql);
}
header("Location: cart.php?message=Order Placed successfully!");
?>