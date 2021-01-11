<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(isset($_SESSION['POLICE_LOGIN'])){
        header('location:police_dashboard_home.php');
    }

    //When Submit-CHANGE_PASSWORD Button is Clicked
    if(isset($_POST['Change_Password'])){
        $Email=$_POST['Email'];
        $NewPassword=$_POST['NewPassword'];
        $ConfirmPassword=$_POST['ConfirmPassword'];
        $Security_Question=$_POST['Security_Question'];
        $Security_Question_Answer=$_POST['Security_Question_Answer'];


         //Query to Select Email From Database
         $query="SELECT * FROM `account` WHERE `Email`='$Email' AND `User_Type`='Police'";
         $resultQuery=mysqli_query($dbConnect,$query);

          //if Email Exists in Database
        if(mysqli_num_rows($resultQuery)==1){
            //storing user values as an array
           $rowValues=mysqli_fetch_assoc($resultQuery);
           //checkig is security Question and it's answer matches or not
           if(strcasecmp($Security_Question,$rowValues['Security_Question'])==0 && strcasecmp($Security_Question_Answer,$rowValues['Security_Question_Answer'])==0){
               if(strlen($NewPassword)>5 && strlen($ConfirmPassword)>5){
                if(strcmp($NewPassword,$ConfirmPassword)==0){
                    //Using Hassing Algorithm to Hash Driver Given Password
                    $Hased_Password=password_hash($NewPassword,PASSWORD_DEFAULT);
                    //Update Query To Updade Password
                    $query="UPDATE `account` SET `Password`='$Hased_Password' WHERE `Email`='$Email'";
                    $resultQuery=mysqli_query($dbConnect,$query);
                    $LoginFailedMessage="Password has been Updated Successfully"; 
    
                   }else{
                    $LoginFailedMessage="Both Password Doesn't Match";  
                   }

               }else{
                $LoginFailedMessage="PassWord length must  be greater than 5 Character."; 
               }
           }else{
               $LoginFailedMessage="Security Question and Answer Doesn't Match";
           }
       }else{
           $LoginFailedMessage="Email is Invalid!";
       }
    }



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Police Forget Password</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="police_css/police_forget_password.css">
       <!--- <script type="text/javascript" src="https://ff.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=F_TZUbMbZ-8lw7AXp426kxQOBvrbT0qE4HE8woC8bZk5yDYeUpm_xlNZUbqKNwPIaiXBuzsQ8_MIB2zA8AKJRl5wf6zeLA0PxOEASm2u3bBOFcYl6ppR9ZfboJ0FInVsgEh7geih2ctiFp-k4f59ZId_VI0N3mSqI_QZVCGk9hb8rFFcXfctJ3Hk27xGj3BepLsJyv2Hw0C2diVJHgF9DZyfZ7O14Nn5TDZftKdZifI6mizFs2IHjV5TtX2uO8NlD7NbFecKcuCVGAhZOJZsQYcB-A-wCppQmOjSxPQLZQ4Lh0qT2ZCb6tOGXu6p0CHQjHOHvbwI3vNHM07TIMwTigrBcrBiEkWPJNnZ-8cWLMQnbLFva7iRtmfw7wJti_8MhzWvfXRfqFmtnPW69wvekmGw0CHUOyzutAu4RIIFU6o" charset="UTF-8"></script><script  src="https://kit.fontawesome.com/a81368914c.js"></script> -->
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
                        <li><a href="../driver/driver_login.php">Driver</a></li>
                        <li><a href="police_login.php">Police</a></li>
                        <li><a href="../admin/admin_login.php">Admin</a></li>
                    </ul>
                </nav>
                <a class="contact-btn" href="../contact_page.php"><button>Contact</button></a>
        </header>
        <section class="forget-password-section">
            <div class="forget_password_page_container">
        <div class="container">
           <h2>Forget Password??</h2>
                <?php
                    if(isset($LoginFailedMessage)){
                    ?>
                        <div class="alert success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <strong><?=$LoginFailedMessage?></strong> Please Try Again.
                     </div>

                    <?php
                     }
                ?>

           <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
               <div class="row100">
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input  class="email-input" type="text" name="Email" required="requied">
                            <span class="text">Email</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>

                <div class="row100">
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input type="Password" name="NewPassword" required="requied">
                            <span class="text">New Password</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>
                <div class="row100">    
                    <div class="col">
                        <div class="inputBox shorten-input">
                            <input type="Password" name="ConfirmPassword" required="requied">
                            <span class="text">Confirm Password</span>
                            <span class="line shorten-line"></span>
                        </div>
                    </div>
                </div>
            
        
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
                            <textarea name="Security_Question_Answer" id=""  cols="20" rows="7" required></textarea>   
                            <span class="text">Type Your Answer Here</span>
                            <span class="line "></span>
                        </div>
                    </div>
                </div>

                <div class="row100">
                    <div class="col">
                        <input type="submit"  name="Change_Password" value="Submit">
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