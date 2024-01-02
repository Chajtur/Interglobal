<?php

include_once '../helpers/db.php';
include_once '../controllers/Login.php';

/**
 * Listado de permisos y sus códigos
 * *********************************
 * ----------- MENU -----------------
 * I - Acceso al menú de Interglobal Insurance
 * U - Acceso al menú de US Trucking for Hire
 * 1 - Acceso a Call Center Interglobal
 * 2 - Acceso a Cotizaciones
 * 3 - Acceso a RFP
 * 4 - Acceso a Cargas
 * 5 - Acceso a Camiones
 * 6 - Acceso a Conductores
 * 7 - Acceso a Call Center US Trucking
 * 8 - Acceso a Safer
 * 9 - 
 * ----------- RRHH ------------------
 * crearFeriado - Crear/Eliminar Feriados
 * aprobarVacaciones - Aprobar/Rechazar Vacaciones del Personal
 * verVacaciones - Ver Vacaciones del Personal
 * 
 */

startSession();

/**
 * Función que devuelve los datos del empleado seleccionado
 * 
 * @$user int - El id de usuario que vamos a devolver
 * 
 * @return array - La información del empleado que buscamos
 */
function getEmployee($user)
{
    global $conn;
    $query = "Select * 
                 from Employees 
                 where (userName = '" . $user . "' or workEmail = '" . $user . "') 
                 and active = 1 limit 1";
    $resp = $conn->query($query);
    $usuario = $resp->fetch_assoc();
    if ($usuario) {
        $_SESSION['user'] = $usuario;
        return $usuario;
    } else {
        return "User not found";
    }
}

/**
 * Función que devuelve una lista de todos los Empleados que están activos
 * 
 * @return array - La lista de empleados
 */
function getActiveUsers()
{
    global $conn;
    $query = "Select * 
                 from Employees
                 where active = 1";
    $resp = $conn->query($query);
    $usuarios = mysqli_fetch_all($resp, MYSQLI_ASSOC);
    return $usuarios;
}

/**
 * Función que devuelve los permisos de un empleado
 * 
 * $idUser integer - El usuario que vamos a buscarle sus permisos
 * 
 * @return string - La lista de permisos, separados por coma, que tiene el usuario
 */
function getPermissions($idUser)
{
    global $conn;
    $query = "select permissions from Employees where id = " . $idUser;
    $resp = $conn->query($query);
    $permissions = $resp->fetch_assoc();
    return $permissions;
}

/**
 * Función que valida si un usuario tiene un permiso específico
 * 
 * $idFunction string - El permiso que validaremos
 * 
 * @return integer - 0 o 1 dependiendo si tiene o no permiso
 */
function hasPermission($idFunction)
{
    if (isset($_SESSION['employeeId'])) {
        $permissions = getPermissions($_SESSION['employeeId']);
        $permissions = $permissions['permissions'];
        if (in_array($idFunction, explode(',', $permissions))) {
            return '1';
        } else {
            return '0';
        }
    } else {
        return '0';
    }
}

/**
 * Función que lista todos los agentes haciendo llamadas
 * 
 * @return array - Lista de agentes
 */
function listAgents()
{
    global $conn;
    $query = "SELECT e.id, concat(e.firstName, ' ', e.lastName) as name
    FROM Calls c, Employees e
    WHERE c.`user` = e.id
    GROUP BY e.id";
    $resp = $conn->query($query);
    $agents = mysqli_fetch_all($resp, MYSQLI_ASSOC);
    return $agents;
}

/**
 * Devuelve las marcaciones del empleado durante el mes
 * @employee int - el id del Empleado
 * @month int - el mes a buscar
 * @year int - el año a buscar
 * 
 * @return array - retorna arreglo con la primera marcación del día del empleado para todo el mes
 */
function getMonthPunches($year, $month, $employeeId)
{
    global $conn;
    /*$employeeId = $_POST['employee'];
    $month = $_POST['month'];
    $year = $_POST['year'];*/
    $query = "Select day(punchTime) as Fecha, time(min(punchTime)) as Entrada 
        from PunchTimes 
        where year(punchTime) = $year and month(punchTime) = $month and employeeId = $employeeId
        group by date(punchTime)";
    $datosObj = $conn->query($query);
    $marcas = mysqli_fetch_all($datosObj, MYSQLI_ASSOC);
    //echo json_encode($marcas);
    return ($marcas);
}

/**
 * Función que retorna los datos del usuario
 * @agent int - El id del usuario
 * 
 * @return array - El usuario
 */
function getAgent($agent)
{
    global $conn;
    $query = "Select * from Employees where id = $agent";
    $resp = $conn->query($query);
    $agent = $resp->fetch_assoc();
    return $agent;
}

/**
 * Función que valida si un usuario tiene un rol específico
 * @agent int - El id del usuario
 * @role string - El rol que vamos a validar
 * 
 * @return integer - 0 o 1 dependiendo si tiene o no el rol
 */
function hasRole($agent, $role)
{
    global $conn;
    $query = "Select * from Employees where id = $agent";
    $resp = $conn->query($query);
    $roles = $resp->fetch_assoc();
    var_dump($roles);
    $roles = explode(',', $roles['roles']);
    if (in_array($role, $roles)) {
        return 1;
    } else {
        return 0;
    }
}

/**
 * Función que lista todos los agentes haciendo llamadas de seguros
 * 
 * @return array - Lista de agentes
 */
function listInsuranceAgents()
{
    global $conn;
    $query = "SELECT e.id, concat(e.firstName, ' ', e.lastName) as name
    FROM Employees e
    WHERE active = 1";
    $resp = $conn->query($query);
    $employees = mysqli_fetch_all($resp, MYSQLI_ASSOC);
    foreach ($employees as $employee) {
        if (hasRole($employee['id'], 'agent')) {
            $agents[] = $employee;
        }
    }
    return $agents;
}