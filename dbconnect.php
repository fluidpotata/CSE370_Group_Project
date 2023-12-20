<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quickeats";

    $connection = new mysqli($servername, $username, $password);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
        }
    else{
        mysqli_select_db($connection, $dbname);
        // echo "Connection successful";
        }
    
?>
