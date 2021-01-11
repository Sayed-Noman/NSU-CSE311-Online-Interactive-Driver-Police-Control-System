<?php
    require_once 'php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
   

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Contact Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/contact_page_css.css">
        <script  src="https://kit.fontawesome.com/a81368914c.js"></script>
        <!-- Google Fonts Links-->
        <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@700&display=swap" rel="stylesheet">
        	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
 
	<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
 
    </head>
    <body>
      
    </div>
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
           
         <div class="box">
            <p class="heading">FAQs</p>
            <div class="faqs">
               <details>
                  <summary>What is Driver Police Interactive system?</summary>
                  <p class="text">It is a Website where you can monitor and maintain the Traffic rules and penalty</p>
               </details>
               <details>
                  <summary>What is this page about?</summary>
                  <p class="text">monitoring and maintaining "Traffic rules and penalty"</p>
               </details>
               <details>
                  <summary>What is The rule and regulations?</summary>
                  <p class="text">Respact others users and obey the policy.
                    Do not chose illegal Activies.
                  </p>
               </details>
            </div>
         </div>
         
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