<?php
include "../helpers/db.php";

class holiday
{
    public $id;
    public $date;
    public $name;
    public $holidayDetail;
    public $fullDay;
    public $active;

    public function __construct($id = null, $date = null, $name = null, $holidayDetail = null, $fullDay = null, $active = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->holidayDetail = $holidayDetail;
        $this->fullDay = $fullDay;
        $this->active = $active;
    }

    /**
     * Función que devuelve solamente la lista de fechas designadas como feriado
     * 
     * @return array - Listado de fechas de feriados
     */
    function getHolidayDates()
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
    function getHolidays($date)
    {
        global $conn;
        $query = "Select name as holidayName, active as holidayActive, holidayDetail from Holidays where date = '$date'";
        $resp = $conn->query($query);
        $holiday = $resp->fetch_assoc();
        if ($holiday) {
            return $holiday;
        }
        return 0;
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
        $query = "Select v.*, concat(e.firstName, ' ', e.lastName) as approvedEmployee from Vacations v left join Employees e on v.approvedBy = e.id where idEmployee = $user";
        $resp = $conn->query($query);
        $daysOff = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        if ($daysOff) {
            return $daysOff;
        }
        return 0;
    }

    /**
     * Función que devuelve todos los días libres que ha pedido el usuario
     * @user int - El id del usuario a buscar
     * 
     * @return array - Lista de días libres que ha solicitado el usuario
     */
    function getApprovedDaysOffbyDay($date)
    {
        global $conn;
        $query = "Select v.*, concat(f.firstName, ' ', f.lastName) as requestEmployee, concat(e.firstName, ' ', e.lastName) as approvedEmployee 
    from Vacations v 
    left join Employees e on v.approvedBy = e.id 
    left join Employees f on v.idEmployee = f.id
    where v.dateFrom = '$date'";
        $resp = $conn->query($query);
        $daysOff = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        if ($daysOff) {
            return $daysOff;
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
        if ($conn->query($query) === TRUE) {
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
     * Función que inserta una solicitud de vacaciones a la BD
     * @fechaInicio date - Fecha del primer día de vacación solicitado
     * @fechaFinal date - Fecha del último día de vacación solicitado
     * @motivo string - Motivo por el cual solicita las vacaciones
     * @user int - Id del usuario solicitando las vacaciones
     * 
     * @return int - Id de la solicitud ingresada
     */
    function insertVacationRequest($fechaInicio, $fechaFinal, $motivo, $user)
    {
        global $conn;
        $lastId = 0;
        $query = "insert into Vacations (idEmployee, dateFrom, dateTo, detail, status, approvedBy, requestDate)
                values ($user, '$fechaInicio', '$fechaFinal', '$motivo', 'Solicitado', 0, NOW())";
        if ($conn->query($query) === TRUE) {
            $lastId = $conn->insert_id;
        }
        return $lastId;
    }

    /**
     * Función que determina los días hábiles entre dos fechas, excluyendo además días feriados
     * @fechaInicio date - Fecha inicial del cálculo
     * @fechaFinal date - Fecha final del cálculo
     * 
     * @return int - Cantidad de días hábiles
     */
    function getBusinessDays($fechaInicio, $fechaFinal)
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
        $holidays = getHolidayDates();

        foreach ($period as $dt) {
            $curr = $dt->format('D');
            $temp = $dt->format('Y-m-d');
            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }
            // (optional) for the updated question
            else {
                foreach ($holidays as $holiday) {
                    if ($temp == $holiday['date']) {
                        $days--;
                    }
                }
            }
        }
        return $days;
    }
}
