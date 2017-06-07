<?php
/**
 * Created by PhpStorm.
 * User: BT
 * Date: 01/26/2016
 * Time: 12:04 PM
 */

namespace func {
    require_once("DB.php");


    class functions
    {
        public static function commandDB($sql){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            if($con->query($sql)){
                $result = true;
                //echo mysqli_insert_id($con);
            }
            else{
                $result = false;
            }
            return $result;
        }
        public static function Send($sql){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            if($con->query($sql)){
                $result = mysqli_insert_id($con);
            }
            else{
                $result =  null;
            }
            return $result;
        }
        public static function Login($sql){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query($sql);
            if($rslt->num_rows > 0){
                while($row = $rslt->fetch_assoc()){
                    $result = $row['password'];
                }
            }
            return $result;
        }
        public static function getFullName($username){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT first_name, last_name FROM Mail.user WHERE username='$username';");
            if($rslt->num_rows > 0){
                while($row = $rslt->fetch_assoc()){
                    $result = $row['first_name'] . " " . $row['last_name'];
                }
            }
            return $result;
        }
        public static function getItemBy($item , $username){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT " . $item . " FROM Mail.user WHERE username='$username';");
            if($rslt->num_rows > 0){
                while($row = $rslt->fetch_assoc()){
                    $result = $row[$item];
                }
            }
            return $result;
        }
        public static function getUserCount(){
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT * FROM Mail.user;");
            return $rslt->num_rows;
        }
        public static function getItem($item, $where, $w){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT " . $item . " FROM Mail.user WHERE " . $where . "='$w';");
            if($rslt->num_rows > 0){
                while($row = $rslt->fetch_assoc()){
                    $result = $row[$item];
                }
            }
            return $result;
        }
        public static function downLoad($id){
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT filename, filebyte, size FROM Mail." . $_SESSION['log-user'] . "_attachment WHERE message_id='$id';");
            if($rslt->num_rows > 0){
                while($row = $rslt->fetch_assoc()){
                    header("Content-Disposition: attachment; filename=".$row['filename']);
                    header("Content-Type: application/octet-stream");
                    header("Content-Type: application/force-download");
                    header("Content-Type: application/octet-stream");
                    header("Content-Type: application/download");
                    header("Content-Description: File Transfer");
                    header("Content-length: ". $row['size']);
                    echo $row['filebyte'];
                }
            }
        }

        public static function getConnection(){
            return mysqli_connect(DB::getHost(),DB::getUser(),DB::getPasw(),DB::getDbname());
        }
        public static function checkExistUser($username){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT username FROM Mail.user WHERE username='$username';");
            if($rslt->num_rows > 0){
                $result = true;
            }
            return $result;
        }
        public static function checkExistMail($mail){
            $result = false;
            $con = functions::getConnection();
            if($con->connect_error){
                die("Conenction Error : ".$con->connect_error);
            }
            $rslt = $con->query("SELECT backup_mail FROM Mail.user WHERE backup_mail='$mail'");
            if($rslt->num_rows > 0){
                $result = true;
            }
            return $result;
        }
    }
}