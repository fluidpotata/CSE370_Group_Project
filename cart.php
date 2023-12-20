<?php

session_start();
require_once("dbconnect.php");

$cusID = $_SESSION['cusID'];

$sql = "SELECT cart.foodID as foodID, cart.resID as resID, cart.Quantity, cart.Price, food.foodName, restaurant.name 
        FROM cart 
        INNER JOIN food ON cart.foodID = food.foodID 
        INNER JOIN restaurant ON cart.resID = restaurant.resID 
        WHERE cart.cusID = '$cusID'";

$result = mysqli_query($connection, $sql);
$cartitems = mysqli_fetch_all($result, MYSQLI_ASSOC);

$totalPrice = 0;

function confirmorder($cusID,$cartitems){
        echo '<script>';  
        echo 'alert("Order confirmed")';  
        echo '</script>';
}

if(array_key_exists('orderbutton', $_POST)) { 
    header("Location: cusrider.php");
}


if(array_key_exists('deletebutton', $_POST)) { 
    header("Location: delete-from-cart.php");
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
</head>
<body>

    <div class='sidebar'>

        <h1 class='logo'>QUICKEATS</h1>

        <div class='sidebar-menus'>
            <a href='customer.php'><ion-icon name='storefront-outline'></ion-icon>Home</a>
            <a href='#preorders.php'><ion-icon name='receipt-outline'></ion-icon>Bills</a>
            <!-- <a href='#'><ion-icon name='wallet-outline'></ion-icon>Wallet</a> -->
            <!-- <a href='#'><ion-icon name='notifications-outline'></ion-icon>Notification</a> -->
            <a href='about.php'><ion-icon name='chatbubble-outline'></ion-icon>Contact Us</a>
            <!-- <a href='#'><ion-icon name='settings-outline'></ion-icon>Settings</a> -->
        </div>

        <div class="sidebar-logout">
            <a href='login.php'><ion-icon name='log-out-outline'></ion-icon>Logout</a>
        </div>
    </div>
        <div class="main">

        <div class="main-navbar">
        </div>


        <div class="main-highlight">

            <div class="main-header">

            </div>
            </div>

            <div class="highlight-wrapper">
            </div>


        <div class="main-content" style="margin-left: 250px">
        <?php if (count($cartitems) > 0): ?>
            <?php foreach($cartitems as $row): ?>
                <?php
                $totalPrice += $row["Price"] * $row["Quantity"];
                $orderID = 'your-order-id';
                $status = 'Prepping';
                ?>
                <div class='cart-item'>
                    
                    <div class="menu-cont">
                        <div>
                        <h2><?php echo $row["foodName"]; ?></h2>
                        <p><h4><?php echo $row["name"]; ?></h4></p>
                        <p>Quantity: <?php echo $row["Quantity"]; ?></p>
                        <p>Price: <?php echo $row["Price"]; ?></p>
                        <form action="delete-from-cart.php" method="post"> 
                        <input type="hidden" name="cusID" value="<?php echo $cusID; ?>">
                        <input type="hidden" name="resID" value="<?php echo $row['resID']; ?>">
                        <input type="hidden" name="foodID" value="<?php echo $row['foodID']; ?>">
                        <!-- <input type="submit" name="deletebutton" -->
                        <!-- class="confirmbutton" value="Drop" ><ion-icon name="trash" slot="icon"></ion-icon> -->
                        <button type="submit" name="deletebutton" class="confirmbutton">
                            <ion-icon name='trash'></ion-icon>
                        </button> 
                    </form>
                        </div>
                        <img class="menu-img" src="resources/<?php echo $row['foodID'];?>.png"><br>
                    </div>
                    
                </div>
            <?php endforeach; ?>
            <form method="post"> 
            <input type="submit" name="orderbutton"
                    class="confirmbutton" value="Confirm order">
        </form>
        <?php else: ?>
            <p>No items in cart</p>
        <?php endif; ?>
        <div class='total-price'>
            <b>Total Price: <?php echo $totalPrice; ?>
        </div>
        </div>
    </div>


        <!-- <button class="restaurant-button" onclick="window.location.href='restaurant.php?name=<?php echo urlencode($restaurant['Name']); ?>'">
            <?php echo $restaurant['Name']; ?> (Rating: <?php echo $restaurant['resID']; ?>)
        </button> -->
    <!-- <?php 

       
    ?>
    <?php $connection->close(); ?> -->
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
        .main-content {
            margin-left: 500px;
            padding: 20px;
        }
        .main-navbar {
        display: flex;
        height: max-content;
        justify-content: space-between;
        align-items: center; 
        }
        .cart-item {
            padding: 10px;
            /* margin-bottom: 20px; */
            width: 600px;
            background-color: white;
            margin: 0 auto;
            margin-top: 10px;
            border: 3px solid #435361;
            border-radius: 4px;

        }
        .total-price {
            display: flex;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--grayColor);
            padding: 15px;
            border: 1px solid #435361;
            border-radius: 10px;
        }
        .confirmbutton{
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
        }
        .profile{
            display: flex;
            align-items: right;
            gap:0.5rem ;
        }
        .menu-cont{
            display: flex;
        }
        .menu-img{
            margin-left: 10%;
            align-items: right;
            width: 150px;
            height: 150px;
        }

    </style>
    <script>
        function displayAlert(message) {
            alert(message);
        }
        <?php if (isset($_GET['message'])): ?>
            displayAlert("<?php echo $message; ?>");
        <?php endif; ?>
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
