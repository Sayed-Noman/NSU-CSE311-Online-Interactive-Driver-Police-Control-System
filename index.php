<?php
    require_once 'php/dbConnect.php';
    session_start();
    if(isset($_SESSION['ADMIN_LOGIN'])){
      header('location:admin/admin_dashboard_home.php');
    }
    if(isset($_SESSION['POLICE_LOGIN'])){
      header('location:police/police_dashboard_home.php');
    }
    if(isset($_SESSION['DRIVER_LOGIN'])){
      header('location:driver/driver_dashboard_dashboard_home.php');
    }

?>




<!DOCTYPE html>
<html> 
    <head>
        <title>Home Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/homepage_css.css">
        <script  src="https://kit.fontawesome.com/a81368914c.js"></script>
        <!-- Google Fonts Links-->
        <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Antic&display=swap" rel="stylesheet"> 
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	        <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    </head>
    <body>
      
   
    <div class="page-wrapper">
        <header>
            <h3 class="logo-header"><a href="index.php"> Driver-Police Control System</a></h3>
                <nav class="nav-container">
                    <ul class="navbar_links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="driver/driver_login.php">Driver</a></li>
                        <li><a href="police/police_login.php">Police</a></li>
                        <li><a href="admin/admin_login.php">Admin</a></li>
                    </ul>
                </nav>
                <a class="contact-btn" href="contact_page.php"><button>Contact</button></a>
        </header>
        <div class="con">
        <div class="cont">
          <p>Welcome <span class="typed-text"></span><span class="cursor">&nbsp;</span></p>
        </div>
      </div>
       
        
        <section class="login-section">
          <div class ="buton-area">
            <br>
            <br>
            <br>
            <br>
            <br>
            <h1><p>&nbsp;Driver Login Support:</p></h1>
            <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Already Registered As Driver</h2>
          <div class="buttons">
            <a href="driver/driver_login.php"><button>Click Here</button></a>
            <br>
            <h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Not Register yet? </h2>
            <a href="driver/driver_registration.php"><button>Register</button></a>
          </div>
        </div>
          <script>
            const typedTextSpan = document.querySelector(".typed-text");
const cursorSpan = document.querySelector(".cursor");

const textArray = ["To Driver Police Inter Active System!", "To Driver Police Inter Active System!", "To Driver Police Inter Active System!", "To Driver Police Inter Active System!"];
const typingDelay = 200;
const erasingDelay = 100;
const newTextDelay = 2000; // Delay between current and next text
let textArrayIndex = 0;
let charIndex = 0;

function type() {
  if (charIndex < textArray[textArrayIndex].length) {
    if(!cursorSpan.classList.contains("typing")) cursorSpan.classList.add("typing");
    typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
    charIndex++;
    setTimeout(type, typingDelay);
  } 
  else {
    cursorSpan.classList.remove("typing");
  	setTimeout(erase, newTextDelay);
  }
}

function erase() {
	if (charIndex > 0) {
    if(!cursorSpan.classList.contains("typing")) cursorSpan.classList.add("typing");
    typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex-1);
    charIndex--;
    setTimeout(erase, erasingDelay);
  } 
  else {
    cursorSpan.classList.remove("typing");
    textArrayIndex++;
    if(textArrayIndex>=textArray.length) textArrayIndex=0;
    setTimeout(type, typingDelay + 1100);
  }
}

document.addEventListener("DOMContentLoaded", function() { // On DOM Load initiate the effect
  if(textArray.length) setTimeout(type, newTextDelay + 250);
});


          </script>
           
               
            </div>
            <script>
                const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});
            </script>
            
        </section>
</div>
<!------------------------------Ranking Table/Showing top -10 Driver based on their points------------->
<div>
<table class="content-table">
  <thead>
    <tr>
      <th>#Rank</th>
      <th>Name</th>
      <th>Driver Id</th>
      <th>Current Point</th>
      <th>No of Cases</th>
    </tr>
  </thead>
      <tbody>
                       <?php
                                //Joining two table Based on Email to retrieve data
                                //query to show data in rank table
                                  $query="SELECT  DISTINCT `Email`,`Driver_Id`,`First_Name`,`Last_Name`,`Point`,`Issue_Date_Time`,`No_Of_Cases`,caseissue.`Driver_Email_Fk`,ROW_NUMBER() OVER (PARTITION  BY `Point` ORDER BY `Point`DESC) AS `Rank`  FROM (`account` INNER JOIN `driver` ON `Email`=`Driver_Email_Fk`)  JOIN `caseissue` ON driver.`Driver_Email_Fk`=caseissue.`Driver_Email_Fk` GROUP BY caseissue.`Driver_Email_Fk` ORDER BY `No_Of_Cases` ASC,`Issue_Date_Time` ASC  LIMIT 10";
                                  $resultQuery=mysqli_query($dbConnect,$query);
                                  while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?= $rowValues['Rank']?></td>
                                            <td><?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></td>
                                            <td><?= ucwords($rowValues['Driver_Id'])?></td>
                                            <td><?= $rowValues['Point']?>/15</td>
                                            <td><?= $rowValues['No_Of_Cases']?></td>
                                            
                                        </tr>

                                    <?php
                                }

                        ?>

      </tbody>
      <thead>
    <tr>
      <th>#Rank</th>
      <th>Name</th>
      <th>Driver Id</th>
      <th>Current Point</th>
      <th>No of Cases</th>
    </tr>
  </thead>
  
 
  
