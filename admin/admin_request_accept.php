<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Admin Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_request_accept.css">
    <!------------------Jquery Latest Cdn Script--------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!------------------Jquery Latest Cdn Script--------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!------------------Font Awesome Cdn Script--------------------------------->
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!--Datatable script-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".hamburger").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
    </script>
    <title>Admin Request Accept Page</title>
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
                <li><a href="admin_dashboard_home.php" >
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
                    <span class="icon"><i class="far fa-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Driver</span>
                </a></li>
                <li><a href="admin_edit_profile.php">
                    <span class="icon"><i class="fas fa-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Police</span>
                </a></li>
                <li><a href="admin_add_traffic_rules.php">
                    <span class="icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                    <span class="title">Traffic Rule</span>
                </a></li>
                <li><a href="admin_request_accept.php"class="active">
                    <span class="icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                    <span class="title">Requests</span>
                </a></li>
                
            </ul>
        </div>
        <!------------------Main Page Container Section--------------------------------->
        <div class="main_container">
            <div class="item request-table-box">
                <h4>User Requests</h4>
                <div class="table-container">
                    <table id="example" class="display" style="width:100%">
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
                                $query="SELECT * FROM `request`";
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
                                                <a href="admin_request_quick_view.php?requestQuickView=<?= base64_encode($rowValues['Email'])?>" target="_blank">View</a>
                                                <a href="admin_php/request_accept_php.php?requestAccept=<?= base64_encode($rowValues['Email'])?>" onclick="return confirm('Are You Sure You Want to Accept This Request?')" >Accept</a>
                                                <a href="admin_php/request_delete_php.php?requestDelete=<?= base64_encode($rowValues['Email'])?>" onclick="return confirm('Are You Sure You Want to Reject This Request?')" >Reject</a>
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
        </div>
    </div>
    <script>
         $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>

     

</body>
</html>