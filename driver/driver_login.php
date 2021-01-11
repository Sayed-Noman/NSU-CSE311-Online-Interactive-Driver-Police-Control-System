<?php
    require_once('../php/dbConnect.php');
    session_start();//session start
    //IF Driver has already loged in then he will be redirected to dashboard
    if(isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_dashboard_home.php');
    }

    //If Driver Login Button is  Pressed then This Loop Will Execute
    if(isset($_POST['Driver_Login'])){
        //Storing Input Fields Data into  Variable
        $Email=$dbConnect->real_escape_string($_POST['Email']);
        $Password=$dbConnect->real_escape_string($_POST['Password']);

        //Query to Select Email From Database
        $query="SELECT * FROM `account` WHERE `Email`='$Email' AND `User_Type`='Driver'";
        $resultQuery=mysqli_query($dbConnect,$query);
        
        
        //if Email Exists in Database
        if(mysqli_num_rows($resultQuery) == 1){
             //storing user values as an array
            $rowValues=mysqli_fetch_assoc($resultQuery);
            //checkig Password Matches or not
            if(password_verify($Password,$rowValues['Password'])){
               
                $_SESSION['DRIVER_LOGIN']=$Email;//Saving Email as Session Variable to Retrieve data later using it
                header('location:driver_dashboard_home.php');

            }else{
                $LoginFailedMessage="Password Invalid!";
               // echo " <script>alert('Password is incorrect');</script>  ";
            }
        }else{
            $LoginFailedMessage="Email or Password is Incorrect!";
        }
    }


?>



<!DOCTYPE html>
<html>
    <head>
        <title>Driver Login Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="driver_css/driver_login_css.css">
        <script  src="https://kit.fontawesome.com/a81368914c.js"></script>
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
        <section class="login-section">
           
                <div class="login_page_container">
                    <div class="boy_with_car">
                        <img class="boy_with_car_image" src="driver_img/driver_login_page_img/jeep_car_driver.svg">
                    </div>
                    <div class="login_form_container">
                        <form  method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <img class="profile_avatar_image" src="driver_img/driver_login_page_img/profile_picture_avatar.svg">
                            <h2 class="welcome_title">Welcome</h2>

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




                            <div class="input-container username">
                                <div class="icon-tag">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="div">
                                    <h5>Email</h5>
                                    <input class="input" name="Email" type="email">
                                </div>
                            </div>

                            <div class="input-container password">
                                <div class="icon-tag">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="div">
                                    <h5>Password</h5>
                                    <input type="Password" name="Password"  class="input" >
                                </div>
                            </div>
                            <a class="forget_pass_link" href="driver_forget_password.php">Forgot Password</a>
                            <input type="submit" name="Driver_Login" class="login_btn" value="Login">
                            <a class="register_account_link" href="driver_registration.php">Dont have an account?</a>
                        </form>
                    
                    </div>
            </div>
        </section>

        <footer>

        </footer>
</div>
    
        <script type="text/javascript" src="driver_js/driver_login_js.js"></script>

    </body>

</html>