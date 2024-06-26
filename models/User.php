<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php';

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

class User
{
    public $id;
    private $userName;
    public $password;
    public $firstName;
    public $lastName;
    private $gender;
    private $birthDate;
    private $address;
    private $phone;
    private $mobile;
    private $picture;
    public $workEmail;
    public $hireDate;
    private $personalEmail;
    public $jobTitle;
    private $roles;
    private $permissions;
    private $active;
    public $workPhone;
    public $workExtension;

    public function __construct($id = null, $userName = null, $password = null, $firstName = null, $lastName = null, $gender = null, $birthDate = null, $address = null, $phone = null, $mobile = null, $picture = null, $workEmail = null, $personalEmail = null, $jobTitle = null, $roles = null, $permissions = null, $active = null, $workPhone = null, $workExtension = null)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->address = $address;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->picture = $picture;
        $this->workEmail = $workEmail;
        $this->personalEmail = $personalEmail;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->active = $active;
        $this->workPhone = $workPhone;
        $this->workExtension = $workExtension;
        $this->id = $id;
        $this->jobTitle = $jobTitle;
    }

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
     * Función que carga los datos del empleado al objeto
     * @user int - El id del usuario que vamos a cargar
     * 
     * @return array - La información del empleado que buscamos
     */
    function load($user)
    {
        global $conn;
        $query = "Select * 
        from Employees
        where id = $user";
        $resp = $conn->query($query);
        $usuario = $resp->fetch_assoc();
        $this->id = $usuario['id'];
        $this->userName = $usuario['userName'];
        $this->password = $usuario['password'];
        $this->firstName = $usuario['firstName'];
        $this->lastName = $usuario['lastName'];
        $this->gender = $usuario['gender'];
        $this->birthDate = $usuario['birthDate'];
        $this->address = $usuario['address'];
        $this->phone = $usuario['phone'];
        $this->mobile = $usuario['mobile'];
        $this->picture = $usuario['picture'];
        $this->workEmail = $usuario['workEmail'];
        $this->hireDate = $usuario['hireDate'];
        $this->personalEmail = $usuario['personalEmail'];
        $this->roles = $usuario['roles'];
        $this->permissions = $usuario['permissions'];
        $this->active = $usuario['active'];
        $this->workPhone = $usuario['workPhone'];
        $this->workExtension = $usuario['workExtension'];
        $this->workEmail = $usuario['workEmail'];
        $this->jobTitle = $usuario['jobTitle'];
    }

    /**
     * Función que inhabilita un changePassword Token
     *
     * @passwordChange string - El token que vamos a inhabilitar
     *  
     * @return int - 1 si se actualizó, 0 si no
     */
    function disableChangePasswordToken($passwordChange)
    {
        global $conn;
        $query = "Update passwordChange
        set active = 0
        where passwordChange = '$passwordChange'";
        $resp = $conn->query($query);
        return $resp;
    }

    /**
     * Función que actualiza los datos del empleado
     * 
     * @return void
     */
    function update()
    {
        global $conn;
        $query = "Update Employees
        set userName = '$this->userName',
        password = '$this->password',
        firstName = '$this->firstName',
        lastName = '$this->lastName',
        workEmail = '$this->workEmail',
        hireDate = '$this->hireDate',
        jobTitle = '$this->jobTitle',
        workPhone = '$this->workPhone',
        workExtension = '$this->workExtension'
        where id = $this->id";
        $conn->query($query);
        if ($conn->affected_rows == 0) {
            return "Error updating user";
        } else {
            return "User updated";
        }
    }

    /**
     * Función para cargar un usuario usando passwordChange para cambiar la contraseña
     * @passwordChange string - El identificador para encontrar el usuario
     * 
     * @return array - La información del usuario
     */
    function loadByPasswordChange($passwordChange)
    {
        global $conn;
        $query = "Select idUser
        from passwordChange
        where passwordChange = '$passwordChange' and active = 1";
        $resp = $conn->query($query);
        $usuario = $resp->fetch_assoc();
        if ($usuario) {
            $this->load($usuario['idUser']);
            return $this;
        } 
    }

    /**
     * Función que devuelve una lista de todos los Empleados que están activos
     *
     * @return array - La lista de empleados
     */
    static function getActiveUsers()
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
            $permissions = $this->getPermissions($_SESSION['employeeId']);
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
        $query = "Select E.id, E.firstName, E.lastName, AC.agentCommission, AC.idSupervisor, AC.supervisorCommission, S.firstName as supervisorName, S.lastName as supervisorLastName
                    from Employees E
                    left join agentCommissions AC on E.id = AC.idAgent
                    left join Employees S on AC.idSupervisor = S.id
                    where E.active = 1";
        $resp = $conn->query($query);
        $agents = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        $resp = [];
        foreach ($agents as $agent) {
            $roles = $this->getRoles($agent['id']);
            $var = 'agent';
            $roles = explode(',', $roles[0]['roles']);
            if (in_array($var, $roles)) {
                $resp[] = $agent;
            }
        }
        return $resp;
    }

    /**
     * Función que lista todos los roles del usuario
     * 
     * @return array - Lista de roles
     */
    function getRoles($id)
    {
        global $conn;
        $query = "Select roles from Employees where id = " . $id;
        $resp = $conn->query($query);
        $roles = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $roles;
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
        $query = "Select E.*, AC.agentCommission from Employees E 
        left join agentCommissions AC on E.id = AC.idAgent
        left join Employees S on AC.idSupervisor = S.id
        where E.id = $agent";
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
            if ($this->hasRole($employee['id'], 'agent')) {
                $agents[] = $employee;
            }
        }
        return $agents;
    }
}
