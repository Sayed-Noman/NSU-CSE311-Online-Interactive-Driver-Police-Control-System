<?php 
    require_once '../php/dbConnect.php';
    session_start();//session start
     //IF Driver has already loged in then he will be redirected to dashboard
    if(isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_dashboard_home.php');
    }
    //Storing Form Values into Variables
    if(isset($_POST['Driver_Register'])){
        $First_Name=$_POST['First_Name'];
        $Last_Name=$_POST['Last_Name'];
        $Email=$dbConnect->real_escape_string($_POST['Email']);
        $Password=$dbConnect->real_escape_string($_POST['Password']);
        $Gender=$_POST['Gender'];
        $Birth_Date=$_POST['Birth_Date'];
        $Phone_Number=$_POST['Phone_Number'];
        $Nid=$_POST['Nid'];
        $Nid_Image=addslashes(file_get_contents($_FILES['Nid_Image']['tmp_name']));
        $Driving_License_No=$_POST['Driving_License_No'];
        $Driving_License_Image=addslashes(file_get_contents($_FILES['Driving_License_Image']['tmp_name']));
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
         if(empty($Driving_License_No)){
            $Registration_Input_Errors['Driving_License_No']="Driving License No is Required!";
        }
         //if fields are empty then store them in array
         if(empty($Driving_License_Image)){
            $Registration_Input_Errors['Driving_License_Image']="Driving License Image is Required!";
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
                    //Nid Checking If Already Exists or not
                    $nidCheckQuery="SELECT * FROM `account` WHERE `Nid`= '$Nid'";
                    $nidCheck=mysqli_query($dbConnect,$nidCheckQuery);
                    $nid_check_row=mysqli_num_rows($nidCheck);
                    if($nid_check_row == 0){
                        if(strlen($Nid)==15){
                            //Nid Checking If Already Exists or not
                            $drivingLicenseNoCheckQuery="SELECT * FROM `account` WHERE `Driving_License_No`= '$Driving_License_No'";
                            $drivingLicenseNoCheck=mysqli_query($dbConnect,$drivingLicenseNoCheckQuery);
                            $driving_License_No_check_row=mysqli_num_rows($drivingLicenseNoCheck);
                            if($driving_License_No_check_row == 0){
                                if(strlen($Driving_License_No)==15){
                                    //If Everything Goes Well Then Register Will Happen
                                    //Using Hassing Algorithm to Hash Driver Given Password
                                     $Hased_Password=password_hash($Password,PASSWORD_DEFAULT);
                                    //Inser Query to Insert Values into Database
                                    $query="INSERT INTO `request`(`Email`, `Password`, `First_Name`, `Last_Name`, `Gender`, `Birth_Date`, `Phone_Number`, `Nid`, `Nid_Image`, `Driving_License_No`, `Driving_License_Image`, `Badge_Id`, `Badge_Image`, `Pincode`, `Join_Date`, `Security_Question`, `Security_Question_Answer`, `User_Type`) VALUES ('$Email','$Hased_Password','$First_Name','$Last_Name','$Gender','$Birth_Date','$Phone_Number','$Nid','$Nid_Image','$Driving_License_No','$Driving_License_Image',NULL,NULL,NULL,CURRENT_TIMESTAMP,'$Security_Question','$Security_Question_Answer','Driver')";
                                    //Executing Query
                                    $resultQuery=mysqli_query($dbConnect,$query);
                                    if($resultQuery){
                                        $successMessage="Registration Successfull!";
                                    }
                                    else{
                                        $failedMessage="Registration Failled";
                                    }  

                                }else{
                                    $drivingLicenseNoExistsMessage=" Driving License No Lenghth Must be 15 Character!";
                                }
                            }else{
                                $drivingLicenseNoExistsMessage="This Driving License No Already Exists!";
                            }


                        }else{
                            $nidExistsMessage=" Nid Must be 15 Character!"; 
                        }
                    } else{
                        $nidExistsMessage="This Nid Already Exists!";  
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
        <title>Driver Registration Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="driver_css/Zahid_Driver_Registrtion_Css.css">
     <!---   <script type="text/javascript" src="https://ff.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=yGw1HVV5iBxPwL5aTUeyALXQD7nCKWExuzDfd7u_Pl6c_EnF7_F_aDWmnaysK4vxOh_EiwTiLLgbroAhyj-CSTbGIan4jUMt7Ed0oIf_KnEBjcpPjyOm9BD-jog99VB3TnQR7lmrA8NHS7hWMEdbNJ2EKFAHP8QwvwLoCtNbQZ2Q3xJSwBo1z4zYLf3hjOAMdITMtyM5uqvlU9aiV3-IodgnCDGmK0b-J7-D0Bw5wlz-EYhYCbdSYAVG-3ZiAB06CL4M2YUEbw7Vdh56E3Xex4-RK5SUCLwujwUQgg7hfrZqYKA0OE0MWVtzvgGYnyNLp_0J0iJre1rM_loShHr3GTaevpeFYpFZzbEPGpA4sHIYFDmXgzt_QRQpUQwBABnB9abOetf6ct1lMa0XEvSEqsM_-J2GJSjMq4xlZcoxUfACLg7r4d3v7wuav1p4fTK1ztrRRcysE3Rd2PfgTsQBEhsZ3xxjfrSmQP_9aV01brzm4OKX-Dblc3kaTWLYgeeOH1HhyHCJUkF0QeCSrvnri7iD9CLEH6EUEBsdTlpDEYY" charset="UTF-8"></script><script  src="https://kit.fontawesome.com/a81368914c.js"></script> --->
        <!-- Google Fonts Links-->
        <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet"> 
    </head>
    <body>
    
    <div class="page-wrapper">
        <header>
            <h3 class="logo-header"><a href="../index.php"> Driver-Police Control System</a></h3>
                <nav class="nav-container">
                    <ul class="navbar_links">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="driver_login.php">Driver</a></li>
                        <li><a href="../police/police_login.php">Police</a></li>
                        <li><a href="../admin/admin_login.php">Admin</a></li>
                    </ul>
                </nav>
                <a class="contact-btn" href="../contact_page.php"><button>Contact</button></a>
        </header>
        <section class="registration-section">
           
                <div class="registration_page_container">
        <div class="container">
           <h2>Register here as Driver!</h2>
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
                if(isset($drivingLicenseNoExistsMessage)){
                    ?>
                        <div class="alert success">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                <strong><?=$drivingLicenseNoExistsMessage?></strong> Please Try with Valid Driving License Id.
                        </div>

                    <?php
                }
           ?>

           <div class="register-input-errors">
               <?php 
                    if(isset($Registration_Input_Errors['First_Name'])){
                        echo '<span>'.$Registration_Input_Errors['First_Name'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Last_Name'])){
                        echo '<span>'.$Registration_Input_Errors['Last_Name'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Email'])){
                        echo '<span>'.$Registration_Input_Errors['Email'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Passwors'])){
                        echo '<span>'.$Registration_Input_Errors['Password'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Gender'])){
                        echo '<span>'.$Registration_Input_Errors['Gender'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Birth_Date'])){
                        echo '<span>'.$Registration_Input_Errors['Birth_Date'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Phone_Number'])){
                        echo '<span>'.$Registration_Input_Errors['Phone_Number'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Nid'])){
                        echo '<span>'.$Registration_Input_Errors['Nid'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Nid_Image'])){
                        echo '<span>'.$Registration_Input_Errors['Nid_Image'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Driving_License_No'])){
                        echo '<span>'.$Registration_Input_Errors['Driving_License_No'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Driving_License_Image'])){
                        echo '<span>'.$Registration_Input_Errors['Driving_License_Image'].'</span>';
                    }

                    
                    if(isset($Registration_Input_Errors['Security_Question'])){
                        echo '<span>'.$Registration_Input_Errors['Security_Question'].'</span>';
                    }

                    if(isset($Registration_Input_Errors['Security_Question_Answer'])){
                        echo '<span>'.$Registration_Input_Errors['Security_Question_Answer'].'</span>';
                    }
                ?>

           </div>
                
<!------------------------------Driver  Registration Form Start--------->
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
                            <input  class="email-input" type="email" name="Email" value="<?= isset($Email) ? $Email:'' ?>"required>
                            <span class="text">Email</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>

                <div class="row100">
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input type="Password" name="Password" value="<?= isset($Password) ? $Password:'' ?>" required>
                            <span class="text">Password</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>
                
                <div class="row100">
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input type="number" name="Phone_Number" value="<?= isset($Phone_Number) ? $Phone_Number:'' ?>" required>
                            <span class="text">Mobile</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>

                <div class="row100">
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input name="Birth_Date" type="text" onfocus="(this.type='date')"  onblur="(this.type='text')" value="<?= isset($Birth_Date) ? $Birth_Date:'' ?>" required>
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
                        <input type="number" name="Nid" value="<?= isset($Nid) ? $Nid:'' ?>" required>
                        <span class="text">National ID.</span>
                        <span class="line shorten-line"></span>
                </div>
                </div>
                <br/>
                <h4>**Upload Your NID Picture for varification** </h4>
                
        <br><input type="file" class="inputBox" name="Nid_Image" accept="image/*" onchange="preview_image(event)"  required>
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
            <div class="row100">
                <div class="col">
                    <div class="inputBox shorten-input">
                        <input type="number" name="Driving_License_No" value="<?= isset($Driving_License_No) ? $Driving_License_No:'' ?>" required >
                        <span class="text">Driving License No.</span>
                        <span class="line"></span>
                </div>
                </div>
                    <h4>**Upload D'License Imagr for varification**</h4>
    <input type="file" class="inputBox" name="Driving_License_Image" accept="image/*" onchange="loadFile(event)" required >
    <img id="output"/>
    <script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
        var output = document.getElementById('output');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
                    </script>
            
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox">          
                        <span class="text">Select a Security Question</span>
                    </div>
                </div>
            </div>
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

            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="Security_Question_Answer"   cols="20" rows="7" required></textarea>
                        <span class="text">Type Your Answer Here</span>
                        <span class="line "></span>
                    </div>
                </div>
            </div>

            <div class="row100">
                <div class="col">
                    <input type="submit"  name="Driver_Register" value="Register">
                    </div> 
            </div>
    </form>
        </div>
            </div>
        </section>

        <footer>

        </footer>
</div>

    </body>

</html>