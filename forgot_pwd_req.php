<?php
use PHPMailer\PHPMailer\PHPMailer;
include_once "PHPMailer/PHPMailer.php";
include_once "PHPMailer/Exception.php";
include_once "PHPMailer/SMTP.php";
include "init.php";
if(isset($_SESSION['email'])){
    $email=$_SESSION['email'];
    $_SESSION['otp']=otp();
    $array=['resp'=>1, 'err'=>''];
    $msg = $_SESSION['otp'];
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "pankajboruah28.pb@gmail.com";
    $mail->Password = "Panky@9289";
    $mail->setFrom('pankajboruah28.pb@gmail.com', 'Pankaj Boruah');
    $mail->addAddress($email);
    $mail->Subject = "OTP for password reset";
    $data=['html_title'=> 'OTP','email'=>$email, 'msg'=>$msg];
    $body=make('otp.php',$data);
    $mail->Body = $body;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } 
//    echo ($array['resp']);
//    echo($_SESSION['otp']);
    header('location:reset_pwd.php');
    exit;
}
?>