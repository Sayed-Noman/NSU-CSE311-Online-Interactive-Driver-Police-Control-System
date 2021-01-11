<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }
    //Getting Session Email
    $sessionEmail=$_SESSION['ADMIN_LOGIN'];
    //$Email=$sessionEmail;
//Joing Tables to get all Imformation for user
 $query= "SELECT `First_Name`,`Last_Name`,`Gender`,`Birth_Date`,account.`Phone_Number`,`Nid`,`Nid_Image`,`Driving_License_No`,`Driving_License_Image`,`Badge_Id`,`Badge_Image`,`Pincode`,`Join_Date`,`Security_Question`,`Security_Question_Answer`,`User_Type`,`Email`,`Admin_Id`,admin.`Address`,`Nationality`,`Admin_Profile_Picture`,emegencyinformation.`Phone_Number` AS E_Phone_Number,emegencyinformation.`Address` As E_Address,`Dependent_Name`,`Dependent_Relation` FROM (`account` INNER JOIN `admin` ON `Email`=`Admin_Email_Fk`) INNER JOIN `emegencyinformation` ON `Admin_Email_Fk`=`User_Email_Fk` WHERE `Email`='$sessionEmail'";
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
 //Admin Information
 $Admin_Id=$rowValues['Admin_Id'];
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
  $Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
  $Nationality=$_POST['Nationality'];
  $Address=$_POST['Address'];
  //Personal information upadate Query
  $dbConnect->autocommit(false);
  $query="UPDATE `account` SET `First_Name`='$First_Name',`Last_Name`='$Last_Name',`Gender`='$Gender',`Birth_Date`='$Birth_Date',`Phone_Number`='$Phone_Number',`Nid`='$Nid',`Nid_Image`='$Nid_Image' WHERE `Email`='$sessionEmail'";
  $adminTablequery="UPDATE `admin` SET `Address`='$Address',`Nationality`='$Nationality' WHERE `Admin_Email_FK`='$sessionEmail'";
  $dbConnect->query($query);
  $dbConnect->query($adminTablequery);
  $dbConnect->commit();
  header('location:admin_edit_profile.php');
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
  header('location:admin_edit_profile.php');
}
//Updating Profile Picture when submit button is clicked
if(isset($_POST['Upload_Profile_Picture'])){
  //path to store the profile picture to profilepicture server
    $targetPath="admin_img/admin_profile_picture_server/".basename($_FILES['Profile_Picture']['name']);
    $Profile_Picture=$_FILES['Profile_Picture']['name'];
    $dbConnect->autocommit(false);
    $query="UPDATE `admin` SET `Admin_Profile_Picture`='$Profile_Picture' WHERE `Admin_Email_FK`='$sessionEmail'";
    $dbConnect->query($query);
    $dbConnect->commit();
    //move uploaded profile picture to the server
    move_uploaded_file($_FILES['Profile_Picture']['tmp_name'],$targetPath);

    header('location:admin_edit_profile.php');
  
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_edit_profile_css.css">
   
    <script type="text/javascript" src="https://ff.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=wLUfM6uYs0IaTZ4dZ2utr1Glm42p3g5xb4v5gABB1bHDWn9fi2T1gYe9nBsI5Cu-ojpbyFZAczm92YZLudazaUtg8JrzIpe3m0CQBjzkM4Ompi54e7okmlYn1VXuRu0ggXHAIXBYsEJyEILpmxUIY4OoM-3KoyGnFR_VG6aH5CoMZh1ixsC82KaIOmF_5STaI-C0Pa11KOF5vgTeeh7qVdOId90FO8j-rrlDkVtRqk4wdbFcfUsikXTfnJ9t0M8mIRkU2CE2aJbtbp6ju1tMD-YK0qUaHkO33wpW8kh388PXt9yXq3nu4g3xg_5MR-B8RTmWEFhreGgEo14w8VI7vfey6qdZSalXK0idTE7jKWI5loCFsuDk5Rnse3d80WUC1MnzZX2GNPF633bWwPi8eayeS6rvPaLgFIrBhfdT0ugyrmsBr_OTL7-UTGuQQCyhpv88nsteKBUQFFvxYb7UBaJBF11MdEwfVCGy389q0twVW2VVn5ErkGngLaIzvR5bfguJTQnr8fCJVY5hHqcq9_4LkSDpIN1_IQ712R0fG_8" charset="UTF-8"></script>
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
    <title>Admin Edit Profile</title>
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
                <li><a href="admin_edit_profile.php"class="active">
                    <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Profile</span>
                </a></li>
                <li><a href="admin_edit_driver.php">
                    <span class="icon"><i class="far fa-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Driver</span>
                </a></li>
                <li><a href="admin_edit_police.php">
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
                          <h4>NID:</h4><input class="login-form__input" type="number" name="Nid" value="<?=$Nid?>"placeholder="Enter NID">
                        <br>
                          
                        <input class="login-form__input"  type="file" accept="image/*" name="Nid_Image" onchange="preview_nid_image(event)"><br/>
                       <!--- <img id="nid_image_preview"/> --->
                        <?php //echo"<img  id='nid_image_preview' src='data:image/jpeg;base64,".base64_encode($rowValues['Nid_Image'])."'/>";  
                          echo "<img  id='nid_image_preview'src='data:image/jpg;base64,".base64_encode($rowValues['Nid_Image'])."' />" ;
                        ?>
                          <br>
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
                            echo"<img id='profile_image_preview' src='admin_img/admin_profile_picture_server/".$rowValues['Admin_Profile_Picture']."'/>";
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
<!------------------Admin Info--------------------------------->
            <div class="item">
                      <h2>Admin Information</h2>
                      <br>
                <h4>Admin ID:</h4> <input class="login-form__input" type="text" name="Admin_Id" value="<?=$Admin_Id?>"placeholder="Enter Admin Id" readonly>
                  <br>
            </div>
            
<!------------------Emergency info--------------------------------->
            <div class="item">
              <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

                    <h2>Emergency Information</h2>
                    <br>
                    <h4>Dependent Name:</h4> <input class="login-form__input" type="text" name="Dependent_Name" value="<?= $emergency_Dependent_Name ?>" placeholder="Enter Dependent Name">
                    <br>
                    <h4> Dependent Relation:</h4><input class="login-form__input" type="text" name="Dependent_Relation" value="<?=$emergency_Dependent_Relation ?>"placeholder="Enter Dependent Relation">
                    <br>
                    <h4>Phone Number:</h4> <input class="login-form__input" type="number" name="Emergency_Phone_Number" value="<?= $emergency_Phone_Number?>"placeholder="Enter E'Contact Number">
                    <br>
                    <h4>Address:</h4> <input class="login-form__input" type="text" name="Emergency_Address" value="<?=$emergency_Address ?>" placeholder="Enter Emergency Address">
                    <br>
                    <center>
                      <button class="login-form__button4" name="Emergency_Information"type="submit">Submit</button>
                    </center>
              </form>
            </div>
            
        </div>
    </div>
</body>
</html>