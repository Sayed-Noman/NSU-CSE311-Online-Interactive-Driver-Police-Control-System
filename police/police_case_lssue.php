<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['POLICE_LOGIN'])){
        header('location:police_login.php');
    }
    //Getting Session Email for Police
    $sessionEmail=$_SESSION['POLICE_LOGIN'];
    /*----------------Query For 4 Broken Rules---------------*/
    $ruleSelectQuery1="SELECT * FROM `trafficrule` ";
    $ruleSelectQueryResult1=$dbConnect->query($ruleSelectQuery1);

    $ruleSelectQuery2="SELECT * FROM `trafficrule` ";
    $ruleSelectQueryResult2=$dbConnect->query($ruleSelectQuery2);

    $ruleSelectQuery3="SELECT * FROM `trafficrule` ";
    $ruleSelectQueryResult3=$dbConnect->query($ruleSelectQuery3);

    $ruleSelectQuery4="SELECT * FROM `trafficrule` ";
    $ruleSelectQueryResult4=$dbConnect->query($ruleSelectQuery4);

    //When Case Submit Button is Clicked
    if(isset($_POST['Case_Submit'])){  
        //Driver case Related Information 
        $Driver_Email=$_POST['Hidden_Email'];
        $Broken_Rule_Id_1=$_POST['Broken_Rule_Id_1'];
        $Broken_Rule_Id_2=$_POST['Broken_Rule_Id_2'];
        $Broken_Rule_Id_3=$_POST['Broken_Rule_Id_3'];
        $Broken_Rule_Id_4=$_POST['Broken_Rule_Id_4'];
        $Police_Massage=$_POST['Police_Massage'];
        $Issue_Date=$_POST['Issue_Date'];
        $Issue_Place=$_POST['Issue_Place'];
        print_r($Driver_Email);
      //print_r($Broken_Rule_Id_1);
     // print_r($Broken_Rule_Id_1);
     // print_r($Broken_Rule_Id_3);
     // print_r($Broken_Rule_Id_4);
       //Checking if First Rule Id is selected or not
       /*---------Selecting Driver Previous No of Case Count---------*/
       $NocaseCountQuery="SELECT * From `driver` WHERE `Driver_Email_Fk`='$Driver_Email'";
       $NocaseCountResult=mysqli_query($dbConnect,$NocaseCountQuery);
       $NocaseRow=mysqli_fetch_assoc($NocaseCountResult);
        $previous_No_Of_Cases=intVal($NocaseRow['No_Of_Cases']);
        $previous_Point=floatval($NocaseRow['Point']);
       // print_r($previous_Point);
       //print_r($previous_No_Of_Cases);

        /*---------Selecting Police Previous No of Case Count---------*/
       $policeNocaseCountQuery="SELECT * From `police` WHERE `Police_Email_Fk`='$sessionEmail'";
       $policeNocaseCountResult=mysqli_query($dbConnect,$policeNocaseCountQuery);
       $policeNocaseRow=mysqli_fetch_assoc($policeNocaseCountResult);
        $previous_No_Of_Cases_Filled=intVal($policeNocaseRow['No_Of_Cases_Filled']);
        //print_r($previous_No_Of_Cases_Filled);

       if(!empty($Broken_Rule_Id_1)){
           $query="SELECT `Deductable_Point` FROM `trafficrule` WHERE `Rule_Id`='$Broken_Rule_Id_1'";
           $result=mysqli_query($dbConnect,$query);
           $row=mysqli_fetch_assoc($result);
           //print_r($row['Deductable_Point']);
           $deductablePoint1=(float)$row['Deductable_Point'];
           
       }else{
           $deductablePoint1=intval(0);
       }
       if(!empty($Broken_Rule_Id_2)){
        $query="SELECT `Deductable_Point` FROM `trafficrule` WHERE `Rule_Id`='$Broken_Rule_Id_2'";
        $result=mysqli_query($dbConnect,$query);
        $row=mysqli_fetch_assoc($result);
        //print_r($row['Deductable_Point']);
        $deductablePoint2=(float)$row['Deductable_Point'];
        
    }else{
        $deductablePoint2=intval(0);
    }
    if(!empty($Broken_Rule_Id_3)){
        $query="SELECT `Deductable_Point` FROM `trafficrule` WHERE `Rule_Id`='$Broken_Rule_Id_3'";
        $result=mysqli_query($dbConnect,$query);
        $row=mysqli_fetch_assoc($result);
        //print_r($row['Deductable_Point']);
        $deductablePoint3=(float)$row['Deductable_Point'];
        
    }else{
        $deductablePoint3=intval(0);
    }
    if(!empty($Broken_Rule_Id_4)){
        $query="SELECT `Deductable_Point` FROM `trafficrule` WHERE `Rule_Id`='$Broken_Rule_Id_4'";
        $result=mysqli_query($dbConnect,$query);
        $row=mysqli_fetch_assoc($result);
        //print_r($row['Deductable_Point']);
        $deductablePoint4=(float)$row['Deductable_Point'];
        
    }else{
        $deductablePoint4=intval(0);
    }
       
    $TotalDeductablePoint=floatval($deductablePoint1+$deductablePoint2+$deductablePoint3+$deductablePoint4);
   // print_r($TotalDeductablePoint);
   $New_No_Of_Cases=intval($previous_No_Of_Cases +1);
   $New_No_Of_Cases_Filled=intval($previous_No_Of_Cases_Filled+1);
   $New_Point=floatval($previous_Point-$TotalDeductablePoint);
   //print_r($New_No_Of_Cases);
   //print_r($New_No_Of_Cases_Filled);
    //print_r($New_Point);
    /*----------------------Inserting Driver and Police Table infos----------------------*/
    $dbConnect->begin_transaction();
    $dbConnect->autocommit(false);
    $polieNewDataUpdateQuery="UPDATE `police` SET `No_Of_Cases_Filled`='$New_No_Of_Cases_Filled' WHERE `Police_Email_Fk`='$sessionEmail'";
    $driverNewDataUpdateQuery="UPDATE `driver` SET `Point`='$New_Point',`No_Of_Cases`='$New_No_Of_Cases' WHERE `Driver_Email_Fk`='$Driver_Email'";
    $caseIssueTableInsertQuery="INSERT INTO `caseissue`(`Issue_Date`, `Issue_Date_Time`, `Issue_Place`, `Broken_Rule_Id_1`, `Broken_Rule_Id_2`, `Broken_Rule_Id_3`, `Broken_Rule_Id_4`, `Deducted_Point`, `Police_Message`, `Driver_Email_Fk`, `Police_Email_Fk`) VALUES ('$Issue_Date',CURRENT_TIMESTAMP,'$Issue_Place','$Broken_Rule_Id_1','$Broken_Rule_Id_2','$Broken_Rule_Id_3','$Broken_Rule_Id_4','$TotalDeductablePoint','$Police_Massage','$Driver_Email','$sessionEmail')";
    $dbConnect->query($polieNewDataUpdateQuery);
    $dbConnect->query($driverNewDataUpdateQuery);
    $dbConnect->query($caseIssueTableInsertQuery);
    $dbConnect->commit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="police_css/police_case_issue_css.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!------------------Jquery Latest Cdn Script--------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!------------------Font Awesome Cdn Script--------------------------------->
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script>
        $(document).ready(function(){
            $(".hamburger").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
    </script>
    <title>Police Case Issue Page</title>
</head>
<body>
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
                    <a href="police_dashboard_home.php">First_Name</a>
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
                <li><a href="police_case_lssue.php"class="active">
                    <span class="icon"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                    <span class="title">Case Issue</span>
                </a></li>
                
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">

            <div class="item">
                <h2>Enter Email To Search Users</h2>
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

                    <div class="searchbar">
                        <input type="text" class="searchbar__input" name="Searched_Email" placeholder="Enter Email to search">
                        <button type="submit" name="Search_Button" class="searchbar__button">
                            <i class="material-icons">search</i>
                        </button>
                    </div>
              </form>
            </div>
            <!--------------Php Code to Search Driver------------->
            <?php
                //if Search Button is Clicked
                if(isset($_POST['Search_Button'])){
                  $Searched_Email=$_POST['Searched_Email'];
                  $query="SELECT `Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, account.`Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`,`Driver_Id`,driver.`Address`,`Driver_Profile_Picture`,driver.`Nationality`,`License_Type`,`License_Issue_Date`,`License_Expire_Date`,`Point`,`No_Of_Cases`,emegencyinformation.`Phone_Number` AS E_Phone_Number,emegencyinformation.`Address` AS E_Address,`Dependent_Name`,`Dependent_Relation`,`No_Plate`,`Car_Model`,`Brand_Name`,`Color`,`Vechile_Type`,`Car_Image`,`Car_Document_Image` FROM (`account` INNER JOIN `driver` ON `Email`=`Driver_Email_Fk`) INNER JOIN `emegencyinformation` ON `Driver_Email_Fk`=`User_Email_Fk` INNER JOIN `car` ON emegencyinformation.User_Email_Fk=car.`Driver_Email_Fk` WHERE `Email`='$Searched_Email'";
                  $queryResult=mysqli_query($dbConnect,$query);
                  while($rowValues=mysqli_fetch_array($queryResult)){
                    

                                  //Admin Personal Values
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
                                  $Nationality=$rowValues['Nationality'];
                                  $Address=$rowValues['Address'];
                                  //Driver Information
                                  $No_Of_Cases=intVal($rowValues['No_Of_Cases']);
                                  $Point=$rowValues['Point'];
                                  $License_Expire_Date=$rowValues['License_Expire_Date'];
                                  $License_Issue_Date=$rowValues['License_Issue_Date'];
                                  $License_Type=$rowValues['License_Type'];
                                  $Driver_Id=$rowValues['Driver_Id'];
                                  



                    //php ends ?> 
                  

                    <!------------------------------------All forms Code---------->
                           <!------------------Personal info--------------------------------->
                <div class="item">
                 <!--<h2>Personal Information</h2>---->
                 <div class="login-form__content">
                <div class="login-form__header">
                <h2>Driver Information</h2>
                </div>
                  <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>"placeholder="Enter Email">
                    <div class="sameline-inputs">   
                        <h4 style="margin-top:8px ;margin-left: 20px;">Name:</h4>
                        <input class="login-form__input" type="text" name="#Name" value="<?=ucwords( $First_Name . ' '. $Last_Name)?>"placeholder=" Full Name" readonly>
                        <h4 style="margin-top:8px ;margin-left: 50px;">Email:</h4>
                        <input class="login-form__input" type="email" name="#Email" value="<?=ucwords($Email)?>"placeholder="Enter Email" readonly>
                     </div>  
                     <div class="sameline-inputs">    
                        <h4 style="margin-top:8px;margin-left: 20px;">Driver Id:</h4>
                        <input class="login-form__input" type="text" name="#Driver_Id" value="<?= $Driver_Id?>"placeholder="Driver Id" readonly>
                        <h4 style="margin-top:8px ;margin-left: 50px;">Nid:</h4>
                        <input class="login-form__input" type="email" name="#Nid" value="<?=$Nid?>"placeholder="Enter Email" readonly>
                 </div> 
                 <div class="sameline-inputs">    
                    <h4 style="margin-top:8px;margin-left: 20px;">Point:</h4>
                    <input class="login-form__input" type="text" name="#Point" value="<?= $Point?>"placeholder="Point" readonly>
                    <h4 style="margin-top:8px ;margin-left: 50px;">#Case:</h4>
                    <input class="login-form__input" type="email" name="#Case" value="<?=$No_Of_Cases?>"placeholder="Enter Email" readonly>
                </div> 
              </div>

            </div>


            <div class="item">
                 <!--<h2>Personal Information</h2>---->
                 <div class="login-form__content">
                <div class="login-form__header">
                <h2>Case Issue Form</h2>
                </div>
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>"placeholder="Enter Email">
                <div class="sameline-inputs">   
                        <h4 style="margin-top:8px;margin-left: 20px;">Driver Id:</h4>
                        <input class="login-form__input" type="text" name="Driver_Id" value="<?= $Driver_Id?>"placeholder="Driver Id" readonly>
                        <h4 style="margin-top:8px;margin-left: 20px;">Email:</h4>
                        <input class="login-form__input" type="email" name="#Email" value="<?=ucwords($Email)?>"placeholder="Enter Email" readonly>
                    </div> 
                    <div class="sameline-inputs">   
                        <h4 style="margin-top:8px;margin-left: 20px;">Issue Place:</h4>
                        <input class="login-form__input" type="text" name="Issue_Place" placeholder="Enter Place Name" required="Issue Plaece is Required!">
                        <h4 style="margin-top:8px;margin-left: 20px;">Issue Date:</h4>
                        <input class="login-form__input" type="text" onfocus="(this.type='date')"  onblur="(this.type='text')" required="Issue Date Is Required" name="Issue_Date" placeholder="Enter Case Issue Date">
                    </div> 
                    <!------------First and Second Broken Rule Id----------------->
                    <div class="sameline-inputs">   
                        <h4 style="margin-top:8px;margin-left: 20px;">Broken Rule-1:</h4>
                        <select class="login-form__input_select"  name="Broken_Rule_Id_1" id="Broken_Rule_Id_1">
                            <option value="">Select Rule Id</option>
                            <?php
                                while($selctValues1=mysqli_fetch_array($ruleSelectQueryResult1)){
                                    $Rule_Id=$selctValues1['Rule_Id'];
                                    $Rule_Name=$selctValues1['Rule_Name'];
                                    $Deductable_Point=$selctValues1['Deductable_Point'];
                                    echo "<option value='$Rule_Id'>($Rule_Id)$Rule_Name Point=$Deductable_Point</option>";
                                    
                                } 
                            
                            ?>

                        </select>

                        <h4 style="margin-top:8px;margin-left: 20px;">Broken Rule-2:</h4>
                        <select class="login-form__input_select" name="Broken_Rule_Id_2"id="Broken_Rule_Id_2">
                            <option value="">Select Rule Id</option>
                            <?php
                                while($selctValues2=mysqli_fetch_array($ruleSelectQueryResult2)){
                                    $Rule_Id=$selctValues2['Rule_Id'];
                                    $Rule_Name=$selctValues2['Rule_Name'];
                                    $Deductable_Point=$selctValues2['Deductable_Point'];
                                    echo "<option value='$Rule_Id'>($Rule_Id)$Rule_Name Point=$Deductable_Point</option>";
                                    
                                } 
                            
                            ?>

                        </select>
                        
                       
                    </div> 
                     <!------------Second and Third Broken Rule Id----------------->
                     <div class="sameline-inputs">   
                        <h4 style="margin-top:8px;margin-left: 20px;">Broken Rule-3:</h4>
                        <select class="login-form__input_select" name="Broken_Rule_Id_3"id="Broken_Rule_Id_3">
                        <option value="">Select Rule Id</option>
                            <?php
                                while($selctValues3=mysqli_fetch_array($ruleSelectQueryResult3)){
                                    $Rule_Id=$selctValues3['Rule_Id'];
                                    $Rule_Name=$selctValues3['Rule_Name'];
                                    $Deductable_Point=$selctValues3['Deductable_Point'];
                                    echo "<option value='$Rule_Id'>($Rule_Id)$Rule_Name Point=$Deductable_Point</option>";
                                    
                                } 
                            
                            ?>

                        </select>
                        <h4 style="margin-top:8px;margin-left: 20px;">Broken Rule-4:</h4>
                        <select class="login-form__input_select" name="Broken_Rule_Id_4" id="Broken_Rule_Id_4">
                            <option value="">Select Rule Id</option>
                            <?php
                                while($selctValues4=mysqli_fetch_array($ruleSelectQueryResult4)){
                                    $Rule_Id=$selctValues4['Rule_Id'];
                                    $Rule_Name=$selctValues4['Rule_Name'];
                                    $Deductable_Point=$selctValues4['Deductable_Point'];
                                    echo "<option value='$Rule_Id'>($Rule_Id)$Rule_Name Point=$Deductable_Point</option>";
                                    
                                } 
                            
                            ?>

                        </select>
                        
                       
                    </div> 
                    <br>
                    <center>
                    <h4 style="margin-top:8px;margin-left: 20px;">Massage:</h4>
                    <textarea class="login-form__input_rule_massage" type="text"  name="Police_Massage" placeholder="Enter Massage For Driver">Enter Massage For Driver</textarea>
                    </br><br>
                        
                            <button class="login-form__button2" name="Case_Submit" type="submit" onclick="return confirm('CONFIRM TO SUBMIT CASE')">Submit</button>
                        </center>
                     </form>
              </div>

            </div>
          
         
         


          





<!-----------------------------------------All Forms code End--------------------->
                    <?php //php starts
                  }


                }//search button If ends


            ?>
           
        </div><!--------main container ends----->
    </div>
</body>
</html>


