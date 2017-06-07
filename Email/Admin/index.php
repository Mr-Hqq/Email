<?php
/**
 * Created by PhpStorm.
 * User: Ehem
 * Date: 10/15/2016
 * Time: 08:13 PM
 */
require_once("../function/functions.php");
session_start();
if(!isset($_SESSION['log-admin'])){
    header("location: ../login/index.php?redirect=admin");
}

if(isset($_GET['lo'])){
    session_destroy();
    header("location: ../login");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Email Project</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../theme/docs.min.css"/>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">



    <style>
        /* For example page only. Not part of cruddy. */
        body{ margin: 40px 0 200px 0}
    </style>
</head>
<body>
<form method="post">
    <a name="lout" style="margin-left: 5%; text-align:center; margin-top: 10px;" href="index.php?lo=0"><i class="fa fa-sign-out" aria-hidden="true"> Admin</i></a>
    <div style="margin-left: 5%; width: 25%; float: left; text-align:center; position:absolute; margin-top: 10px;">
        <div class="card card-block">
            <p class="card-text">User Count : <?php echo func\functions::getUserCount(); ?></p>
        </div>
    </div>
    <div style="margin-right: 5%; float: right; width: 60%; height: 100%; text-align: center;margin-top: 10px;">
        <div class="card card-block" style="height: 100%;">
            <table class="table" >
                <thead class="thead-inverse">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Back Up Mail</th>
                </tr>
                </thead>
                <tbody style="cursor: pointer;">
                <tr id="ehem">
                    <?php
                    $con = mysqli_connect(func\DB::getHost(),func\DB::getUser(),func\DB::getPasw(),func\DB::getDbname());
                    if($con->connect_error){
                        die("Conenction Error : ".$con->connect_error);
                    }
                    $rslt = $con->query("SELECT * FROM Mail.user");
                    if(is_object($rslt) && $rslt->num_rows > 0){
                        while($row = $rslt->fetch_assoc()){
                                echo "<tr><td> " . $row['first_name'] . " " . $row['last_name'] . " </td><td>" . $row['username'] . "</td><td>" . $row['backup_mail'] . "</td></tr>";
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>
