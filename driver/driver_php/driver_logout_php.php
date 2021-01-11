<?php
    session_start();
    session_destroy();
    header('location:../driver_login.php');
?>