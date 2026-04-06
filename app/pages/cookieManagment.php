<?php
    session_start();
    setcookie("sessionID", "forzabari", time()+5, "/");
    header("Location: ../index.php");
?>