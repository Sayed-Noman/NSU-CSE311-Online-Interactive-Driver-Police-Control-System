<?php 
    require_once '../php/dbConnect.php';
    session_start();//session start
     //IF Driver has already loged in then he will be redirected to dashboard
    if(isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_dashboard_home.php');
    }

    //Storing Form Values into Variables
    if(isset($_POST['Admin_Register'])){
        $First_Name=$_POST['First_Name'];
        $Last_Name=$_POST['Last_Name'];
        $Email=$_POST['Email'];
        $Password=$_POST['Password'];
        $Pincode=$_POST['Pincode'];
        $Gender=$_POST['Gender'];
        $Birth_Date=$_POST['Birth_Date'];
        $Phone_Number=$_POST['Phone_Number'];
        $Nid=$_POST['Nid'];
        $Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
        $Security_Question=$_POST['Security_Question'];
        $Security_Question_Answer=$_POST['Security_Question_Answer'];
        

        /*------Validating Driver Registration Form Fields----------*/
        //creating an array to store errors in array
        $Registration_Input_Errors=array();
        //if fields are empty then store them in array
        if(empty($First_Name)){
            $Registration_Input_Errors['First_Name']="First Name is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Last_Name)){
            $Registration_Input_Errors['Last_Name']="Last Name is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Email)){
            $Registration_Input_Errors['Email']="Email Id is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Password)){
            $Registration_Input_Errors['Password']="Password is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Pincode)){
            $Registration_Input_Errors['Pincode']="Pincode is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Gender)){
            $Registration_Input_Errors['Gender']="Gender is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Birth_Date)){
            $Registration_Input_Errors['Birth_Date']="Birth Date is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Phone_Number)){
            $Registration_Input_Errors['Phone_Number']="Phone Number is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Nid)){
            $Registration_Input_Errors['Nid']="Nid is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Nid_Image)){
            $Registration_Input_Errors['Nid_Image']="Nid Image is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Security_Question)){
            $Registration_Input_Errors['Security_Question']="Security Question is Required!";
        }
        //if fields are empty then store them in array
        if(empty($Security_Question_Answer)){
            $Registration_Input_Errors['Security_Question_Answer']="Security Question Answer is Required!";
        }
        
        if(count($Registration_Input_Errors)==0){
            //Email Checking If Already Exists or not
            //$emailCheckQuery="SELECT * FROM `account` WHERE `Email`= $Email";
            $emailCheckQuery="SELECT * FROM `account` WHERE `Email`= '$Email'";
            $emailCheck=mysqli_query($dbConnect,$emailCheckQuery);
            $email_check_row=mysqli_num_rows($emailCheck);
            if($email_check_row == 0){
                if(strlen($Password)>5){
                    //Checking If Given Pincode Matches Predefine Pincode
                    if($Pincode== "Admin321"){
                    //Nid Checking If Already Exists or not
                    $nidCheckQuery="SELECT * FROM `account` WHERE `Nid`= '$Nid'";
                    $nidCheck=mysqli_query($dbConnect,$nidCheckQuery);
                    $nid_check_row=mysqli_num_rows($nidCheck);
                    if($nid_check_row == 0){
                        if(strlen($Nid)==15){
                                    //If Everything Goes Well Then Register Will Happen
                                    //Using Hassing Algorithm to Hash Driver Given Password
                                    $Hased_Password=password_hash($Password,PASSWORD_DEFAULT);
                                    //Inser Query to Insert Values into Database
                                    $query="INSERT INTO `request`(`Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, `Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`) VALUES ('$Email','$Hased_Password','$First_Name','$Last_Name','$Gender','$Birth_Date','$Phone_Number','$Nid','$Nid_Image',NULL,NULL,NULL,NULL,'$Pincode',CURRENT_TIMESTAMP,'$Security_Question','$Security_Question_Answer','Admin')";
                                    //Executing Query
                                    $resultQuery=mysqli_query($dbConnect,$query);
                                    if($resultQuery){
                                        $successMessage="Registration Successfull!";
                                    }
                                    else{
                                        $failedMessage="Registration Failled";
                                    }  

                        }else{
                            $nidExistsMessage=" Nid Must be 15 Character!"; 
                        }
                    } else{
                        $nidExistsMessage="This Nid Already Exists!";  
                    }   

                    }else{
                        $PincodeExistMessage="Pin Code Doesn't Match";
                    }
                    
                    }else{
                        $passwordExistsMessage="Password Length Must be Greater Than 5 Character";
                    }
                    
              
            }else{
                $emailExistsMessage="This Email Already Exists!";
            }


           
        }
        
       /*  //To Count Errors
        print_r($Registration_Input_Errors);
        echo count($Registration_Input_Errors);
        */
        //Inser Query to Insert Values into Database
        /*
        $query="INSERT INTO `request`(`Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, `Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`) VALUES ('$Email',' $Hased_Password','$First_Name','$Last_Name','$Gender','$Birth_Date','$Phone_Number','$Nid','$Nid_Image','$Driving_License_No','$Driving_License_Image',NULL,NULL,NULL,CURRENT_TIMESTAMP,'$Security_Question','$Security_Question_Answer','Driver')";
        //Executing Query
        mysqli_query($dbConnect,$query);
        */

    }
