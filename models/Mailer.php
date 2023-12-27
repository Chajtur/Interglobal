<?php

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
require_once("../../../interglobalus.com/wp-load.php");

if (!isset($_SESSION)) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendRequestQuoteMail($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, $status, $ownersName)
{
    /*//Setting EMAIL options
    $mail = new PHPMailer();
    $mail->isMail();
    $mail->Mailer = "smtp";
    $mail->isHTML(true);
    $mail->WordWrap     = 50;
    $mail->Subject      = "Quote Request";
    $mail->SMTPDebug    = 4;
    $mail->setFrom('admin@bull-transportation.com', 'ALI');
    $mail->addReplyTo('admin@bull-transportation.com', 'ALI');
    //$mail->addAddress('robertoj@interglobalus.com', 'Roberto Jimenez');
    $mail->addAddress('chajtur@gmail.com', 'Jose Chajtur');
    //$mail->addAddress('info@interglobalus.com', 'Interglobal Insurance');
    */
    $html = "<body class='container'>
<div class='container-fluid'>
    <div class='row'>
        <div class='text-center'>
            <h3>New quote requested!!</h3>
        </div>
    </div>
    <div class='row mt-2'>
        <table class='table table-striped'>
            <tbody>
                <tr>
                    <td>Name:</td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>MC Number:</td>
                    <td>$mc</td>
                </tr>
                <tr>
                    <td>DOT Number:</td>
                    <td>$dot</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>$address</td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td>$city</td>
                </tr>
                <tr>
                    <td>State:</td>
                    <td>$state</td>
                </tr>
                <tr>
                    <td>Zip:</td>
                    <td>$zip</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>$email</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>$phone</td>
                </tr>
                <tr>
                    <td>Owner:</td>
                    <td>$ownersName</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h4>Please contact this customer as soon as possible to complete his quote.</h4>
    <br>
    <h3>ALI</h3>
    <hr/>
    <h5>This email was automatically generated, please do not respond</h5>
</div>
</body>";
    /*$mail->Body = $html;
    if (!$mail->send()) {
        echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent.';
    }

    $mail->smtpClose();*/
    $to = "info@interglobalus.com, rinaz@interglobalus.com, admin@interglobalus.com";
    $subject = "Quote Request";
    $message = $html;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if (!wp_mail($to, $subject, $message, $headers)) {
        echo 'Email not sent an error was encountered: ' . error_get_last()['message'];
    } else {
        echo 'Message has been sent.';
    }
    
};

function solicitarPermiso($idUsuario, $fecha)
{
//Setting EMAIL options
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->isHTML(true);
$mail->Host         = "smtp.gmail.com";
$mail->WordWrap     = 50;
$mail->SMTPAuth     = true;
$mail->SMTPSecure   = "tls";
$mail->SMTPAutoTLS = false;
$mail->Port         = 587;
$mail->Username     = "admin@ustruckingforhire.com";
$mail->Password     = "Partrenzado04!";
$mail->Subject      = "Solicitud de Permiso";
$mail->SMTPDebug    = 0;
$mail->setFrom('admin@bull-transportation.com', 'ALI');
//$mail->addAddress('robertoj@interglobalus.com', 'Roberto Jimenez');
$mail->addAddress('jose@chajtur.com', 'Jose Chajtur');
$html =
    '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head style="box-sizing: border-box;">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" style="box-sizing: border-box;"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js" style="box-sizing: border-box;"></script>
    <script src="https://kit.fontawesome.com/55b2ee1815.js" crossorigin="anonymous" style="box-sizing: border-box;"></script>
    <script src="js/jsPDF/dist/jspdf.umd.js" style="box-sizing: border-box;"></script>
    
    
    <title style="box-sizing: border-box;">
        INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" style="box-sizing: border-box;">
    <meta charset="utf-8" style="box-sizing: border-box;">
</head>
<body><div class="container-fluid text-center" style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-right: auto;margin-left: auto;text-align: center!important;">
    <div class="row" style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(-1 * var(--bs-gutter-y));margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));">
        <div class="col-lg-6 offset-lg-3 mt-5 p-3" style="box-sizing: border-box;flex-shrink: 0;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: 3rem!important;flex: 0 0 auto;margin-left: auto;padding: 1rem!important;">
            <h4 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;color: var(--bs-heading-color,inherit);font-size: calc(1.275rem + .3vw);">Solicitud de Permiso</h4>
            <h5 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;color: var(--bs-heading-color,inherit);font-size: 1.25rem;">Grupo Corsan</h5>
            <div class="border col-lg-3 mt-5 border-dark" style="box-sizing: border-box;flex: 0 0 auto;--bs-border-opacity: 1;border: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;margin-top: 3rem!important;">
                <p class="border-bottom border-dark fw-bold fs-5" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;--bs-border-opacity: 1;border-bottom: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;font-size: 1.25rem!important;font-weight: 700!important;">Fecha de Solicitud</p>
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;">10 de Marzo de 2023</p>
            </div>
            <div class="row text-start mt-5 border border-dark" style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: 3rem!important;margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));--bs-border-opacity: 1;border: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;text-align: left!important;">
                <div class="col-lg-3 fw-bold" style="box-sizing: border-box;flex-shrink: 0;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 0 0 auto;font-weight: 700!important;">Nombre del Empleado:</div>
                <div class="col border-start border-dark" style="box-sizing: border-box;flex-shrink: 0;width: 100%;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 1 0 0%;--bs-border-opacity: 1;border-left: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;">Rina Zelaya</div>
            </div>
            <div class="row text-start border-start border-bottom border-end border-dark" style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(-1 * var(--bs-gutter-y));margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));--bs-border-opacity: 1;border-right: 1px solid;border-bottom: 1px solid;border-left: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;text-align: left!important;">
                <div class="col-lg-3 fw-bold" style="box-sizing: border-box;flex-shrink: 0;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 0 0 auto;font-weight: 700!important;">Cargo que Desempe&ntilde;a:</div>
                <div class="col border-start border-dark" style="box-sizing: border-box;flex-shrink: 0;width: 100%;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 1 0 0%;--bs-border-opacity: 1;border-left: 1px solid;border-color: rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;">Se r&iacute;e de todo</div>
            </div>
            <div class="row mt-5 text-start" style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: 3rem!important;margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));text-align: left!important;">
                <p style="box-sizing: border-box;margin-top: var(--bs-gutter-y);margin-bottom: 1rem;flex-shrink: 0;width: 100%;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);">Por medio de la presente solicito permiso a partir de las 10:00 AM el d&iacute;a 15 de Marzo de 2023</p>
            </div>
            <div style="margin-top: 15px;">
                <button style="background-color:green; color:white">Aprobar</button>
                <button style="background-color:red; color:white">Rechazar</button>
            </div>
        </div>
    </div>
</div></body>
</html>';
$mail->Body = $html;
if (!$mail->send()) {
    echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent.';
}

$mail->smtpClose();
};
