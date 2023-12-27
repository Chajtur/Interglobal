<?php

require_once('../controllers/Login.php');

startSession();
checkActivity();

$webKey = "?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79";
$apiBaseURL = "https://mobile.fmcsa.dot.gov/qc/services/";
$googleMapsApiKey = "AIzaSyAvoz1u2dRSfyimsYnF7bnbekygaulzZj8";

$action = $_GET['action'];

// Controlador de solicitudes
switch ($action) {
    case 'generalDot':
        queryGeneralDot();
        break;
    case 'generalMC':
        queryGeneralMc();
        break;
    case 'hasPermission':
        userPermission();
        break;
    case 'searchVIN':
        searchVIN();
        break;
    default:
        break;
}

function searchVIN() {
    $VIN = $_GET['VIN'];
    $URL = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/' . $VIN . '?format=json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    echo json_encode($result);
}

function getDOT($docketNumber)
{

    https: //mobile.fmcsa.dot.gov/qc/services/carriers/3249789/docket-numbers

    global $apiBaseURL;
    global $webKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiBaseURL . "carriers/" . $docketNumber . "/docket-numbers" . $webKey);
    curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    if (isset($result->content[0]->docketNumber)) {
        return $result->content[0]->docketNumber;
    } else {
        return null;
    }
}

function queryGeneralDot()
{
    global $apiBaseURL;
    global $webKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiBaseURL . "carriers/" . $_GET['dot'] . $webKey);
    curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    if ($result->content != NULL) {
        $result->content->carrier->mcNumber = getDOT($_GET['dot']);
        echo json_encode($result->content->carrier);
    } else {
        echo null;
    }
}

function queryGeneralMc()
{
    global $apiBaseURL;
    global $webKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiBaseURL . "carriers/docket-number/" . $_GET['mc'] . $webKey);
    curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    if (isset($result->content[0]->carrier)) {
        echo json_encode($result->content[0]->carrier);
    } else {
        echo null;
    }
}

//https://mobile.fmcsa.dot.gov/qc/services/carriers/3249789/cargo-carried?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79