?>




<!DOCTYPE html>
<html>
    <head>
        <title>Admin Registration Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="admin_css/Zahid_Admin_Registration_Css.css">
       <!--<script type="text/javascript" src="https://ff.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=wLUfM6uYs0IaTZ4dZ2utr1Glm42p3g5xb4v5gABB1bHDWn9fi2T1gYe9nBsI5Cu-ojpbyFZAczm92YZLudazaUtg8JrzIpe3m0CQBjzkM4Ompi54e7okmlYn1VXuRu0ggXHAIXBYsEJyEILpmxUIY4OoM-3KoyGnFR_VG6aH5CoMZh1ixsC82KaIOmF_5STaI-C0Pa11KOF5vgTeeh7qVdOId90FO8j-rrlDkVtRqk4wdbFcfUsikXTfnJ9t0M8mIRkU2CE2aJbtbp6ju1tMD-YK0qUaHkO33wpW8kh388PXt9yXq3nu4g3xg_5MR-B8RTmWEFhreGgEo14w8VI7vfey6qdZSalXK0idTE7jKWI5loCFsuDk5Rnse3d80WUC1MnzZX2GNPF633bWwPi8eayeS6rvPaLgFIrBhfdT0ugyrmsBr_OTL7-UTGuQQCyhpv88nsteKBUQFFvxYb7UBaJBF11MdEwfVCGy389q0twVW2VVn5ErkGngLaIzvR5bfguJTQnr8fCJVY5hHqcq9_4LkSDpIN1_IQ712R0fG_8" charset="UTF-8"></script> -->
        <script  src="https://kit.fontawesome.com/a81368914c.js"></script>
        <!-- Google Fonts Links-->
        <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet"> 
    </head>
    <body>
    
    <div class="page-wrapper">
        <header>
            <h3 class="logo-header"><a href="#"> Driver-Police Control System</a></h3>
                <nav class="nav-container">
                    <ul class="navbar_links">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../driver/driver_login.php">Driver</a></li>
                        <li><a href="../police/police_login.php">Police</a></li>
                        <li><a href="../admin/admin_login.php">Admin</a></li>
                    </ul>
                </nav>
                <a class="contact-btn" href="../contact_page.php"><button>Contact</button></a>
        </header>
        <section class="registration-section">
           
                <div class="registration_page_container">
        <div class="container">
           <h2  style="color: #00b0ff ;" >Register here as Admin!</h2>

           <?php
                if(isset($successMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$successMessage?></strong> Please Wait Until Your Account is Activated.
                        </div>

                    <?php
                }
           ?>

           <?php
                if(isset($failedMessage)){
                    ?>
                        <div class="alert faield">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$failedMessage?></strong>Please Try Again.
                        </div>

                    <?php
                }
           ?>

           <?php
                if(isset($emailExistsMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$emailExistsMessage?></strong> Please Try with another Account.
                        </div>

                    <?php
                }
           ?>

           <?php
                if(isset($nidExistsMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$nidExistsMessage?></strong> Please Try with Valid Nid.
                        </div>

                    <?php
                }
           ?>

            <?php
                if(isset($passwordExistsMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$passwordExistsMessage?></strong> Please Try witha Strong Password.
                        </div>

                    <?php
                }
           ?>
           <?php
                if(isset($PincodeExistMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$PincodeExistMessage?></strong> Please Try with Valid Pincode.
                        </div>

                    <?php
                }
           ?>

           <div class="register-input-errors">
               <?php 
                    if(isset($Registration_Input_Errors['First_Name'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['First_Name'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Last_Name'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Last_Name'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Email'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Email'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Passwors'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Password'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Pincode'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Pincode'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Gender'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Gender'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Birth_Date'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Birth_Date'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Phone_Number'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Phone_Number'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Nid'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Nid'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Nid_Image'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Nid_Image'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Security_Question'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Security_Question'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Security_Question_Answer'])){
                        echo '<span class="required-span">'.$Registration_Input_Errors['Security_Question_Answer'].'</span>';
                    }
                ?>

           </div>
                



           <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
           <div class="row100">
                <div class="col">
                    <div class="inputBox">
                        <input type="text" name="First_Name" value="<?= isset($First_Name) ? $First_Name:'' ?>" required>
                        <span class="text">First Name</span>
                        <span class="line"></span>
                    </div>
                </div>
                
                <div class="col">
                    <div class="inputBox">
                        <input type="text" name="Last_Name" value="<?= isset($Last_Name) ? $Last_Name:'' ?>" required>
                        <span class="text">Last Name</span>
                        <span class="line"></span>
                    </div>
                </div>

            </div>

            <div class="row100">
                <div class="col">
                    <div class="inputBox shorten-input">
                        <input  class="email-input" type="text" name="Email" value="<?= isset($Email) ? $Email:'' ?>" required>
                        <span class="text">Email</span>
                        <span class="line shorten-line"></span>
                    </div>
                </div>
            </div>

            <div class="row100">
                <div class="col">
                    <div class="inputBox shorten-input">
                        <input type="Password" name="Password"  required>
                        <span class="text">Password</span>
                        <span class="line shorten-line"></span>
                    </div>
                </div>
            </div>
           
            <div class="row100">
            <div class="col">
                    <div class="inputBox">
                        <input type="Password" name="Pincode"  required>
                        <span class="text">PIN code</span>
                        
                        <span class="line shorten-line"></span>
                    </div>
                </div>
               </div>
            <div class="row100">
                <div class="col">
                    <div class="inputBox shorten-input">
                        <input type="text" name="Phone_Number" value="<?= isset($Phone_Number) ? $Phone_Number:'' ?>" required>
                        <span class="text">Mobile</span>
                        <span class="line shorten-line"></span>
                    </div>
                </div>
            </div>

            <div class="row100">
                <div class="col">
                       <div class="inputBox shorten-input">
                           <input  name="Birth_Date" type="text"  onfocus="(this.type='date')"  onblur="(this.type='text')" value="<?= isset($Birth_Date) ? $Birth_Date:'' ?>" required>
                           <span class="text">Date of Birth</span>
                           <span class="line shorten-line"></span>
                        </div>
                </div>
            </div>

            <div class="row100">  
                <div class="col">
                    
                        <h3>
                        Select Your Gender &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="Gender" value="Male" checked><b>&nbsp;Male</b>
                        <input type="radio" name="Gender" value="Female"><b>&nbsp;Female</b>
                        <input type="radio" name="Gender" value="Others"><b>&nbsp;Others</b>
                        </h3>
                      
                </div> 
            </div>
         
        <div class="row100">
            <div class="col">
                   <div class="inputBox shorten-input">
                       <input type="text" name="Nid" value="<?= isset($Nid) ? $Nid:'' ?>" required>
                       <span class="text">National ID.</span>
                       <span class="line shorten-line"></span>
               </div>
            </div>
            <br/>
             <h4>**Upload Your NID Picture for varification** </h4>
            
    <br><input type="file" class="inputBox" name="Nid_Image"  accept="image/*" onchange="preview_image(event)" required>
 <br><img id="output_image"/>

<script type='text/javascript'>
            
function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
                </script>
         
         <br>
         <br/>
        <div class="row100">
            <div class="col">
                <div class="inputBox">          
                    <span class="text">Select a Security Question</span>
                </div>
            </div>
        </div>
        <br>
        <div class="row100">
            <div class="col">
                <div class="inputBox">          
                    <div class="select">
                        <select name="Security_Question" id="slt-1">
                            <option value="">Choose an option</option>
                            <option value="I Like sports">I Like sports</option>
                            <option value="I like foods">I like foods</option>
                            <option value="I like traveling">I like traveling </option>
                            <option value="I like pets">I like pets</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row100">
            <div class="col">
                <div class="inputBox textarea">
                    <textarea name="Security_Question_Answer"   cols="20" rows="7"  required ></textarea>
                    
                    <span class="text">Type Your Answer Here</span>
                    <span class="line "></span>
                </div>
            </div>
        </div>
          <br>
        <div class="row100">
               <div class="col">
                   <input type="submit" name="Admin_Register" value="Register">
                </div> 
        </div>
    </form>
        </div>
            </div>
        </section>

        <footer>

        </footer>
</div>
    
        <script type="text/javascript" src="js/login_js.js"></script>

    </body>

</html>