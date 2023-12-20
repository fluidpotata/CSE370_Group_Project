<?php

session_start();

include('dbconnect.php');

if (isset($_POST['cusID']) && isset($_POST['resID']) && isset($_POST['foodID']) && isset($_POST['price']) && isset($_POST['quantity'])) {
    $cusID = $_POST['cusID'];
    $resID = $_POST['resID'];
    $foodID = $_POST['foodID'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];


    $check = "SELECT count(*) as countdata
              FROM cart 
              WHERE cusID='$cusID' AND resID='$resID' AND foodID='$foodID'";
  
    $check = mysqli_query($connection, $check);
    $check = mysqli_fetch_all($check, MYSQLI_ASSOC);
    
    if ($check[0]['countdata'] == 0) {
      if ($quantity>0){
      $sql = "INSERT IGNORE INTO cart (cusID, resID, foodID, price, quantity) 
              VALUES ('$cusID', '$resID', '$foodID', '$price', '$quantity')";
      $stmt = mysqli_query($connection, $sql);
      header("Location: menu.php?message=Item added to cart successfully!&resID=$resID");
      exit; 
      }
      else{
        header("Location: menu.php?message=Invalid Amount&resID=$resID");
        exit;
      }
    }
    else{
      header("Location: menu.php?resID=$resID&message=Item already exists in cart!!");
      exit;
    }



}