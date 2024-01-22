<?php

$styles = file_get_contents('../css/html2PDF.css');
$logo = file_get_contents('../assets/logo-tiny-removebg-preview.png');
include_once '../models/User.php';
include_once '../controllers/Login.php';

ini_set("display_errors", true);
ini_set("error_log", "phperr.log");
ini_set("log_errors", true);
error_reporting(E_ALL);

$user = new User();
$user->load($_SESSION['user']['id']);


// Include autoloader 
require_once '../assets/dompdf/autoload.inc.php'; 

// Reference the Dompdf namespace 
use Dompdf\Dompdf;
use Dompdf\Options;

error_log($_POST['html']);

$html = $_POST['html'];
$html .= "<style>$styles</style>";

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

// Instantiate the Dompdf class 
$dompdf = new Dompdf($options);

// Set paper size
$dompdf->setPaper('Letter', 'portrait');

// Replace all placeholder variables
//$html = str_replace('{QuoteNumber}', $_POST['quoteNumber'], $html);
$html = str_replace('{logo}', $logo, $html);
$html = str_replace('{Date}', date('Y-m-d'), $html);
$html = str_replace('{agentName}', $user->firstName . ' ' . $user->lastName, $html);
$html = str_replace('{QuoteNumber}', $_POST['dot'], $html);

$phoneNumber = $user->workPhone;
$phoneNumberArray = str_split($phoneNumber);
$phoneNumberWithHyphens = substr_replace($phoneNumber, '(', 0, 0);
$phoneNumberWithHyphens = substr_replace($phoneNumberWithHyphens, ') ', 4, 0);
$phoneNumberWithHyphens = substr_replace($phoneNumberWithHyphens, '-', 9, 0);


$html = str_replace('{phoneNumber}', $phoneNumberWithHyphens, $html);

$html = str_replace('{extension}', $user->workExtension, $html);

// Load HTML content 
$dompdf->loadHtml($html);

// Load CSS files
$dompdf->setBasePath('../css/');


// Render the HTML as PDF 
$dompdf->render(); 

// Output the generated PDF (1 = download and 0 = preview) 
$dompdf->stream($_POST['filename'], array("Attachment" => 0)); 
?>
