<?php

require_once('../controllers/Login.php');
include_once '../models/Quote.php';

startSession();
checkActivity();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'newQuote':
        newQuote();
        break;
    case 'getQuotes':
        getQuotes();
        break;
    default:
        break;
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
function newQuote()
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
    echo insertQuote($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, "Requested", $ownerName);
}

/**
 * Devuelve el listado de Cotizaciones Solicitadas para el agente seleccionado
 * 
 * @agent int - El código de agente para buscarle Cotizaciones
 * 
 * @resp object - Respuesta con código de éxito o error y su explicación
 */
function getQuotes() {
    if (isset($_POST['agent'])) {
        echo json_encode(loadQuotes($_POST['agent']));
    } else {
        echo 'No quotes found';
    }
}