<?php
include $_SERVER['DOCUMENT_ROOT'] . "/helpers/db.php";

class vacation
{
    public $id;
    public $idEmployee;
    public $dateFrom;
    public $dateTo;
    public $detail;
    public $status;
    public $approvedBy;
    public $approvedDate;
    public $requestDate;
    public $approvedEmployee;

    public function __construct($idEmployee = null, $dateFrom = null, $dateTo = null, $detail = null, $status = null, $approvedBy = null, $approvedDate = null, $requestDate = null)
    {
        $this->idEmployee = $idEmployee;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->detail = $detail;
        $this->status = $status;
        $this->approvedBy = $approvedBy;
        $this->approvedDate = $approvedDate;
        $this->requestDate = $requestDate;
    }

    /**
     * Función que calcula desde cuando contabilizar feriados y permisos de un empleado según su fecha de contratación
     * @date hireDate - Fecha de contratación del empleado
     * 
     * @return string - Fecha desde la cual se contabilizarán los feriados y permisos
     */
    function getWorkingDate($hireDate)
    {
        $today = new DateTime(date('Y-m-d'));
        $hireDate = new DateTime($hireDate);
        $diff = $hireDate->diff($today)->y;
        while ($diff >= 1) {
            $hireDate->add(new DateInterval('P1Y'));
            $diff--;
        }
        return $hireDate->format('Y-m-d');
    }

    /**
     * Función que calcula cuantos días de vacaciones tiene derecho el empleado
     * @user int - El id del usuario a buscar
     * 
     * @return int - Cantidad de días de vacaciones que tiene el empleado
     */
    function getAvailableDays($user)
    {
        global $conn;
        $query = "Select hireDate from Employees where id = $user";
        $resp = $conn->query($query);
        $daysOff = $resp->fetch_assoc();
        $hireDate = new DateTime($daysOff['hireDate']);
        $today = new DateTime(date('Y-m-d'));

        $diff = $hireDate->diff($today);
        $years = $diff->y;

        if ($years >= 4)
        {
            return 20;
        } else if ($years >= 3)
        {
            return 15;
        } else if ($years >= 2)
        {
            return 12;
        } else if ($years >= 1)
        {
            return 10;
        } else
        {
            return $diff->days * 0.02778;
        }
    }

    /**
     * Función que carga una solicitud de vacaciones
     * @id int - El id de la solicitud a cargar
     * 
     * @return array - La solicitud de vacaciones
     */
    function load($id)
    {
        global $conn;
        $query = "Select v.id, v.idEmployee, v.dateFrom, v.dateTo, v.detail, v.status, v.approvedBy, Convert_TZ(v.approvedDate, '+00:00', '-06:00') as approvedDate, CONVERT_TZ(v.requestDate, '+00:00', '-06:00') as requestDate, concat(e.firstName, ' ', e.lastName) as approvedEmployee from Vacations v left join Employees e on v.idEmployee = e.id where v.id = $id";
        $resp = $conn->query($query);
        $vacation = $resp->fetch_assoc();
        if ($vacation)
        {
            $this->id = $vacation['id'];
            $this->idEmployee = $vacation['idEmployee'];
            $this->dateFrom = $vacation['dateFrom'];
            $this->dateTo = $vacation['dateTo'];
            $this->detail = $vacation['detail'];
            $this->status = $vacation['status'];
            $this->approvedBy = $vacation['approvedBy'];
            $this->approvedDate = $vacation['approvedDate'];
            $this->requestDate = $vacation['requestDate'];
            $this->approvedEmployee = $vacation['approvedEmployee'];
        }
    }

    /**
     * Función que devuelve todos los días libres que ha pedido el usuario
     * @user int - El id del usuario a buscar
     * 
     * @return array - Lista de días libres que ha solicitado el usuario
     */
    function getDaysOff($user)
    {
        global $conn;
        $query = "Select v.id, v.idEmployee, v.dateFrom, v.dateTo, v.detail, v.status, v.approvedBy, Convert_TZ(v.approvedDate, '+00:00', '-06:00') as approvedDate, CONVERT_TZ(v.requestDate, '+00:00', '-06:00') as requestDate, concat(e.firstName, ' ', e.lastName) as approvedEmployee 
        from Vacations v 
        left join Employees e on v.approvedBy = e.id 
        where idEmployee = $user 
        order by v.dateFrom desc";
        $resp = $conn->query($query);
        $daysOff = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        if ($daysOff)
        {
            return $daysOff;
        } else
        {
            return 0;
        }

    }

