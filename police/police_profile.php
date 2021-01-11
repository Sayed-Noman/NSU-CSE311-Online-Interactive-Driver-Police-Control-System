<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['POLICE_LOGIN'])){
        header('location:police_login.php');
    }
    /*--------Getting Email From Session--------*/
    $sessionEmail=$_SESSION['POLICE_LOGIN'];
    $Email=$sessionEmail;

    //police Information
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
            $Nationality='Not set yet';
        }else 
        {   
            $Police_Department=$policeValues['Police_Department'];
        }
        //$Position=$policeValues['Position'];
        $Position=isset($policeValues['Position']);
        if( $Police_Department=='' || is_null( $Position))
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

    

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Police Profile Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="police_css/police_profile_css.css">
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
                   
                    <a href="../police/police_php/police_logout_php.php"><button type="submit">Signout</button></a>    
                </div> 
            </div>
        </div>
        <!------------------Side Admin Menu Bar--------------------------------->
        <div class="sidebar">
            <ul>
                <li><a href="police_dashboard_home.php" >
                    <span class="icon"><i class="fas fa-house-user" aria-hidden="true"></i></span>
                    <span class="title">Home</span>
                </a></li>
                <li><a href="police_profile.php" class="active-menu">
                    <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                    <span class="title">Profile</span>
                </a></li>
                <li><a href="police_edit_profile.php">
                    <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Profile</span>
                </a></li>
                <li><a href="police_case_lssue.php">
                    <span class="icon"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                    <span class="title">Case Issue</span>
                </a></li>
                
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
            <div class="item profile-box">
               <div class="box">  
                    <div class="tab-box">
                        
                        <button class="tab-links active" id="defaultOpen" onclick="openInfoTab(event,'tab-one-content-box')"><i class="fas fa-id-card" aria-hidden="true"></i><span>Profile</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-two-content-box')"><i class="fas fa-id-badge" aria-hidden="true"></i><span>Police</span></button>
                    
                        <button class="tab-links" onclick="openInfoTab(event,'tab-three-content-box')"><i class="fas fa-car" aria-hidden="true"></i><span>Emergency</span></button>


                </div>       
              
                   <div class="content">
                       <div id="tab-one-content-box"  class="tab-content">
                        <div class="resume">
                            <div class="resume_left">
                              <?php 
                            if($userType == 'Police'){
                                $Police_Profile_Picture=isset($policeValues['Police_Profile_picture']);
                                if( $Police_Profile_Picture=='' || is_null($Police_Profile_Picture))
                                {
                                    echo'<div class="resume_profile">';
                                    $profiler_Picture_Url="../admin/admin_img/profile.png";
                                    echo '<img src="'.$profiler_Picture_Url.'" class="photo" alt="Profile Picture">';
                                    echo'</div>';
                                }else{
                                    echo '<div class="resume_profile_fix">';
                                    echo "<img class='photo' src='../police/police_img/police_profile_picture_server/".$policeValues['Police_Profile_picture']."'/>";  
                                    echo '</div>';
                                }

                            } 

                        
                        ?>
                                <h3> 
                                    <p>Name:<?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></p>  
                                    <p>Gender: <?= $Gender?> </p>   
                                    <p>Birth Date:<?= date('d-M-Y',strtotime($rowValues['Birth_Date']))?></p>  
                                    <p>Email: <?= ucwords($Email)?> </p>
                                    <p>Phone Number: <?= $Phone_Number?> </p>
                                    <p>Nationality:<?= ucwords($Nationality)?> </p>
                                    <p>Address:<?= ucwords($Address)?> </p>
                                    <p>Join Date:<?= ucwords($Join_Date)?> </p>
                                    <p>NID No: <?= ucwords($Nid)?></p>
                                    <p>NID Image:</p>
                                </h3>
                              <div class="resume2">
                                <div class="resume_left2">
                                  <div class="resume_profile2_nid">
                                  <?= '<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Nid_Image']).'" /> '?>
                                  </div>   
                            </div>
                        </div>
                       </div>
                       </div>
                       </div>
                       
                       <div id="tab-two-content-box" class="tab-content">
                        <h3>
                            <p>Police Id: <?= $Police_Id?> </p>   
                            <p>Badge Id:<?= $Badge_Id?></p>  
                            <p>Department: <?= ucwords($Police_Department)?> </p>
                            <p>Position: <?= $Position?> </p>
                            <p>Region of Work:<?= ucwords($Region_Of_Work)?> </p>
                            <p>No of Cases Filled:<?= $No_Of_Cases_Filled?> </p>
                            <p>Badge Image:</p>
                            
                        </h3>
                        <div class="resume2">
                                <div class="resume_left2">
                                  <div class="resume_profile2_badge">
                                  <?= '<img src="data:image/jpeg;base64,'.base64_encode($rowValues['Badge_Image']).'" height="250" width="500"/> '?>
                                  </div>   
                            </div>
                        </div>
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