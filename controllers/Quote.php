<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Quote.php';

$quote = new Quote();

startSession();
checkActivity();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'newQuoteRequest':
        newQuoteRequest();
        break;
    case 'getQuotes':
        getQuotes();
        break;
    case 'saveQuote':
        saveQuote();
        break;
    case 'saveQuoteCoverage':
        saveCoverage();
        break;
    case 'saveQuoteBillPlan':
        saveBillPlan();
        break;
    case 'getById':
        getById();
        break;
    default:
        break;
}

/**
 * Devuelve la cotización solicitada por el cliente
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function getById()
{
    global $quote;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/Coverage.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/BillPlan.php";
    $coverage = new Coverage();
    $billPlan = new BillPlan();
    if (isset($_POST['id'])) {
        $quoteData['quote'] = $quote->getById($_POST['id']);
        $billPlanList = $billPlan->listAll($_POST['id']);
        
    } else {
        echo 'No quote found';
    }
}

/**
 * Procesa los planes de pago creados por agentes para los clientes
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function saveBillPlan()
{
    require_once '../models/BillPlan.php';
    $downPayment = $_POST['downPayment'];
    $downPayment = str_replace('$', '', $downPayment);
    $downPayment = str_replace(',', '', $downPayment);
    $installmentAmount = $_POST['installmentAmount'];
    $installmentAmount = str_replace('$', '', $installmentAmount);
    $installmentAmount = str_replace(',', '', $installmentAmount);
    $billPlan = new BillPlan($_POST['idBillPlan'], $_POST['idQuote'], $downPayment, $_POST['installments'], $installmentAmount, $_POST['idOption'],addslashes($_POST['optionName']), $_POST['term']);
    echo $billPlan->save();
}

/**
 * Procesa las coberturas creadas por agentes para los clientes
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function saveCoverage()
{
    require_once '../models/Coverage.php';
    $amount = $_POST['coverageAmount'];
    $amount = str_replace('$', '', $amount);
    $amount = str_replace(',', '', $amount);
    $basePremium = $_POST['basePremium'];
    $basePremium = str_replace('$', '', $basePremium);
    $basePremium = str_replace(',', '', $basePremium);
    $taxesFees = $_POST['taxesFees'];
    $taxesFees = str_replace('$', '', $taxesFees);
    $taxesFees = str_replace(',', '', $taxesFees);
    $coverage = new Coverage($_POST['idCoverage'], $_POST['idQuote'], $_POST['idBillPlan'], $_POST['carrier'], $amount, $basePremium, $taxesFees, $_POST['notes']);
    echo $coverage->save();
}

/**
 * Procesa las nuevas solicitudes de cotización por parte de potenciales clientes
 * 
 * @proposedDate date - Fecha proyectada de la solicitud de cotización
 * @mc int - El número de MC del cliente
 * @dot int - El número de DOT del cliente
 * @name string - Nombre de la empresa
 * @ownersName string - Nombre del dueño de la empresa
 * @address string - Dirección de la empresa
 * @city string - Ciudad de la empresa
 * @state string - Estado de la empresa
 * @zip int - Zipcode de la empresa
 * @email string - Correo electrónico de contacto de la empresa
 * @phone string - Número telefónico de contacto
 * @driverLicense string - Licencia de conducir del dueño de la empresa
 * 
 * @resp int - Respuesta de éxito o error a la creación de solicitud de cotización
 */
function newQuoteRequest()
{
    $proposedDate = (isset($_POST['proposedDate']) ? $_POST['proposedDate'] : null);
    $mc = (isset($_POST['mc']) ? $_POST['mc'] : null);
    $dot = (isset($_POST['dot']) ? $_POST['dot'] : null);
    $name = (isset($_POST['name']) ? $_POST['name'] : null);
    $ownerName = (isset($_POST['ownersName']) ? $_POST['ownersName'] : null);
    $address = (isset($_POST['address']) ? $_POST['address'] : null);
    $city = (isset($_POST['city']) ? $_POST['city'] : null);
    $state = (isset($_POST['state']) ? $_POST['state'] : null);
    $zip = (isset($_POST['zip']) ? $_POST['zip'] : null);
    $email = (isset($_POST['email']) ? $_POST['email'] : null);
    $phone = (isset($_POST['phone']) ? $_POST['phone'] : null);
    $driverLicense = (isset($_POST['driversLicense']) ? $_POST['driversLicense'] : null);
    //echo insertQuote($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, "Requested", $ownerName);
}

/**
 * Devuelve el listado de Cotizaciones Solicitadas para el agente seleccionado
 * 
 * @agent int - El código de agente para buscarle Cotizaciones
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function getQuotes() {
    global $quote;
    if (isset($_POST['agent'])) {
        echo json_encode($quote->loadQuotes($_POST['agent']));
    } else {
        echo 'No quotes found';
    }
}

/**
 * Procesa las cotizaciones creadas por agentes para los clientes
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function saveQuote()
{
    global $quote;
    $user = $_SESSION['user']['id'];
    if (isset($_POST['idQuote'])) {
        $quote->delete($_POST['idQuote']);
    }
    $quote->date = date('Y-m-d H:i:s');
    $quote->dot = $_POST['dot'];
    $quote->owner = $user;
    $quote->status = "Quoted";
    $quote->type = $_POST['type'];
    echo $quote->save();
}
