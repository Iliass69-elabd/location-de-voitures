<?php

// $name = $_POST["name"];
$email = $_SESSION["user"][4];
require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->SMTPSecure = 'tls';
try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host     = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'omnigold450@gmail.com';
    $mail->Password = 'anckvhkvxprzfyhm';
    $mail->SMTPSecure = 'tls';
    $mail->Port     = 587;

    $mail->setFrom('no-reply@example.com', 'No Reply');
    // $mail->addReplyTo('support@example.com', 'Support');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->AddCustomHeader('MIME-Version: 1.0\r\n');
    $mail->AddCustomHeader('Content-Type: text/html; charset=ISO-8859-1\r\n');
    $mail->Subject = 'Reservation de voiture';
    $mail->Body = "<!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8' />
                        <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        <title>Document</title>
                        <style>
                        .mail {
                            text-align: center;
                        }
                        .imag {
                            width: 160px;
                            height: 70px;
                            filter: brightness(100);
                            padding: 20px;
                        }
                        .head {
                            background-color: rgb(0, 28, 55);
                        }
                        .paragraphe {
                            font-size: 20pt;
                            font-family: 'Times New Roman', Times, serif;
                        }
                        .logot{
                            color: white;
                            font-size:30px;
                        }
                        </style>
                    </head>
                    <body>
                        <section class='mail'>
                        <div class='head'>
                            <h1 class='logot'>WLC</h1>
                        </div>
                        <p class='paragraphe'>Merci pour votre confiance !</p>
                        <p class='paragraphe'>Votre réservation est effectué avec succés!</p>
                        <p class='paragraphe'>La secrétaire confirmera votre demande dans quelques instants via le numéro de téléphone!</p>
                        <footer>&copy;WLC 2023-2024</footer>
                        </section>
                    </body>
                    </html>";
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

