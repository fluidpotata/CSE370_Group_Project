<?php

session_start();

require_once("dbconnect.php");

$cusID = $_SESSION['cusID'];


$query = "SELECT Name, resID FROM RESTAURANT";
$result = mysqli_query($connection, $query);
$restaurants = mysqli_fetch_all($result, MYSQLI_ASSOC);

// $query2 = "SELECT foodID, count(foodID) as count
//            FROM Orders
//            GROUP BY foodID
                // ";


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>Food Delivery System</title>
</head>

<body>

    <div class='sidebar'>

        <h1 class='logo'>QUICKEATS</h1>

        <div class='sidebar-menus'>
            <a href='customer.php'><ion-icon name='storefront-outline'></ion-icon>Home</a>
            <a href='cus_his.php'><ion-icon name='receipt-outline'></ion-icon>Previous Orders</a>
            <a href='about.php'><ion-icon name='chatbubble-outline'></ion-icon>Contact Us</a>
        </div>

        <div class="sidebar-logout">
            <a href='login.php'><ion-icon name='log-out-outline'></ion-icon>Logout</a>
        </div>
    </div>

    <div class="main">

        <div class="main-navbar">

            <ion-icon class="menu-toggle" name="menu-outline"></ion-icon>
            <!--search bar-->
            <div class="search">
            <form method="post" action="search.php">
                <input type="text" name="foodID" placeholder="What you want to eat?">
                <button type="submit" class="search-btn">Search</button>
            </form>
            </div>

            <div class="profile">
                <a class="cart" href="cart.php"><ion-icon name='cart-outline'></ion-icon></a>
                <a class="user" href="cus_profile.php"><ion-icon name='person-outline'></ion-icon></a>
            </div>
        </div>

        <div class="main-highlight">

            <div class="main-header">
                <h2 class="main-title">Recommendation</h2>
                <div class="main-arrow">
                    <ion-icon class="back" name="chevron-back-circle-outline"></ion-icon>
                    <ion-icon class="next" name="chevron-forward-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="highlight-wrapper">
                <div class="highlight-card">
                    <img class="highlight-img" src="noodles.jpg">
                    <div class="highlight-desc">
                        <h4>Name of food1</h4>
                        <p>$100</p>
                    </div>
                </div>

                <div class="highlight-card">
                    <img class="highlight-img" src="coffee.jpg">
                    <div class="highlight-desc">
                        <h4>Name of food2</h4>
                        <p>$200</p>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="resID" id="resID" value="">

        <div class="main-filter">
        <div>
            <h2 class="main-title">Pick a Restaurant</h2>
            <div class="main-arrow">
            <ion-icon class="back-menus" name="chevron-back-circle-outline"></ion-icon>
            <ion-icon class="next-menus" name="chevron-forward-circle-outline"></ion-icon>
            </div>
        </div>

        <?php foreach($restaurants as $restaurant): ?>
        <form method="post" action="menu.php">
            <input type="hidden" name="resID" value="<?php echo $restaurant['resID']; ?>">
            <button type="submit" class="restaurant-button">
            <?php echo $restaurant['Name']; ?>
            </button>
        </form>
        <!-- <button class="restaurant-button" onclick="window.location.href='restaurant.php?name=<?php echo urlencode($restaurant['Name']); ?>'">
            <?php echo $restaurant['Name']; ?> (Rating: <?php echo $restaurant['resID']; ?>)
        </button> -->
        <?php endforeach; ?>
        </div>
        </div>
    </div>
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

        .menu.toggle {
            width: 60%;
            height: 40px;
            display: flex;
            justify-content: space-around;
            background-color: var(--whiteColor);
            border-radius: 20%;

        }
        .search {
            width: 60%;
            height: 40px;
            display: flex;
            justify-content: space-around;
            background-color: var(--whiteColor);
            border-radius: 20px;

        }
        .search input {
            width: 80%;
            height: 100%;
            padding: 20px;
            border:none;
            border-radius: 20px;


        }
        .search-btn {
        
            background-color: var(--secondaryColor);
            color: var(--whiteColor);
            border: none;
            border-radius: 20px;
            width: 120px;
            cursor: pointer;
        }
        .search:hover {
            box-shadow: 0px 8px 24px rgb(102, 113, 114);
        }
        .search-btn:hover {
            background-color: var(--primaryColor);
        }
        .profile{
            display: flex;
            align-items: center;
            gap:0.5rem ;
        }
        .cart,.user{
            display:flex;
            justify-content: center;
            align-items: center;
            background-color: var(--whiteColor);
            font-size: 20px;
            color: var(--primaryColor);
            text-decoration: none;
            padding: 0 10px;
            height: 40px;
            border-radius: 50%;
        }

        .cart:hover, .user:hover{
            box-shadow:  0px 8px 24px rgb(102, 113, 114);
        }
        .main-highlight{
            margin: 3% 0;
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
            font-size: 20px;

        }
        .main-arrow{
            font-size: 24px;
        }
        .back,.next{
            cursor: pointer;

        }
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
        .highlight-img{
            width: 40px;
            height: 40px;
            border-radius:8px ;
            object-fit: cover;
            object-position: center;
            
        }
        .highlight-desc h4{
            color: var(--whiteColor);
            
        }
        .highlight-desc p{
            color: var(--blackColor);
            font-size: 13px;
            
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
        /* Styling for Filter Section */
        .main-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-top: 1.5rem;
            padding: 0 2%;
            gap: 1rem;
        }
        .back-menus,.next-menus{
            cursor: pointer;
        }
        .back-menus:hover,.next-menus:hover{
            color: var(--primaryColor);
        }

        .filter-wrapper {
            display: flex;
            justify-content: flex-start;
            gap: 1.2rem;
            overflow-x: hidden;
            width: 100%;
            height: 100px;

        }

        .filter-card {
            display: flex;
            flex-direction: column;
            min-width: 80px;
            height:100%;
            align-items: center;
            justify-content: space-around;
            background-color: var(--whiteColor);
            color: var(--blackColor);
            border-radius: 8px;
            border: 1px solid ;
            padding: 1rem;
            cursor: pointer;
        }

        .filter-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60%;
            height: 60%;
            font-size: 30px;
            background-color: var(--whiteColor);
            color: var(--primaryColor);
            border-radius: 8px;
            border:1px solid var(--softblueColor);
        }

        .filter-card:hover {
            background-color: var(--primaryColor);
            color: var(--whiteColor);
        }

        .filter-card:hover .filter-icon {
            background-color: var(--whiteColor);

        }
        .restaurant-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: var(--secondaryColor); /* Use your preferred color */
            color: var(--whiteColor);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .restaurant-button:hover {
            background-color: var(--primaryColor); /* Change color on hover */
        }
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>