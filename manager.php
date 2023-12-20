<?php

    session_start();

    $mgr = $_SESSION['cusID'];

    require_once("dbconnect.php");

    $query = "select * from restaurant where mgr_ID='$mgr'";
    $result = mysqli_query($connection, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $res = $rows[0]['resID'];
    
    $query1 = "select Orders.orderID, Orders.foodID, food.foodname, Orders.quantity, Orders.riderID from Orders inner join food on Orders.foodID = Food.foodID where Orders.resID= '$res' and orders.status = 'pending'";
    $result1 = mysqli_query($connection, $query1);

    $qfun1 ="select count(distinct orderID) as count from ORDERS where resID= '$res'";
    $rfun1 =mysqli_query($connection, $qfun1);
    $count1 = mysqli_fetch_all($rfun1, MYSQLI_ASSOC);;


    $qfun2 ="select count(distinct orderID) as count from ORDERS where resID= '$res' and status= 'pending'";
    $rfun2 =mysqli_query($connection, $qfun2);
    $count2 = mysqli_fetch_all($rfun2, MYSQLI_ASSOC);;

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>Food Delivery System</title>
</head>

<body>
    <!--sidebar-->
    <div class='sidebar'>
        <div class=" logo">Quickeats</div>
        <div class='sidebar-menus'>
            <a href='manager.php'><ion-icon name='storefront-outline'></ion-icon>Home</a>
            <a href='foodlist.php'><ion-icon name='list-outline'></ion-icon>Food-list</a>
            <a href='res_his.php'><ion-icon name='receipt-outline'></ion-icon>Previous orders</a>
        </div>
        <!--logout-->
        <div class="sidebar-logout">
            <a href='login.php'><ion-icon name='log-out-outline'></ion-icon>Logout</a>
        </div>
    </div>
    <!--main-->
    <div class="main">
        <!--main navbar-->
        <div class="main-navbar">
            <?php foreach($rows as $row):?>
            <h2 class="res-name">  <?php echo "ID: " . $row['resID'] . "<br>";
                echo "Name: " . $row['name'] . "<br>";
                $_SESSION['resID']= $row['resID'];
                ?>
                <hr>
            </h2>
            
            <?php endforeach  ?>
            
            <!--profile icon on the left side of navbar-->
            <div class="profile">
                <a class="user" href="mgr_profile.php"><ion-icon name='person-outline'></ion-icon></a>
            </div>
        </div>

        <!--main highlight-->
        <div class="main-highlight">
            <!--title section and arrow-->
            <div class="main-header">
                <h2 class="main-title">Today's highlight</h2>
            </div>
            <!--highlight menu-->
            <div class="highlight-wrapper">
                <div class="highlight-card">
                    <div class="highlight-desc">
                        <h3>Total Order count: <?php echo $count1[0]['count'] ?></h3>
                    </div>
                </div>
                <div class="highlight-card">
                    <div class="highlight-desc">
                        <h3>Pending Order count: <?php echo $count2[0]['count'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class = 'order'>
            <div class="Olist">
            <div>
                <h2 class="main-title1">Current Orders:</h2>
                <!-- <p class=headiling>OrderID  -  RiderID  -  Foodname   -  Quantity</p> -->
                <div class=order>
                <?php
                if ($result1) {
                    $rows = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                    $orderID = "";
                    foreach ($rows as $row) {
                        echo '<div class=olistp>';

                            if($orderID <> $row['orderID']){
                                if($orderID<>""){
                                    $isFormDisabled = false;
                                    echo "<form class = button method='post' name='order_form_$orderID' ";
                                    if (isset($_POST["confirm_$orderID"])) {
                                        $isFormDisabled = true;
                                    }
                            
                                    echo ">";
                                    echo "<input type='submit' name='confirm_$orderID' value='confirm'";
                                    if ($isFormDisabled) {
                                        echo " disabled";
                                    }
                            
                                    echo ">";
                            
                                    echo "</form>";
                                    if (isset($_POST["confirm_$orderID"])) {

                                        $sql = "UPDATE ORDERS SET status = 'ready' WHERE orderID = '$orderID' and resID = '$resID'";

                                        if ($connection->query($sql) === TRUE) {
                                            echo '<script>';  
                                            echo 'alert("successfully handed to rider")';  
                                            echo '</script>';
                                        } else {
                                            echo '<script>';  
                                            echo 'alert("Invalid")';  
                                            echo '</script>';
                                        }
                                        }
                                    echo "<hr>";
                                    echo "<br>";
                                }
                                $orderID = $row['orderID']; 
                                echo '<h3>Order ID: ' . $row['orderID'].'</h3>' .'<br> '.
                                'Rider ID: '.$row['riderID'].' <br> '.
                                '-'.$row['foodname'].' x '.
                                '-'.$row['quantity'];}
                            else{
                                echo '-'.$row['foodname'].' x '.
                                '-'.$row['quantity'];}   
                            echo '<div>';
                            }
                    mysqli_free_result($result);
                } else {
                    echo "Error executing query: " . mysqli_error($connection);
                }
                if($orderID<>""){
                            $isFormDisabled = false;                
                            echo "<form class = button method='post' name='order_form_$orderID' ";
                            if (isset($_POST["confirm_$orderID"])) {
                                $isFormDisabled = true;
                            }
                    
                            echo ">";
                            echo "<input type='submit' name='confirm_$orderID' value='confirm'";
                            if ($isFormDisabled) {
                                echo " disabled";
                            }
                    
                            echo ">";
                    
                            echo "</form>";
                            if (isset($_POST["confirm_$orderID"])) {

                                $sql = "UPDATE ORDERS SET status = 'ready' WHERE orderID = '$orderID' and resID='$res'";

                                if ($connection->query($sql) === TRUE) {
                                    echo '<script>';  
                                    echo 'alert("successfully handed to rider")';  
                                    echo '</script>';
                                } else {
                                    echo '<script>';  
                                    echo 'alert("Invalid")';  
                                    echo '</script>';
                                }
                                }
                            echo "<hr>";
                            echo "<br>";}
                ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
   
    <style>
        :root {
            --primaryColor: #435361;
            --secondaryColor: rgb(73, 119, 157);
            --whiteColor: #fff;
            --blackColor: #222;
            --softblueColor:#91d4cd;
            --darkBlueColor:rgb(57, 92, 99);
            --grayColor: #f5f5f5;
        }
        *{
            margin: 0;
            padding:0;
            box-sizing: border-box;
            outline: none;
            font-family:'Open Sans',sans-serif;

        }
        body { 
            width:100%;
            height: auto;
            display:flex;


        }
        .sidebar {
            height:100%;
            width: 250px;
            display:flex;
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
            color: azure;
            font-size: 2rem;
            font-weight: bold;
            font-style: italic;
            padding: 0 2rem;
            }
        .sidebar-menus {
            display: flex;
            flex-direction: column;
        }
        .sidebar-menus a , .sidebar-logout a {
            padding: 5% 8%;
            margin: 0.5rem 0;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            text-decoration: none;
            color: var(--whiteColor);
        }
        .sidebar-menus a ion-icon , .sidebar-logout a ion-icon {
            font-size: 20px;
        }
        .sidebar-menus a:hover, .sidebar-logout a:hover{
            background-color: var(--secondaryColor);
            border-radius:50px;
        }
        .main{
            width: 100%;
            height: max-content;
            min-height: 100vh ;
            padding: 2%;
            background-color: azure;
            margin-left: 250px;
        }
        .main-navbar {
            display: flex;
            height: max-content;
            justify-content: space-between;
            align-items: center; 
        }
        .main-navbar h2{
            font-size: 30px;
            color: var(--secondaryColor);
        }
        
        
        
        .profile{
            display: flex;
            align-items: right;
            gap:0.5rem ;
            border: 1px solid #c0cccc;
            border-radius: 50px;
        }
        
        .main-highlight{
            margin: 2% 0;
            padding: 2%;
            background-color: var(--secondaryColor);
            border-radius: 8px;

        }
        .main-header{
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            
        }
        .main-title{
            font-size: 22px;
            color: #ffff;
        }
        .main-title1{
            font-size: 22px;
            color: var(--secondaryColor);
            margin-bottom: 2.5rem;}
        /* .headiling{
            font-size: 17px;
            color: var(--secondaryColor);
            margin-bottom: 1rem;
        } */
        
    
        .back.hover, .back.hover{
            color: var(--primaryColor);
        }
        .highlight-wrapper{
            width:100% ;
            display: flex;
            padding: 1%;
            border-radius: 8px;
            gap: 1.5rpm;
            overflow: hidden;

        }
        .highlight-card{
            display: flex;
            flex-direction: row;
            min-width: 200px;
            width: 80%;
            height: 100%;
            gap: 1rem;
            border-radius: 8px;
            padding: 1%;
            background-color: var(--grayColor);
            cursor: pointer;

        }
        .highlight-desc h3{
            color: var(--primaryColor);   
        }
        .highlight-card:hover {
            background-color: var(--whiteColor);
            box-shadow:  0px 8px 24px rgb(102, 113, 114);
            
        }
        .main-menu {
            min-height: 100%;
            background-color: var(--grayColor);
            padding: 2%;
            border-radius: 8px;
        }
        
        
        .order {
            
        }
        .olistp{
            font-size: 15px;
            color: var(--primaryColor);

        }
        .olistp h3{
            display: inline;
            font-size: 18px;
        }

        .button input {
            width: 100px;
            height: 30px;
            /* padding: 1rem 3rem ; */
            font-size: 12px;
            border: none;
            color: #f0ffff;
            background-color: #49779d;
            cursor:pointer ;
            border-radius: 20px;}
        .button input:disabled {
            background-color: #fff;
            color: #666;
            border: 1px;
            border-color: #222;
            opacity: 0.75;
            cursor: not-allowed;
            }

        
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>