<?php
include "../helpers/db.php";

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
 * Función que inserta una Transacción en la base de datos
 * @date date - La fecha de la transacción
 * @insured string - El nombre del asegurado
 * @carrier string - El nombre de la compañía
 * @policyNumber string - El número de póliza
 * @type string - El tipo de transacción
 * @premium float - El monto de la transacción
 * @user array - El usuario que está insertando la transacción
 * 
 * @return array - El resultado de la inserción
 */
 function insertTransaction($date, $insured, $carrier, $policyNumber, $type, $premium, $user)
 {
     global $conn;
     $query = "Insert into Transactions (date, insured, carrier, policyNumber, type, premium, createdOn, createdBy) values ('$date', '$insured', '$carrier', '$policyNumber', '$type', $premium, now(), $user)";
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
      $query = "Select date, insured, carrier, policyNumber, type, premium, agent from Transactions where deletedOn is null and year(date) = " . date('Y');
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
  * @mes int - El mes que vamos a buscar
  * @agente int - El agente que vamos a buscar
  * @tipo string - El tipo de transacción que vamos a buscar
  * @keyword string - La palabra clave que vamos a buscar
  * @page int - La página que vamos a buscar
  *
  * @return array - Las transacciones
  */
  function getTransactions($mes, $agente, $tipo, $keyword, $page)
  {
      global $conn;
        $page = $page - 1;
        $page = $page * 10;
      $query = "Select * from Transactions where deletedOn is null and year(date) = " . date('Y');
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
      $query .= " order by date ASC limit $page, 10";
      $resp = $conn->query($query);
      $data = $resp->fetch_all(MYSQLI_ASSOC);
      $query = "Select count(*) as totalRows, sum(premium) as totalPremium from Transactions where deletedOn is null and year(date) = " . date('Y');
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
   * 
   * @return array - Total de pólizas, total de primas, total de comisiones
  */
function getPolicyStats($year, $agente)
{
    global $conn;
    $query = "Select count(*) as total, sum(premium) as premium, sum(premium * 0.04) as commission 
    from Transactions 
    where deletedOn is null 
    and year(date) = $year";
    if ($agente != 'all') {
        $query .= " and agent = $agente";
    }
    $resp = $conn->query($query);
    $generalStats = $resp->fetch_assoc();
    $query = "Select month(date), count(*) as total, round(sum(premium),2) as premium, round(sum(premium * 0.04),2) as commission 
        from Transactions 
        where deletedOn is null 
        and year(date) = $year
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