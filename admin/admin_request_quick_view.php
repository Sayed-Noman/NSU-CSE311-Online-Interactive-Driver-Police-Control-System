<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }

    if(isset($_GET['requestQuickView'])){
        $Email=base64_decode($_GET['requestQuickView']);
        $query="SELECT * FROM `request` WHERE `Email`='$Email'";
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



    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Request Quick View Page</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="admin_css/admin_request_quick_view_css.css">
</head>
<body>
   
<div id="page">
    <div class="photo-and-name">
        <img src="admin_img/profile.png" class="photo" alt="Profile Picture">
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
            <?php
                if($userType == 'Driver'){
                    echo "<tr>";
                    echo "<td>Driving License No:</td>";
                    echo "<td><b>$Driving_License_No</b></td>";
                    echo "</tr>";
                }
                if($userType == 'Police'){
                    echo "<tr>";
                    echo "<td>Badge Id:</td>";
                    echo "<td><b>$Badge_Id</b></td>";
                    echo "</tr>";
                }
            ?>
            <tr>
                <td>Join Date:</td>
                <td><b><?=$Join_Date?></b></td>
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
            if($userType == 'Driver'){
                echo '<tr class="work-2">';
                echo "<td>D'License Image:</td>";
                echo '<td><img src="data:image/jpeg;base64,'.base64_encode($rowValues['Driving_License_Image']).'" height="250" width="500"/></td>';
                 echo "</tr>";
                    
                }
            

            if($userType == 'Police'){
                echo '<tr class="work-2">';
                echo "<td>Badge Image</td>";
                echo '<td><img src="data:image/jpeg;base64,'.base64_encode($rowValues['Driving_License_Image']).'" height="250" width="500"/></td>';
                 echo "</tr>";
                    
                }
            ?>
            
            
 
        </table>
    </div>
    

</body>
</html>
