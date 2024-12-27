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
            $query .= ' where l.New_Call = 1';
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
            $query .= " and l.Business_State not in ('CA', 'NY', 'MN')";
        }
        $query .= 'and l.DOT not in (select distinct(c.dot) from Calls c where c.status in ("Lead", "Possible Lead", "Black List"))';
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

class truckerBusiness 
{
    private $id;
    private $dot;
    private $name;
    private $address;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $email;
    private $rep;
    private $mailingAddress;
    private $mailingCity;
    private $mailingState;
    private $mailingZip;
    private $dotPin;
    private $irp;
    private $mc;


    public function __construct($id = null, $dot = null, $name = null, $address = null, $city = null, $state = null, $zip = null, $phone = null, $email = null, $rep = null, $mailingAddress = null, $mailingCity = null, $mailingState = null, $mailingZip = null, $dotPin = null, $irp = null, $mc = null)
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
        $this->mailingAddress = $mailingAddress;
        $this->mailingCity = $mailingCity;
        $this->mailingState = $mailingState;
        $this->mailingZip = $mailingZip;
        $this->dotPin = $dotPin;
        $this->irp = $irp;
        $this->mc = $mc;
    }

    /**
     * Función que actualiza un camionero en la base de datos
     * 
     * @id integer - Especifica el id del camionero
     * @dot integer - Especifica el DOT del camionero
     * @name string - Especifica el nombre del camionero
     * @address string - Especifica la dirección del camionero
     * @city string - Especifica la ciudad del camionero
     * @state string - Especifica el estado del camionero
     * @zip integer - Especifica el código postal del camionero
     * @phone integer - Especifica el número de teléfono del camionero
     * @email string - Especifica el correo electrónico del camionero
     * @rep string - Especifica el representante del camionero
     * @mailingAddress string - Especifica la dirección de envío del camionero
     * @mailingCity string - Especifica la ciudad de envío del camionero
     * @mailingState string - Especifica el estado de envío del camionero
     * @mailingZip integer - Especifica el código postal de envío del camionero
     * @dotPin blob - Especifica el PIN del DOT del camionero
     * @irp blob - Especifica el IRP del camionero
     * @mc string - Especifica el MC del camionero
     * 
     * @return boolean - Retorna si la operación fue exitosa
     */
    function update($id, $dot, $name, $address, $city, $state, $zip, $phone, $email, $rep, $mailingAddress, $mailingCity, $mailingState, $mailingZip, $dotPin, $irp, $mc)
    {
        global $conn;
        $query = "Update Businesses 
        set DOT = $dot, Name = '$name', Address = '$address', City = '$city', State = '$state', Zip = $zip, Phone = $phone, Email = '$email', Rep = '$rep', Mailing_Address = '$mailingAddress', Mailing_City = '$mailingCity', Mailing_State = '$mailingState', Mailing_Zip = $mailingZip, DOT_PIN = '$dotPin', IRP = '$irp', MC = '$mc'
        where id = $id";
        $resp = $conn->query($query);
        return $resp;
    }

    /**
     * Función que guarda los datos de un camionero en la base de datos
     * 
     * @dot integer - Especifica el DOT del camionero
     * @name string - Especifica el nombre del camionero
     * @address string - Especifica la dirección del camionero
     * @city string - Especifica la ciudad del camionero
     * @state string - Especifica el estado del camionero
     * @zip integer - Especifica el código postal del camionero
     * @phone integer - Especifica el número de teléfono del camionero
     * @email string - Especifica el correo electrónico del camionero
     * @rep string - Especifica el representante del camionero
     * @mailingAddress string - Especifica la dirección de envío del camionero
     * @mailingCity string - Especifica la ciudad de envío del camionero
     * @mailingState string - Especifica el estado de envío del camionero
     * @mailingZip integer - Especifica el código postal de envío del camionero
     * @dotPin blob - Especifica el PIN del DOT del camionero
     * @irp blob - Especifica el IRP del camionero
     * @mc string - Especifica el MC del camionero
     * 
     * @return boolean - Retorna si la operación fue exitosa
     */
    function save($dot, $name, $address, $city, $state, $zip, $phone, $email, $rep, $mailingAddress, $mailingCity, $mailingState, $mailingZip, $dotPin, $irp, $mc)
    {
        global $conn;
        $query = "Insert into Businesses (DOT, Name, Address, City, State, Zip, Phone, Email, Rep, Mailing_Address, Mailing_City, Mailing_State, Mailing_Zip, DOT_PIN, IRP, MC)
        values ($dot, '$name', '$address', '$city', '$state', $zip, $phone, '$email', '$rep', '$mailingAddress', '$mailingCity', '$mailingState', $mailingZip, '$dotPin', '$irp', '$mc')";
        $resp = $conn->query($query);
        if ($resp->num_rows > 0)
        {
            return $conn->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Función que busca un camionero por su id
     * 
     * @id integer - Especifica el id del camionero
     * 
     * @return array - Devuelve el perfil del camionero
     */
    function get($id)
    {
        global $conn;
        $query = "Select * 
        from Businesses l
        where l.id = $id";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }

    /**
     * Función que devuelve el perfil de un camionero basado en el DOT
     * 
     * @dot integer - Especifica el DOT que vamos a buscar
     * 
     * @return array - Devuelve el perfil del camionero
     */
    function getTruckerBusinessByDot($dot)
    {
        global $conn;
        $query = "Select * 
        from Businesses l
        where l.dot = $dot";
        $resp = $conn->query($query);
        $data = $resp->fetch_assoc();
        return $data;
    }



}