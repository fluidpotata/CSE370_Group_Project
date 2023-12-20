<?php
session_start();
require_once("dbconnect.php");

if(isset($_POST['login'])){
    $u = $_POST['email'];
    $p = $_POST['password'];

    $query = "SELECT * FROM USERS WHERE email = '$u' AND password = '$p'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if($row){
        // Store userID in session
        $_SESSION['cusID'] = $row['userID'];
        $_SESSION['Name'] = $row['email'];

        if($row['type'] == 'CUS'){
            header('Location: customer.php');
        } elseif($row['type'] == 'MGR'){
            header('Location: manager.php');
        } elseif($row['type'] == 'RDR'){
            header('Location: rider.php');
        } 
    }
    else {
        echo '<script>';  
        echo 'alert("Invalid Login Credentials")';  
        echo '</script>';  
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
</head>
<body>
    <div class="container">
    <h1 style="text-align: center; color: #265073; font-style: italic;">QuickEats</h1>
        <form method="post" action="login.php">
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
</div>
<style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ecf4d6;
        }
        .container{
            width: 300px;
            padding: 16px;
            background-color: white;
            margin: 0 auto;
            margin-top: 250px;
            border: 1px solid black;
            border-radius: 4px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #265073;
            box-sizing: border-box;
        }
        button{
            background-color: #265073;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        button:hover{
            opacity: 0.8;
        }
    </style>
</body>
</html>
