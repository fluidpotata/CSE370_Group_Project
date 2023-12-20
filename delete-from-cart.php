<?php

session_start();

require_once('dbconnect.php');
echo $_POST['cusID'];
echo $_POST['resID'];
echo $_POST['foodID'];

if (isset($_POST['cusID']) && isset($_POST['resID']) && isset($_POST['foodID'])) {
    $cusID = $_POST['cusID'];
    $resID = $_POST['resID'];
    $foodID = $_POST['foodID'];
    $sql = "DELETE
    FROM cart
    WHERE cusID='$cusID' AND resID='$resID' AND foodID='$foodID'";
    $stmt = mysqli_query($connection, $sql);
    if ($stmt) {
        header("Location: cart.php?message=Item removed from cart successfully!");
    }
}

?>