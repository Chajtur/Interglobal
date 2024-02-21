<?php

include_once '../helpers/db.php';

class BillPlan {
    public $id;
    public $idQuote;
    public $downPayment;
    public $installments;
    public $installmentAmount;
    public $idOption;
    public $term;

    public function __construct($id = null, $idQuote = null, $downPayment = null, $installments = null, $installmentAmount = null, $idOption = null, $term = null)
    {
        $this->id = $id;
        $this->idQuote = $idQuote;
        $this->downPayment = $downPayment;
        $this->installments = $installments;
        $this->installmentAmount = $installmentAmount;
        $this->idOption = $idOption;
        $this->term = $term;
    }

    /** Función para guardar el Bill Plan
     * 
     * @return json - Respuesta con código de éxito o error y su explicación
     */
    function save()
    {
        global $conn;
        $query = "Insert into Bill_Plans (idBillPlan, idQuote, downPayment, installments, amount, idOption, term)
        values ('$this->id', $this->idQuote, $this->downPayment, $this->installments, $this->installmentAmount, $this->idOption, $this->term)";
        $resp = $conn->query($query);
        if ($resp) {
            return json_encode(array('code' => 200, 'message' => 'Bill Plan created successfully'));
        } else {
            return json_encode(array('code' => 500, 'message' => 'Error creating Bill Plan'));
        }
    }

    /** Función para cargar un Bill Plan
     * 
     * @id integer - El id del Bill Plan a buscar
     * @idQuote integer - El id de la cotización a la que pertenece el Bill Plan
     * 
     * @return array - Devuelve el Bill Plan
     */
    function load($id, $idQuote)
    {
        global $conn;
        $query = "Select * from Bill_Plans where id = $id and idQuote = $idQuote";
        $resp = $conn->query($query);
        $billPlan = $resp->fetch_assoc();
        return $billPlan;
    }

    /** Función que lista todos los bill plans de una cotización
     * 
     * @idQuote integer - El id de la cotización a buscar
     * 
     * @return array - Lista de bill plans de la cotización
     */
    function listAll($idQuote)
    {
        global $conn;
        $query = "Select idBillPlan from Bill_Plans where idQuote = $idQuote";
        $resp = $conn->query($query);
        $billPlans = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $billPlans;
    }

}