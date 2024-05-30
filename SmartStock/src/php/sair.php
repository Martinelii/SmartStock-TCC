<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../../00.Login/index.php");
    exit();
?>