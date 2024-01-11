<?php
    $hostname = "localhost";

    //Konfig MySQL
    $user_db = "root";
    $pass_db = "";
    $db_name = "db_webakademis_php";

    // Create Connection
    $conn = new mysqli($hostname, $user_db, $pass_db);

    // Check Connection
    if ($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    }
    mysqli_select_db($conn, $db_name);
?>