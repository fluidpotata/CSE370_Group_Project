<?php

session_start();

include('dbconnect.php');

$cusID = $_SESSION['cusID'];
$foodID = $_REQUEST['foodID'];

$foodkey = "%".$foodID.'%';
$query = "SELECT available_foods.resID as resID, food.foodID as foodID, food.foodName as foodName, food.price as price
        FROM available_foods INNER JOIN food 
        ON available_foods.foodID = food.foodID 
        WHERE available_foods.foodID IN (SELECT foodID FROM food WHERE foodname LIKE '$foodkey' or foodType  LIKE '$foodkey') ";
$result = mysqli_query($connection, $query);
$foods = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo "Search of ".$foodID; ?></title>
</head>

<body>

    <!-- Add your restaurant content here -->
    <div class="restaurant-menu" id="restaurant1-menu">
    <h1>Searched Items</h1>
    <div class="menu-content">     
        <main>
        <div class="menu-items">
            <!-- Menu Items -->
            <?php foreach($foods as $food): ?>
                <?php
                $resID = $food['resID'];
                $res = "SELECT name FROM restaurant WHERE resID='$resID'";
                $res = mysqli_query($connection, $res);
                $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
                ?>
                <div class="menu-item" data-id="<?php echo $food['foodID']; ?>" data-available-quantity="3">
                    <img class="menu-img" src="resources/<?php echo $food['foodID'];?>.png">
                    <div class="menu-desc">
                        <h4><?php echo $food['foodName']; ?></h4>
                        <p><?php echo $res[0]['name']; ?></p>
                        <p>৳<?php echo $food['price']; ?></p>
                        <div class="cart-controls">
                        <form action="add-to-cart.php" method="post" class="add-to-cart-form">
                            <input type="hidden" name="cusID" value="<?php echo $cusID; ?>">
                            <input type="hidden" name="resID" value="<?php echo $resID; ?>">
                            <input type="hidden" name="foodID" class="food-id" value="<?php echo $food['foodID']; ?>">
                            <input type="hidden" name="price" class="food-price" value="<?php echo $food['price']; ?>">
                            <input type="number" name="quantity" class="food-quantity" value="0">
                            <input type="submit" class="add-to-cart-btn" name="Add to Cart">
                        </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <button class="cartbutton" onclick="window.location.href='cart.php'">Go to Cart</button>
</div>
            </main>
<style>
    .cartbutton{
        margin: 0 auto;
        margin-top: 30px;
        background-color: white;
        color: #87CEEB;
        padding: 7px 9px;
        border: none;
        cursor: pointer;
        width: 20%;
    }
    .restaurant-menu {
        text-align: center;
        margin:50px;
        width:100% ;
        display: grid;
        padding: 5%;
        border-radius: 8px;
        gap: 1.5rpm;
        overflow: hidden;
    }

    .menu-items {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
        cursor: pointer; 
    }

    .menu-item {
        background-color: #f5f5f5;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .menu-img {
        max-width: 100%;
        border-radius: 20px;
        width: 150px;
        height: 150px;
    }

    .menu-desc {
        margin-top: 10px;
    }

    #restaurant1-menu ,#restaurant2-menu{ 
    background-color: var(--secondaryColor);
    border: #222;
}


.restaurant1-menu:hover ,.restaurant2-menu:hover{
    background-color: var(--primaryColor);
    color: var(--whiteColor);
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

</body>

</html>
