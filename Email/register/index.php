<?php
/**
 * Created by PhpStorm.
 * User: BT
 * Date: 09/11/2016
 * Time: 12:04 PM
 */
require_once("../function/functions.php");
if(isset($_POST['reg'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $user = $_POST['user'];
    $pass = $_POST['psw'];
    $repass = $_POST['cpsw'];
    $mail = $_POST['mail'];
    if($pass == $repass){
        if(!func\functions::checkExistUser($user) && !func\functions::checkExistMail($mail)) {
            if (func\functions::commandDB("INSERT INTO Mail.user (first_name, last_name, username, password, backup_mail) VALUES ('$fname', '$lname', '$user', '$pass', '$mail')")) {
                if (func\functions::commandDB("CREATE TABLE IF NOT EXISTS Mail." . $user . "_message (`mykey` INT(11) NOT NULL AUTO_INCREMENT, `subject` VARCHAR(60) NOT NULL, `body` TEXT NOT NULL, `read_tag` TINYINT(4) NOT NULL, `status` TINYINT(4) NOT NULL, `file` TINYINT(4) NOT NULL, `username` TEXT NOT NULL, `username_to` TEXT NOT NULL, `username_from` TEXT NOT NULL, `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`mykey`));")) {
                    echo "ok";
                }
                if (func\functions::commandDB("CREATE TABLE IF NOT EXISTS Mail." . $user . "_attachment (`id` INT(11) NOT NULL AUTO_INCREMENT,`filename` VARCHAR(40) NOT NULL,`filebyte` LONGBLOB NOT NULL,`message_id` INT(11) NOT NULL, `size` INT(11) NOT NULL, PRIMARY KEY (`id`))")) {
                    echo "ok";
                }
                header("location: ../login");
            } else {
                $msg = "Something Is Wrong!";
            }
        }
    }else{
        $msg = "Password not match with Confirm!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | Email Project</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../theme/docs.min.css"/>


    <style>
        /* For example page only. Not part of cruddy. */
        body{ margin: 40px 0 200px 0}
    </style>
</head>
<body>
    <form method="post">
        <center>
            <div class="bd-callout bd-callout-warning" style="width: 30%; padding: 2%;">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-user"></i></span>
                    <input type="text" name="fname" class="form-control" placeholder="First name" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-user"></i></span>
                    <input type="text" name="lname" class="form-control" placeholder="Last name" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-user"></i></span>
                    <input type="text" name="user" class="form-control" placeholder="Username" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-lock"></i></span>
                    <input type="password" name="psw" class="form-control" placeholder="PassWord" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-lock"></i></span>
                    <input type="password" name="cpsw" class="form-control" placeholder="Confirm PassWord" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-fw fa-envelope"></i></span>
                    <input type="text" name="mail" class="form-control" placeholder="Backup Email" aria-describedby="sizing-addon2">
                </div>
                <br/>
                <input value="Sign Up" name="reg" class="btn btn-primary" style="width: 100%;" type="submit"/>
                <br/>
                <?php
                if(isset($msg)){
                    echo "<p style='color: red; font-weight: bold;'>".$msg."</p>";
                }
                ?>
            </div>
        </center>
    </form>
</body>
</html>

