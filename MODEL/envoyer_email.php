<?php
include "../CONTROL/controleur.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$n = new Control; 
$r = $n->agence_info(); 
$email="";
$username_email="";
while($row=$r->fetch()){
$email = $row[5];
$username_email = $row[1];
} 

if(isset($_POST['fullname'])&&isset($_POST['email'])&&isset($_POST['sujet'])&&isset($_POST['message'])){
        // $the_email = htmlspecialchars($_POST['email']);
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "issamlaafer509@gmail.com";
        $mail->Password = 'wvgycbaeypbwpwvk';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom(htmlspecialchars($_POST['email']),htmlspecialchars($_POST['fullname']));
        $mail->addAddress("$email");
        $mail->isHTML(true);
        $mail->Subject = htmlspecialchars($_POST['sujet']);
        $mail->Body = "<h1>".htmlspecialchars($_POST['message'])."</h1>";
        // $mail->send();
        if($mail->send()){
                echo "send";
        }else{
                echo "not_send";
        }
}

?>