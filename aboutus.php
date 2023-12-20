<?php
session_start();

require_once("dbconnect.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <nav>
        <div class=" logo">Quickeats</div>
        <div class="nav-items">
            <a href="Home.php">HOME</a>
            <a href="signup.php">SIGNUP</a>
            <a href="login.php">LOGIN</a>
        </div>
    </nav>
    <section class= "front">
        <div class="front-container">
            <div class= "column-left">
                <h1>ABOUT US</h1>
                <p>
                We are the future of food delivery, built for speed and your convenience. 
                Say goodbye to long wait times and hello to hot, delicious food delivered 
                straight to your door within minutes. With our innovative platform and dedicated 
                network of riders, we guarantee lightning-fast delivery so you can satisfy your 
                cravings in no time. Plus, our seamless cash-on-delivery system allows you to pay 
                for your order only when it arrives, ensuring a stress-free experience. Whether you're 
                craving a quick bite or a multi-course feast, we've got you covered with a wide range of 
                restaurants and cuisines to choose from. So next time hunger hits, don't wait, order from our 
                website and experience the fastest and most convenient food delivery service in town.
                </p>
                <!-- <button onclick="window.location.href='signup.php'">Let's Start</button> -->
            </div>
        </div>
    </section>
    <style>
        *{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    nav {
        height: 80px;
        background: #265073;
        display:flex ;
        justify-content: space-between;
        align-items: center;
        padding: 0rem calc((100vw -1300px) / 2);
        
    }
    
    .logo {
        color: #ECF4D6;
        font-size: 2rem;
        font-weight: bold;
        font-style: italic;
        padding: 0 2rem;
        
    }

    nav a {
        text-decoration: none;
        font-size: 1.3rem;
        color: #9AD0C2;
        padding: 0 1.5rem;

        
    }

    nav a:hover {
        color: #ECF4D6;
    }
    .front {
        background: #ECF4D6;
    }
    .front-container {
        margin-left: 2rem;
        display:flex ;
        grid-template-columns: 1fr 1fr ;
        height:95vh ;
        padding: 3rem calc((100vw -1300px) / 2);
        justify-content:center ;
        align-items: center ;
    }

    .column-left {
        display:flex ;
        flex-direction:column ;
        justify-content:center ;
        align-items: center ;
        color:#265073 ;
        padding: 0rem 4rem;
    }

    .column-left h1 {
        margin-top: 3px;
        font-size: 2.5rem;
        margin-bottom : 2rem;
    }

    .column-left p {
        margin-left: 4rem;
        margin-right: 4rem;
        font-size: 1.2rem;
        line-height: 1.5;
        margin-bottom : 3rem;
    }

    /* button {
        padding: 1rem 3rem ;
        font-size: 1rem;
        border: none;
        color: #ECF4D6;
        background: #265073;
        cursor:pointer ;
        border-radius: 50px;
    }

    button:hover{
        background: #9ad0c2;
        color: #265073;
        
    } */
        
    </style>
</body>
</html>