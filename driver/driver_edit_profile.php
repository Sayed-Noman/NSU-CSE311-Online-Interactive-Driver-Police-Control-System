<?php
 require_once '../php/dbConnect.php';
 session_start();//session start
  //IF Driver has already loged in then he will be redirected to dashboard
 if(!isset($_SESSION['DRIVER_LOGIN'])){
     header('location:driver_dashboard_home.php');
 }
  //Getting Session Email
  $sessionEmail=$_SESSION['DRIVER_LOGIN'];
  //$Email=$sessionEmail;

  //Joing Tables to get all Imformation for user
  $query="SELECT `Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, account.`Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`,`Driver_Id`,driver.`Address`,`Driver_Profile_Picture`,driver.`Nationality`,`License_Type`,`License_Issue_Date`,`License_Expire_Date`,`Point`,`No_Of_Cases`,emegencyinformation.`Phone_Number` AS E_Phone_Number,emegencyinformation.`Address` AS E_Address,`Dependent_Name`,`Dependent_Relation`,`No_Plate`,`Car_Model`,`Brand_Name`,`Color`,`Vechile_Type`,`Car_Image`,`Car_Document_Image` FROM (`account` INNER JOIN `driver` ON `Email`=`Driver_Email_Fk`) INNER JOIN `emegencyinformation` ON `Driver_Email_Fk`=`User_Email_Fk` INNER JOIN `car` ON emegencyinformation.User_Email_Fk=car.`Driver_Email_Fk` WHERE `Email`='$sessionEmail'";
 $queryResult=mysqli_query($dbConnect,$query);
 $rowValues=mysqli_fetch_assoc($queryResult);

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
 //Car Information
 $Vechile_Type=$rowValues['Vechile_Type'];
 $Color=$rowValues['Color'];
 $Brand_Name=$rowValues['Brand_Name'];
 $Car_Model=$rowValues['Car_Model'];
 $No_Plate=$rowValues['No_Plate'];
 
 //Emergency Information
 $emergency_Dependent_Relation=$rowValues['Dependent_Relation'];
 $emergency_Dependent_Name=$rowValues['Dependent_Name'];
 $emergency_Address=$rowValues['E_Address'];
 $emergency_Phone_Number=$rowValues['E_Phone_Number'];


  //Updating Personal Informations when submit button is clicked
  if(isset($_POST['Personal_Information'])){
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
    $query="UPDATE `account` SET `First_Name`='$First_Name',`Last_Name`='$Last_Name',`Gender`='$Gender',`Birth_Date`='$Birth_Date',`Phone_Number`='$Phone_Number',`Nid`='$Nid' WHERE `Email`='$sessionEmail'";
    $driverTablequery="UPDATE `driver` SET `Address`='$Address',`Nationality`='$Nationality' WHERE `Driver_Email_FK`='$sessionEmail'";
    $dbConnect->query($query);
    $dbConnect->query($driverTablequery);
    $dbConnect->commit();
    header('location:driver_edit_profile.php');
  }

  //Updating Car Information When Submit Button is Clicked
  if(isset($_POST['Driver_Information'])){

    //Driver Information
    $Driving_License_No=$_POST['Driving_License_No'];
    $License_Expire_Date=$_POST['License_Expire_Date'];
    $License_Issue_Date=$_POST['License_Issue_Date'];
    $License_Type=$_POST['License_Type'];
    $query="UPDATE `account` SET `Driving_License_No`='$Driving_License_No' WHERE `Email`='$sessionEmail'";
    $driverTablequery="UPDATE `driver` SET `License_Type`='$License_Type',`License_Expire_Date`='$License_Expire_Date',`License_Issue_Date`='$License_Issue_Date' WHERE `Driver_Email_FK`='$sessionEmail'";
    $dbConnect->query($query);
    $dbConnect->query($driverTablequery);
    $dbConnect->commit();

    header('location:driver_edit_profile.php');
  }
  
  //Updating Emergency Informations when submit button is clicked
  if(isset($_POST['Emergency_Information'])){
    $emergency_Dependent_Relation=$_POST['Dependent_Relation'];
    $emergency_Dependent_Name=$_POST['Dependent_Name'];
    $emergency_Address=$_POST['Emergency_Address'];
    $emergency_Phone_Number=$_POST['Emergency_Phone_Number'];
    //emergency Information Update Query
    $dbConnect->autocommit(false);
    $query="UPDATE `emegencyinformation` SET `Phone_Number`='$emergency_Phone_Number',`Address`='$emergency_Address',`Dependent_Name`='$emergency_Dependent_Name',`Dependent_Relation`='$emergency_Dependent_Relation' WHERE `User_Email_Fk`='$sessionEmail';";
    $dbConnect->query($query);
    $dbConnect->commit();
    header('location:driver_edit_profile.php');
  }
  //Updating Profile Picture when submit button is clicked
  if(isset($_POST['Upload_Profile_Picture'])){
    //path to store the profile picture to profilepicture server
      $targetPath="driver_img/driver_profile_picture_server/".basename($_FILES['Profile_Picture']['name']);
      $Profile_Picture=$_FILES['Profile_Picture']['name'];
      $dbConnect->autocommit(false);
      $query="UPDATE `driver` SET `Driver_Profile_Picture`='$Profile_Picture' WHERE `Driver_Email_FK`='$sessionEmail'";
      $dbConnect->query($query);
      $dbConnect->commit();
      //move uploaded profile picture to the server
      move_uploaded_file($_FILES['Profile_Picture']['tmp_name'],$targetPath);
  
      header('location:driver_edit_profile.php');
    
    }
    //Updating Car Information When Submit Button is Clicked
    if(isset($_POST['Car_Information'])){
      //Car Information
      $Vechile_Type=$_POST['Vechile_Type'];
      $Color=$_POST['Color'];
      $Brand_Name=$_POST['Brand_Name'];
      $Car_Model=$_POST['Car_Model'];
      $No_Plate=$_POST['No_Plate'];
      $query="UPDATE `car` SET `No_Plate`='$No_Plate',`Car_Model`='$Car_Model',`Brand_Name`='$Brand_Name',`Color`='$Color',`Vechile_Type`='$Vechile_Type' WHERE `Driver_Email_Fk`='$sessionEmail'";
      $dbConnect->query($query);
      $dbConnect->commit();

      header('location:driver_edit_profile.php');
    }

    //Updating Car  Image when submit button is clicked
  if(isset($_POST['Upload_Car_Image'])){
    //path to store the profile picture to profilepicture server
      $targetPath="driver_img/driver_car_picture_server/".basename($_FILES['Car_Picture']['name']);
      $Car_Picture=$_FILES['Car_Picture']['name'];
      $dbConnect->autocommit(false);
      $query="UPDATE `car` SET `Car_Image`='$Car_Picture' WHERE `Driver_Email_FK`='$sessionEmail'";
      $dbConnect->query($query);
      $dbConnect->commit();
      //move uploaded profile picture to the server
      move_uploaded_file($_FILES['Car_Picture']['tmp_name'],$targetPath);
  
      header('location:driver_edit_profile.php');
    
    }
     //Updating Car Document Imagewhen submit button is clicked
  if(isset($_POST['Upload_Car_Document_Image'])){
    //path to store the profile picture to profilepicture server
      $targetPath="driver_img/driver_car_document_picture_server/".basename($_FILES['Car_Document_Picture']['name']);
      $Car_Document_Picture=$_FILES['Car_Document_Picture']['name'];
      $dbConnect->autocommit(false);
      $query="UPDATE `car` SET `Car_Document_Image`='$Car_Document_Picture' WHERE `Driver_Email_FK`='$sessionEmail'";
      $dbConnect->query($query);
      $dbConnect->commit();
      //move uploaded profile picture to the server
      move_uploaded_file($_FILES['Car_Document_Picture']['tmp_name'],$targetPath);
  
      header('location:driver_edit_profile.php');
    
    }

      //Updating Driving License Imagesubmit button is clicked
  if(isset($_POST['Upload_Driving_License_Image'])){
      $Driving_License_Image=addslashes(file_get_contents($_FILES['Driving_License_Image']['tmp_name']));
      $query="UPDATE `account` SET `Driving_License_Image`='$Driving_License_Image' WHERE `Email`='$sessionEmail'";
      $dbConnect->query($query);
      $dbConnect->commit();
      header('location:driver_edit_profile.php');
    
    }
      //Updating Driving License Imagesubmit button is clicked
  if(isset($_POST['Upload_Nid_Image'])){
    $Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
    $query="UPDATE `account` SET `Nid_Image`='$Nid_Image' WHERE `Email`='$sessionEmail'";
    $dbConnect->query($query);
    $dbConnect->commit();
    header('location:driver_edit_profile.php');
  
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_css/driver_edit_profile_css.css">

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
    <title>Driver Edit Profile</title>
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
                <li><a href="driver_profile.php" >
                    <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                    <span class="title">Profile</span>
                </a></li>
                <li><a href="driver_edit_profile.php" class="active">
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
          <!------------------Personal info--------------------------------->
          <div class="item">
                 <!--<h2>Personal Information</h2>---->
                 <div class="login-form__content">
                <div class="login-form__header">
                <h2>Personal Information</h2>
                </div>
                  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

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
                      <center>
                          <br>
                          <?php //echo"<img  id='nid_image_preview' src='data:image/jpeg;base64,".base64_encode($rowValues['Nid_Image'])."'/>";  
                          echo "<img  id='nid_image_preview'src='data:image/jpg;base64,".base64_encode($rowValues['Nid_Image'])."' />" ;
                        ?>
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
                      <center>
                          <br>
                          <?php
                            echo"<img id='profile_image_preview' src='driver_img/driver_profile_picture_server/".$rowValues['Driver_Profile_Picture']."'/>";
                        ?>
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
            
            <!---------------Driver Info--------------------------------->
            <div class="item">
               <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                      <h2>Driver Information</h2>
                        <br>
                      <h4>Driver ID:</h4> <input class="login-form__input" type="text" name="Driver_Id" placeholder="Driver ID" value="<?= $Driver_Id?>" readonly>
                        <br>
                      <h4>Driver License No:</h4> <input class="login-form__input" type="Number" name="Driving_License_No" placeholder="Driving License No"  value="<?=$Driving_License_No ?>" readonly>
                        <br>
                      <h4>License Type:</h4> <input class="login-form__input" type="text" name="License_Type" placeholder="License Type"  value="<?=$License_Type ?>">
                        <br>
                      <h4>License Issue Date:</h4> <input class="login-form__input" type="text" onfocus="(this.type='date')"  onblur="(this.type='text')" required="requied" name="License_Issue_Date" placeholder="License Issue Date"  value="<?=$License_Issue_Date ?>">

                      <br>
                      <h4>License Expire Date:</h4> <input class="login-form__input" type="text" onfocus="(this.type='date')"  onblur="(this.type='text')" required="requied" name="License_Expire_Date" placeholder="License Expire Date" value="<?=$License_Expire_Date ?>">
                        <br>
                        <h4>Points:</h4> <input class="login-form__input" type="text" name="Point" placeholder="Points" value="<?= $Point?>" readonly>
                        <br>
                      <h4>Number of Cases:</h4> <input class="login-form__input" type="text" name="No_OF_Cases" placeholder="Number of Cases" value="<?= $No_Of_Cases?>" readonly>
                        <br>
                        <center>
                            <button class="login-form__button2" name="Driver_Information" type="submit">Submit</button>
                        </center>
                  </form>
            </div>
            <!---------------Driving License Image--------------->
            <div class="item">
                  <h2> Driver License Image</h2>
                  <br>
                  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

                      <center>
                          <!---<img id="driving_license_image_preview"/> --->
                          <?php //echo"<img  id='nid_image_preview' src='data:image/jpeg;base64,".base64_encode($rowValues['Nid_Image'])."'/>";  
                          echo "<img  id='driving_license_image_preview'src='data:image/jpg;base64,".base64_encode($rowValues['Driving_License_Image'])."' />" ;
                        ?>
                          
                          <br>
                          <input class="login-form__input"  name="Driving_License_Image" type="file" accept="image/*" onchange="preview_driving_license_image(event)"><br/>
                              <br>
                          <button class="login-form__button5" name="Upload_Driving_License_Image" type="submit">Submit</button>
                        </center>
                  </form>
            </div>

              <script type='text/javascript'>
            
                      function preview_driving_license_image(event) 
                      {
                      var reader = new FileReader();
                      reader.onload = function()
                      {
                        var output = document.getElementById('driving_license_image_preview');
                        output.src = reader.result;
                      }
                      reader.readAsDataURL(event.target.files[0]);
                      }
                </script>
            <!------------------Car info--------------------------------->
            <div class="item">
                  <h2>Car Information</h2>
                  <br>
                  <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <h4>No Plate:</h4> <input class="login-form__input" type="text" name="No_Plate" placeholder="No Plate" value="<?= ucwords($No_Plate)?>">
                          <br>
                        <h4>Car Model:</h4> <input class="login-form__input" type="text" name="Car_Model" placeholder="Car Model" value="<?=ucwords($Car_Model) ?>">
                          <br>
                        <h4>Brand Name:</h4> <input class="login-form__input" type="text" name="Brand_Name" placeholder="Brand Name" value="<?= ucwords($Brand_Name)?>">
                          <br>
                        <h4>Color:</h4> <input class="login-form__input" type="text" name="Color" placeholder="Color" value="<?= ucwords($Color)?>">
                          <br>
                          <h4>Vechicle Type:</h4> <input class="login-form__input" type="text" name="Vechile_Type" placeholder="Vechicle Type" value="<?= ucwords($Vechile_Type)?>">
                          <br>
                          <center>
                          <button class="login-form__button3" name="Car_Information" type="submit">Submit</button>
                          </center>
                    </form>
              </div>
  
    <div class="item">
            <h2>Car Image</h2>
            <br>
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                  <center>
                   <!--- <img id="car_image_preview"/> -->
                    <?php
                            echo"<img id='car_image_preview' src='driver_img/driver_car_picture_server/".$rowValues['Car_Image']."'/>";
                   ?>
                    <br>
                    <input class="login-form__input"  name="Car_Picture"type="file" accept="image/*" onchange="preview_car_image(event)"><br/>
                      <br>
                      <button class="login-form__button6" name="Upload_Car_Image" type="submit">Submit</button>
                  </center>
            </form>
    </div>

        <script type='text/javascript'>
            
            function preview_car_image(event) 
            {
            var reader = new FileReader();
            reader.onload = function()
            {
              var output = document.getElementById('car_image_preview');
              output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
            }
      </script>      
      <div class="item">
              <h2>Car Document Image</h2>
              <br>
              <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <center>
                   <!---- <img id="car_document_image_preview"/> -->
                   <?php
                            echo"<img id='car_document_image_preview' src='driver_img/driver_car_document_picture_server/".$rowValues['Car_Document_Image']."'/>";
                        ?>
                    <br>
                    <input class="login-form__input" name="Car_Document_Picture" type="file" accept="image/*" onchange="preview_car_document_image(event)"><br/>
                    <br>
                    <button class="login-form__button7" name="Upload_Car_Document_Image"type="submit">Submit</button>
                    </center>
              </form>
        </div>
        <script type='text/javascript'>
            
            function preview_car_document_image(event) 
            {
            var reader = new FileReader();
            reader.onload = function()
            {
              var output = document.getElementById('car_document_image_preview');
              output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
            }
      </script>      
      <!------------------Emergency info--------------------------------->
      <div class="item">
              <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

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
            
        </div><!---------main page container ends--->
    </div>
</body>
</html>