    /**
     * Función que inserta una solicitud de vacaciones a la BD
     * @fechaInicio date - Fecha del primer día de vacación solicitado
     * @fechaFinal date - Fecha del último día de vacación solicitado
     * @motivo string - Motivo por el cual solicita las vacaciones
     * @user int - Id del usuario solicitando las vacaciones
     * 
     * @return int - Id de la solicitud ingresada
     */
    function request($fechaInicio, $fechaFinal, $motivo, $user)
    {
        global $conn;
        $lastId = 0;
        $query = "insert into Vacations (idEmployee, dateFrom, dateTo, detail, status, approvedBy, requestDate)
                values ($user, '$fechaInicio', '$fechaFinal', '$motivo', 'Requested', 0, NOW())";
        if ($conn->query($query) === TRUE)
        {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Función que devuelve todas las solicitudes de vacaciones aprovadas para una fecha específica
     * @user $date - La fecha a buscar
     * 
     * @return array - Lista de solicitudes para ese día
     */
    function getApprovedDaysOffbyDay($date)
    {
        global $conn;
        $query = "Select v.id, v.idEmployee, v.dateFrom, v.dateTo, v.detail, v.status, v.approvedBy, Convert_TZ(v.approvedDate, '+00:00', '-06:00') as approvedDate, CONVERT_TZ(v.requestDate, '+00:00', '-06:00') as requestDate, concat(f.firstName, ' ', f.lastName) as requestEmployee, concat(e.firstName, ' ', e.lastName) as approvedEmployee 
    from Vacations v 
    left join Employees e on v.approvedBy = e.id 
    left join Employees f on v.idEmployee = f.id
    where v.dateFrom = '$date'";
        $resp = $conn->query($query);
        $daysOff = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        if ($daysOff)
        {
            return $daysOff;
        }
        return 0;
    }

    /**
     * Función que devuelve el siguiente día hábil
     * @author Chajtur
     * @copyright (c) 2024
     *
     * @param string $date - Fecha a partir de la cual se buscará el siguiente día hábil
     * @return string - Siguiente día hábil
     */
    function getNextBusinessDay($date)
    {
        $date = new DateTime($date); // Today's date

        do
        {
            $date->add(new DateInterval('P1D')); // Add 1 day
        } while ($date->format('N') >= 6); // Repeat if the day is Saturday (6) or Sunday (7)
        $nextBusinessDay = $date->format('Y-m-d');
        return $nextBusinessDay;
    }

    /**
     * Contador de días feriados que ha pedido el usuario para el año actual
     * @author Chajtur
     * @copyright (c) 2024
     *
     * @param int $user - Id del usuario a buscar
     * @return int - Cantidad de días feriados que ha pedido el usuario
     */
    function countDaysOff($user)
    {
        global $conn;
        $query = "Select count(*) as daysOff from Vacations where idEmployee = $user and year(requestDate) = year(now())";
        $resp = $conn->query($query);
        $daysOff = $resp->fetch_assoc();
        return $daysOff['daysOff'];
    }
}


class holiday
{
    public $id;
    public $date;
    public $name;
    public $holidayDetail;
    public $fullDay;
    public $active;

    public function __construct($date = null, $id = null, $name = null, $holidayDetail = null, $fullDay = null, $active = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->holidayDetail = $holidayDetail;
        $this->fullDay = $fullDay;
        $this->active = $active;
    }

    /**
     * Función que verifica si la fecha es feriado
     * 
     * @return boolean - Si la fecha es feriado o no
     */
    function isHoliday()
    {
        global $conn;
        $query = "Select * from Holidays where date = '$this->date'";
        $resp = $conn->query($query);
        $holiday = $resp->fetch_assoc();
        if ($holiday)
        {
            return true;
        }
        return false;
    }

    /**
     * Función que devuelve solamente la lista de fechas designadas como feriado
     * 
     * @return array - Listado de fechas de feriados
     */
    static function getHolidayDates()
    {
        global $conn;
        $query = "Select date from Holidays where active = 1";
        $resp = $conn->query($query);
        $daysOff = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $daysOff;
    }

    /**
     * Función que devuelve la información de la fecha si es feriado
     * $date date = La fecha a buscar
     */
    function getHolidays()
    {
        global $conn;
        $query = "Select name as holidayName, active as holidayActive, holidayDetail from Holidays where date = '$this->date'";
        $resp = $conn->query($query);
        $holiday = $resp->fetch_assoc();
        if ($holiday)
        {
            return $holiday;
        }
        return 0;
    }

    /**
     * Función que guarda una fecha como feriado
     * @fecha date = La fecha a convertir en feriado
     * @nombre string = El nombre del feriado
     * @detalle string = Información sobre el feriado
     * 
     * @return integer - id de la última inserción en la BD
     */
    function save($fecha, $nombre, $detalle, $diaCompleto)
    {
        global $conn;
        $lastId = 0;
        $query = "insert into Holidays (date, name, holidayDetail, fullDay, active)
        values ('$fecha', '$nombre', '$detalle', '$diaCompleto', 1)";
        if ($conn->query($query) === TRUE)
        {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Función que elimina un feriado de la BD
     * @fecha date - La fecha que vamos a eliminar el feriado
     * 
     * @return int - La cantidad de filas afectadas con el query
     */
    function delete($fecha)
    {
        global $conn;
        $affectedRows = 0;
        $query = "Delete from Holidays
                where date = '$fecha';";
        $conn->query($query);
        $affectedRows = $conn->affected_rows;
        return $affectedRows;
    }

    /**
     * Función que determina los días hábiles entre dos fechas, excluyendo además días feriados
     * @fechaInicio date - Fecha inicial del cálculo
     * @fechaFinal date - Fecha final del cálculo
     * 
     * @return int - Cantidad de días hábiles
     */
    public function getBusinessDays($fechaInicio, $fechaFinal)
    {
        $start = new DateTime($fechaInicio);
        $end = new DateTime($fechaFinal);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        // best stored as array, so you can add more than one
        $holidays = $this->getHolidayDates();

        foreach ($period as $dt)
        {
            $curr = $dt->format('D');
            $temp = $dt->format('Y-m-d');
            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun')
            {
                $days--;
            }
            // (optional) for the updated question
            else
            {
                foreach ($holidays as $holiday)
                {
                    if ($temp == $holiday['date'])
                    {
                        $days--;
                    }
                }
            }
        }
        return $days;
    }
}
