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
$rslt = $con->query("SELECT filename FROM Mail." . $_SESSION['log-user'] . "_attachment WHERE message_id='" . $_POST['ID'] . "';");
if($rslt->num_rows > 0){
    while($row = $rslt->fetch_assoc()){
        echo $row['filename'];
    }
}