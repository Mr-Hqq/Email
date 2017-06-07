<?php
/**
 * Created by PhpStorm.
 * User: BT
 * Date: 09/11/2016
 * Time: 12:04 PM
 */
require_once("../function/functions.php");
session_start();
if(isset($_POST['submit'])){
    if(isset($_GET['redirect']) && $_GET['redirect'] == "admin"){
        $user = $_POST['user'];
        $psw = $_POST['pasw'];
        if($user == "admin" && $psw == "admin"){
            $_SESSION['log-admin'] = $user;
            //header("Location: ../admin");
        }
    }else {
        $user = $_POST['user'];
        $psw = $_POST['pasw'];
        if ($user != "" && $psw != "") {
            if (!func\functions::Login("SELECT password FROM Mail.user WHERE username='$user';") == $psw) {
                $msg = "Wrong Password Or Username!";
            } else {
                $_SESSION['log-user'] = $user;
                header("Location: ../");
            }
        } else {
            $msg = "Fill All Field!";
        }
    }
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


    <style>
        /* For example page only. Not part of cruddy. */
        body{ margin: 40px 0 200px 0}
    </style>
</head>
<body>
<form method="post">
<div class="bd-callout bd-callout-warning" style="float: right; width: 30%; margin-right: 30px; padding: 2%;">
    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2">Username</span>
        <input type="text" class="form-control" name="user" placeholder="Username" aria-describedby="sizing-addon2">
    </div>

    <br/>
    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2">Password</span>
        <input type="password" class="form-control" name="pasw" placeholder="PassWord" aria-describedby="sizing-addon2">
    </div>
    <br/>
    <br/>
    <input class="btn btn-primary" style="width: 100%;" name="submit" value="Login" type="submit"/>
    <br/>
    <br/>
    <?php
        if(isset($msg)){
            echo "<p style='color: red; font-weight: bold;'>".$msg."</p>";
        }
    ?>
    <hr/>
    <br/>
    <div class="alert alert-info" role="alert">
        <a href="../register" class="alert-link">Sign Up?</a>
    </div>
    <br/>
    <hr/>
    <br/>
    <br/>
    <a href="#" class="alert-link">Forget Your PassWord?</a>
</div>
<div style="float: left; margin-left: 20%; text-align: center;margin-top: 15%;">
    <div class="card card-block">
        <p class="card-text">Powered By Css3 PHP 5 And BootStrap</p>
    </div>
</div>
    </form>
</body>
</html>
