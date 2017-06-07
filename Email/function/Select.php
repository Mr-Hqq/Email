<?php
/**
 * Created by PhpStorm.
 * User: Ehem
 * Date: 10/10/2016
 * Time: 12:49 AM
 */

$result = false;
$con = functions::getConnection();
if($con->connect_error){
    die("Conenction Error : ".$con->connect_error);
}
$rslt = $con->query("SELECT first_name, last_name FROM Mail.message WHERE id='';");
if($rslt->num_rows > 0){
    while($row = $rslt->fetch_assoc()){
        echo $row['first_name'] . " " . $row['last_name'];
    }
}