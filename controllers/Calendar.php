<?php

include_once '../models/Dates.php';
require_once('../controllers/Login.php');

startSession();
checkActivity();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'getPunches':
        getEmployeeMonthPunches();
        break;
    case 'getHoliday':
        getInfoDate();
        break;
    case 'hasPermission':
        userPermission();
        break;
    case 'saveHoliday':
        saveHoliday();
        break;
    case 'removeHoliday':
        removeHoliday();
        break;
    case 'askDayOff':
        askDayOff();
        break;
    case 'getDaysOff':
        userDaysOff();
        break;
    default:
        break;
}

/**
 * Controlador de la función userDaysOff que retorna los días libres solicitados por el usuario
 * Llama a la función getDaysOff en Dates
 */
function userDaysOff()
{
    $user = getUser();
    $resp['data'] = getDaysOff($user);
    if ($resp['data'] > 0) {
        $resp['text'] = 1;
        $dias = [];
        foreach ($resp['data'] as $request) {
            $request['askedDays'] = getBusinessDays($request['dateFrom'], $request['dateTo']);
            $dias[] = $request;
        }
        $resp['data'] = $dias;
    }
    if (haspermission(2))
    echo json_encode($resp);
}

/**
 * Controlador de la funcion askDayOff que solicita un permiso de vacaciones
 * Llama a la funcion insertDayOffRequest en Dates
 */
function askDayOff()
{
    $dateFrom = $_POST['from'] ?: '1901-01-01';
    $dateTo = $_POST['to'] ?: '1901-01-01';
    $reason = $_POST['reason'] ?: 'Descanso';
    $resp['data'] = insertVacationRequest($dateFrom, $dateTo, $reason, getUser());
    if ($resp['data'] > 0) {
        $resp['status'] = 'success';
        $resp['text'] = 'Vacaciones solicitadas correctamente';
    } else {
        $resp['status'] = 'error';
        $resp['text'] = 'No se ha podido ingresar la solicitud de vacaciones, favor intente de nuevo';
    }
    echo json_encode($resp);
}

/**
 * Controlador de la función removeHoliday que elimina un feriado que haya sido creado
 * Llama a la función deleteHoliday en Dates
 */
function removeHoliday()
{
    $date = $_POST['fecha'] ?: '2023-01-01';
    $resp['data'] = deleteHoliday($date);
    if ($resp['data'] > 0) {
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'error';
    }
    echo json_encode($resp);
}

/**
 * Controlador de la función saveHoliday que inserta un feriado en la base de datos
 * Llama a la función insertHoliday en Dates
 */
function saveHoliday()
{
    $date = $_POST['fecha'] ?: '2023-01-01';
    $fecha = new holiday($date);
    $name = $_POST['nombre'] ?: 'Feriado';
    $detail = $_POST['detalle'] ?: 'Se otorgó feriado';
    $fullDay = $_POST['diaCompleto'] ?: 'true';
    $resp['data'] = $fecha->save($date, $name, $detail, $fullDay);
    if ($resp['data'] > 0) {
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'error';
    }
    echo json_encode($resp);
}

/**
 * Controlador de la función hasPermission en el Modelo de User
 * Llama a la función hasPermission en User
 */
function userPermission()
{
    if (isset($_POST['function'])) {
        echo hasPermission($_POST['function']) == true ? 1 : 0;
    } else {
        echo 0;
    }
}

/**
 * Controlador para buscar datos de feriados
 * Llama la función getHolidays de Dates.php
 */
function getInfoDate()
{
    $date = new holiday($_POST['date']);
    $holiday = $date->getHolidays();
    echo json_encode($holiday);
}

/**
 * Controlador para buscar las marcaciones del empleado
 * Llama a la función getMonthPunches en User
 */
function getEmployeeMonthPunches()
{
    //echo getMonthPunches();
}
