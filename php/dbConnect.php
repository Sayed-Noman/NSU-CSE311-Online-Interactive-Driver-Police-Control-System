<?php
    
    //Defining varables to hold connection parameter
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','');
    define('DBNAME','driver-police-control-system');

    //Creating a connection Variable
    $dbConnect= mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
   
?>
