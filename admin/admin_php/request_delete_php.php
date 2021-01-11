<?php
    require_once'../../php/dbConnect.php';
    if(isset($_GET['requestDelete'])){
        $Email=base64_decode($_GET['requestDelete']);
        $query="DELETE FROM `request` WHERE `Email`='$Email'";
        $queryResult=mysqli_query($dbConnect,$query);
         header('location:../admin_request_accept.php');

    }


?>