<?php
// Include autoloader 
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/dompdf/autoload.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$user = new User();
$date = new Vacation();
$holiday = new Holiday();
$date->load($_POST['id']);
$user->load(getUser());

$styles = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/css/tailwind.css');
$logo = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/logo-tiny-removebg-preview.png');

ini_set("display_errors", true);
ini_set("error_log", "phperr.log");
ini_set("log_errors", true);
error_reporting(E_ALL);

$daysTaken = 0;

// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate the Dompdf class
$dompdf = new Dompdf();

// Load CSS files
$dompdf->setBasePath($_SERVER['DOCUMENT_ROOT'] . "/css/");

// Load HTML content
$html = '
<div class="flex w-full justify-center flex-col">
<div class="flex flex-row justify-between">
    <div class="w-1/3">
        <img src="data:image/png;base64,' . base64_encode($logo) . '" alt="logo" class="w-64 h-24">
    </div>
</div>
<div class="text-center underline">SOLICITUD DE VACACIONES</div>
<div class="text-center underline">GRUPO CORSAN</div>
<table class="table mt-5">
    <tr>
        <td colspan=3 class="border border-black font-bold">Fecha de Solicitud</td>
    </tr>
    <tr>
        <td class="border text-center">{dayToday}</td>
        <td class="border text-center">{monthToday}</td>
        <td class="border text-center">{yearToday}</td>
    </tr>
</table>
<table class="table mt-3">
    <tr>
        <td class="border font-bold">Nombre del Empleado:</td>
        <td class="border">{employeeName}</td>
    </tr>
    <tr>
        <td class="border font-bold">Cargo que Desempeña:</td>
        <td class="border">{employeeTitle}</td>
    </tr>
</table>
<div class="mt-3">
    <span>Por medio de la presente, solicito me sean autorizados {daysOff} día(s) a cuenta de vacaciones.</span>
</div>
<table class="table mt-3 mx-auto w-full">
    <tr>
        <td colspan=6 class="border font-bold text-center">Para ser gozadas</td>
    </tr>
    <tr>
        <td colspan=3 class="border text-center font-bold">Desde</td>
        <td colspan=3 class="border text-center font-bold">Hasta</td>
    </tr>
    <tr>
        <td class="border text-center font-bold">Día</td>
        <td class="border text-center font-bold">Mes</td>
        <td class="border text-center font-bold">Año</td>
        <td class="border text-center font-bold">Día</td>
        <td class="border text-center font-bold">Mes</td>
        <td class="border text-center font-bold">Año</td>
    </tr>
    <tr>
        <td class="border text-center">{Dayfrom}</td>
        <td class="border text-center">{Monthfrom}</td>
        <td class="border text-center">{Yearfrom}</td>
        <td class="border text-center">{Dayto}</td>
        <td class="border text-center">{Monthto}</td>
        <td class="border text-center">{Yearto}</td>
    </tr>
</table>
<table class="table mt-3 w-3/4">
    <tr>
        <td class="font-bold border">Ha gozado de vacaciones este año</td>
        <td class="font-bold border">{daysTakenQuestion}</td>
    </tr>
    <tr>
        <td class="font-bold border">Cuantos días?</td>
        <td class="border text-center">{daysTaken}</td>
    </tr>
</table>
<table class="mt-3 table mx-auto w-full">
    <tr>
        <td class="border font-bold text-center">Observaciones:</td>
    </tr>
    <tr>
        <td class="border">{reason}</td>
    </tr>
</table>
</div>
';

$html .= "<style>$styles 
            .underline { text-decoration: underline; }</style>";

//$html = str_replace("{date}", date("Y-m-d"), $html);
$html = str_replace("{dayToday}", date("d"), $html);
$html = str_replace("{monthToday}", date("m"), $html);
$html = str_replace("{yearToday}", date("Y"), $html);
$html = str_replace("{employeeName}", $user->firstName . " " . $user->lastName, $html);
$html = str_replace("{employeeTitle}", $user->jobTitle, $html);
$html = str_replace("{daysOff}", $holiday->getBusinessDays($date->dateFrom, $date->dateTo), $html);
$html = str_replace("{from}", $date->dateFrom, $html);
$html = str_replace("{to}", $date->dateTo, $html);
//str_replace("{daysTaken}", $date->getDaysOff(getUser()), $html);
$html = str_replace("{daysTaken}", $daysTaken, $html);
$html = str_replace("{reason}", $date->detail, $html);
$html = str_replace("{Dayfrom}", date("d", strtotime($date->dateFrom)), $html);
$html = str_replace("{Monthfrom}", date("m", strtotime($date->dateFrom)), $html);
$html = str_replace("{Yearfrom}", date("Y", strtotime($date->dateFrom)), $html);
$html = str_replace("{Dayto}", date("d", strtotime($date->dateTo)), $html);
$html = str_replace("{Monthto}", date("m", strtotime($date->dateTo)), $html);
$html = str_replace("{Yearto}", date("Y", strtotime($date->dateTo)), $html);
$html = str_replace("{daysTakenQuestion}", $daysTaken > 0 ? 'SI' : 'NO', $html);

$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('Letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

/*// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("vacationrequest.pdf", array("Attachment" => 0));
*/

// Get the generated PDF
$pdf = $dompdf->output();

// Path to save the PDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/assets/PDF/vacationRequest.pdf';  // Replace with the path where you want to save the file

// Save the PDF as a file
file_put_contents($filePath, $pdf);

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                 
    $mail->isSMTP();  
    $mail->CharSet = 'UTF-8';      
    $mail->Mailer = 'smtp';                              
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'admin@ustruckingforhire.com';                 
    $mail->Password = 'stjc tbbt mgch kmjn'; 
    //$mail->Password = 'Partrenzado04!';                          
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;                                    

    //Recipients
    $mail->setFrom($user->workEmail, $user->firstName . " " . $user->lastName);
    $mail->addReplyTo($user->workEmail, $user->firstName . " " . $user->lastName);
    $mail->addAddress('admin@ustruckingforhire.com', 'Admin');

    //Attachments
    $mail->addAttachment($filePath);         

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'New Vacation Request from ' . $user->firstName . " " . $user->lastName;
    $mail->Body    = 'See attached vacation request';
    $mail->AltBody = 'See attached vacation request';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}