<?php
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_login.php');
    }
    require_once'../php/dbConnect.php';
    if(isset($_GET['driverQuickView'])){
        $Email=base64_decode($_GET['driverQuickView']);
       //Retreving Data from account table
       $query="SELECT * FROM `account` WHERE `Email`='$Email'";
       $queryResult=mysqli_query($dbConnect,$query);
       $rowValues=mysqli_fetch_assoc($queryResult);
        //detecting usertype
        $userType=$rowValues['User_Type'];
        //other information
        $First_Name=$rowValues['First_Name'];
        $Last_Name=$rowValues['Last_Name'];
        $Email=$rowValues['Email'];
        $Gender=$rowValues['Gender'];
        $Birth_Date=$rowValues['Birth_Date'];
        $Phone_Number=$rowValues['Phone_Number'];
        $Nid=$rowValues['Nid'];
        $Driving_License_No=$rowValues['Driving_License_No'];
        $Join_Date=$rowValues['Join_Date'];
        //Retreving Data from driver table if user is a Driver
        if($userType == 'Driver'){
            $driverDataRetrieveQuery="SELECT * FROM `driver` WHERE `Driver_Email_Fk`='$Email'";
            $queryResult=mysqli_query($dbConnect,$driverDataRetrieveQuery);
            $driverValues=mysqli_fetch_assoc($queryResult);
            //Driver information
            $Driver_Id=$driverValues['Driver_Id'];
            //$Address=$driverValues['Address'];
            $Address=isset($driverValues['Address']);
            if($Address== '' || is_null($Address))
            {
                $Address='Not set yet';
            }else 
            {   
                $Address=$driverValues['Address'];
            }
          
            //$Nationality=$driverValues['Nationality'];
            $Nationality=isset($driverValues['Nationality']);
            if( $Nationality=='' || is_null( $Nationality))
            {
                $Nationality='Not set yet';
            }else 
            {   
                $Nationality=$driverValues['Nationality'];
            }
            //$License_Type=$driverValues['License_Type'];
            $License_Type=isset($driverValues['License_Type']);
            if($License_Type=='' || is_null($License_Type))
            {
                $License_Type='Not set yet';
            }else 
            {   
                $License_Type=$driverValues['License_Type'];
            }
            //$License_Issue_Date=$driverValues['License_Issue_Date'];
            $License_Issue_Date=isset($driverValues['License_Issue_Date']);
            if( $License_Issue_Date=='' || is_null( $License_Issue_Date))
            {
                $License_Issue_Date='Not set yet';
            }else 
            {   
                $License_Issue_Date=$driverValues['License_Issue_Date'];
            }

            //$License_Expire_Date=$driverValues['License_Expire_Date'];
            $License_Expire_Date=isset($driverValues['License_Expire_Date']);
            if(  $License_Expire_Date=='' || is_null( $License_Expire_Date))
            {
                $License_Expire_Date='Not set yet';
            }else 
            {   
                $License_Expire_Date=$driverValues['License_Expire_Date'];
            }
            $Point=$driverValues['Point'];

            //$No_Of_Cases=$driverValues['No_Of_Cases'];
            $No_Of_Cases=intVal(isset($driverValues['No_Of_Cases']));
            if($No_Of_Cases=='' || is_null($No_Of_Cases))
            {
                $No_Of_Cases=(int)0;
            }else 
            {   
                $No_Of_Cases=intVal($driverValues['No_Of_Cases']);
            }
        
            //Driver car information
            $driverCarDataRetrieveQuery="SELECT * FROM `car` WHERE `Driver_Email_Fk`='$Email'";
            $queryResult=mysqli_query($dbConnect,$driverCarDataRetrieveQuery);
            $carValues=mysqli_fetch_assoc($queryResult);
            //car info

            //$No_Plate=$carValues['No_Plate'];
            $No_Plate=isset($carValues['No_Plate']);
            if($No_Plate == '' || is_null($No_Plate))
            {
                $No_Plate='Not set yet';
            }else 
            {
                $No_Plate=$carValues['No_Plate'];
            }
            
            //$Car_Model=$carValues['Car_Model'];
            $Car_Model=isset($carValues['Car_Model']);
            if($Car_Model== '' || is_null($Car_Model))
            {
                $Car_Model='Not set yet';
            }else 
            {
                $Car_Model=$carValues['Car_Model'];
            }
            
            //$Brand_Name=$carValues['Brand_Name'];
            $Brand_Name=isset($carValues['Brand_Name']);
            if($Brand_Name == '' || is_null($Brand_Name))
            {
                $Brand_Name='Not set yet';
            }else 
            {
                $Brand_Name=$carValues['Brand_Name'];
                //print_r($Brand_Name);
            }
            //$Color=$carValues['Color'];
            $Color=isset($carValues['Color']);
            if( $Color == '' || is_null( $Color))
            {
                $Color='Not set yet';
            }else 
            {
                $Color=$carValues['Color'];
            }
            //$Vechile_Type=$carValues['Vechile_Type'];
            $Vechile_Type=isset($carValues['Vechile_Type']);
            if( $Vechile_Type == '' || is_null($Vechile_Type))
            {
                $Vechile_Type='Not set yet';
            }else 
            {
                $Vechile_Type=$carValues['Vechile_Type'];
                //print_r($Vechile_Type);
            }


            //Retreving Data from emergency information table
        $emergencyInfoRetrievequery="SELECT * FROM `emegencyinformation` WHERE `User_Email_Fk`='$Email'";
        $queryResult=mysqli_query($dbConnect,$emergencyInfoRetrievequery);
        $emergencyInfoValues=mysqli_fetch_assoc($queryResult);
        //emergency info
        //$emergency_Phone_Number=$emergencyInfoValues['Phone_Number'];
        $emergency_Phone_Number=isset($emergencyInfoValues['Phone_Number']);
        if($emergency_Phone_Number == '' || is_null($emergency_Phone_Number))
        {
            $emergency_Phone_Number='Not set yet';
        }else 
        {
            $emergency_Phone_Number=$emergencyInfoValues['Phone_Number'];

        }
        //$emergency_Address=$emergencyInfoValues['Address'];
        $emergency_Address=isset($emergencyInfoValues['Address']);
       
        if( $emergency_Address== '' || is_null($emergency_Address))
        {
            $emergency_Address='Not set yet';
        }else 
        {
            $emergency_Address=$emergencyInfoValues['Address'];

        }
         
        //$emergency_Dependent_Name=$emergencyInfoValues['Dependent_Name'];
        $emergency_Dependent_Name=isset($emergencyInfoValues['Dependent_Name']);
        if( $emergency_Dependent_Name== '' || is_null($emergency_Dependent_Name))
        {
            $emergency_Dependent_Name='Not set yet';
        }else 
        {
            $emergency_Dependent_Name=$emergencyInfoValues['Dependent_Name'];

        }
        //$emergency_Dependent_Relation=$emergencyInfoValues['Dependent_Relation'];
        $emergency_Dependent_Relation=isset($emergencyInfoValues['Dependent_Relation']);
        if( $emergency_Dependent_Relation== '' || is_null($emergency_Dependent_Relation))
        {
            $emergency_Dependent_Relation='Not set yet';
        }else 
        {
            $emergency_Dependent_Relation=$emergencyInfoValues['Dependent_Relation'];

        }
            
        }



    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Quick View</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="driver_css/driver_driver_quick_view_css.css">
</head>
<body>
   
<div id="page">
    <div class="photo-and-name">
    <?php
            if($userType == 'Driver'){
                $Driver_Profile_Picture=isset($driverValues['Driver_Profile_Picture']);
                if( $Driver_Profile_Picture=='' || is_null($Driver_Profile_Picture))
                {
                    $profiler_Picture_Url="../admin/admin_img/profile.png";
                    echo '<img src="'.$profiler_Picture_Url.'" class="photo" alt="Profile Picture">';
                }else 
                { 
                    echo"<img class='photo' src='../driver/driver_img/driver_profile_picture_server/".$driverValues['Driver_Profile_Picture']."'/>"; 
                    
                }
                
            }

        ?>
        <div class="contact-info-box">
            <h1 class="name"><?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></h1>
            <br>
            <h3 class="job-title">User Type: <?= $rowValues['User_Type']?></h3>
            <p class="contact-details">Phone: +88<?= $rowValues['Phone_Number']?> &nbsp; - &nbsp;Email: <?= ucwords($rowValues['Email'])?></p>
        </div>
    </div>
    <div id="bio-data">
        <h3>Personal Information</h3>
        <table>
            <tr>
                <td>First Name:</td>
                <td><b><?=ucwords( $rowValues['First_Name'])?></b></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><b><?=ucwords( $rowValues['Last_Name'])?></b></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><b><?= date('d-M-Y',strtotime($rowValues['Birth_Date']))?><b></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><b><?= $Gender ?></b></td>
            </tr>
            <tr>
                <td>Nid:</td>
                <td><b><?= $rowValues['Nid']?></b></td>
            </tr>
            <tr>
                <td>Nationality:</td>
                <td><b><?= $Nationality?></b></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><b><?= $Address?></b></td>
            </tr>

            <tr>
                <td>Join Date:</td>
                <td><b><?=$Join_Date?></b></td>
            </tr>
            
        </table>
    </div>
    <div id="bio-data">
        <!-----Heafing------>
        <!--- <h3>Personal Information</h3> --->
    <?php
        if($userType == 'Driver'){
            echo "<h3>Driver Information</h3>";
        }
    ?>
    <!--------------Table Start for Driver/Police/Admin Information----------------->
       
        <table>
            <!-------------Driver/Poile/Admin-Id----------->
            <?php
                if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>Driver Id:</td>";
                    echo "<td><b>$Driver_Id</b></td>";
                    echo"</tr>";
                }
               
            ?>
            <!-----------------Driving License/Badge Id------------->
            <?php
                 if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>Driving License No:</td>";
                    echo "<td><b>$Driving_License_No</b></td>";
                    echo"</tr>";
                }
            ?>
            <!----------------Driver License Type/Police Department------------->
            <?php
                 if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>License Type:</td>";
                    echo "<td><b>$License_Type</b></td>";
                    echo"</tr>";
                }
            ?>
             <!----------------Driver License Issue Date/Police Position------------->
             <?php
                 if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>License Issue Date:</td>";
                    echo "<td><b>$License_Issue_Date</b></td>";
                    echo"</tr>";
                }
            ?>
            <!----------------Driver License Expire/Police Region of Work------------->
            <?php
                 if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>License Expire Date:</td>";
                    echo "<td><b>$License_Expire_Date</b></td>";
                    echo"</tr>";
                }
            ?>
             <!----------------Driver Point-No of cases/Police No of cases Filled/Admin------------->
             <?php
                 if($userType == 'Driver'){
                    echo "<tr>";
                    echo"<td>Current Point:</td>";
                    echo "<td><b>$Point/15.0</b></td>";
                    echo"</tr>";
                }
            ?>
            
        </table>
    </div>
    
</div>
    

</body>
</html>
