<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../controllers/Login.php';
include_once '../models/Business.php';
include_once '../models/Call.php';

startSession();
checkActivity();

global $business, $call;
$business = new Business();
$call = new Call();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'getNewCall':
        getNewCall();
        break;
    case 'saveCall':
        saveCall();
        break;
    case 'getAgents':
        getAgents();
        break;
    case 'getCalls':
        getCalls();
        break;
    case 'getReminders':
        getReminders();
        break;
    case 'getCallHistory':
        getCallHistory();
        break;
    case 'checkIfExists':
        checkIfExists();
        break;
    case 'getStatistics':
        getStatistics();
        break;
    default:
        break;
}

/**
 * Function controller to provide statistics for a user
 */
function getStatistics()
{
    global $call;
    $user = getUser();
    $role = getRole();
    switch ($role) {
        case 'agent':
            $resp['dailyCalls'] = $call::countDailyCalls($user);
            $resp['monthlyCalls'] = $call::countMonthlyCalls($user);
            $resp['yearlyCalls'] = $call::countYearlyCalls($user);
            echo json_encode($resp);
            break;
    }
}

/**
 * Function controller to check if a Business exists on our Lists
 */
function checkIfExists()
{
    global $business;
    $param = $_POST['param'];
    $param = str_replace('-', '', $param);
    $param = str_replace(' ', '', $param);
    $param = str_replace('(', '', $param);
    $param = str_replace(')', '', $param);
    $param = str_replace('+1', '', $param);
    $dot = $business->getNewBusinessByDot($param);
    if ($dot != null) {
        echo $dot['DOT'];
        die();
    } else {
        $dot = $business->getNewBusinessByPhone($param);
        if ($dot != null) {
            echo $dot['DOT'];
            die();
        } else {
            echo 0;
            die();
        }
    }
}

/**
 * Function controller to load call history for a dot
 */
function getCallHistory()
{
    global $call;
    $dot = $_POST['dot'];
    echo json_encode($call::callHistoryByDot($dot));
}

/**
 * Function controller for new calls
 */
function getNewCall()
{
    $business = new Business();
    $type = $_POST['type'];
    $status = $_POST['status'];
    $state = isset($_POST['state']) ? $_POST['state'] : 'All';
    if (is_numeric($state)) {
        echo json_encode($business->getNewBusinessByDot($state));
    } else {
        if ($type == 1) {
            echo json_encode($business->getNewBusiness($state, $status));
        } else {
            echo json_encode($business->getRenewBusiness($state, $status));
        }
    }

}

/**
 * Function controller for saving calls
 */
function saveCall()
{
    global $call;
    $Dot = $_POST['DOT'];
    $status = $_POST['status'];
    $user = getUser();
    $callAgain = isset($_POST['callAgain']) ? $_POST['callAgain'] : 0;
    $notes = addslashes($_POST['notes']);
    $sentMessage = $_POST['sentMessage'];
    $idCall = $call::insertCall($Dot, $status, $user, $sentMessage);
    if ($idCall) {
        if ($callAgain) {
            $call::callAgain($idCall, $callAgain);
        }
        if ($notes) {
            $call::saveNote($idCall, $notes);
        }
    }
    echo $idCall;
}

/**
 * Function controller to list all agents making calls
 */
function getAgents()
{
    global $business;
    $agents = $business::listAgents();
    echo json_encode($agents);
}

/**
 * Function controller to list calls
 */
function getCalls()
{
    global $call;
    $agent = isset($_POST['agent']) ? $_POST['agent'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : 'Any';
    $state = isset($_POST['state']) ? $_POST['state'] : 'All';
    $calls = $call::listCalls($agent, $status, $state);
    echo json_encode($calls);
}

/**
 * Function controller for getting reminders
 */
function getReminders()
{
    global $call;
    if (isset($_SESSION['employeeId'])) {
        $agent = $_SESSION['employeeId'];
        $reminders = $call::listReminders($agent);
        echo json_encode($reminders);
    }
}
