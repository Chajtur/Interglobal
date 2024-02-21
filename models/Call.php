<?php
include "../helpers/db.php";

class Call
{
    private $idCall;
    private $dot;
    private $status;
    private $user;
    private $sentMessage;

    public function __construct($idCall = null, $dot = null, $status = null, $user = null, $sentMessage = null)
    {
        $this->idCall = $idCall;
        $this->dot = $dot;
        $this->status = $status;
        $this->user = $user;
        $this->sentMessage = $sentMessage;
    }

    /**
     * Cuenta las llamadas diarias hechas por un agente
     * 
     * @user integer - Id del agente que vamos a buscar
     * 
     * @return integer - Devuelve el número de llamadas que hizo el agente
     */
    static function countDailyCalls($user)
    {
        global $conn;
        $query = "Select count(*) as count
    from Calls c
    where c.user = $user
    and date(c.date) = date(now())";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }



    /**
     * Cuenta las llamadas en el mes hechas por un agente
     * 
     * @user integer - Id del agente que vamos a buscar
     * 
     * @return integer - Devuelve el número de llamadas que hizo el agente
     */
    static function countMonthlyCalls($user)
    {
        global $conn;
        $query = "Select count(*) as count
        from Calls c
        where c.user = $user
        and month(c.date) = month(now())";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }

    /**
     * Cuenta las llamadas en el año hechas por un agente
     * 
     * @user integer - Id del agente que vamos a buscar
     * 
     * @return integer - Devuelve el número de llamadas que hizo el agente
     */
    static function countYearlyCalls($user)
    {
        global $conn;
        $query = "Select month(c.date) as month, count(*) as monthCount
        from Calls c
        where c.user = $user
        and year(c.date) = year(now())
        group by month(c.date)";
        $resp = $conn->query($query);
        $calls = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $calls;
    }

    /**
     * Inserta una nueva llamada en la tabla
     * 
     * @dot integer - DOT de la empresa llamada
     * @status string - Estado resultante de la llamada
     * @user integer - Usuario que efectuó la llamada
     * @sentMessage char - Si se le envió un SMS a la empresa o no
     * 
     * @return integer - Id de la llamada insertada en BD
     */
    static function insertCall($dot, $status, $user, $sentMessage)
    {
        global $conn;
        $lastId = 0;
        $query = "Insert into Calls (dot, date, user, status, sentMessage) values ($dot, now(), $user, '$status', '$sentMessage')";
        if ($conn->query($query) === TRUE) {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Inserta una fecha para llamar nuevamente a la empresa
     * 
     * @idCall integer - id de la llamada a la que pertenece la fecha
     * @callAgain date - fecha de cuando llamar nuevamente a la empresa
     * 
     * @return integer - Id of the inserted row
     */
    static function callAgain($idCall, $date)
    {
        global $conn;
        $lastId = 0;
        $query = "Insert into CallAgain (idCall, date, createdOn) values ($idCall, '$date', now())";
        if ($conn->query($query) === TRUE) {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Obtiene el historial de llamadas a una empresa basado en el DOT
     * 
     * @dot integer - Número de DOT
     * 
     * @return array - Arreglo de llamadas a la empresa
     */
    static function callHistoryByDot($dot)
    {
        global $conn;
        $query = "Select c.idCall, c.dot, concat(e.firstName, ' ', e.lastname) as agentName, date(c.date) as `date`, l.Legal_Name as businessName, l.phone, l.Company_Rep1 as rep, n.note as notes, ca.date as callAgain, c.sentMessage, c.`status`, l.Business_Address as address, l.Business_State as state
    from Calls c
    left join CallAgain ca on c.idCall = ca.idCall
    left join Notes n on c.idCall = n.idCall
    left join Lists l on c.dot = l.dot
    left join Employees e on c.user = e.id
    where c.dot = $dot
    group by c.idCall
	order by `date` ASC
    limit 5";
        $resp = $conn->query($query);
        $calls = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $calls;
    }

    /**
     * Inserta una nota a la llamada
     * 
     * @idCall integer - Id de la llamada que corresponde la nota
     * @note string - Texto de la nota adjunta a la llamada
     * 
     * @return integer - Id de la nota insertada
     */
    static function saveNote($idCall, $note)
    {
        global $conn;
        $lastId = 0;
        $query = "Insert into Notes (idCall, note) values ($idCall, '$note')";
        if ($conn->query($query) === TRUE) {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Lista todas las llamadas que cumplen con las condiciones de los filtros
     * 
     * @agent integer - El id de agente para filtrar las llamadas, 0 para todos
     * @status string - El estatus de la llamada para filtrar, 'Any' para todos
     * @state string - El estado de la llamada para filtrar, 'All' para todos
     * 
     * @return array - El arreglo de llamadas que cumplen con las condiciones
     */
    static function listCalls($agent, $status, $state)
    {
        global $conn;
        $query = "Select c.idCall, c.dot, concat(e.firstName, ' ', e.lastname) as agentName, CONVERT_TZ(c.date,'-00:00','-06:00') as `date`, date(c.date) as shortDate, l.Legal_Name as businessName, l.phone, l.Company_Rep1 as rep, n.note, ca.date as callAgain, c.sentMessage, c.`status`, l.Business_Address as address, l.Business_State as state
    from Calls c
    left join CallAgain ca on c.idCall = ca.idCall
    left join Notes n on c.idCall = n.idCall
    left join Lists l on c.dot = l.dot
    left join Employees e on c.user = e.id
    where 1=1";
        if ($agent != 0) {
            $query .= " and e.id = $agent";
        }
        if ($status != 'Any') {
            $query .= " and c.`status` = '$status'";
        }
        if ($state != 'All') {
            $query .= " and l.Business_State = '$state'";
        }
        $query .= " group by c.dot, c.date";
        $resp = $conn->query($query);
        $calls = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $calls;
    }

    /**
     * Lista las próximas 5 empresas que el agente guardó como llamar nuevamente
     * 
     * @agent integer - El id del agente al que pertenecen los recordatorios
     * 
     * @return array - El arreglo de recordatorios a mostrar
     */
    static function listReminders($agent)
    {
        global $conn;
        $query = "Select c.idCall, c.dot, concat(e.firstName, ' ', e.lastname) as agentName, CONVERT_TZ(c.date,'-00:00','-06:00') as `date`, l.Legal_Name as businessName, l.phone, l.Company_Rep1 as rep, n.note, ca.date as callAgain, c.sentMessage, c.`status`, l.Business_Address as address, l.Business_State as state
    from Calls c
    left join CallAgain ca on c.idCall = ca.idCall
    left join Notes n on c.idCall = n.idCall
    left join Lists l on c.dot = l.dot
    left join Employees e on c.user = e.id
    where e.id = $agent
    and date(ca.date) >= date(now())
	and ca.date is not null
    group by c.dot
	order by ca.date, c.idCall ASC
    limit 5";
        $resp = $conn->query($query);
        $calls = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $calls;
    }
}
