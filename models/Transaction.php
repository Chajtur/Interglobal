<?php
include "../helpers/db.php";
include_once '../models/User.php';

$transactionTypes = [
    'NEW BUSINESS' => 1,
    'RENEWAL' => 2,
    'CANCELLATION' => 3,
    'REINSTATEMENT' => 4,
    'ADDITIONAL PREMIUM' => 5,
    'RETURN PREMIUM' => 6,
    'OTHER' => 7
];

/**
 * Función que actualiza una transacción en la base de datos
 * @id int - El id de la transacción
 * @date date - La fecha de la transacción
 * @insured string - El nombre del asegurado
 * @carrier string - El nombre de la compañía
 * @policyNumber string - El número de póliza
 * @type string - El tipo de transacción
 * @agent int - El agente que está insertando la transacción
 * @premium float - El monto de la transacción
 * @commission float - La comisión de la transacción
 * @agentCommission float - La comisión del agente
 * 
 * @return array - El resultado de la actualización
 */
function updateTransaction($id, $date, $insured, $carrier, $policyNumber, $type, $premium, $commission, $agentCommission, $agent)
{
    global $conn;
    $user = getUser();
    $query = "Update Transactions set date = '$date', insured = '$insured', carrier = '$carrier', policyNumber = '$policyNumber', type = '$type', premium = $premium, commission = '$commission', agentCommission = '$agentCommission', agent = $agent, updatedOn = now(), updatedBy = $user where id = $id";
    $resp = $conn->query($query);
    if ($resp) {
        return 1;
    } else {
        return $conn->error;
    }
}

/**
 * Función que inserta una Transacción en la base de datos
 * @date date - La fecha de la transacción
 * @insured string - El nombre del asegurado
 * @carrier string - El nombre de la compañía
 * @policyNumber string - El número de póliza
 * @type string - El tipo de transacción
 * @premium float - El monto de la transacción
 * @commission float - La comisión de la transacción
 * @agentCommission float - La comisión del agente
 * @agent int - El agente que está insertando la transacción
 * @user array - El usuario que está insertando la transacción
 * 
 * @return array - El resultado de la inserción
 */
function insertTransaction($date, $insured, $carrier, $policyNumber, $type, $premium, $commission, $agentCommission, $agent, $user)
{
    global $conn;
    $query = "Insert into Transactions (date, insured, carrier, policyNumber, type, premium, commission, agentCommission, agent, createdOn, createdBy) values ('$date', '$insured', '$carrier', '$policyNumber', '$type', $premium, $commission, $agentCommission, $agent,  now(), $user)";
    $resp = $conn->query($query);
    if ($resp) {
        return $conn->insert_id;
    } else {
        return $conn->error;
    }
}

/**
 * Función que devuelve todas las transacciones
 * @mes int - El mes que vamos a buscar
 * @agente int - El agente que vamos a buscar
 * @tipo string - El tipo de transacción que vamos a buscar
 * @keyword string - La palabra clave que vamos a buscar
 *
 * @return array - Las transacciones
 */
function getAllTransactions($mes, $agente, $tipo, $keyword)
{
    global $conn;
    $query = "Select date, insured, carrier, policyNumber, type, premium, agent from Transactions where deletedOn is null";
    if ($mes != 'all') {
        $query .= " and month(date) = $mes";
    }
    if ($agente != 'all') {
        $query .= " and agent = $agente";
    }
    if ($tipo != 'all') {
        $query .= " and type = '$tipo'";
    }
    if ($keyword != null) {
        $query .= " and (insured like '%$keyword%' or policyNumber like '%$keyword%' or carrier like '%$keyword%')";
    }
    $query .= " order by date ASC";
    $resp = $conn->query($query);
    $data = $resp->fetch_all(MYSQLI_ASSOC);
    if ($resp) {
        return $data;
    } else {
        return $conn->error;
    }
}
/**
 * Función que devuelve las transacciones de un mes
 * @year int - El año que vamos a buscar
 * @mes int - El mes que vamos a buscar
 * @agente int - El agente que vamos a buscar
 * @tipo string - El tipo de transacción que vamos a buscar
 * @keyword string - La palabra clave que vamos a buscar
 * @page int - La página que vamos a buscar
 *
 * @return array - Las transacciones
 */
function getTransactions($year, $mes, $agente, $tipo, $keyword, $page)
{
    global $conn;
    $page = $page - 1;
    $page = $page * 10;
    if ($agente <> 'all') {  
        $query = "Select idAgent from agentCommissions where idSupervisor = $agente";
        $resp = $conn->query($query);
        $agents = $resp->fetch_all(MYSQLI_ASSOC);
        $agents[] = ['idAgent' => $agente];
        $agents = implode(',', array_column($agents, 'idAgent'));
    }
    $query = "Select * from Transactions where deletedOn is null";
    if ($year != 'all') {
        $query .= " and year(date) = $year";
    }
    if ($mes != 'all') {
        $query .= " and month(date) = $mes";
    }
    if ($agente != 'all') {
        $query .= " and agent in ($agents)";
    }
    if ($tipo != 'all') {
        $query .= " and type = '$tipo'";
    }
    if ($keyword != null) {
        $query .= " and (insured like '%$keyword%' or policyNumber like '%$keyword%' or carrier like '%$keyword%')";
    }
    $query .= " order by date, id ASC limit $page, 10";
    $resp = $conn->query($query);
    $data = $resp->fetch_all(MYSQLI_ASSOC);
    
    $query = "Select count(T.id) as totalRows, sum(T.premium) as totalPremium, sum(T.premium * T.commission/100) as agencyCommission, sum(T.premium * T.commission/100 * T.agentCommission/100) as agentCommission from Transactions T where T.deletedOn is null";
    if ($year != 'all') {
        $query .= " and year(date) = $year";
    }
    if ($mes != 'all') {
        $query .= " and month(date) = $mes";
    }
    if ($agente != 'all') {
        $query .= " and T.agent in ($agents)";
    }
    if ($tipo != 'all') {
        $query .= " and T.type = '$tipo'";
    }
    if ($keyword != null) {
        $query .= " and (T.insured like '%$keyword%' or T.policyNumber like '%$keyword%' or T.carrier like '%$keyword%')";
    }
    $transactions['data'] = $data;
    $resp2 = $conn->query($query);
    $totalStats = $resp2->fetch_assoc();
    $transactions['stats'] = $totalStats;
    if ($resp) {
        return $transactions;
    } else {
        return $conn->error;
    }
}

