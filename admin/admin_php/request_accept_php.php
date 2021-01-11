<?php
    require_once'../../php/dbConnect.php';
    if(isset($_GET['requestAccept'])){
        //fuction to generate Unique id
    function generateUniqeId($prefix){
        $year=date('y');
        $month=date('m');
        $date=date('d');
        $randValue= sprintf("%04d", rand(0,9999));
        $uniqeId=$prefix . '-' . $year . $month . $date .'-'. $randValue;

        return $uniqeId;
    }


        $Email=base64_decode($_GET['requestAccept']);
        try{
            //Transaction for Accepting request and deleting Record from Request From request tabe at same time
            $dbConnect->begin_transaction();
            $insertQuery="INSERT INTO `account` SELECT * FROM `request` WHERE`Email`= '$Email'";
            $deleteQuery="DELETE FROM `request` WHERE `Email`= '$Email'";
        
            $userTypeQuery="SELECT * FROM `request` WHERE `Email`='$Email'";

           

            //Determinig the usertype of the accepted Email
            $userTypeQueryResult=$dbConnect->query($userTypeQuery);
            $rowValues=mysqli_fetch_assoc($userTypeQueryResult);
            $userType=$rowValues['User_Type'];
            //print_r($userType);

             //inserting and deleteing at same time
             $dbConnect->query($insertQuery);
             $dbConnect->query($deleteQuery);

            
            //If UserType =Driver
            if($userType == 'Driver'){
                //profile picture server target path
               // $profile_picture_target_path="admin/admin_img/admin_profile_picture_server".basename($_FILES(['image']['name']));
                

                //variabes
                $prefix="D";
                $Driver_Id;
                $count;
                
                do{
                    $Driver_Id=generateUniqeId($prefix);
                    //print_r($Driver_Id);
                    $query="SELECT COUNT(*) AS `idCount` FROM `driver` WHERE `Driver_Id`='$Driver_Id'";
                    $queryResult=$dbConnect->query($query);
                    $numRows=mysqli_fetch_array($queryResult);
                    $count=$numRows['idCount'];
                    //print_r($count);
                }while($count!=0);
                
                //print_r($Driver_Id);
                //default image name for car Image and Car Document Image
                $Car_Image='default_image.jpg';
                $Car_Document_Image='default_image.jpg';
                $Driver_Profile_Picture='default_profile_picture.png';

                $driverTableInsertQuery="INSERT INTO `driver`(`Driver_Id`, `Address`, `Driver_Profile_Picture`, `Nationality`, `License_Type`, `License_Issue_Date`, `License_Expire_Date`, `Point`, `No_Of_Cases`, `Driver_Email_Fk`) VALUES ('$Driver_Id',NULL,'$Driver_Profile_Picture',NULL,NULL,NULL,NULL,15,0,(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
                $carTableInsertQuery="INSERT INTO `car`(`No_Plate`, `Car_Model`, `Brand_Name`, `Color`, `Vechile_Type`, `Car_Image`, `Car_Document_Image`, `Driver_Email_Fk`) VALUES (NULL,NULL,NULL,NULL,NULL,'$Car_Image','$Car_Document_Image',(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
                $emergencyInfoTableInsertQuery="INSERT INTO `emegencyinformation`(`Phone_Number`, `Address`, `Dependent_Name`, `Dependent_Relation`, `User_Email_Fk`) VALUES (NULL,NULL,NULL,NULL,(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
                $dbConnect->query($driverTableInsertQuery);
                $dbConnect->query($carTableInsertQuery);
                $dbConnect->query($emergencyInfoTableInsertQuery);   
                
            }

            //If UserType =Police
            if($userType == 'Police'){
                //variabes
                $prefix="P";
                $Police_Id;
                $count;
                
                do{
                    $Police_Id=generateUniqeId($prefix);
                    //print_r($Driver_Id);
                    $query="SELECT COUNT(*) AS `idCount` FROM `police` WHERE `Police_Id`='$Police_Id'";
                    $queryResult=$dbConnect->query($query);
                    $numRows=mysqli_fetch_array($queryResult);
                    $count=$numRows['idCount'];
                    //print_r($count);
                }while($count!=0);

                //default image name for car Image and Car Document Image
                $Police_Profile_Picture='default_profile_picture.png';
                
                $policeTableInsertQuery="INSERT INTO `police`(`Police_Id`, `Address`, `Police_Profile_picture`, `Nationality`, `Police_Department`, `Position`, `Region_Of_Work`, `No_Of_Cases_Filled`, `Police_Email_Fk`) VALUES ('$Police_Id',NULL,'$Police_Profile_Picture',NULL,NULL,NULL,NULL,NULL,(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
                $emergencyInfoTableInsertQuery="INSERT INTO `emegencyinformation`(`Phone_Number`, `Address`, `Dependent_Name`, `Dependent_Relation`, `User_Email_Fk`) VALUES (NULL,NULL,NULL,NULL,(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
                $dbConnect->query($policeTableInsertQuery);
                $dbConnect->query($emergencyInfoTableInsertQuery);   
                
            }

           //If UserType =Police
           if($userType == 'Admin'){
            //variabes
            $prefix="A";
            $Admin_Id;
            $count;
            
            do{
                $Admin_Id=generateUniqeId($prefix);
                //print_r($Driver_Id);
                $query="SELECT COUNT(*) AS `idCount` FROM `admin` WHERE `Admin_Id`='$Admin_Id'";
                $queryResult=$dbConnect->query($query);
                $numRows=mysqli_fetch_array($queryResult);
                $count=$numRows['idCount'];
                //print_r($count);
            }while($count!=0);

            //default image name for car Image and Car Document Image
            $Admin_Profile_Picture='default_profile_picture.png';

            $adminTableInsertQuery="INSERT INTO `admin`(`Admin_Id`, `Address`, `Nationality`, `Admin_Profile_Picture`, `Admin_Email_FK`) VALUES ('$Admin_Id',NULL,NULL,'$Admin_Profile_Picture',(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
            $emergencyInfoTableInsertQuery="INSERT INTO `emegencyinformation`(`Phone_Number`, `Address`, `Dependent_Name`, `Dependent_Relation`, `User_Email_Fk`) VALUES (NULL,NULL,NULL,NULL,(SELECT `Email` FROM `account` WHERE `Email`='$Email'))";
            $dbConnect->query($adminTableInsertQuery);
            $dbConnect->query($emergencyInfoTableInsertQuery);   
            
        }
             
            //Commiting Transaction
            $dbConnect->commit();
        }catch(Exception $exception){
            echo 'Roll Back';
            $dbConnect->rollback();
        }        
            
        header('location:../admin_request_accept.php');

    }

?>