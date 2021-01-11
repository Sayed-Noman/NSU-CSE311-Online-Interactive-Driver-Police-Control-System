<?php
require_once '../php/dbConnect.php';
session_start();//session start
 //IF Driver has already loged in then he will be redirected to dashboard
 if(!isset($_SESSION['ADMIN_LOGIN'])){
  header('location:admin_login.php');
}


//Updating Personal Informations when submit button is clicked
if(isset($_POST['Personal_Information'])){
  $Searched_Email=$_POST['Hidden_Email'];
  $First_Name=$_POST['First_Name'];
  $Last_Name=$_POST['Last_Name'];
  $Email=$_POST['Email'];
  $Gender=$_POST['Gender'];
  $Birth_Date=$_POST['Birth_Date'];
  $Phone_Number=$_POST['Phone_Number'];
  $Nid=$_POST['Nid'];
  //$Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
  //$Driving_License_Image=addslashes(file_get_contents($_FILES['Driving_License_Image']['tmp_name']));
  $Nationality=$_POST['Nationality'];
  $Address=$_POST['Address'];
  //Personal information upadate Query
  $dbConnect->autocommit(false);
  $query="UPDATE `account` SET `First_Name`='$First_Name',`Last_Name`='$Last_Name',`Gender`='$Gender',`Birth_Date`='$Birth_Date',`Phone_Number`='$Phone_Number',`Nid`='$Nid' WHERE `Email`='$Searched_Email'";
  $policeTablequery="UPDATE `police` SET `Address`='$Address',`Nationality`='$Nationality' WHERE `Police_Email_FK`='$Searched_Email'";
  $dbConnect->query($query);
  $dbConnect->query($policeTablequery);
  $dbConnect->commit();
  header('location:admin_edit_police.php');
}

//Updating Police Information When Submit Button is Clicked
if(isset($_POST['Police_Information'])){

  //Police Information
  $Searched_Email=$_POST['Hidden_Email'];
  $No_Of_Cases_Filled=intVal($_POST['No_Of_Cases_Filled']);
  $Region_Of_Work=$_POST['Region_Of_Work'];
  $Position=$_POST['Position'];
  $Police_Department=$_POST['Police_Department'];
  $Badge_Id=$_POST['Badge_id'];
  
 
  //$query="UPDATE `account` SET `Badge_Id`='$Badge_Id' WHERE `Email`='$sessionEmail'";
  $policeTablequery="UPDATE `police` SET `Police_Department`='$Police_Department',`Position`='$Position',`Region_Of_Work`='$Region_Of_Work' WHERE `Police_Email_Fk`='$Searched_Email'";
  $dbConnect->query($query);
  $dbConnect->query($policeTablequery);
  $dbConnect->commit();

  header('location:admin_edit_police.php');
}

//Updating Emergency Informations when submit button is clicked
if(isset($_POST['Emergency_Information'])){
  $Searched_Email=$_POST['Hidden_Email'];
  $emergency_Dependent_Relation=$_POST['Dependent_Relation'];
  $emergency_Dependent_Name=$_POST['Dependent_Name'];
  $emergency_Address=$_POST['Emergency_Address'];
  $emergency_Phone_Number=$_POST['Emergency_Phone_Number'];
  //emergency Information Update Query
  $dbConnect->autocommit(false);
  $query="UPDATE `emegencyinformation` SET `Phone_Number`='$emergency_Phone_Number',`Address`='$emergency_Address',`Dependent_Name`='$emergency_Dependent_Name',`Dependent_Relation`='$emergency_Dependent_Relation' WHERE `User_Email_Fk`='$Searched_Email';";
  $dbConnect->query($query);
  $dbConnect->commit();
  header('location:admin_edit_police.php');
}
//Updating Profile Picture when submit button is clicked
if(isset($_POST['Upload_Profile_Picture'])){
  $Searched_Email=$_POST['Hidden_Email'];
  //path to store the profile picture to profilepicture server
    $targetPath="../police/police_img/police_profile_picture_server/".basename($_FILES['Profile_Picture']['name']);
    $Profile_Picture=$_FILES['Profile_Picture']['name'];
    $dbConnect->autocommit(false);
    $query="UPDATE `police` SET `Police_Profile_picture`='$Profile_Picture' WHERE `Police_Email_FK`='$Searched_Email'";
    $dbConnect->query($query);
    $dbConnect->commit();
    //move uploaded profile picture to the server
    move_uploaded_file($_FILES['Profile_Picture']['tmp_name'],$targetPath);

    header('location:admin_edit_police.php');
  
  }
  


    //Updating Driving License Imagesubmit button is clicked
if(isset($_POST['Upload_Badge_Image'])){
    $Searched_Email=$_POST['Hidden_Email'];
    $Badge_Image=addslashes(file_get_contents($_FILES['Badge_Image']['tmp_name']));
    $query="UPDATE `account` SET `Badge_image`='$Badge_Image' WHERE `Email`='$Searched_Email'";
    $dbConnect->query($query);
    $dbConnect->commit();
    header('location:admin_edit_police.php');
  
  }
    //Updating Upload Nid Image submit button is clicked
