<?php
    require_once '../php/dbConnect.php';
    session_start();//Starting session
    //IF Driver Tries to access this page without login the he will be redirected to Login Page
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        header('location:admin_login.php');
    }
    //Function to Generate Uniqe Rule id
    function generateUniqeId($prefix){
        $year=date('y');
        $month=date('m');
        $date=date('d');
        $randValue= sprintf("%04d", rand(0,9999));
        $uniqeId=$prefix . '-' . $year . $month . $date .'-'. $randValue;

        return $uniqeId;
    }

    if(isset($_POST['addTrafficRule'])){
        //Retrieving Session Email
        $sessionEmail=$_SESSION['ADMIN_LOGIN'];
        $Added_By_Email=$sessionEmail;

        //Traffic Rule Table Values
        $Rule_Name=$dbConnect->real_escape_string($_POST['Rule_Name']);
        $Deductable_Point=(float)$dbConnect->real_escape_string($_POST['Deductable_Point']);
        $Rule_Description=$dbConnect->real_escape_string($_POST['Rule_Description']);

        //variabes
        $prefix="T";
        $Rule_Id;
        $count;
        
        do{
            $Rule_Id=generateUniqeId($prefix);
            //print_r($Driver_Id);
            $query="SELECT COUNT(*) AS `idCount` FROM `trafficrule` WHERE `Rule_Id`='$Rule_Id'";
            $queryResult=$dbConnect->query($query);
            $numRows=mysqli_fetch_array($queryResult);
            $count=$numRows['idCount'];
            //print_r($count);
        }while($count!=0);

        $trafficRulInsertQuery="INSERT INTO `trafficrule`(`Rule_Id`, `Rule_Name`, `Rule_Description`, `Deductable_Point`, `Admin_Email_Fk`) VALUES ('$Rule_Id','$Rule_Name','$Rule_Description',$Deductable_Point,(SELECT `Admin_Email_FK` FROM `admin` WHERE `Admin_Email_FK`='$Added_By_Email'))";
        print_r($trafficRulInsertQuery);
        $dbConnect->query($trafficRulInsertQuery);
        $dbConnect->commit();
        header('location:admin_add_traffic_rules.php');

    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_css/admin_add_traffic_rules.css">
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
    <title>Admin Add Traffic Rules</title>
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
                <li><a href="admin_edit_police.php">
                    <span class="icon"><i class="fas fa-edit" aria-hidden="true"></i></span>
                    <span class="title">Edit Police</span>
                </a></li>
                <li><a href="admin_add_traffic_rules.php" class="active">
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
         

             <!------------------Driver Tabele------------------------>
    <div class="item driver-table-box">
                <h4>List of Traffic Rule</h4>
                <div class="table-container">
                    <table id="trafficRuleTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Rule Id</th>
                                <th>Rule Name</th>
                                <th>Description</th>
                                <th>Deductable Point</th>
                                <th>Added By</th>
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <!---------PHP CODE TO SHOW DATA INTO TABLE FROM DATABASE------------->
                            
                            <?php
                                //Joining two table Based on Email to retrieve data
                                $query="SELECT * FROM `trafficrule`";
                                $resultQuery=mysqli_query($dbConnect,$query);
                                while($rowValues=mysqli_fetch_assoc($resultQuery)){
                                    ?>
                                        <tr>
                                            <td><?=ucwords( $rowValues['Rule_Id'])?></td>
                                            <td><?= ucwords($rowValues['Rule_Name'])?></td>
                                            <td><?= ucwords($rowValues['Rule_Description'])?></td>
                                            <td><?= $rowValues['Deductable_Point']?></td>
                                            <td><?= ucwords($rowValues['Admin_Email_Fk'])?></td>
                                            <td  class="action-link">
                                            <a href="admin_php/delete_traffic_rule_php.php?deleteTrafficRule=<?= base64_encode($rowValues['Rule_Id'])?>" onclick="return confirm('Are You Sure You Want to Delete This Request?')" >Delete</a>
                                            </td>
                                            
                                        </tr>

                                    <?php
                                }

                            ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Rule Id</th>
                                <th>Rule Name</th>
                                <th>Description</th>
                                <th>Deductable Point</th>
                                <th>Added By</th>
                                <th>Action</th> 
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>


            <!------------------Add Traffic Rule Window--------------------------------->
            <div class="item">
            <h2>Add Traffic Rule</h2>
            <br>
            <center>
            <form  method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <h4>Rule Name:</h4> <input class="login-form__input" type="text" name="Rule_Name" placeholder="Enter Rule Name">
                        <br>
                    <h4>Deductable Point:</h4> <input class="login-form__input" type="text" name="Deductable_Point" placeholder="Enter Deductable Point">
                        <br>
                    <h4>Rule Description:</h4> <textarea class="login-form__input" type="text" name="Rule_Description" placeholder="Enter Rules Description"></textarea>
                        <br>
                        <br>
                        <button class="login-form__button4"  name="addTrafficRule" type="submit">Submit</button>
                </form>
            
                </center>

            </div>

            
        </div> <!--main page container ends--->
    </div> <!---page wrapper ends--->
   
    <script>
         $(document).ready(function() {
        $('#trafficRuleTable').DataTable();
    } );
    </script>
    
</body>
</html>