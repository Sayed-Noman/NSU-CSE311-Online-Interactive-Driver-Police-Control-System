<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_login.php');
    }
    /*--------Getting Email From Session--------*/
    $sessionEmail=$_SESSION['DRIVER_LOGIN'];
    $Email=$sessionEmail;

    //Driver Information
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
        $Point=floatVal($driverValues['Point']);

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
        
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_css/driver_profile_css.css">
    <!------------------Jquery Latest Cdn Script--------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!------------------Font Awesome Cdn Script--------------------------------->
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet"> 
    <!------------------Jquery Cdn Script---------------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".hamburger").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
    </script>
    <!-----------Tab Menu Scripts:To open Tab when its clicked-------------->
    <script type="text/javascript">
        function openInfoTab(eventName,tabName){
            /*Declaring Variables*/
            var index,tabLinks,tabContent;
            /*Getting all the elemts with class "tabConten" and hidig them*/
            tabContent=document.getElementsByClassName("tab-content");
            for(index=0;index<tabContent.length;index++){
                tabContent[index].style.display="none";
            }
            //Getting all the element with class"tabLinks" and remove the class active
            tabLinks=document.getElementsByClassName("tab-links");
            for(index=0;index<tabLinks.length;index++){
                tabLinks[index].className=tabLinks[index].className.replace(" active", "");
            }
            //show thee current tab and add an "active" class the button that open the tab so that it becomes the active tab
            document.getElementById(tabName).style.display="block";
            eventName.currentTarget.className +=" active";
        }
        //document.getElementById("defaultOpen").click();
    </script>
    <title>Driver Profile Page</title>
