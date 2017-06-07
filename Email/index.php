<?php
/**
 * Created by PhpStorm.
 * User: BT
 * Date: 09/11/2016
 * Time: 12:02 PM
 */
require_once("function/functions.php");
session_start();



if(!isset($_SESSION['log-user'])){
    header("location: login");
}
if(isset($_GET['lo'])){
    session_destroy();
    header("location: login");
    die();
}
if(isset($_POST['down'])){
    func\functions::downLoad($_POST['mykey']);
}
if(isset($_POST['send'])){
    $sub = $_POST['subject'];
    $to = $_POST['to'];
    $body = $_POST['body'];
    $user_s = $_SESSION['log-user'];
    if(func\functions::checkExistUser($to)) {
        if (isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['body'])) {
            if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {
                $file = 1;
            } else {
                $file = 0;
            }
            $Message_ids = func\functions::Send("INSERT INTO Mail." . $user_s . "_message (subject, body, read_tag, status, file, username, username_to, username_from) VALUES ('$sub', '$body', '0', '2','$file', '$user_s', '$to', '$user_s')");
            $Message_idr = func\functions::Send("INSERT INTO Mail." . $to . "_message (subject, body, read_tag, status, file, username, username_to, username_from) VALUES ('$sub', '$body', '0', '1','$file', '$to', '$to', '$user_s')");

            if ($file == 1 && $Message_ids != null && $Message_idr != null) {
                $fileName = $_FILES['userfile']['name'];
                $tmpName = $_FILES['userfile']['tmp_name'];
                $size = $_FILES['userfile']['size'];

                $fp = fopen($tmpName, 'r');
                $content = fread($fp, $_FILES['userfile']['size']);
                $content = addslashes($content);
                fclose($fp);
                if (!get_magic_quotes_gpc()) {
                    $fileName = addslashes($fileName);
                }
                func\functions::commandDB("INSERT INTO Mail." . $user_s . "_attachment (filename, filebyte, message_id,size) VALUES ('$fileName', '$content', '$Message_ids', '$size')") && func\functions::commandDB("INSERT INTO Mail." . $to . "_attachment (filename, filebyte, message_id, size) VALUES ('$fileName', '$content', '$Message_idr', '$size')");
            }
        }
    }
    else{
        $msg = "This username does not exist!";
    }
}

if(isset($_POST['update'])){
    if(func\functions::getItemBy("first_name",$_SESSION['log-user']) != $_POST['fn']){
        func\functions::commandDB("UPDATE Mail.user SET first_name='" . $_POST['fn'] . "' WHERE username='" . $_SESSION['log-user'] . "'");
    }
    if(func\functions::getItemBy("last_name",$_SESSION['log-user']) != $_POST['ln']){
        func\functions::commandDB("UPDATE Mail.user SET last_name='" . $_POST['ln'] . "' WHERE username='" . $_SESSION['log-user'] . "'");
    }
    if(func\functions::getItemBy("password",$_SESSION['log-user']) != $_POST['pw']){
        func\functions::commandDB("UPDATE Mail.user SET password='" . $_POST['pw'] . "' WHERE username='" . $_SESSION['log-user'] . "'");
    }
    if(func\functions::getItemBy("backup_mail",$_SESSION['log-user']) != $_POST['be']){
        func\functions::commandDB("UPDATE Mail.user SET backup_mail='" . $_POST['be'] . "' WHERE username='" . $_SESSION['log-user'] . "'");
    }
}


