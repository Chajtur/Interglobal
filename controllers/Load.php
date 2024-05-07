<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php';

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
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiBaseURL . "carriers/" . $dot . $webKey);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36'
    ));
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    /*var_dump($apiBaseURL . "carriers/" . $dot . $webKey);*/
    /*$context = stream_context_create(
        array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            "https" => array(
                "header" => "User-Agent: User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36"
            )
        )
    );
    //var_dump($apiBaseURL . "carriers/" . $dot . $webKey);
    $result = file_get_contents("'" . $apiBaseURL . "carriers/" . $dot . $webKey . "'",false,$context);
    //$result = file_get_contents('https://mobile.fmcsa.dot.gov/qc/services/carriers/name/greyhound?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79', false, $context);*/
    $result = json_decode($result);
    //var_dump($result);
    if (isset($result->content)) {
        $result->content->carrier->mcNumber = $dot;
        return $result->content->carrier;
    } else {
        return null;
    }
}

function queryGeneralDotWeb()
{
    /*global $apiBaseURL;
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
    //$result = file_get_contents('https://mobile.fmcsa.dot.gov/qc/services/carriers/name/greyhound?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79', false, $context);
    $result = json_decode($result);
    var_dump($result);
    if ($result->content != NULL) {
        $result->content->carrier->mcNumber = $dot;
        echo json_encode($result->content->carrier);
    } else {
        echo 'No info found';
    }*/
    $url = 'http://interglobalservice.ddns.net//Load.php';
    $data = array('dot' => $_POST['dot'], 'action' => 'queryGeneralDotWeb');

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);

    curl_close($ch);

    $response = json_decode($response);
    if ($response->content != NULL) {
        $response->content->carrier->mcNumber = $_POST['dot'];
        return $response->content->carrier;
    } else {
        return NULL;
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
