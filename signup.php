<?php
session_start();
require_once("dbconnect.php");

if(isset($_POST['Signup'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $fn =$_POST['fname'];
    $ln =$_POST['lname'];
    $phn =$_POST['phone'];
    $add =$_POST['address'];
    $dob =$_POST['DOB'];

    //cus id maker//
      $cq = "select count(*) as y from customers";
      $r1 = mysqli_query($connection, $cq);
      $res1 = mysqli_fetch_all($r1, MYSQLI_ASSOC);
      $res2 = $res1[0]['y'];
      $cusID = 'C'.(1001+$res2);

    //cus id maker//
    
    $q = "INSERT into users values('$cusID', '$email','$pass','CUS')";
    $qq = "INSERT into customers values('$cusID', '$fn', '$ln','$phn', '$email','$dob','$add')";
    $q1 = "select count(*) as x from users where email='$email'";
    $r1 = mysqli_query($connection, $q1);
    $res1 = mysqli_fetch_all($r1, MYSQLI_ASSOC);
    $res2 = $res1[0]['x'];
    if ($res2>0){
        echo '<script>';  
        echo 'alert("YOU ALREADY HAVE AN ACCOUNT")';  
        echo '</script>';
    }else{
        $exec = mysqli_query($connection, $q);
        $exec2= mysqli_query($connection, $qq);
        echo '<script>';   
        echo 'alert("Welcome to Quickeats")';  
        echo '</script>';
        header("Location: login.php");
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class=" logo">Quickeats</div>
        <div class="nav-items">
            <a href="Home.php">HOME</a>
            <a href="aboutus.php">ABOUT</a>
            <a href="login.php">LOGIN</a>
        </div>
    </nav>
    <section class= "front">
        <div class=heading><h1 style="text-align: center; color: #265073;">Signup</h1></div>
        <div class="front-container">
            <div class= mid-container>
            <!-- the form starts here -->
                <form class = 'frm' method="post" action="signup.php">
                <label for="Fname"><b>First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="fname" required>
                <!-- <br> -->
                <label for="lname"><b>Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="lname" required>
                <br>
                <label for="phone"><b>Phone</b></label>
                <input type="text" placeholder="Enter Phone Number" name="phone" required>
                <br>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>
                <br>
                <label for="address"><b>address</b></label>
                <input type="text" placeholder="Enter Your Address" name="address" required>
                <br>
                <label for="bday"><b>Date of Birth</b></label>
                <input type="text" placeholder="Enter Date of Birth" name="DOB" required>
                <br>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pass" required>
                <br>
                <button class='butt' type="submit" name="Signup">Signup</button>
                </form>
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
        height: 50px;
        background: #265073;
        display:flex ;
        justify-content: space-between;
        align-items: center;
        padding: 0rem calc((100vw -1300px) / 2);
        
    }
    
    .logo {
        color: #ECF4D6;
        font-size: 1.7rem;
        font-weight: bold;
        font-style: italic;
        padding: 0 2rem;
        
    }

    nav a {
        text-decoration: none;
        font-size: 1.2rem;
        color: #9AD0C2;
        padding: 0 1.5rem;

        
    }

    nav a:hover {
        color: #ECF4D6;
    }
    .front {
        background: #ECF4D6;
    }
    
    .heading{
        text-align: center;
        font-size: 1.7rem;
        color:265073;
        
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


    .mid-container{
        display: flex;
        justify-content:center ;
        padding: 16px;
        align-items: center ;
        height: 600px;
        width:350px;
        background-color: #265073;
        color:#ECF4D6;
        font-size: 1rem;
        margin-top: -3rem;

    }
    .frm{
        align-items: center ;
        justify-content:center ;
    }
    input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;}

    .butt {
        padding: 1rem 3rem ;
        border: none;
        color: #265073;
        background: #ECF4D6;
        cursor:pointer ;
        border-radius: 50px;
        margin-left:5.5rem;
        font-size:1rem;
    }

    button:hover{
        background: #fff;
        color: #265073;
        
    } 
        
    </style>
</body>
</html>
