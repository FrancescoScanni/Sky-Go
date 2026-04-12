<?php
    $servername = "mysql_db";
    $username = "app_user";
    $password = "app_password";
    $dbname = "SkyGo";

    //Connessione creata
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connessione
    if ($conn->connect_error) {
    die("Fallito: " . $conn->connect_error);
    }
?>