</table>
  
</div>   
    
    <br><br>   
 
    <div id ="cent">
        <div class="container">

            <div class="s-box">
      
              <div class="imgBx">
      
                <img src="img/AdminS.jpg">
      
              </div>
      
              <div class="content">
      
                <h3>About Admin Policy</h3>
      
                <p>Admin should Respact his work and rules regulations. Admin should not do any illegal activities contray especially cyber crime.
                  Admin's job is to monitor and help the other types of users in such help and guide them to what the need. Admin needs to collaborate with police to maintain proper process.Management of office equipment.
                  Maintaining a clean and enjoyable working environment. Handling external or internal communication or management system.<br> 
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for reading.
                
                </p>
      
              </div>
      
            </div>
            <div class="s-box">

                <div class="imgBx">
        
                  <img src="img/PoliceS.jfif">
        
                </div>
        
                <div class="content">
                   <h3>About Police Policy</h3>
                  <p>Police should Respact his work and rules regulations. POlice should not do any illegal activities.Police officers are tasked with maintaining order and keeping their communities safe. The term police officer covers a wide variety of roles, including behind the scenes work like handwriting analysis and officer training. Attending a recruitment event in your local area can help you learn more about all the potential paths.
                    Police officers can work for the city, county, state, or federal government.<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for reading.
                 
        
                </div>
        
              </div>
        
              <div class="s-box">
        
                <div class="imgBx">
        
                  <img src="img/DriverS.jpg">
        
                </div>
        
                <div class="content">
        
                  <h3>About Driver Policy</h3>
        
                  <p>Driver should Respact his work and rules regulations. Driver should not do any illegal activities.Driving for work involves a risk not only for drivers, but also for fellow workers and members of the public, such as pedestrians and other road users. As an employer or self-employed person, you must, by law, manage the risks that may arise when you or your employees drive for work.<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for reading</p>
        
                </div>
        
              </div>
      
          </div>
        </div>
         <br>
         <br>
         <br>
      
         
         <br>
         <br>
         <br>
         <br><br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
      
         <br>
         <br>
         <br>
      
         
         <br>
         <br><br>
         <br>
         <br>
      
         
         <br>
         <br>
         <br>
         <br>
                                
        <div id="clock">
            
            <div id="time">
            <div><span id="hour">00</span><span>Hours</span></div>
            <div><span id="minutes">00</span><span>Minutes</span></div>
            <div><span id="seconds">00</span><span>Seconds</span></div>
            <div><span id="ampm">AM</span></div>
        </div> 
        </div>
        <script type="text/javascript">
        function clock(){
            var hours = document.getElementById('hour');
            var Minutes = document.getElementById('minutes');
            var seconds = document.getElementById('seconds');
            var ampm = document.getElementById('ampm');
        var h = new Date().getHours();
        var m = new Date().getMinutes();
        var s = new Date().getSeconds();
        var am = "AM";
           if(h > 12){
               h = h - 12;
              var am = "PM"
           }
           h = (h < 10) ? "0" + h : h
           m = (m < 10) ? "0" + m : m
           s = (s < 10) ? "0" + s : s

         hours.innerHTML = h;
         minutes.innerHTML = m;
         seconds.innerHTML = s;
         ampm.innerHTML = am;
        }
         var interval = setInterval(clock, 1000);

         
        </script>  
         <br>
        <br>
        <br>
        <div class="middle">
            <a class="btn" href="#">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a class="btn" href="#">
              <i class="fab fa-twitter"></i>
            </a>
            <a class="btn" href="#">
              <i class="fab fa-google"></i>
            </a>
            <a class="btn" href="#">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="btn" href="#">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
          <br/>
         <br>

         <footer class="footer-distributed">
 
          <div class="footer-left">
              <img src="">
            <h3><span>Driver Police Inter Active System</span></h3>
     
            
     
            <p class="footer-company-name">© ODPIAS Pvt. Ltd.</p>
          </div>
     
          <div class="footer-center">
            <div>
              <i class="fa fa-map-marker"></i>
                <p><span>
                 Dhaka,Bangladesh.
                 </span>
                </p>
            </div>
     
            <div>
              <i class="fa fa-phone"></i>
              <p>+91 22-27782183</p>
            </div>
            <div>
              <i class="fa fa-envelope"></i>
              <p><a href="mailto:support@eduonix.com">DriverPolice@gmail.com</a></p>
            </div>
          </div>
          <div class="footer-right">
            <p class="footer-company-about">
              <span>About the company</span>
              We offer Police Driver Traffic Organizing System.</p>
            
          </div>
        </footer>
         
         

</body>  

</html>