<?php
session_start();
require_once("dbconnect.php");

$cusID = $_SESSION['cusID'];


$query = "SELECT * FROM restaurant WHERE mgr_id='$cusID'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <!--sidebar-->
    <div class='sidebar'>
        <!--logo-->
        <h1 class='logo'>QUICKEATS</h1>
        <!--list of menu-->
        <div class='sidebar-menus'>
            <a href='home.php'><ion-icon name='storefront-outline'></ion-icon>Home</a>
            <a href='#preorders.php'><ion-icon name='receipt-outline'></ion-icon>Bills</a>
            <!-- <a href='#'><ion-icon name='wallet-outline'></ion-icon>Wallet</a> -->
            <!-- <a href='#'><ion-icon name='notifications-outline'></ion-icon>Notification</a> -->
            <a href='about.php'><ion-icon name='chatbubble-outline'></ion-icon>Contact Us</a>
            <!-- <a href='#'><ion-icon name='settings-outline'></ion-icon>Settings</a> -->
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
            <!--menu when appear on mob ver-->
            <ion-icon class="menu-toggle" name="menu-outline"></ion-icon>
            <!--search bar-->
            <div class="search">
                <input type="text" placeholder="What you want to eat?">
                <button class="search-btn">Search</button>
            </div>
            <!--profile icon on the left side of navbar-->
            <div class="profile">
                <a class="cart" href="cart.php"><ion-icon name='cart-outline'></ion-icon></a>
                <a class="user" href="cus_profile.php"><ion-icon name='person-outline'></ion-icon></a>
            </div>
        </div>
              <main>
    <h1>Profile</h1>
    <div class="profile-info">
    <p>
        <span class="infos">ID:</span>
        <span id="resID"><?php echo $row[0]['resID'] ?></span>
      </p>
      <p>
        <span class="infos"> Restaurant Name:</span>
        <span class="infos"><?php echo $row[0]['name'] ?></span>
      </p>
      <p>
        <span class="infos">Restaurant Phone:</span>
        <span class="infos"><?php echo $row[0]['phone'] ?></span>
      </p>
      <p>
        <span class="infos">Manger Email:</span>
        <span class="infos"><?php echo $row[0]['mgr_mail'] ?></span>
      </p>
      <p>
        <span class="infos">Restaurant Address:</span>
        <span class="infos"><?php echo $row[0]['address'] ?></span>
      </p>
    </div>
    </div>

  </main>
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
        main {
  padding: 20px;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

.profile-info {
  background-color: #f5f5f5;
  padding: 20px;
  border-radius: 5px;
}

.infos {
  font-weight: bold;
  width: 100px;
  display: inline-block;
}

.profile-info p {
  margin-bottom: 10px;
}
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>