<?php
include "../helpers/db.php";

class Business
{
    public $id;
    public $dot;
    public $name;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $phone;
    public $email;
    public $rep;

    public function __construct($id = null, $dot = null, $name = null, $address = null, $city = null, $state = null, $zip = null, $phone = null, $email = null, $rep = null)
    {
        $this->id = $id;
        $this->dot = $dot;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->phone = $phone;
        $this->email = $email;
        $this->rep = $rep;
    }

    /**
     * Devuelve un perfil al azar de una empresa
     * 
     * @state string - Fija un estado del cual buscar perfiles, 'All' para cualquiera
     * @status integer - Define si queremos una empresa sin llamar o ya contactada
     * 
     * @return array - Retorna el perfil de una empresa
     */
    public function getNewBusiness($state, $status)
    {
        global $conn;
        $query = 'Select * 
        from Lists l';
        if ($status == 0) {
            $query .= ' where l.dot
        not in (
            select c.dot 
            from Calls c
            where (c.status in ("Lead", "Possible Lead", "Black List"))
            or (c.status = "No Answer" and c.date > date_sub(now(), interval 168 hour))
            or (c.status = "Not Interested" and c.date > date_sub(now(), interval 720 hour)))';
        } else if ($status == 1) {
            $query .= ' where l.dot
            not in (
                select distinct(c.dot)
                from Calls c)';
        } else if ($status == 2) {
            $query .= ' where l.dot
            in (
                select distinct(c.dot)
                from Calls c
                where c.status = "No Answer")';
        }
        if ($state != 'All') {
            $query .= " and l.Business_State = '$state'";
        } else {
            $query .= " and l.Business_State not in ('CA', 'NY')";
        }
        $query .= 'and l.Insurer is null 
    order by RAND() limit 1';
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }

    /**
     * Devuelve el perfil de una empresa para renovación al azar
     * 
     * @state string - Fija un estado del cual buscar perfiles, 'All' para cualquiera
     * @status integer - Define si queremos una empresa sin llamar o ya contactada
     * 
     * @return array - Devuelve el perfil de una empresa
     */
    function getRenewBusiness($state, $status)
    {
        global $conn;
        $query = 'Select * 
        from Lists l';
        if ($status == 0) {
            $query .= ' where l.dot
        not in (
            select c.dot 
            from Calls c
            where (c.status in ("Lead", "Possible Lead", "Black List"))
            or (c.status = "No Answer" and c.date > date_sub(now(), interval 168 hour))
            or (c.status = "Not Interested" and c.date > date_sub(now(), interval 720 hour)))';
        } else if ($status == 1) {
            $query .= ' where l.dot
            not in (
                select distinct(c.dot)
                from Calls c)';
        } else if ($status == 2) {
            $query .= ' where l.dot
            in (
                select distinct(c.dot)
                from Calls c
                where c.status = "No Answer")';
        }
        if ($state != 'All') {
            $query .= " and l.Business_State = '$state'";
        }
        $query .= 'and l.Insurer is not null
    and date(now()) <= concat(year(now()), "-", l.Policy_Expiration_Month, "-", l.Policy_Expiration_Day)
    order by RAND() limit 1';
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }

    /**
     * Función que devuelve el perfil de una empresa basado en el DOT
     * 
     * @dot integer - Especifica el DOT que vamos a buscar
     * 
     * @return array - Devuelve el perfil de la empresa
     */
    function getNewBusinessByDot($dot)
    {
        global $conn;
        $query = "Select * 
        from Lists l
        where l.dot = $dot";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }

    /**
     * Función que devuelve el perfil de una empresa basado en el número de teléfono
     * 
     * @phone integer - Especifíca el número a buscar
     * 
     * @return array - Devuelve el perfil de la empresa
     */
    function getNewBusinessByPhone($phone)
    {
        global $conn;
        $query = "Select * 
        from Lists l
        where l.Phone = $phone";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }
}
