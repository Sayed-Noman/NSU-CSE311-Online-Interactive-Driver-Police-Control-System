<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['DRIVER_LOGIN'])){
        header('location:driver_login.php');
    }
    $sessionEmail=$_SESSION['DRIVER_LOGIN'];
     /*-----------------------Total No of Driver/Police/No Cases Filled----------------------*/
     $DriverCountQuery=$dbConnect->query("SELECT * FROM `driver`");
     $PoliceCountQuery=$dbConnect->query("SELECT * FROM `police`");
     $AdminCountQuery=$dbConnect->query("SELECT * FROM `admin`");
     $DriverCasePointCountQuery=$dbConnect->query("SELECT `No_Of_Cases`,`Point` FROM `driver` WHERE `Driver_Email_Fk`='$sessionEmail'");
     $TotalDriverCount=mysqli_num_rows($DriverCountQuery);
     $TotalPoliceCount=mysqli_num_rows($PoliceCountQuery);
     $TotalNoOFCasePointCountResult=mysqli_fetch_assoc($DriverCasePointCountQuery);
     $TotalNoOFCases=$TotalNoOFCasePointCountResult['No_Of_Cases'];
     $TotalPoint=$TotalNoOFCasePointCountResult['Point'];
     //print_r($TotalNoOFCases);
     //print_r($TotalDriverCount);
     //print_r($TotalAdminCount);
    //print_r($TotalPoliceCount);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_css/driver_dashboard_home_css.css">
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
    <title>Driver DashBoard Home</title>
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
                <li><a href="driver_dashboard_home.php" class="active">
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
                <li><a href="driver_case_log.php">
                    <span class="icon"><i class="fas fa-clipboard-list" aria-hidden="true"></i></span>
                    <span class="title">Case Log</span>
                </a></li>

            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
            <div class="item widget-menu">
                <div>
            <div class="row">
  <div class="column">
    <div class="card">
      <p><i class="fa fa-calculator"></i></p>
      <h3><?=$TotalPoint?></h3>
      <p>Current Point</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <p><i class="fa fa-calendar"></i></p>
      <h3><?=$TotalNoOFCases?></h3>
      <p>#Case</p>
    </div>
  </div>
  <div class="column">
    <div class="card">
      <p><i class="fa fa-car"></i></p>
      <h3><?=$TotalDriverCount?></h3>
      <p>Driver</p>
    </div>
  </div>

  
  <div class="column">
    <div class="card">
      <p><i class="fa fa-user"></i></p>
      <h3><?=$TotalPoliceCount?></h3>
      <p>Police</p>
    </div>
  </div>
</div> 
    </div>
</div>
<!----------------------------Show Massage In Div------------------------------------->
<div class="item widget-menu">
                <?php
                        $getDriverPoinQuery="SELECT * FROM `driver` WHERE `Driver_Email_Fk`='$sessionEmail'";
                        $queryResult=$dbConnect->query($getDriverPoinQuery);
                        $resultRow=mysqli_fetch_assoc($queryResult);
                        $currentPoint=intVal($resultRow['Point']);
                        $message='';
                        if($currentPoint==15){
                            $message="You Havent Lose Any Point Yet.Try to keep it Up.";
                        }
                        if($currentPoint>12 && $currentPoint<14.9){
                            $message="You Are Losing Point.Try to be cautious.";
                        }
                        if($currentPoint>8 && $currentPoint<=11.9){
                            $message="You Have Lost Several Point.Try to Hold into This State";
                        }
                        if($currentPoint>3 && $currentPoint<=8){
                            $message="You Have Lost too Many Point.Loosing More Points will Cost your License";
                        }
                        if($currentPoint>=1 && $currentPoint<=3){
                            $message="You Are 1 Point Behind to Lose Your License";
                        }
                        if($currentPoint>=1 && $currentPoint<=3){
                            $message="You Are No Longer Eligible to Drive";
                        }

                ?>

                <h3>Message From Admin Regarding Your Status:<?=$message?></h3>
</div>


             <!------------------Driver Tabele------------------------>
    <div class="item driver-table-box">
                <h4>All Accounts of Driver</h4>
                <div class="table-container">
                    <table id="driverTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Driver Id</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>License Type</th>
                                <th>Point</th>
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <!---------PHP CODE TO SHOW DATA INTO TABLE FROM DATABASE------------->
                            
                            <?php
                                //Joining two table Based on Email to retrieve data
                                $query="SELECT * FROM `account` INNER JOIN `driver` ON `Email`=`Driver_Email_Fk`";
                                $resultQuery=mysqli_query($dbConnect,$query);
                                while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></td>
                                            <td><?= ucwords($rowValues['Driver_Id'])?></td>
                                            <td><?= ucwords($rowValues['Email'])?></td>
                                            <td><?= $rowValues['Gender']?></td>
                                            <td><?= $rowValues['License_Type']?></td>
                                            <td><?= $rowValues['Point']?>/15</td>
                                            <td  class="action-link">
                                                <a href="driver_driver_quick_view.php?driverQuickView=<?= base64_encode($rowValues['Email'])?>" target="_blank">View</a>
                                            </td>
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Driver Id</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>License Type</th>
                                <th>Point</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>


            

            
        </div> <!--main page container ends--->
    </div> <!---page wrapper ends--->
   
    <script>
         $(document).ready(function() {
        $('#driverTable').DataTable();
    } );
    </script>

    
</body>
</html>