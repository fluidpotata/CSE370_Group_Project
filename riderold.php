<?php
$deliverButtonVisible = false; //deliverButtonVisible default false 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateAvailability'])) { //if submitted and the 'updateAvailability' button is clicked
    $selectedAvailability = $_POST['availability'];

    

    if ($selectedAvailability === 'unavailable') {
            $deliverButtonVisible = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <title>Rider Home</title>
</head>

<body>

    <!--main-->
    <div class="main">
        <!--main navbar-->
        <div class="main-navbar">
            <!--profile icon on the left side of navbar-->
            <div class="profile">
                <a class="user" href="#"><ion-icon name='person-outline'></ion-icon></a>
            </div>
        </div>

        <!-- Cart Item Section -->
        <div class="main-cart">
            <h2 class="main-title">Customer selected you as a rider to deliver!</h2>
            <div class="cart-item">
                <h3>Order from <br> Customer ID: C1001</h3>
                <p>Restaurant ID: R1001</p>
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <!-- Add more items as needed -->
                </ul>
            </div>
           
            <!-- Availability Form -->
            <form class="availability-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="availability">Availability:</label>
                <select name="availability" id="availability" required>
                    <option value="available" <?php echo ($selectedAvailability === 'available') ? 'selected' : ''; ?>>Available</option>
                    <option value="unavailable" <?php echo ($selectedAvailability === 'unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                </select>
                <button class="availability-btn" type="submit" name="updateAvailability">Update Availability</button>
                <?php if ($deliverButtonVisible): ?>
                    <button class="deliver-btn" type="button" id="deliverBtn">Proceed to Deliver</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateAvailability'])) {
        $selectedAvailability = $_POST['availability'];

        // Add your logic here to update the availability in the database or perform any other necessary actions.

        if ($selectedAvailability === 'unavailable') {
            // Show the deliver button if the availability is set to 'unavailable'
            echo '<script>document.getElementById("deliverBtn").style.display = "block";</script>';
        }
    }
    ?>
    <style>
        .main-cart {
            min-height: 100%;
            background-color: var(--grayColor);
            padding: 2%;
            border-radius: 8px;
        }

        .cart-item {
            background-color: var(--whiteColor);
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .cart-item p {
            color: var(--darkBlueColor);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .cart-item ul {
            list-style-type: none;
            padding: 0;
        }

        .cart-item ul li {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .availability-form {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }

        .availability-form label {
            font-size: 16px;
            margin-right: 10px;
        }

        .availability-form select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--softblueColor);
            margin-right: 10px;
        }

        .availability-btn {
            background: var(--secondaryColor);
            color: var(--whiteColor);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
        }

        .availability-btn:hover {
            background: var(--primaryColor);
        }

        .deliver-btn {
            background: var(--darkBlueColor);
            color: var(--whiteColor);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: auto;
            display: none;
        }
    </style>
</body>

</html>
