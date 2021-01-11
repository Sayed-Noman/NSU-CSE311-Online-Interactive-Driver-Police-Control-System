<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }
    /*--------Getting Email From Session--------*/
    $sessionEmail=$_SESSION['ADMIN_LOGIN'];
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

    //Retreving Data from admin table if user is a Admin
    if($userType == 'Admin'){
        $adminDataRetrieveQuery="SELECT * FROM `admin` WHERE `Admin_Email_Fk`='$Email'";
        $queryResult=mysqli_query($dbConnect,$adminDataRetrieveQuery);
        $adminValues=mysqli_fetch_assoc($queryResult);
        //Admin information
        $Admin_Id=$adminValues['Admin_Id'];
        //$Address=$adminValues['Address'];
        $Address=isset($adminValues['Address']);
        if($Address== '' || is_null($Address))
        {
            $Address='Not set yet';
        }else 
        {   
            $Address=$adminValues['Address'];
        }
      
        //$Nationality=$adminValues['Nationality'];
        $Nationality=isset($adminValues['Nationality']);
        if( $Nationality=='' || is_null( $Nationality))
        {
            $Nationality='Not set yet';
        }else 
        {   
            $Nationality=$adminValues['Nationality'];
        }
                 
    }

    

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_profile_css.css">
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
    <title>Admin Profile Page</title>
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
                 
                    <a href="../admin/admin_php/admin_logout_php.php"><button type="submit">Signout</button></a>   
                </div> 
            </div>
        </div>
        <!------------------Side Admin Menu Bar--------------------------------->
        <div class="sidebar">
            <ul>
                <li><a href="admin_dashboard_home.php" >
                        <span class="icon"><i class="fas fa-house-user" aria-hidden="true"></i></span>
                        <span class="title">Home</span>
                    </a></li>
                    <li><a href="admin_profile.php"class="active-menu">
                        <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                        <span class="title">Profile</span>
                    </a></li>
                    <li><a href="admin_edit_profile.php">
                        <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                        <span class="title">Edit Profile</span>
                    </a></li>
                    <li><a href="admin_edit_driver.php">
                        <span class="icon"><i class="far fa-edit" aria-hidden="true"></i></span>
                        <span class="title">Edit Driver</span>
                    </a></li>
                    <li><a href="admin_edit_profile.php">
                        <span class="icon"><i class="fas fa-edit" aria-hidden="true"></i></span>
                        <span class="title">Edit Police</span>
                    </a></li>
                    <li><a href="admin_add_traffic_rules.php">
                        <span class="icon"><i class="fas fa-edit" aria-hidden="true"></i></span>
                        <span class="title">Traffic Rule</span>
                    </a></li>
                    <li><a href="admin_request_accept.php">
                        <span class="icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                        <span class="title">Requests</span>
                    </a></li>
                   
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
            <div class="item profile-box">
               <div class="box">  
                    <div class="tab-box">
                        
                        <button class="tab-links active" id="defaultOpen" onclick="openInfoTab(event,'tab-one-content-box')"><i class="fas fa-id-card" aria-hidden="true"></i><span>Profile</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-two-content-box')"><i class="fas fa-id-badge" aria-hidden="true"></i><span>Admin</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-three-content-box')"><i class="fas fa-car" aria-hidden="true"></i><span>Emergency</span></button>


                </div>       
              
                   <div class="content">
                       <div id="tab-one-content-box"  class="tab-content">
                        <div class="resume">
                            <div class="resume_left">
                              <?php 
                            if($userType == 'Admin'){
                                $Admin_Profile_Picture=isset($adminValues['Admin_Profile_Picture']);
                                if( $Admin_Profile_Picture=='' || is_null($Admin_Profile_Picture))
                                {
                                    echo'<div class="resume_profile">';
                                    $profiler_Picture_Url="../admin/admin_img/profile.png";
                                    echo '<img src="'.$profiler_Picture_Url.'" class="photo" alt="Profile Picture">';
                                    echo'</div>';
                                }else{
                                    echo '<div class="resume_profile_fix">';
                                    echo "<img  src='admin_img/admin_profile_picture_server/".$adminValues['Admin_Profile_Picture']."'/>";  
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
                                    <?php echo'<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Nid_Image']).'"/> ';?>
                                  </div>   
                            </div>
                        </div>
                       </div>
                       </div>
                       </div>
                       
                       <div id="tab-two-content-box" class="tab-content">
                        <h3>
                            <p class="bold">Admin ID: <?= $Admin_Id?> </p>
                            
                        </h3>
                        
                       </div>
                        

                       
                       

                       <div id="tab-three-content-box" class="tab-content">
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