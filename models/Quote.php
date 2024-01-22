<?php

include '../helpers/db.php';

class Quote
{
    public $id;
    public $date;
    public $name;
    public $dot;
    public $mc;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $email;
    public $phone;
    public $proposedDate;
    public $driverLicense;
    public $status;
    public $owner;

    public function __construct($id = null, $date = null, $name = null, $dot = null, $mc = null, $address = null, $city = null, $state = null, $zip = null, $email = null, $phone = null, $proposedDate = null, $driverLicense = null, $status = null, $owner = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->dot = $dot;
        $this->mc = $mc;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->email = $email;
        $this->phone = $phone;
        $this->proposedDate = $proposedDate;
        $this->driverLicense = $driverLicense;
        $this->status = $status;
        $this->owner = $owner;
    }

    /**
     * Función que devuelve todas las cotizaciones que ha creado un usuario
     * 
     * @user integer - El id del usuario a buscar
     * 
     * @return array - Lista de cotizaciones que ha creado el usuario
     */
    function getAll($user)
    {
        global $conn;
        $query = "Select id, date, name, status
        from Quotes q
        where q.owner = $user
        and q.status <> 'Closed'
        group by q.dot, q.owner, q.proposedDate
        order by q.date desc";
        $resp = $conn->query($query);
        $quotes = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $quotes;
    }

    /** Función que devuelve el detalle de una sola quote
     * $id integer - El id de la quote a buscar
     * 
     * @return array - Devuelve la quote
     */
    function getQuoteDetail($id)
    {
        global $conn;
        $query = "Select id, date, name, dot, mc, address, city, state, zip, email, phone, proposedDate, driverLicense, status, owner
        from Quotes q
        where q.id = $id";
        $resp = $conn->query($query);
        $quote = $resp->fetch_assoc();
        return $quote;
    }

    /** Función que almacena la quote en la BD
     * $name string - El nombre de la empresa
     * $dot integer - El DOT de la empresa
     * $mc integer - El MC de la empresa
     * $address string - La dirección de la empresa
     * $city string - La ciudad de la empresa
     * $state string - El estado de la empresa
     * $zip integer - El código postal de la empresa
     * $email string - El email de la empresa
     * $phone integer - El teléfono de la empresa
     * $proposedDate date - La fecha propuesta para la cotización
     * $driverLicense string - La licencia del conductor
     * $status string - El estado de la cotización
     * $ownersName string - El nombre del dueño de la empresa
     * 
     * @return integer - Devuelve 1 si se guardó correctamente, 0 si no
     */
    function save($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, $status, $ownersName)
    {
        global $conn;
        $query = "insert into Quotes (date, name, dot, mc, address, city, state, zip, email, phone, proposedDate, driverLicense, status, owner) values (NOW(), '$name', $dot, $mc, '$address', '$city', '$state', $zip, '$email', $phone, '$proposedDate', '$driverLicense', '$status', '$ownersName')";
        $resp = $conn->query($query);
        if ($resp == 1) {
            sendRequestQuoteMail($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, $status, $ownersName);
        }
        return $resp;
    }
}