?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo strtoupper($_SESSION['log-user']) . "[at]" . $_SERVER['HTTP_HOST']; ?> | Email Project</title>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"/>


    <!--- --->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link href="theme/assets/css/prettify.css" rel="stylesheet" type="text/css">
    <script src="theme/assets/js/prettify.js"></script>
    <link href="theme/assets/css/develop.css" rel="stylesheet" type="text/css">
    <link href="theme/neditor.min.css" rel="stylesheet" type="text/css">


    <!--- ---->
    <link type="text/css" rel="stylesheet" href="theme/style.css" />
    <link type="text/css" rel="stylesheet" href="theme/jquery.inputfile.css" />



    <style>
        /*-------------------------------*/
        /*           VARIABLES           */
        /*-------------------------------*/


        body {
            position: relative;
            overflow-x: hidden;
        }

        body, html {
            height: 100%;
            background-color: white;
        }

        .nav .open > a { background-color: transparent; }

        .nav .open > a:hover { background-color: transparent; }

        .nav .open > a:focus { background-color: transparent; }

        /*-------------------------------*/
        /*           Wrappers            */
        /*-------------------------------*/

        #wrapper {
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            -webkit-transition: all 0.5s ease;
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapper.toggled { padding-left: 220px; }

        #wrapper.toggled #sidebar-wrapper { width: 220px; }

        #wrapper.toggled #page-content-wrapper {
            margin-right: -220px;
            position: absolute;
        }

        #sidebar-wrapper {
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            -webkit-transition: all 0.5s ease;
            background: #1a1a1a;
            height: 100%;
            left: 220px;
            margin-left: -220px;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease;
            width: 0;
            z-index: 1000;
        }
        #sidebar-wrapper::-webkit-scrollbar {
            display: none;
        }

        #page-content-wrapper {
            padding-top: 70px;
            width: 100%;
        }

        /*-------------------------------*/
        /*     Sidebar nav styles        */
        /*-------------------------------*/

        .sidebar-nav {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            top: 0;
            width: 220px;
        }

        .sidebar-nav li {
            display: inline-block;
            line-height: 20px;
            position: relative;
            width: 100%;
        }

        .sidebar-nav li:before {
            -moz-transition: width 0.2s ease-in;
            -ms-transition: width 0.2s ease-in;
            -webkit-transition: width 0.2s ease-in;
            background-color: #1c1c1c;
            content: '';
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            -webkit-transition: width 0.2s ease-in;
            transition: width 0.2s ease-in;
            width: 3px;
            z-index: -1;
        }

        .sidebar-nav li:first-child a {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .sidebar-nav li:nth-child(2):before { background-color: #52418a; }

        .sidebar-nav li:nth-child(3):before { background-color: #5c499c; }

        .sidebar-nav li:nth-child(4):before { background-color: #6651ad; }

        .sidebar-nav li:nth-child(5):before { background-color: #7562b5; }

        .sidebar-nav li:nth-child(6):before { background-color: #8473be; }

        .sidebar-nav li:nth-child(7):before { background-color: #9485c6; }

        .sidebar-nav li:nth-child(8):before { background-color: #a396ce; }

        .sidebar-nav li:nth-child(9):before { background-color: #b2a7d6; }

        .sidebar-nav li:hover:before {
            -webkit-transition: width 0.2s ease-in;
            transition: width 0.2s ease-in;
            width: 100%;
        }

        .sidebar-nav li a {
            color: #dddddd;
            display: block;
            padding: 10px 15px 10px 30px;
            text-decoration: none;
        }

        .sidebar-nav li.open:hover before {
            -webkit-transition: width 0.2s ease-in;
            transition: width 0.2s ease-in;
            width: 100%;
        }

        .sidebar-nav .dropdown-menu {
            background-color: #222222;
            border-radius: 0;
            border: none;
            box-shadow: none;
            margin: 0;
            padding: 0;
            position: relative;
            width: 100%;
        }

        .sidebar-nav li a:hover, .sidebar-nav li a:active, .sidebar-nav li a:focus, .sidebar-nav li.open a:hover, .sidebar-nav li.open a:active, .sidebar-nav li.open a:focus {
            background-color: transparent;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-nav > .sidebar-brand {
            font-size: 20px;
            height: 65px;
            line-height: 44px;
        }

        /*-------------------------------*/
        /*       Hamburger-Cross         */
        /*-------------------------------*/

        .hamburger {
            background: transparent;
            border: none;
            display: block;
            height: 32px;
            margin-left: 15px;
            position: fixed;
            top: 20px;
            width: 32px;
            z-index: 999;
        }

        .hamburger:hover { outline: none; }

        .hamburger:focus { outline: none; }

        .hamburger:active { outline: none; }

        .hamburger.is-closed:before {
            -webkit-transform: translate3d(0, 0, 0);
            -webkit-transition: all 0.35s ease-in-out;
            color: #ffffff;
            content: '';
            display: block;
            font-size: 14px;
            line-height: 32px;
            opacity: 0;
            text-align: center;
            width: 100px;
        }

        .hamburger.is-closed:hover before {
            -webkit-transform: translate3d(-100px, 0, 0);
            -webkit-transition: all 0.35s ease-in-out;
            display: block;
            opacity: 1;
        }

        .hamburger.is-closed:hover .hamb-top {
            -webkit-transition: all 0.35s ease-in-out;
            top: 0;
        }

        .hamburger.is-closed:hover .hamb-bottom {
            -webkit-transition: all 0.35s ease-in-out;
            bottom: 0;
        }

        .hamburger.is-closed .hamb-top {
            -webkit-transition: all 0.35s ease-in-out;
            background-color: rgba(0, 0, 0, 0.7);
            top: 5px;
        }

        .hamburger.is-closed .hamb-middle {
            background-color: rgba(0, 0, 0, 0.7);
            margin-top: -2px;
            top: 50%;
        }

        .hamburger.is-closed .hamb-bottom {
            -webkit-transition: all 0.35s ease-in-out;
            background-color: rgba(0, 0, 0, 0.7);
            bottom: 5px;
        }

        .hamburger.is-closed .hamb-top, .hamburger.is-closed .hamb-middle, .hamburger.is-closed .hamb-bottom, .hamburger.is-open .hamb-top, .hamburger.is-open .hamb-middle, .hamburger.is-open .hamb-bottom {
            height: 4px;
            left: 0;
            position: absolute;
            width: 100%;
        }

        .hamburger.is-open .hamb-top {
            -webkit-transform: rotate(45deg);
            -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
            background-color: #000;
            margin-top: -2px;
            top: 50%;
        }

        .hamburger.is-open .hamb-middle {
            background-color: #000;
            display: none;
        }

        .hamburger.is-open .hamb-bottom {
            -webkit-transform: rotate(-45deg);
            -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
            background-color: #000;
            margin-top: -2px;
            top: 50%;
        }

        .hamburger.is-open:before {
            -webkit-transform: translate3d(0, 0, 0);
            -webkit-transition: all 0.35s ease-in-out;
            color: #000;
            content: '';
            display: block;
            font-size: 14px;
            line-height: 32px;
            opacity: 0;
            text-align: center;
            width: 100px;
        }

        .hamburger.is-open:hover before {
            -webkit-transform: translate3d(-100px, 0, 0);
            -webkit-transition: all 0.35s ease-in-out;
            display: block;
            opacity: 1;
        }

        /*-------------------------------*/
        /*          Dark Overlay         */
        /*-------------------------------*/

        .overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        /* SOME DEMO STYLES - NOT REQUIRED */

        body, html { background-color: white; }

        body h1, body h2, body h3, body h4 { color: rgba(255, 255, 255, 0.9); }

        body p, body blockquote { color: rgba(255, 255, 255, 0.7); }

        body a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: underline;
        }

        body a:hover { color: #ffffff; }
        .deactive{
            display: none;
        }
        .active{
            background-color: #52418a;
        }
        .js-loading-overlay {
            background-color: rgba(0,0,0,.7);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

    </style>
</head>

<body id="body">
<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand"> <a href="#"> Hi Dear,<br/> <?php echo func\functions::getFullName($_SESSION['log-user']); ?></a> <br/></li>
            <li id="com"> <a href="#"><i class="fa fa-fw fa-envelope"></i> Compose</a> </li>
            <li id="inboxe"> <a href="#"><i class="fa fa-fw fa-inbox"></i> Inbox</a> </li>
            <li id="sente"> <a href="#"><i class="fa fa-fw fa-send"></i> Sent</a> </li>
            <li id="trashe"> <a href="#"><i class="fa fa-fw fa-trash"></i> Trash </a></li>
            <li id="ase"> <a href="#"><i class="fa fa-fw fa-user"></i> Account Setting</a> </li>
            <li id="lout"> <a href="index.php?lo=0"><i class="fa fa-fw fa-sign-out"></i> LogOut</a> </li>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <h2 style="padding: 0 10% 10% 10%;"></h2>
    <div id="page-content-wrapper">
        <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas"> <span class="hamb-top"></span> <span class="hamb-middle"></span> <span class="hamb-bottom"></span> </button>
        <div style="padding: 0 10% 10% 10%; margin-top: 50px;" id="inbox" >
            <h1 style="color: #000;">Inbox</h1>
            <br/>
            <br/>
            <table class="table" >
                <thead class="thead-inverse">
                <tr>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody style="cursor: pointer;">
                <tr id="ehem">
                    <?php
                    $con = mysqli_connect(func\DB::getHost(),func\DB::getUser(),func\DB::getPasw(),func\DB::getDbname());
                    if($con->connect_error){
                        die("Conenction Error : ".$con->connect_error);
                    }
                    $rslt = $con->query("SELECT mykey, subject, file, date_time, username_from FROM Mail." . $_SESSION['log-user'] ."_message WHERE status='1' AND username='" . $_SESSION['log-user'] ."';");
                    if(is_object($rslt) && $rslt->num_rows > 0){
                        while($row = $rslt->fetch_assoc()){
                            if($row['file'] == "1") {
                                echo "<tr><td><a href='#?back=inbox' style='color: #000' onclick='SubmitInbox(" . $row['mykey'] . ");'>" . $row['username_from'] . "<i class='fa fa-paperclip fa-2' aria-hidden='true'>
                                  </i></a> </td><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='toTrash(" . $row['mykey'] . ")' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                            }else{
                                echo "<tr><td><a href='#?back=inbox' style='color: #000' onclick='SubmitInbox(" . $row['mykey'] .");'>" . $row['username_from'] . "</td></a><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='toTrash(" . $row['mykey'] . ")' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                            }
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="padding: 0 10% 10% 10%; margin-top: 50px;" class="deactive" id="sent">
            <h1 style="color: #000;">Sent</h1>
            <br/>
            <br/>
            <table class="table" >
                <thead class="thead-inverse">
                <tr>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody style="cursor: pointer;">

                    <?php
                    $con = mysqli_connect(func\DB::getHost(),func\DB::getUser(),func\DB::getPasw(),func\DB::getDbname());
                    if($con->connect_error){
                        die("Conenction Error : ".$con->connect_error);
                    }
                    $rslt = $con->query("SELECT mykey, subject, file, date_time, username_from, username_to FROM Mail." . $_SESSION['log-user'] ."_message WHERE status='2' AND username='" . $_SESSION['log-user'] ."';");
                    if(is_object($rslt) && $rslt->num_rows > 0){
                        while($row = $rslt->fetch_assoc()){
                            if($row['file'] == "1") {
                                echo "<td><a href='#?back=sent' style='color: #000' onclick='SubmitSent(". $row['mykey'] .");'>" . $row['username_to'] . "<i class='fa fa-paperclip fa-2' aria-hidden='true'>
                                  </i></a> </td><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='toTrash(" . $row['mykey'] . ")' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                            }else{
                                echo "<tr><td><a href='#?back=sent' style='color: #000' onclick='SubmitSent(". $row['mykey'] .");'>" . $row['username_to'] . "</td></a><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='toTrash(" . $row['mykey'] . ")' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="padding: 0 10% 10% 10%; margin-top: 50px;" class="deactive" id="trash">
            <h1 style="color: #000;">Trash</h1>
            <br/>
            <br/>
            <table class="table" >
                <thead class="thead-inverse">
                <tr>
                    <th>Username</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody style="cursor: pointer;">
                <tr id="ehem">
                    <?php
                    $con = mysqli_connect(func\DB::getHost(),func\DB::getUser(),func\DB::getPasw(),func\DB::getDbname());
                    if($con->connect_error){
                        die("Conenction Error : ".$con->connect_error);
                    }
                    $rslt = $con->query("SELECT mykey, subject, file, date_time, username_from, username_to FROM Mail." . $_SESSION['log-user'] ."_message WHERE status='3' AND username='" . $_SESSION['log-user'] ."';");
                    if($rslt->num_rows > 0){
                        while($row = $rslt->fetch_assoc()){
                            if($row['username_from'] == $_SESSION['log-user']){
                                if($row['file'] == "1") {
                                    echo "<td><a style='color: #000' onclick='SubmitTrash(". $row['mykey'] .");'>" . $row['username_from'] . "<i class='fa fa-paperclip fa-2' aria-hidden='true'>
                                  </i></a> </td><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='Delete(". $row['mykey'] .");' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                                }else{
                                    echo "<tr><td><a style='color: #000' onclick='SubmitTrash(". $row['mykey'] .");'>" . $row['username_from'] . "</td></a><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='Delete(". $row['mykey'] .");' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                                }
                            }else if ($row['username_to'] == $_SESSION['log-user']){
                                if($row['file'] == "1") {
                                    echo "<td><a style='color: #000' onclick='SubmitTrash(". $row['mykey'] .");'>" . $row['username_to'] . "<i class='fa fa-paperclip fa-2' aria-hidden='true'>
                                  </i></a> </td><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='Delete(". $row['mykey'] .");' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                                }else{
                                    echo "<tr><td><a style='color: #000' onclick='SubmitTrash(". $row['mykey'] .");'>" . $row['username_to'] . "</td></a><td>" . $row['subject'] . "</td><td>" . $row['date_time'] . "</td><td><button class='btn btn-primary' onclick='Delete(". $row['mykey'] .");' type='button'>
                                  <i class='fa fa-fw fa-trash'></i></button></td></tr>";
                                }
                            }
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="compose" style="padding: 0 10% 10% 10%; margin-top: 50px;" class="deactive">
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">To :</span>
                <input type="text" class="form-control" name="to" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <br/>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">Subject :</span>
                <input type="text" class="form-control" name="subject" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <input name="userfile" type="file" id="userfile"/>
            <div class="nedemo" style="width: 100%; margin-top: 20px;">
                <textarea class="form-control" name="body" id="neditor"></textarea>
            </div>
            <br/>
            <input class="btn btn-primary" name="send" value="Send" type="submit"/>
        </form>

    </div>
    <div id="show" style="padding: 0 10% 10% 10%; background-color: #000000 margin-top: 50px;" class="deactive" >
        <form method="post" enctype="multipart/form-data">
            <a id="closes" href="#" style="cursor: pointer; color: #000; float: right"><i class="fa fa-times" aria-hidden="true"></i></a>
            <h1 id="title" style="color: #000;"></h1>
            <hr/>
            <p id="content" style="color: #000;"></p>
            <br/>
            <input type="submit" style="padding: 6px 12px; margin-bottom: 0; font-size: 14px; font-weight: normal; line-height: 1.428571429; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; border: 1px solid transparent; border-radius: 4px; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; -o-user-select: none; user-select: none; color: #fff; background-color: #428bca; border-color: #357ebd;" id="down" name="down" class="deactive" value=""/>
            <hr/>
            <p id="date" style="float: right; color: #000;"></p>
            <p id="from" style="position: relative; color: #000;"></p>
            <input type="hidden" id="mykey" name="mykey" value="dd"/>

            <script>


                function replaceAll(str, find, replace) {
                    var i = str.indexOf(find);
                    if (i > -1){
                        str = str.replace(find, replace);
                        i = i + replace.length;
                        var st2 = str.substring(i);
                        if(st2.indexOf(find) > -1){
                            str = str.substring(0,i) + replaceAll(st2, find, replace);
                        }
                    }
                    return str;
                }


                function SubmitInbox(mykey) {

                    $("#show").removeClass('deactive');
                    $("#inbox").addClass('deactive');
                    $("#sent").addClass('deactive');
                    $("#trash").addClass('deactive');
                    $("#compose").addClass('deactive');
                    ID = mykey;
                    $.post("select.php", { ID: ID },
                        function(data) {
                            document.getElementById("title").innerHTML = data;
                            s = replaceAll(data,"'", '"');
                            s = replaceAll(s, "\n","</br>");
                            s = replaceAll(s, "\r","");
                            obj = JSON.parse(s);
                            document.getElementById("title").innerHTML = obj.mail[0].subject;
                            document.getElementById("content").innerHTML = obj.mail[0].body;
                            document.getElementById("date").innerHTML = obj.mail[0].date;
                            document.getElementById("from").innerHTML = "FROM : " + obj.mail[0].receiver +"@"+ window.location.hostname;
                            if(obj.mail[0].file == "1"){
                                $("#down").removeClass('deactive');//btn btn-primary
                                SubmitFile(ID);
                            }else{
                                $("#down").addClass('deactive');
                                document.getElementById("down").value = "";
                            }
                        });

                }
                function SubmitFile(mykey) {
                    ID = mykey;
                    $.post("fileName.php", { ID: ID  },
                        function(data) {
                            document.getElementById("down").value = data;
                            document.getElementById("mykey").value = mykey;
                        });
                }
                function SubmitSent(mykey) {
                    $("#show").removeClass('deactive');
                    $("#inbox").addClass('deactive');
                    $("#sent").addClass('deactive');
                    $("#trash").addClass('deactive');
                    $("#compose").addClass('deactive');
                    ID = mykey;
                    $.post("select.php", { ID: ID  },
                        function(data) {
                            s = replaceAll(data,"'", '"');
                            s = replaceAll(s, "\n","</br>");
                            s = replaceAll(s, "\r","");
                            obj = JSON.parse(s);
                            document.getElementById("title").innerHTML = obj.mail[0].subject;
                            document.getElementById("content").innerHTML = obj.mail[0].body;
                            document.getElementById("date").innerHTML = obj.mail[0].date;
                            document.getElementById("from").innerHTML = "TO : " + obj.mail[0].receiver +"@"+ window.location.hostname;
                            if(obj.mail[0].file == "1"){
                                $("#down").removeClass('deactive');
                                document.getElementById("down").value = SubmitFile(ID);
                            }else{
                                $("#down").addClass('deactive');
                                document.getElementById("down").value = "";
                            }
                        });

                }
                function SubmitTrash(mykey) {
                    $("#show").removeClass('deactive');
                    $("#inbox").addClass('deactive');
                    $("#sent").addClass('deactive');
                    $("#trash").addClass('deactive');
                    $("#compose").addClass('deactive');
                    ID = mykey;
                    $.post("select.php", { ID: ID  },
                        function(data) {
                            s = replaceAll(data,"'", '"');
                            s = replaceAll(s, "\n","</br>");
                            s = replaceAll(s, "\r","");
                            obj = JSON.parse(s);
                            document.getElementById("title").innerHTML = obj.mail[0].subject;
                            document.getElementById("content").innerHTML = obj.mail[0].body;
                            document.getElementById("date").innerHTML = obj.mail[0].date;
                            document.getElementById("from").innerHTML = obj.mail[0].receiver +"@"+ window.location.hostname;
                            if(obj.mail[0].file == "1"){
                                $("#down").removeClass('deactive');
                                document.getElementById("down").value = SubmitFile(ID);
                            }else{
                                $("#down").addClass('deactive');
                                document.getElementById("down").value = "";
                            }
                        });

                }
                function toTrash(mykey) {
                    ID = mykey;
                    $.post("to_trash.php", { ID: ID  },
                        function(data) {
                            if(data == "ok"){
                                window.location.reload();
                            }
                        });

                }
                function Delete(mykey) {
                    ID = mykey;
                    $.post("delete.php", { ID: ID  },
                        function(data) {
                            if(data == "ok"){
                                window.location.reload();
                            }
                        });

                }
            </script>
        </form>
    </div>
    <div id="accSetting" style="padding: 0 10% 10% 10%; background-color: #000000 margin-top: 50px;" class="deactive">
        <form method="post">
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">First Name</span>
                <input type="text" class="form-control" value="<?php echo func\functions::getItemBy("first_name", $_SESSION['log-user']) ?>" name="fn" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <br/>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">Last Name</span>
                <input type="text" class="form-control" name="ln" value="<?php echo func\functions::getItemBy("last_name", $_SESSION['log-user']) ?>" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <br/>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">PassWord</span>
                <input type="password" class="form-control" name="pw" value="<?php echo func\functions::getItemBy("password", $_SESSION['log-user']) ?>" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <br/>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2">Backup Email</span>
                <input type="text" class="form-control" name="be" value="<?php echo func\functions::getItemBy("backup_mail", $_SESSION['log-user']) ?>" placeholder="" aria-describedby="sizing-addon2">
            </div>
            <br/>
            <input class="btn btn-primary" name="update" value="Save" type="submit"/>
        </form>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->
<script src="theme/jquery.inputfile.js"></script>
<script>
    $('input[type="file"]').inputfile({
        uploadText: '<span class="glyphicon glyphicon-upload"></span> Select a file',
        removeText: '<span class="glyphicon glyphicon-trash"></span>',
        restoreText: '<span class="glyphicon glyphicon-remove"></span>',

        uploadButtonClass: 'btn btn-primary',
        removeButtonClass: 'btn btn-default'
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="theme/neditor.js" type="text/javascript"></script>

<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var editor = new nEditor($("#neditor"));
    editor.width = "100%";
    editor.height = "200px";
    editor.init();
</script>
<script>
    $(document).ready(function () {
        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;

        trigger.click(function () {
            hamburger_cross();
        });

        function hamburger_cross() {

            if (isClosed == true) {
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');
                isClosed = false;
            } else {
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');
                isClosed = true;
            }
        }

        $('[data-toggle="offcanvas"]').click(function () {
            $('#wrapper').toggleClass('toggled');
        });
        $(document).ready(function()
        {
            function x(){
                document.getElementById("title").innerHTML = "";
                document.getElementById("content").innerHTML = "";
                document.getElementById("date").innerHTML = "";
                document.getElementById("from").innerHTML = "";
                $("#down").addClass('deactive');
                document.getElementById("down").value = "";
            }
            $('#closes').click(function(e) {
                var s = window.location.toString();
                var ss = s.split('=');
                var obj = ss[1];
                switch (obj){
                    case "sent":
                        $("#show").addClass('deactive');
                        $("#sent").removeClass('deactive');
                        break;
                    case "inbox":
                        $("#show").addClass('deactive');
                        $("#inbox").removeClass('deactive');
                        break;
                }
                x();
            });
            $('#inboxe').click(function(e)
            {
                $("#show").addClass('deactive');
                $("#inbox").removeClass('deactive');
                $("#sent").addClass('deactive');
                $("#trash").addClass('deactive');
                $("#inboxe").addClass('active');
                $("#sente").removeClass('active');
                $("#trashe").removeClass('active');
                $("#ase").removeClass('active');
                $("#compose").addClass('deactive');
                $("#com").removeClass('active');
                $("#accSetting").addClass('deactive');
            });
            $('#sente').click(function(e)
            {
                $("#sent").removeClass('deactive');
                $("#inbox").addClass('deactive');
                $("#show").addClass('deactive');
                $("#trash").addClass('deactive');
                $("#inboxe").removeClass('active');
                $("#sente").addClass('active');
                $("#trashe").removeClass('active');
                $("#ase").removeClass('active');
                $("#compose").addClass('deactive');
                $("#com").removeClass('active');
                $("#accSetting").addClass('deactive');
            });
            $('#trashe').click(function(e)
            {
                $("#show").addClass('deactive');
                $("#trash").removeClass('deactive');
                $("#inbox").addClass('deactive');
                $("#sent").addClass('deactive');
                $("#trashe").addClass('active');
                $("#sente").removeClass('active');
                $("#inboxe").removeClass('active');
                $("#ase").removeClass('active');
                $("#compose").addClass('deactive');
                $("#com").removeClass('active');
                $("#accSetting").addClass('deactive');
            });
            $('#com').click(function(e)
            {
                $("#show").addClass('deactive');
                $("#inbox").addClass('deactive');
                $("#sent").addClass('deactive');
                $("#trash").addClass('deactive');
                $("#inboxe").removeClass('active');
                $("#sente").removeClass('active');
                $("#trashe").removeClass('active');
                $("#ase").removeClass('active');
                $("#compose").removeClass('deactive');
                $("#accSetting").addClass('deactive');
                $("#com").addClass('active');
            });
            $('#ase').click(function(e)
            {
                $("#show").addClass('deactive');
                $("#inbox").addClass('deactive');
                $("#sent").addClass('deactive');
                $("#trash").addClass('deactive');
                $("#inboxe").removeClass('active');
                $("#sente").removeClass('active');
                $("#trashe").removeClass('active');
                $("#ase").addClass('active');
                $("#compose").addClass('deactive');
                $("#accSetting").removeClass('deactive');
                $("#com").removeClass('active');
            });
        });
    });

</script>
</body>
</html>

