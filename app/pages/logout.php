<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    //svuoto ed elimino variabili di sessione e  la sessione stessa
?>