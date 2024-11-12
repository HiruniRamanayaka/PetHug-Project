<?php
    $server = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $database = "pethugnew";

    $conn = mysqli_connect($server, $dbusername, $dbpassword, $database);

    if($conn==false){
        die("Error in connection to the database : ".mysqli_connect_error());
    }
?>