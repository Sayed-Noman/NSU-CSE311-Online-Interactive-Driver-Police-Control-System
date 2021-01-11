<?php
    require_once'../../php/dbConnect.php';
    if(isset($_GET['accountDelete'])){
        $Email=base64_decode($_GET['accountDelete']);
       
            $userTypeQuery="SELECT * FROM `account` WHERE `Email`='$Email'";

            //Determinig the usertype of the accepted Email
            $userTypeQueryResult=$dbConnect->query($userTypeQuery);
            $rowValues=mysqli_fetch_assoc($userTypeQueryResult);
            $userType=$rowValues['User_Type'];
            //If user type Driver then delete that user
            if($userType=='Driver'){
                $dbConnect->autocommit(False);
                $qurey="DELETE FROM `account` WHERE `Email`='$Email'";
                $dbConnect->query($qurey);
                $dbConnect->commit();
                $dbConnect->close();
                header('location:../admin_dashboard_home.php');
            }
            //if user type is Police then delete that user
            if($userType=='Police'){
                $dbConnect->autocommit(False);
                $qurey="DELETE FROM `account` WHERE `Email`='$Email'";
                $casesDeleteQuery="DELETE FROM `caseissue` WHERE `Driver_Email_Fk`='$Email'";
                $dbConnect->query($qurey);
                $dbConnect->query($casesDeleteQuery);
                $dbConnect->commit();
                $dbConnect->close();
                header('location:../admin_dashboard_home.php');
            }
            //if user type admin then delete that user 
            if($userType=='Admin'){
                $dbConnect->autocommit(False);
                $qurey="DELETE FROM `account` WHERE `Email`='$Email'";
                $dbConnect->query($qurey);
                $dbConnect->commit();
                $dbConnect->close();
                header('location:../admin_dashboard_home.php');
            }

    }
   


?>