<?php
require("../PHPMailer/class.PHPMailer.php");

function Maili($To ,$psw){
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = "server37.mylittledatacenter.com ";
    $mail->SMTPAuth = true;
    $mail->Username = "tick@mo3tafa.ir";
    $mail->Password = "mostafa";

    $mail->From = "tick@mo3tafa.ir";
    $mail->FromName = "Email Project";
    $mail->AddAddress($To, "");

    $mail->WordWrap = 50;

    $mail->IsHTML(true);

    $mail->Subject = "Email Project New Password";
    $mail->Body    = "Hi " . $To . " Dear, <br/>Your New PassWord Is : <br/> " . $psw;
    $mail->AltBody = "Email Project";

    if(!$mail->Send())
    {
        return false;
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit;
    }
    else{
        return true;
    }
    
}
?>