</head>
<!---opening First tab as Default While loading the page------->
<body onload="document.getElementById('defaultOpen').click();">
    <div class="wrapper">
        <!------------------NavigationBar--------------------------------->
        <div class="top_navbar">
            <div class="hamburger">
                <div class="side-menu-div"></div>
                <div class="side-menu-div"></div>
                <div class="side-menu-div"></div>
                
            </div>
            <div class="top_menu">
                <div class="logo">Driver-Police Control System</div>
                <ul>
                    
                </ul>
                <div class="buttons">
                    
                    <a href="../driver/driver_php/driver_logout_php.php"><button type="submit">Signout</button></a> 
                </div> 
            </div>
        </div>
        <!------------------Side Admin Menu Bar--------------------------------->
        <div class="sidebar">
            <ul>
                <li><a href="driver_dashboard_home.php" >
                    <span class="icon"><i class="fas fa-house-user" aria-hidden="true"></i></span>
                    <span class="title">Home</span>
                </a></li>
                <li><a href="driver_profile.php" class="active-menu">
                    <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                    <span class="title">Profile</span>
                </a></li>
                <li><a href="driver_edit_profile.php">
                    <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Profile</span>
                </a></li>
                <li><a href="driver_case_log.php">
                    <span class="icon"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                    <span class="title">Case Log</span>
                </a></li>
                
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
            <div class="item profile-box">
               <div class="box">  
                    <div class="tab-box">
                        
                        <button class="tab-links active" id="defaultOpen" onclick="openInfoTab(event,'tab-one-content-box')"><i class="fas fa-id-card" aria-hidden="true"></i><span>Profile</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-two-content-box')"><i class="fas fa-id-badge" aria-hidden="true"></i><span>License</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-three-content-box')"><i class="fas fa-car" aria-hidden="true"></i><span>Car</span></button>

                        <button class="tab-links" onclick="openInfoTab(event,'tab-four-content-box')"><i class="fas fa-car" aria-hidden="true"></i><span>Emergency</span></button>

                </div>       
              
                   <div class="content">
                       <div id="tab-one-content-box"  class="tab-content">
                        <div class="resume">
                            <div class="resume_left">
                              <?php 
                            if($userType == 'Driver'){
                                $Driver_Profile_Picture=isset($driverValues['Driver_Profile_Picture']);
                                if( $Driver_Profile_Picture=='' || is_null($Driver_Profile_Picture))
                                {
                                    echo'<div class="resume_profile">';
                                    $profiler_Picture_Url="../admin/admin_img/profile.png";
                                    echo '<img src="'.$profiler_Picture_Url.'" class="photo" alt="Profile Picture">';
                                    echo'</div>';
                                }else{
                                    echo '<div class="resume_profile_fix">';
                                    echo"<img class='photo' src='../driver/driver_img/driver_profile_picture_server/".$driverValues['Driver_Profile_Picture']."'/>"; 
                                    echo '</div>';
                                }

                                } 

                        
                        ?>
                                <h3> 
                                    <p>Name:<?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></p>  
                                    <p>Email: <?= ucwords($Email)?> </p>
                                    <p>Gender: <?= $Gender?> </p>   
                                    <p>Birth Date:<?= date('d-M-Y',strtotime($rowValues['Birth_Date']))?></p>  
                                    <p>Phone Number: <?= $Phone_Number?> </p>
                                    <p>Nationality:<?= ucwords($Nationality)?> </p>
                                    <p>Address:<?= ucwords($Address)?> </p>
                                    <p>Join Date:<?= ucwords($Join_Date)?> </p>
                                    <p>Nid No: <?= ucwords($Nid)?></p>
                                    <p>Nid Image:</p>
                                </h3>
                              <div class="resume2">
                                <div class="resume_left2">
                                  <div class="resume_profile2_nid">
                                  <?= '<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Nid_Image']).'" /> ';?>
                                  </div>   
                            </div>
                        </div>
                       </div>
                       </div>
                       </div>
                       
                       <div id="tab-two-content-box" class="tab-content">
                        <h3>
                            <p class="bold">Driver_ID: <?= $Driver_Id?> </p>
                            <p class="bold">Driving_License_NO:<?= $Driving_License_No?></p>
                            <p class="bold">LicenseType: <?= $License_Type?> </p>
                            <p class="bold">License Issue Date: <?= $License_Issue_Date?> </p>
                            <p class="bold">License Expire Date: <?= $License_Expire_Date?> </p>
                            <p class="bold">Point: <?= $Point?> </p>
                            <p class="bold">No of Case: <?= $No_Of_Cases?> </p>
                            <p class="bold">Driving License Image: </p> 
                        </h3>
                        <div class="resume3">
                            <div class="resume_left3">
                              <div class="resume_profile3_driverLicense">
                              <?= '<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Driving_License_Image']).'" /> ' ;?>
                              </div>
                              </div>
                        </div>
                       </div>
                        

                       
                       <div id="tab-three-content-box" class="tab-content">
                        <h3><p>No_Plate:<?= ucwords($No_Plate)?></p>
                        <p>Car Model: <?= ucwords($Car_Model)?></p>
                        <p>Brand Name: <?= ucwords($Brand_Name)?> </p>
                        <p>Color: <?= ucwords($Color)?></p>
                        <p>Vechile Type: <?=ucwords($Vechile_Type)?></p>
                        <p>Car Image:</p></h3>
                        <?php 
                            if($userType == 'Driver'){
                                $Car_Image=isset($carValues['Car_Image']);
                                if( $Car_Image=='' || is_null($Car_Image))
                                {
                                    $Car_Image='Not Set Yet';
                                    echo "$Car_Image";
                                }else{
                                    echo '<div class="resume5">';
                                    echo '<div class="resume_left5">';
                                    echo '<div class="resume_profile5_carImage">';
                                    echo '<img src="../driver/driver_img/driver_car_picture_server/'.$carValues['Car_Image'].'"/>';
                                    echo '</div>';   
                                   echo' </div>';
                                    echo'</div>';
                                }

                                } 

                        
                        ?>
                        <h3><p>Car Document Image:</p></h3>
                        <?php 
                            if($userType == 'Driver'){
                                $Car_Document_Image=isset($carValues['Car_Document_Image']);
                                if( $Car_Document_Image=='' || is_null($Car_Document_Image))
                                {
                                    $Car_Document_Image='Not Set Yet';
                                    echo "$Car_Document_Image";
                                }else{
                                    echo '<div class="resume5">';
                                    echo '<div class="resume_left5">';
                                    echo '<div class="resume_profile5_carDocument">';
                                    echo '<img src="../driver/driver_img/driver_car_document_picture_server/'.$carValues['Car_Document_Image'].'" />';                                    echo '</div>';   
                                   echo' </div>';
                                    echo'</div>';
                                }

                                } 

                        
                        ?>
                        
                       </div>

                       <div id="tab-four-content-box" class="tab-content">
                        <h3>
                            <p class="bold">Dependent Name: <?=$emergency_Dependent_Name?> </p>
                            <p class="bold">Dependend Relation: <?=$emergency_Dependent_Relation?></p>
                            <p class="bold">E'Contact No:<?=$emergency_Phone_Number?> </p>
                            <p class="bold">Contact Address: <?=$emergency_Address?></p> 
                        </h3>
                        </div>
                       </div>



            </div> <!-----container-->
                   </div>
               </div>
            </div>
            
            
        </div>
    </div>
</body>
</html>