<?php
/**
 * Created by PhpStorm.
 * User: Ehem
 * Date: 10/11/2016
 * Time: 03:03 PM
 */

require_once("function/functions.php");

session_start();

if(func\functions::commandDB("DELETE FROM Mail." . $_SESSION['log-user'] . "_message WHERE mykey='" . $_POST['ID'] . "'")){
    echo "ok";
}