if(isset($_POST['Upload_Nid_Image'])){
  $Searched_Email=$_POST['Hidden_Email'];
  $Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
  $query="UPDATE `account` SET `Nid_Image`='$Nid_Image' WHERE `Email`='$Searched_Email'";
  $dbConnect->query($query);
  $dbConnect->commit();
  header('location:admin_edit_police.php');

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_edit_police_css.css">

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
    <title>Admin Edit Police Page</title>
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
                <li><a href="admin_profile.php">
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
                <li><a href="admin_edit_police.php"class="active">
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
     $query="SELECT `Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, account.`Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`,`Police_Id`,police.`Address`,`Police_Profile_picture`,police.`Nationality`,`Police_Department`,`Position`,`Region_Of_Work`,`No_Of_Cases_Filled`,emegencyinformation.`Phone_Number` As E_Phone_Number,emegencyinformation.`Address` AS E_Address,`Dependent_Name`,`Dependent_Relation` FROM (`account` INNER JOIN `police` ON `Email`=`Police_Email_Fk`) INNER JOIN `emegencyinformation` ON `Email`=`User_Email_Fk` WHERE `Email`='$Searched_Email'";
     $queryResult=mysqli_query($dbConnect,$query);
     while($rowValues=mysqli_fetch_array($queryResult)){
       

           //Police Personal Values
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
           $Nationality=$rowValues['Nationality'];
           $Address=$rowValues['Address'];
           //Police Information
           $No_Of_Cases_Filled=intVal($rowValues['No_Of_Cases_Filled']);
           $Region_Of_Work=$rowValues['Region_Of_Work'];
           $Position=$rowValues['Position'];
           $Police_Department=$rowValues['Police_Department'];
           $Police_Id=$rowValues['Police_Id'];
           
           
           
           //Emergency Information
           $emergency_Dependent_Relation=$rowValues['Dependent_Relation'];
           $emergency_Dependent_Name=$rowValues['Dependent_Name'];
           $emergency_Address=$rowValues['E_Address'];
           $emergency_Phone_Number=$rowValues['E_Phone_Number'];



       //php ends ?> 
     

       <!------------------------------------All forms Code---------->
<!------------------Personal info--------------------------------->
<div class="item">
    <!--<h2>Personal Information</h2>---->
    <div class="login-form__content">
   <div class="login-form__header">
   <h2>Personal Information</h2>
   </div>
     <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
     <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>">
           <h4>First Name:</h4><input class="login-form__input" type="text" name="First_Name" value="<?= $First_Name?>"placeholder="Enter Last Name">
           <h4>Last Name:</h4><input class="login-form__input" type="text" name="Last_Name"  value="<?=$Last_Name?>"placeholder="Enter First Name">
             <h4>Email:</h4> <input class="login-form__input" type="email" name="Email" value="<?=$Email?>"placeholder="Enter Email" readonly>
             <br>
             <h4>Date of Birth:</h4> <input class="login-form__input" type="text" name="Birth_Date"onfocus="(this.type='date')"  onblur="(this.type='text')" required="requied" value="<?=$Birth_Date?>">
             <br>
           <h4>Phone Number:</h4> <input class="login-form__input" type="number" name="Phone_Number" value="<?=$Phone_Number?>"placeholder="Enter Phone Number">
             <br>
           <h4>Gender:</h4> 
           <input type="radio" name="Gender" value="Male" <?php if($Gender=='Male') echo "checked"?>> Male
             <input type="radio" name="Gender" value="Female" <?php if($Gender=='Female') echo "checked"?>> Female
             <input type="radio" name="Gender" value="Others"<?php if($Gender=='Others') echo "checked"?>> Others
             <br>
             <h4>NID:</h4><input class="login-form__input" type="number" name="Nid" value="<?=$Nid?>"placeholder="Enter NID" readonly>

           <h4>Nationality:</h4> <input class="login-form__input" type="Nation" name="Nationality" value="<?= $Nationality?>"placeholder="Enter Nationality">
             <br>
           <h4>Address:</h4> </Address> <input class="login-form__input" type="text" name="Address" value="<?= $Address?>"placeholder="Enter Address">
             <br>
             <br>
             <center>
             <button class="login-form__button" name="Personal_Information" type="submit">Submit</button>
             </center>
     </form>
 </div>

</div>


<!---------------Upload Nid Picture------------>
<div class="item">
     <h2>Upload Nid Picture</h2>
       <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
       <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>">
         <center>
             <br>
             <?php //echo"<img  id='nid_image_preview' src='data:image/jpeg;base64,".base64_encode($rowValues['Nid_Image'])."'/>";  
             echo "<img  id='nid_image_preview'src='data:image/jpg;base64,".base64_encode($rowValues['Nid_Image'])."' />" ;
           ?>
           <br/>
           <br>
           <input class="login-form__input"  type="file" accept="image/*" name="Nid_Image" onchange="preview_nid_image(event)"><br/>
           <br>
           <button class="login-form__button1" name="Upload_Nid_Image" type="submit">Submit</button>
         </center>
       </form>
</div>
<!-----------------nid image Preview script-------------->
<script type='text/javascript'>
   
   function preview_nid_image(event) 
   {
   var reader = new FileReader();
   reader.onload = function()
   {
     var output = document.getElementById('nid_image_preview');
     output.src = reader.result;
   }
   reader.readAsDataURL(event.target.files[0]);
   };
</script>

<!---------------Upload Profile Picture------------>
<div class="item">
     <h2>Upload Profile Picture</h2>
       <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
       <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>"> 
       <center>
             <br>
             <?php
               echo"<img id='profile_image_preview' src='../police/police_img/police_profile_picture_server/".$rowValues['Police_Profile_picture']."'/>";

           ?><br/>
           <br>
           <input class="login-form__input"  name="Profile_Picture" type="file" accept="image/*" onchange="preview_profile_image(event)"><br/>
           <br>
           <button class="login-form__button1" name="Upload_Profile_Picture" type="submit">Submit</button>
         </center>
       </form>
</div>
<script type='text/javascript'>
 
 function preview_profile_image(event) 
 {
 var reader = new FileReader();
 reader.onload = function()
 {
   var output = document.getElementById('profile_image_preview');
   output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
 }
</script>
<!------------------Police Information--------------------------------->
<div class="item">
  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
  <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>">
     <h2>Police Information</h2>
           <br>
         <h4>Police ID:</h4> <input class="login-form__input" type="text" name="Police_Id" placeholder="Police ID" value="<?= $Police_Id?>" readonly>
           <br>
         <h4>Badge Id:</h4> <input class="login-form__input" type="text" name="Badge_Id" placeholder="Enter Badge Id"  value="<?=$Badge_Id?>" readonly>
           <br>
         <h4>Department:</h4> <input class="login-form__input" type="text" name="Police_Department" placeholder="License Type"  value="<?=ucwords($Police_Department)?>">
           <br>
           <h4>Position:</h4> <input class="login-form__input" type="text" name="Position" placeholder="License Type"  value="<?=ucwords($Position) ?>">
           <br>
           <h4>Region Of Work:</h4> <input class="login-form__input" type="text" name="Region_Of_Work" placeholder="License Type"  value="<?=ucwords($Region_Of_Work) ?>">
           <br>
         
         <h4>Number of Cases Filled:</h4> <input class="login-form__input" type="text" name="No_OF_Cases_Filled" placeholder="Number of Cases" value="<?= $No_Of_Cases_Filled?>" readonly>
           <br>
           <center>
               <button class="login-form__button2" name="Police_Information" type="submit">Submit</button>
           </center>
     </form>
</div>

 <!---------------Police Badge Image--------------->
 <div class="item">
     <h2> Police Badge Image</h2>
     <br>
     <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
     <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>">
         <center>
             <!---<img id="driving_license_image_preview"/> --->
             <?php //echo"<img  id='nid_image_preview' src='data:image/jpeg;base64,".base64_encode($rowValues['Nid_Image'])."'/>";  
             echo "<img  id='police_badge_image_preview'src='data:image/jpg;base64,".base64_encode($rowValues['Badge_Image'])."' />" ;
           ?>
             
             <br>
             <input class="login-form__input"  name="Badge_Image" type="file" accept="image/*" onchange="preview_badge_image(event)"><br/>
                 <br>
             <button class="login-form__button5" name="Upload_Badge_Image" type="submit">Submit</button>
           </center>
     </form>
</div>

 <script type='text/javascript'>

         function preview_badge_image(event) 
         {
         var reader = new FileReader();
         reader.onload = function()
         {
           var output = document.getElementById('police_badge_image_preview');
           output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
         }
   </script>

<!------------------Emergency info--------------------------------->
<div class="item">
 <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
 <input class="login-form__input" type="hidden" name="Hidden_Email" value="<?=$rowValues['Email']?>">
       <h2>Emergency Information</h2>
       <br>
       <h4>Dependent Name:</h4> <input class="login-form__input" type="text" name="Dependent_Name" value="<?= ucwords($emergency_Dependent_Name)?>" placeholder="Enter Dependent Name">
       <br>
       <h4> Dependent Relation:</h4><input class="login-form__input" type="text" name="Dependent_Relation" value="<?=ucwords($emergency_Dependent_Relation)?>"placeholder="Enter Dependent Relation">
       <br>
       <h4>Phone Number:</h4> <input class="login-form__input" type="number" name="Emergency_Phone_Number" value="<?= $emergency_Phone_Number?>"placeholder="Enter E'Contact Number">
       <br>
       <h4>Address:</h4> <input class="login-form__input" type="text" name="Emergency_Address" value="<?=ucwords($emergency_Address)?>" placeholder="Enter Emergency Address">
       <br>
       <center>
         <button class="login-form__button4" name="Emergency_Information"type="submit">Submit</button>
       </center>
 </form>
</div>


<!-----------------------------------------All Forms code End--------------------->
<?php //php starts
     }


   }//search button If ends


?>

        </div><!-----main page container ends--------->
    </div>
    
</body>
</html>