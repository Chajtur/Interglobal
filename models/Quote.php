<?php

include '../helpers/db.php';

class Quote
{
    public $id;
    public $date;
    public $dot;
    public $owner;
    public $status;

    public function __construct($id = null, $date = null, $dot = null,  $status = null, $owner = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->dot = $dot;
        $this->status = $status;
        $this->owner = $owner;
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

    /**
     * Función para guardar una cotización
     * 
     * return integer - El id de la cotización guardada
     */
    function save()
    {
        include_once('../models/User.php');
        global $conn;
        $query = "Insert into Quotes (date, idUser, dot)
        values (now(), '$this->owner', '$this->dot')";
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
