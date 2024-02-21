<?php 

include_once '../helpers/db.php';

class Coverage {
    public $id;
    public $idQuote;
    public $idBillPlan;
    public $carrier;
    public $amount;
    public $basePremium;
    public $totalPremium;
    public $taxesFees;
    public $notes;

    public function __construct($id = null, $idQuote = null, $idBillPlan = null, $carrier = null, $amount = null, $basePremium = null, $taxesFees = null, $notes = null)
    {
        $this->id = $id;
        $this->idQuote = $idQuote;
        $this->idBillPlan = $idBillPlan;
        $this->carrier = $carrier;
        $this->amount = $amount;
        $this->basePremium = $basePremium;
        $this->totalPremium = $basePremium + $taxesFees;
        $this->taxesFees = $taxesFees;
        $this->notes = $notes;
    }

    /** Función para guardar la cobertura
     * 
     * @return json - Respuesta con código de éxito o error y su explicación
     */
    function save()
    {
        global $conn;
        $query = "Insert into Coverages (idCoverage, idQuote, idBillPlan, carrier, amount, basePremium, taxesFees, notes)
        values ($this->id, $this->idQuote, '$this->idBillPlan', '$this->carrier', $this->amount, $this->basePremium, $this->taxesFees, '$this->notes')";
        $resp = $conn->query($query);
        if ($resp) {
            return json_encode(array('code' => 200, 'message' => 'Coverage created successfully'));
        } else {
            return json_encode(array('code' => 500, 'message' => 'Error creating Coverage'));
        }
    }

    /** Función para cargar una cobertura
     * 
     * @id integer - El id de la cobertura a buscar
     * @idQuote integer - El id de la cotización a la que pertenece la cobertura
     * @idBillPlan integer - El id del Bill Plan al que pertenece la cobertura
     * 
     * @return array - Devuelve la cobertura
     */
    function load($id, $idQuote, $idBillPlan)
    {
        global $conn;
        $query = "Select * from Coverages where idCoverage = $id and idQuote = $idQuote and idBillPlan = $idBillPlan";
        $resp = $conn->query($query);
        $coverage = $resp->fetch_assoc();
        return $coverage;
    }

    /** Función que lista todas las Coberturas del Bill Plan 
     * 
     * @idQuote integer - El id de la cotización a buscar
     * @idBillPlan integer - El id del Bill Plan a buscar
     * 
     * @return array - Lista de coberturas del Bill Plan
     */
    function listAll($idQuote, $idBillPlan)
    {
        global $conn;
        $query = "Select idCoverage from Coverages where idQuote = $idQuote and idBillPlan = $idBillPlan";
        $resp = $conn->query($query);
        $coverages = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $coverages;
    }

}