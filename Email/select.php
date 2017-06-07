<?php
/**
 * Created by PhpStorm.
 * User: Ehem
 * Date: 10/10/2016
 * Time: 12:49 AM
 */

require_once("function/functions.php");

session_start();

$con = func\functions::getConnection();
if($con->connect_error){
    die("Conenction Error : ".$con->connect_error);
}
$rslt = $con->query("SELECT subject, body, username_from, username_to, date_time, file FROM Mail." . $_SESSION['log-user'] . "_message WHERE mykey='".$_POST['ID']."';");
if($rslt->num_rows > 0){
    while($row = $rslt->fetch_assoc()){
        $sub = $row['subject'];
        $body = $row['body'];
        $sender = $row['username_from'];
        $receiver = $row['username_to'];
        $date = $row['date_time'];
        $file = $row['file'];
        echo "{'mail':[{'subject':'$sub', 'body':'$body', 'sender':'$sender', 'receiver':'$receiver', 'date':'$date', 'file':'$file' }]}";
    }
}