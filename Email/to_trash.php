<?php
/**
 * Created by PhpStorm.
 * User: Ehem
 * Date: 10/10/2016
 * Time: 12:49 AM
 */

require_once("function/functions.php");

session_start();

if(func\functions::commandDB("UPDATE Mail." . $_SESSION['log-user'] . "_message SET status=3 where mykey='" . $_POST['ID'] . "'")){
    echo "ok";
}