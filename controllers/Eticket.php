<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Eticket.php';

startSession();
checkActivity();

switch ($_POST['action']) {
    case 'saveEticket':
        saveTicket();
        break;
    default:
        break;
}

/**
 * Function controller to save a new ticket
 */
function saveTicket() {
    $type = $_POST['type'];
    $issue = $_POST['issue'];
    $detail = $_POST['detail'];
    $ticketId = insertTicket($type, $issue, $detail);
    if ($ticketId > 0) {
        $resp['status'] = 'true';
        $resp['message'] = 'Ticket saved successfully';
        $resp['ticketId'] = $ticketId;
    } else {
        $resp['status'] = 'false';
        $resp['message'] = 'There was an error saving ticket';
    }
    echo json_encode($resp);
}

?>