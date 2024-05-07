<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';

startSession();
checkActivity();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'getHoliday':
        getInfoDate();
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
    $daysOff = new vacation();
    $holiday = new holiday();
    $user = getUser();
    $resp['data'] = $daysOff->getDaysOff($user);
    if ($resp['data'] > 0) {
        $resp['text'] = 1;
        $dias = [];
        foreach ($resp['data'] as $request) {
            $request['askedDays'] = $holiday->getBusinessDays($request['dateFrom'], $request['dateTo']);
            $dias[] = $request;
        }
        $resp['data'] = $dias;
    }
    echo json_encode($resp);
}

/**
 * Controlador de la funcion askDayOff que solicita un permiso de vacaciones
 * Llama a la funcion insertDayOffRequest en Dates
 */
function askDayOff()
{
    $holiday = new vacation();
    $dateFrom = $_POST['from'] ?: '1901-01-01';
    $dateTo = $_POST['to'] ?: '1901-01-01';
    $reason = $_POST['reason'] ?: 'Rest';
    $resp['data'] = $holiday->request($dateFrom, $dateTo, $reason, getUser());
    if ($resp['data'] > 0) {
        $resp['status'] = 'success';
        $resp['text'] = 'Vacation request has been entered successfully';
    } else {
        $resp['status'] = 'error';
        $resp['text'] = 'Error entering vacation request';
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
    $holiday = new holiday($date);
    $resp['data'] = $holiday->delete($date);
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
    $name = $_POST['nombre'] ?: 'Holiday';
    $detail = $_POST['detalle'] ?: 'Holiday set successfully';
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
 * Controlador para buscar datos de feriados
 * Llama la función getHolidays de Dates.php
 */
function getInfoDate()
{
    $date = new holiday($_POST['date']);
    $holiday = $date->getHolidays();
    echo json_encode($holiday);
}