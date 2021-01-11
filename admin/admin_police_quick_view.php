<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }

    if(isset($_GET['policeQuickView'])){
        $Email=base64_decode($_GET['policeQuickView']);
        //Retreving Data from account table
        $query="SELECT * FROM `account` WHERE `Email`='$Email'";
        $queryResult=mysqli_query($dbConnect,$query);
        $rowValues=mysqli_fetch_assoc($queryResult);
        //detecting usertype
        $userType=$rowValues['User_Type'];
        //print_r($userType);
        //other information
        $First_Name=$rowValues['First_Name'];
        $Last_Name=$rowValues['Last_Name'];
        $Email=$rowValues['Email'];
        $Pincode=$rowValues['Pincode'];
        $Gender=$rowValues['Gender'];
        $Birth_Date=$rowValues['Birth_Date'];
        $Phone_Number=$rowValues['Phone_Number'];
        $Nid=$rowValues['Nid'];
        $Driving_License_No=$rowValues['Driving_License_No'];
        $Badge_Id=$rowValues['Badge_Id'];
        $Join_Date=$rowValues['Join_Date'];

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

        //Retreving Data from police table if user is a police
        if($userType == 'Police'){
            $policeDataRetrieveQuery="SELECT * FROM `police` WHERE `Police_Email_Fk`='$Email'";
            $queryResult=mysqli_query($dbConnect,$policeDataRetrieveQuery);
            $policeValues=mysqli_fetch_assoc($queryResult);
            //Driver information
            $Police_Id=$policeValues['Police_Id'];

            //$Address=$policeValues['Address'];
            $Address=isset($policeValues['Address']);
            if($Address== '' || is_null($Address))
            {
                $Address='Not set yet';
            }else 
            {   
                $Address=$policeValues['Address'];
            }
          
            //$Nationality=$policeValues['Nationality'];
            $Nationality=isset($policeValues['Nationality']);
            if( $Nationality=='' || is_null( $Nationality))
            {
                $Nationality='Not set yet';
            }else 
            {   
                $Nationality=$policeValues['Nationality'];
            }
           
    
            //$Police_Department=$policeValues['Police_Department'];
            $Police_Department=isset($policeValues['Police_Department']);
            if( $Police_Department=='' || is_null( $Police_Department))
            {
                $Police_Department='Not set yet';
            }else 
            {   
                $Police_Department=$policeValues['Police_Department'];
            }
            //$Position=$policeValues['Position'];
            $Position=isset($policeValues['Position']);
            if( $Position=='' || is_null( $Position))
            {
                $Position='Not set yet';
            }else 
            {   
                $Position=$policeValues['Position'];
            }
            //$Region_Of_Work=$policeValues['Region_Of_Work'];
            $Region_Of_Work=isset($policeValues['Region_Of_Work']);
            if( $Region_Of_Work=='' || is_null( $Region_Of_Work))
            {
                $Region_Of_Work='Not set yet';
            }else 
            {   
                $Region_Of_Work=$policeValues['Region_Of_Work'];
            }
            //$No_Of_Cases_Filled=$policeValues['No_Of_Cases_Filled'];
            $No_Of_Cases_Filled=isset($policeValues['No_Of_Cases_Filled']);
            if( $No_Of_Cases_Filled=='' || is_null( $No_Of_Cases_Filled))
            {
                $No_Of_Cases_Filled=0;
            }else 
            {   
                $No_Of_Cases_Filled=$policeValues['No_Of_Cases_Filled'];
            }
            
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Police Quick View Page</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="admin_css/admin_request_quick_view_css.css">
</head>
<body>
   
<div id="page">
    <div class="photo-and-name">
    <?php
            if($userType == 'Police'){
                $Police_Profile_Picture=isset($policeValues['Police_Profile_picture']);
                if( $Police_Profile_Picture=='' || is_null($Police_Profile_Picture))
                {
                    $profiler_Picture_Url="../admin/admin_img/profile.png";
                    echo '<img src="'.$profiler_Picture_Url.'" class="photo" alt="Profile Picture">';
                }else 
                { 
                    echo "<img class='photo' src='../police/police_img/police_profile_picture_server/".$policeValues['Police_Profile_picture']."'/>";  
                    
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
        <h3>User Information</h3>
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
        if($userType == 'Police'){
            echo "<h3>Police Information</h3>";
        }
    ?>
    <!--------------Table Start for Driver/Police/Admin Information----------------->
       
        <table>
            <!-------------Driver/Poile/Admin-Id----------->
            <?php
                
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>Police Id:</td>";
                    echo "<td><b>$Police_Id</b></td>";
                    echo"</tr>";
                }
            ?>
            <!-----------------Driving License/Badge Id------------->
            <?php
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>Badge Id:</td>";
                    echo "<td><b>$Badge_Id</b></td>";
                    echo"</tr>";
                }
            ?>
            <!----------------Driver License Type/Police Department------------->
            <?php
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>Police Department:</td>";
                    echo "<td><b>$Police_Department</b></td>";
                    echo"</tr>";
                }
            ?>
             <!----------------Driver License Issue Date/Police Position------------->
             <?php
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>Police Position:</td>";
                    echo "<td><b>$Position</b></td>";
                    echo"</tr>";
                }
            ?>
            <!----------------Driver License Expire/Police Region of Work------------->
            <?php
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>Region of Work:</td>";
                    echo "<td><b>$Region_Of_Work</b></td>";
                    echo"</tr>";
                }
            ?>
             <!----------------Driver Point-No of cases/Police No of cases Filled/Admin------------->
             <?php
                if($userType == 'Police'){
                    echo "<tr>";
                    echo"<td>No of Cases Filled:</td>";
                    echo "<td><b>$No_Of_Cases_Filled</b></td>";
                    echo"</tr>";
                }
            ?>
        </table>
    </div>
    <div id="bio-data">
        <h3>Emergency Information</h3>
        <table>
            <tr>
                <td>Dependent Name:</td>
                <td><b><?=ucwords($emergency_Dependent_Name)?></b></td>
            </tr>
            <tr>
                <td>Dependent Relation:</td>
                <td><b><?=ucwords($emergency_Dependent_Relation)?></b></td>
            </tr>
            <tr>
                <td>Emergency Contact No:</td>
                <td><b><?= $emergency_Phone_Number ?></b></td>
            </tr>
            <tr>
                <td>Contact Address:</td>
                <td><b><?=$emergency_Address?></b></td>
            </tr>
            
        </table>
    </div>
    <div id="work">
        <h3>Validation Documents</h3>
        <table>
            <tr class="work-1">
                <td>Nid Image:</td>
                <td> <?php  echo '<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Nid_Image']).'" height="250" width="500"/>' ?></td>

            </tr>
            <?php
            if($userType == 'Police'){
                echo '<tr class="work-2">';
                echo "<td>Badge Image</td>";
                echo '<td><img src="data:image/jpeg;base64,'.base64_encode($rowValues['Badge_Image']).'" height="250" width="500"/></td>';
                 echo "</tr>";              
                }
            ?>
            
            
            
 
        </table>
    </div>
    

</body>
</html>
