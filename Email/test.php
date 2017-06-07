<?php
/**
 * Created by PhpStorm.
 * User: BT
 * Date: 20/11/2016
 * Time: 05:46 AM
 */
require_once("function/functions.php");
$con = func\functions::getConnection();
if($con->connect_error){
    die("Conenction Error : ".$con->connect_error);
}
$rslt = $con->query("SELECT subject, body, username_s, username_r, date_time, file FROM Mail.message WHERE mykey='11';");
if($rslt->num_rows > 0){
    while($row = $rslt->fetch_assoc()){
        $sub = $row['subject'];
        $body = $row['body'];
        $sender = $row['username_s'];
        $receiver = $row['username_r'];
        $date = $row['date_time'];
        $file = $row['file'];
        //echo $sub;
        echo "{'mail':[{'subject':'$sub', 'body':'$body', 'sender':'$sender', 'receiver':'$receiver', 'date':'$date', 'file':'$file' }]}";
    }
}