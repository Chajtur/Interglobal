<?php

include_once '../controllers/Login.php';
include_once '../models/Transaction.php';
include_once '../models/User.php';

startSession();
checkActivity();

$action = $_POST['action'];

// Controlador de solicitudes
switch ($action) {
    case 'saveTransaction':
        saveTransaction();
        break;
    case 'getTransactions':
        listTransactions();
        break;
    case 'deleteTransaction':
        deleteTransaction();
        break;
    case 'exportTransactions':
        exportTransactions();
        break;
    case 'editTransaction':
        editTransaction();
        break;
    default:
        break;
}

/**
 * Function controller to export transactions
 */
function exportTransactions() {
    $mes = $_POST['mes'] ?? 'all';
    $agente = $_POST['agente'] ?? 'all';
    $tipo = $_POST['tipo'] ?? 'all';
    $keyword = $_POST['keyword'] ?? null;
    $resp['status'] = 'true';
    $data = ['Date', 'Insured', 'Carrier', 'Policy Number', 'Transaction Type', 'Premium', 'Commission', 'Agent'];
    $resp['data'] = [];
    $resp['data'][] = $data;
    $transactions = getAllTransactions($mes, $agente, $tipo, $keyword);
    foreach ($transactions as $row) {
        $date = date_create($row['date']);
        $date = date_format($date, 'M d');
        $type = $row['type'];
        $premium = number_format($row['premium'], 2);
        $commission = number_format(($row['premium'] * 0.04), 2);
        $insured = $row['insured'];
        $carrier = $row['carrier'];
        $policyNumber = $row['policyNumber'];
        $agent = $row['agent'];
        $employee = getAgent($agent);
        $agent = $employee['firstName'] . ' ' . $employee['lastName'];
        $data = [$date, $insured, $carrier, $policyNumber, $type, $premium, $commission, $agent];
        $resp['data'][] = $data;
    }
    echo json_encode($resp);
    
}
/**
 * Function controller to delete a transaction
 */
function deleteTransaction() {
    $id = $_POST['id'];
    $user = getUser();
    $data['status'] = json_encode(removeTransaction($id, $user));
    if ($data['status'] == 'true') {
        $data['message'] = 'Transaction deleted successfully';
    } else {
        $data['message'] = 'There was an error deleting the transaction';
    }
    echo json_encode($data);
}

/**
 * Function controller to get transactions
 */
function listTransactions() {
    $mes = $_POST['mes'] ?? 'all';
    $agente = $_POST['agente'] ?? 'all';
    $tipo = $_POST['tipo'] ?? 'all';
    $keyword = $_POST['keyword'] ?? null;
    $page = $_POST['page'] ?? 1;
    echo json_encode(getTransactions($mes, $agente, $tipo, $keyword, $page));
}

/**
 * Function controller to save a transaction
 */
function saveTransaction() {
    $user = $_POST['agent'] ?? getUser();
    $date = $_POST['date'];
    $insured = $_POST['insured'];
    $carrier = $_POST['carrier'];
    $policyNumber = $_POST['policyNumber'];
    $type = $_POST['type'];
    $premium = $_POST['premium'];
    echo json_encode(insertTransaction($date, $insured, $carrier, $policyNumber, $type, $premium, $user));
}

/**
 * Function controller to edit a transaction
 */
function editTransaction() {
    $id = $_POST['id'];
    $user = $_POST['agent'] ?? getUser();
    $date = $_POST['date'];
    $insured = $_POST['insured'];
    $carrier = $_POST['carrier'];
    $policyNumber = $_POST['policyNumber'];
    $type = $_POST['type'];
    $premium = $_POST['premium'];
    echo json_encode(updateTransaction($id, $date, $insured, $carrier, $policyNumber, $type, $premium, $user));
}