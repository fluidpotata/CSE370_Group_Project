<?php

session_start();
$resID = $_SESSION['resID'];
require_once("dbconnect.php");
$query = "select foodID, foodName from Food";
$result = mysqli_query($connection, $query);
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
    <div class = 'left'>
        <div class='sidebar'>
            <div class=" logo">Quickeats</div>
            <div class='sidebar-menus'>
            <a href='manager.php'><ion-icon name='storefront-outline'></ion-icon>Home</a>
            <a href='foodlist.php'><ion-icon name='list-outline'></ion-icon>Food-list</a>
            <a href='res_his.php'><ion-icon name='receipt-outline'></ion-icon>Previous orders</a>
            </div>
            <div class="sidebar-logout">
                <a href='login.php'><ion-icon name='log-out-outline'></ion-icon>Logout</a>
            </div>
        </div>
    </div>
    <div class = 'right'>
        <div class = 'foods'>
        <h2 class = 'headline'>Foodlist</h2>
        <?php
            
            if ($result) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    $foodID = $row['foodID'];
                    // echo'<div class= foodname.';
                    echo $row['foodName'];
                    //add
                    $isFormDisabled = false;
                    echo "<form class= button method='post' name='order_form_$foodID' ";
                    if (isset($_POST["confirm_$foodID"])) {
                        $isFormDisabled = true;
                        echo "disabled"; 
                    }

                    echo ">";
                    echo "<input type='submit' name='confirm_$foodID' value='add food'";
                    if ($isFormDisabled) {
                        echo " disabled";
                    }

                    echo ">";

                    echo "</form>";
                    if (isset($_POST["confirm_$foodID"])) {
                        $sql = "INSERT into available_foods VALUES('$resID', '$foodID');";
                        $query3 = "select count(*) as x from available_foods where resID= '$resID' and foodID = '$foodID'";
                        $result = mysqli_query($connection, $query3);
                        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $isthere = $result[0]['x'];
                        if ($isthere>0) {
                            echo '<script>';  
                            echo 'alert("This food item has been added alredy")';  
                            echo '</script>';
                        } else {
                            $exec = mysqli_query($connection, $sql);
                            echo '<script>';  
                            echo 'alert("successfully added")';  
                            echo '</script>';
                        }
                        }
                    //delet
                    echo "<form class= button method='post' name='order_form_$foodID' ";
                    

                    echo ">";
                    echo "<input type='submit' name='delet_$foodID' value='Delet Food'";
                
                    echo ">";

                    echo "</form>";
                    if (isset($_POST["delet_$foodID"])) {
                        $sql = "DELETE FROM available_foods WHERE resID='$resID' AND foodID='$foodID'";
                        $query3 = "select count(*) as x from available_foods where resID= '$resID' and foodID = '$foodID'";
                        $result = mysqli_query($connection, $query3);
                        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $isthere = $result[0]['x'];
                        if ($isthere<>0) {
                             $exec = mysqli_query($connection, $sql);
                            echo '<script>';  
                            echo 'alert("successfully removed")';  
                            echo '</script>';
                        } else {
                            echo '<script>';  
                            echo 'alert("This food not on your menu")';  
                            echo '</script>';
                        }
                        }
                    
                    
                    echo "<hr>";
                    echo"<br>";
                    // echo '</div>';
                }
            } else {

                echo "Error executing query: " . mysqli_error($connection);
            }
            ?>
            
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
        .logo {
        color: azure;
        font-size: 2rem;
        font-weight: bold;
        font-style: italic;
        padding: 0 2rem;
        align-items: center;
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
        
        .sidebar-menus a:hover, .sidebar-logout a:hover{
            background-color: var(--secondaryColor);
            border-radius:50px;
        }
        .right{
            display: flex;
            background-color: azure;
            font-size: 1.5rem; 
            font-weight: bold;
            color: #49779d; 
            padding:3rem;
            font-family:'Open Sans',sans-serif;
            width: 100%;
            height: max-content;
            min-height: 100vh ;
            margin-left: 250px;
    
        }
        .headline {
            display: flex;
            font-size: 3rem; 
            font-weight: bold;
            margin-bottom: 20px;
            color: #5d7387;}
        .button input {
            width: 100px;
            height: 30px;
            /* padding: 1rem 3rem ; */
            font-size: 12px;
            border: none;
            color: #f0ffff;
            background: #49779d;
            cursor:pointer ;
            border-radius: 20px;}
        .button input:disabled {
            background-color: #fff;
            color: #666;
            border: 1px solid #222;
            opacity: 0.75;
            cursor: not-allowed;
            }
        </style>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>      

</body>
</html>

