<?php
/**
 * Path: models/Quote.php
 * This file contains the Quote class and the pendingQuote class.
 * The Quote class is used to manage quotes created by the user.
 * The pendingQuote class is used to manage quotes that have been assigned to the user and generated through webpage.
 * 
 * @package models
 * @version 1.0
 * @since 1.0
 * @category classes
 * @see components/quotes/previewQuote.php
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';
startSession();

include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php';

class Quote
{
    public $id;
    public $date;
    public $dot;
    public $owner;
    public $type;
    public $status;
    public $agent;

    public function __construct($id = null, $date = null, $dot = null, $status = 'Quoted', $owner = null, $type = null, $idUser = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->dot = $dot;
        $this->status = $status;
        $this->type = $type;
        $this->owner = $owner;
        $this->agent = $idUser;
    }

    /**
     * Función que lista todas las opciones dentro de la cotización
     * 
     * @return array - Lista de opciones de la cotización
     */
    function listOptions()
    {
        global $conn;
        $query = "Select distinct(idOption) from Bill_Plans where idQuote = $this->id order by idOption asc";
        $resp = $conn->query($query);
        $options = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $options;
    }

    /**
     * Función que lista todos los bill plans de una opción de la cotización
     * @idOption integer - El id de la opción a buscar
     * 
     * @return array - Lista de bill plans de la opción
     */
    function listBillPlans($idOption)
    {
        global $conn;
        $query = "Select idBillPlan from Bill_Plans where idQuote = $this->id and idOption = $idOption order by idBillPlan asc";
        $resp = $conn->query($query);
        $billPlans = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $billPlans;
    }

    /**
     * Función que carga una cotización al objeto
     * @id integer - El id de la cotización a cargar
     * 
     * @return array - Devuelve la cotización
     */
    function load($id)
    {
        global $conn;
        $query = "Select * from Quotes where id = $id";
        $resp = $conn->query($query);
        $quote = $resp->fetch_assoc();
        $this->id = $quote['id'];
        $this->date = $quote['date'];
        $this->dot = $quote['dot'];
        $this->status = $quote['status'];
        $this->type = $quote['type'];
        $this->owner = $quote['name'];
    }

    /**
     * Función que elimina una cotización y todos sus bill plans juton con las coberturas
     * 
     * @id integer - El id de la cotización a eliminar
     * 
     * @return json - Respuesta con código de éxito o error y su explicación
     */
    function delete($id)
    {
        global $conn;
        $query = "Delete from Quotes where id = $id";
        $resp = $conn->query($query);
        if ($resp) {
            $query = "Delete from Bill_Plans where idQuote = $id";
            $resp = $conn->query($query);
            if($resp){
                $query = "Delete from Quote_Coverages where idQuote = $id";
                $resp = $conn->query($query);
                if($resp){
                    return json_encode(array('code' => 200, 'message' => 'Quote deleted successfully'));
                } else {
                    return json_encode(array('code' => 500, 'message' => 'Error deleting Quote Coverages'));
                }
            } else {
                return json_encode(array('code' => 500, 'message' => 'Error deleting Bill Plans'));
            }
        } else {
            return json_encode(array('code' => 500, 'message' => 'Error deleting Quote'));
        }
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
        $query = "Select id, date(`date`) as date, dot, name
        from Quotes q
        where q.idUser = $user
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
        $query = "Select id, date(`date`) as date, dot, type from Quotes where id = $id";
        $resp = $conn->query($query);
        $quote = mysqli_fetch_assoc($resp);
        return $quote;
    }

    /**
     * Función para guardar una cotización
     * 
     * return integer - El id de la cotización guardada
     */
    function save()
    {
        include_once('../models/User.php');
        global $conn;
        $query = "Insert into Quotes (date, idUser, dot, type)
        values (now(), '$this->owner', '$this->dot', '$this->type')";
        $conn->query($query);
        $this->id = $conn->insert_id;
        if ($this->id) {
            return json_encode(array('code' => 200, 'message' => 'Quote saved successfully', 'id' => $this->id));
        } else {
            return json_encode(array('code' => 500, 'message' => 'Error saving Quote'));
        }
        return $conn->insert_id;
    }
};


class pendingQuote
{
    public $id;
    public $date;
    public $businessName;
    public $status;
    public $owner;
    public $dot;
    
    public function __construct($id = null, $date = null, $businessName = null, $status = null, $owner = null,$type = null, $dot = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->businessName = $businessName;
        $this->status = $status;
        $this->owner = $owner;
        $this->dot = $dot;
    }

    /**
     * Función que devuelve todas las cotizaciones que se han asignado a un usuario
     * 
     * @user integer - El id del usuario a buscar
     * 
     * @return array - Lista de cotizaciones que se han asignado al usuario
     */
    public static function getAll($user)
    {
        global $conn;
        $query = "Select q.id, date(q.date) as date, q.dot, q.status, q.name, q.owner as owner
        from Requested_Quotes q, Employees u 
				where q.owner = u.id
        and q.status = 'Requested' and q.owner = $user
        order by q.date desc";
        $resp = $conn->query($query);
        $quotes = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $quotes;
    }
}