<?php

session_start();

include('dbconnect.php');

$cusID = $_SESSION['cusID'];
$resID = $_REQUEST['resID'];
// $_SESSION['resID'] = $resID;

$query = "SELECT name FROM restaurant WHERE resID = '$resID'";
$result = mysqli_query($connection, $query);
$restaurant = mysqli_fetch_assoc($result);

$query = "SELECT food.foodID as foodID, food.foodName as foodName, food.price as price
        FROM available_foods INNER JOIN food 
        ON available_foods.foodID = food.foodID 
        WHERE available_foods.resID = '$resID'";
$result = mysqli_query($connection, $query);
$foods = mysqli_fetch_all($result, MYSQLI_ASSOC);


$message = "";
// if (isset($_GET['message'])) {
//     $message = $_GET['message'];
//     echo '<script>';  
//     echo 'alert("'.$message.'")';  
//     echo '</script>'; 
// }
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
    <title><?php echo $restaurant['name']; ?></title>
</head>

<body>

    <!-- Add your restaurant content here -->
    <div class="restaurant-menu" id="restaurant1-menu">
    <h1>Menu</h1>
    <div class="menu-content">
        <h3 class="restaurant-name"><?php echo $restaurant['name']; ?></h3>
        <!-- <p class="restaurant-quantity">Items in Cart: <span id="restaurant-quantity-label">0</span></p> -->
        <div class="menu-items">
            <!-- Menu Items -->
            <?php foreach($foods as $food): ?>
                <div class="menu-item" data-id="<?php echo $food['foodID']; ?>" data-available-quantity="3">
                    <img class="menu-img" src="resources/<?php echo $food['foodID'];?>.png">
                    <div class="menu-desc">
                        <h4><?php echo $food['foodName']; ?></h4>
                        <p>$<?php echo $food['price']; ?></p>
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
        // document.addEventListener("DOMContentLoaded", function () {
        //     const quantityInputs = document.querySelectorAll('.quantity-input');
        //     const totalPriceElements = document.querySelectorAll('.total-price');
        //     const quantityIncrementButtons = document.querySelectorAll('.quantity-increment');
        //     const quantityDecrementButtons = document.querySelectorAll('.quantity-decrement');
        //     const restaurantQuantityLabel = document.getElementById('restaurant-quantity-label');
        //     const addBtn = document.querySelectorAll('.add-to-cart-btn')
        //     addBtn.forEach(btn => {
        //         btn.addEventListener('click', () => {
        //             const foodId = btn.closest('.menu-item').dataset.id;
        //             const price = document.querySelector('.food-price').value;
        //             const quantity = document.querySelector('.food-quantity').value;

        //             document.querySelector('.food-id').value = foodId;
        //             document.querySelector('.food-price').value = price;
        //             document.querySelector('.food-quantity').value = quantity;

        //             document.querySelector('.add-to-cart-form').submit();
        //         });
        //     });
        // })
        function displayAlert(message) {
            alert(message);
        }
        <?php if (isset($_GET['message'])): ?>
            displayAlert("<?php echo $message; ?>");
        <?php endif; ?>

</script>

</body>

</html>
