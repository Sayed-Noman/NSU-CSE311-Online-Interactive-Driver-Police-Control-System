<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
   }
    /*-----------------------Total No of Driver/Police/No Cases Filled----------------------*/
   $DriverCountQuery=$dbConnect->query("SELECT * FROM `driver`");
   $PoliceCountQuery=$dbConnect->query("SELECT * FROM `police`");
   $AdminCountQuery=$dbConnect->query("SELECT * FROM `admin`");
   $RequestCountQuery=$dbConnect->query("SELECT * FROM `request`");
   $TotalDriverCount=mysqli_num_rows($DriverCountQuery);
   $TotalPoliceCount=mysqli_num_rows($PoliceCountQuery);
   $TotalAdminCount=mysqli_num_rows($AdminCountQuery);
   $TotalRequestCount=mysqli_num_rows($RequestCountQuery);
    
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_dashboard_home_css.css">
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
    <title>Admin Dashboard Home</title>
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
            <li><a href="admin_dashboard_home.php" class="active">
                    <span class="icon"><i class="fas fa-house-user" aria-hidden="true"></i></span>
                    <span class="title">Home</span>
                </a></li>
                <li><a href="admin_profile.php">
                    <span class="icon"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
                    <span class="title">Profile</span>
                </a></li>
                <li><a href="admin_edit_profile.php">
                    <span class="icon"><i class="fas fa-user-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Profile</span>
                </a></li>
                <li><a href="admin_edit_driver.php">
                    <span class="icon"><i class="far fa-car" aria-hidden="true"></i></span>
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
            <div class="item widget-menu">
            <div>
            <div class="row">
                <div class="column">
                    <div class="card">
                    <p><i class="fa fa-users"></i></p>
                    <h3><?=$TotalRequestCount?></h3>
                    <p>Request</p>
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

            
            <div class="column">
                <div class="card">
                <p><i class="fa fa-user-secret"></i></p>
                <h3><?=$TotalAdminCount?></h3>
                <p>Admin</p>
                </div>
            </div>
            </div> 
                </div>
            </div>


<!-------------All Account Table Contents------------->
<div class="item account-table-box">
                <h4>All Accounts of Users</h4>
                <div class="table-container">
                    <table id="accountTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Nid</th>
                                <th>User Type</th>
                                <th>Action</th>
                                    
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!---------PHP CODE TO SHOW DATA INTO TABLE FROM DATABASE------------->
                            
                            <?php
                                $query="SELECT * FROM `account`";
                                $resultQuery=mysqli_query($dbConnect,$query);
                                while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></td>
                                            <td><?= ucwords($rowValues['Email'])?></td>
                                            <td><?= $rowValues['Gender']?></td>
                                            <td><?= date('d-M-Y',strtotime($rowValues['Birth_Date']))?></td>
                                            <td><?= $rowValues['Nid']?></td>
                                            <td><?= $rowValues['User_Type']?></td>
                                            <td  class="action-link">
                                                <a href="admin_account_quick_view.php?accountQuickView=<?= base64_encode($rowValues['Email'])?>" target="_blank">View</a>
                                                <a href="admin_php/account_delete_php.php?accountDelete=<?= base64_encode($rowValues['Email'])?>" onclick="return confirm('Are You Sure You Want to Accept This Request?')" >Delete</a>
                                            </td>
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Nid</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>

             <!------------------Driver Tabele------------------------>
    <div class="item driver-table-box">
                <h4>All Accounts of Driver</h4>
                <div class="table-container">
                    <table id="driverTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Driver ID</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>No of Cases</th>
                                <th>Points</th>
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
                                            <td><?= $rowValues['No_Of_Cases']?></td>
                                            <td><?= $rowValues['Point']?></td>
                                            <td  class="action-link">
                                                <a href="admin_driver_quick_view.php?driverQuickView=<?= base64_encode($rowValues['Email'])?>" target="_blank">View</a>
                                            </td>
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                            <th>Name</th>
                                <th>Driver ID</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>No of Cases</th>
                                <th>Points</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>
<!-------------------------Police All Account Table--------------------->
        <div class="item police-table-box">
                <h4>All Accounts of Police</h4>
                <div class="table-container">
                    <table id="policeTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Badge Id</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Region Of Work</th>
                                <th>Action</th>
                                    
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!---------PHP CODE TO SHOW DATA INTO TABLE FROM DATABASE------------->
                            
                            <?php
                                $query="SELECT * FROM `account` INNER JOIN `police` ON `Email`=`Police_Email_Fk`";
                                $resultQuery=mysqli_query($dbConnect,$query);
                                while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?=ucwords( $rowValues['First_Name'] . ' '. $rowValues['Last_Name'])?></td>
                                            <td><?= ucwords($rowValues['Badge_Id'])?></td>
                                            <td><?= ucwords($rowValues['Email'])?></td>
                                            <td><?= $rowValues['Gender']?></td>
                                            <td><?= ucwords($rowValues['Police_Department'])?></td>
                                            <td><?= ucwords($rowValues['Region_Of_Work'])?></td>
                                            <td  class="action-link">
                                                <a href="admin_police_quick_view.php?policeQuickView=<?= base64_encode($rowValues['Email'])?>" target="_blank">View</a>
                                            </td>
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Badge Id</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Region Of Work</th>
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
        $('#accountTable').DataTable();
    } );
    </script>
    <script>
         $(document).ready(function() {
        $('#driverTable').DataTable();
    } );
    </script>
    <script>
         $(document).ready(function() {
        $('#policeTable').DataTable();
    } );
    </script>
</body>
</html>