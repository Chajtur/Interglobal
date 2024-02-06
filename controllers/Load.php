<?php

require_once('../controllers/Login.php');
require_once('../helpers/db.php');

startSession();
checkActivity();

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Controlador de solicitudes
switch ($action) {
    case 'generalDotWeb':
        queryGeneralDotWeb();
        break;
    case 'generalDot':
        queryGeneralDot($_POST['dot']);
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

function searchVIN()
{
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

function queryGeneralDot($dot)
{
    global $apiBaseURL;
    global $webKey;
    /*$ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiBaseURL . "carriers/" . $dot . $webKey);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36'
    ));
    $result = curl_exec($ch);
    curl_close($ch);*/
    /*var_dump($apiBaseURL . "carriers/" . $dot . $webKey);*/
    $context = stream_context_create(
        array(
            "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
            "https" => array(
                "header" => "User-Agent: User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
            )
        )
            );
    $result = file_get_contents($apiBaseURL . "carriers/" . $dot . $webKey,false,$context);
    $result = json_decode($result);
    //var_dump($result);
    if ($result->content != NULL) {
        $result->content->carrier->mcNumber = $dot;
        //echo json_encode($result->content->carrier);
        return $result->content->carrier;
    } else {
        return null;
    }
}

function queryGeneralDotWeb(){
    global $apiBaseURL;
    global $webKey;
    $dot = $_GET['dot'];
    $context = stream_context_create(
        array(
            "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
            "https" => array(
                "header" => "User-Agent: User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
            )
        )
            );
    $result = file_get_contents($apiBaseURL . "carriers/" . $dot . $webKey,false,$context);
    $result = json_decode($result);
    //var_dump($result);
    if ($result->content != NULL) {
        $result->content->carrier->mcNumber = $dot;
        echo json_encode($result->content->carrier);
    } else {
        echo 'No info found';
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
