<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_login.php');
    }
    $sessionEmail=$_SESSION['DRIVER_LOGIN'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_css/driver_case_log.css">
    <!------------------Jquery Latest Cdn Script--------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!------------------Font Awesome Cdn Script--------------------------------->
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!--Datatable script-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function(){
            $(".hamburger").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
    </script>
    <title>Driver Case Log Page</title>
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
                <li><a href="driver_profile.php">
                    <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                    <span class="title">Profile</span>
                </a></li>
                <li><a href="driver_edit_profile.php">
                    <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Profile</span>
                </a></li>
                <li><a href="driver_case_log.php" class="active">
                    <span class="icon"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                    <span class="title">Case Log</span>
                </a></li>
              
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
         

             <!------------------Driver Tabele------------------------>
    <div class="item driver-table-box">
                <h4>List of Traffic Rule</h4>
                <div class="table-container">
                    <table id="caseLogTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Issue Date</th>
                                <th>Issue Place</th>
                                <th>Deducted Point</th>
                                <th>Issued By</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <!---------PHP CODE TO SHOW DATA INTO TABLE FROM DATABASE------------->
                            
                            <?php
                                //Joining two table Based on Email to retrieve data
                                $query="SELECT * FROM `caseissue` WHERE `Driver_Email_Fk`='$sessionEmail'";
                                $resultQuery=mysqli_query($dbConnect,$query);
                                while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?= date('d-M-Y',strtotime($rowValues['Issue_Date']))?></td>
                                            <td><?= ucwords($rowValues['Issue_Place'])?></td>
                                            <td><?= $rowValues['Deducted_Point']?></td>
                                            <td><?= ucwords($rowValues['Police_Email_Fk'])?></td>
                                            
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Issue Date</th>
                                <th>Issue Place</th>
                                <th>Deducted Point</th>
                                <th>Issued By</th>
                            
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>

            
        </div> <!--main page container ends--->
    </div> <!---page wrapper ends--->
   
    <script>
         $(document).ready(function() {
        $('#caseLogTable').DataTable();
    } );
    </script>
    
</body>
</html>