/** Función que retorna las estadísticas de pólizas para todo el año 
 * @year int - El año que vamos a buscar
 * @agente int - El agente que vamos a buscar
 * @quarter string - El trimestre que vamos a buscar
 * 
 * @return array - Total de pólizas, total de primas, total de comisiones
 */
function getPolicyStats($year, $agente, $quarter)
{
    switch ($quarter) {
        case 'fullYear':
            $quarter = 'fullYear';
            break;
        case 'firstQuarter':
            $quarter = 1;
            break;
        case 'secondQuarter':
            $quarter = 2;
            break;
        case 'thirdQuarter':
            $quarter = 3;
            break;
        case 'fourthQuarter':
            $quarter = 4;
            break;
    }
    global $conn;
    $query = "Select count(*) as total, sum(premium) as premium, sum(premium * commission/100) as commission, sum(if(type = 'NEW BUSINESS', 1, 0)) as newBusiness, sum(if(type = 'RENEWAL', 1, 0)) as renewal, sum(if(type = 'CANCELLATION', 1, 0)) as cancellation, sum(if(type = 'REINSTATEMENT', 1, 0)) as reinstatement, sum(if(type = 'ADDITIONAL PREMIUM', 1, 0)) as additionalPremium, sum(if(type = 'RETURN PREMIUM', 1, 0)) as returnPremium, sum(if(type = 'OTHER', 1, 0)) as other
    from Transactions 
    where deletedOn is null";
    if ($year != 'all') {
        $query .= " and year(date) = $year";
    }
    if ($agente != 'all') {
        $query .= " and agent = $agente";
    }
    if ($quarter != 'fullYear') {
        $query .= " and month(date) between " . (($quarter - 1) * 3 + 1) . " and " . ($quarter * 3);
    }
    $resp = $conn->query($query);
    $generalStats = $resp->fetch_assoc();
    $query = "Select month(date), count(*) as total, round(sum(premium),2) as premium, round(sum(premium * commission/100),2) as commission 
        from Transactions 
        where deletedOn is null";
    if ($year != 'all') {
        $query .= " and year(date) = $year";
    }
    if ($agente != 'all') {
        $query .= " and agent = $agente";
    };
    if ($quarter != 'fullYear') {
        $query .= " and month(date) between " . (($quarter - 1) * 3 + 1) . " and " . ($quarter * 3);
    }
    $query .= "
        group by month(date)
        order by month(date) ASC";
    $resp = $conn->query($query);
    $monthlyStats = $resp->fetch_all(MYSQLI_ASSOC);
    $data['generalStats'] = $generalStats;
    $data['monthlyStats'] = $monthlyStats;
    if ($resp) {
        return $data;
    } else {
        return $conn->error;
    }
}

/**
 * Función que retorna una transacción
 * @id int - El id de la transacción
 * 
 * @return array - La transacción
 */
function getTransaction($id)
{
    global $conn;
    $query = "Select * from Transactions where id = $id";
    $resp = $conn->query($query);
    $data = $resp->fetch_assoc();
    if ($resp) {
        return $data;
    } else {
        return $conn->error;
    }
}

/**
 * Función que elimina una transacción
 * @id int - El id de la transacción
 * @user int - El usuario que está eliminando la transacción
 * 
 * @return array - El resultado de la eliminación
 */
function removeTransaction($id, $user)
{
    global $conn;
    $query = "Update Transactions set deletedOn = now(), deletedBy = $user where id = $id";
    $resp = $conn->query($query);
    if ($resp) {
        return true;
    } else {
        return $conn->error;
    }
};

/**
 * Función que actualiza el porcentaje de comisión de un agente
 * @agentId int - El id del agente
 * @commission float - El porcentaje de comisión
 * @supervisorId int - El id del supervisor
 * @supervisorCommission float - El porcentaje de comisión del supervisor
 * @user int - El usuario que está actualizando la comisión
 * 
 * @return array - El resultado de la actualización
 */
function updateCommission($agentId, $commission, $supervisorId, $supervisorCommission, $user)
{
    global $conn;
    $query = "Insert ignore into agentCommissions 
                (idAgent, agentCommission, idSupervisor, supervisorCommission) 
                values ($agentId, $commission, $supervisorId, $supervisorCommission)
                on duplicate key update agentCommission = $commission, idSupervisor = $supervisorId, supervisorCommission = $supervisorCommission, updatedOn = now(), updatedBy = $user";
    $resp = $conn->query($query);
    if ($resp) {
        return 1;
    } else {
        return $conn->error;
    }
}