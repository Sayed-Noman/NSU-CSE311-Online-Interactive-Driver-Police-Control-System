<?php
    require_once'../../php/dbConnect.php';
    if(isset($_GET['deleteTrafficRule'])){
        $Rule_Id=base64_decode($_GET['deleteTrafficRule']);
        $query="DELETE FROM `trafficRule` WHERE `Rule_Id`='$Rule_Id'";
        $queryResult=mysqli_query($dbConnect,$query);
         header('location:../admin_add_traffic_rules.php');

    }


?>