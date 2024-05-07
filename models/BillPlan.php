<?php

/**
 * 
 * Bill Plan class
 * 
 * This class is used to manage the Bill Plans of the quotes
 * 
 * @package models
 * @version 1.0
 * @since 1.0
 * @category classes
 * @see components/quotes/previewQuote.php
 * 
 * @author Chajtur
 * @copyright (c) 2024
 */

class BillPlan
{
    public $id;
    public $idQuote;
    public $downPayment;
    public $installments;
    public $installmentAmount;
    public $idOption;
    public $optionName;
    public $term;

    public function __construct($id = null, $idQuote = null, $downPayment = null, $installments = null, $installmentAmount = null, $idOption = null, $optionName = null, $term = null)
    {
        $this->id = $id;
        $this->idQuote = $idQuote;
        $this->downPayment = $downPayment;
        $this->installments = $installments;
        $this->installmentAmount = $installmentAmount;
        $this->idOption = $idOption;
        $this->optionName = $optionName;
        $this->term = $term;
    }

    /**
     * Función que lista todas las coverturas del bill plan
     * 
     * @return string - Lista de coberturas del bill plan
     */
    function listCoverages()
    {
        global $conn;
        $query = "Select L.name from Coverages C, LoB L where C.idBillPlan = '$this->id' and C.idQuote = $this->idQuote and L.id = C.idCoverage order by idCoverage ASC";
        $resp = $conn->query($query);
        $coverages = mysqli_fetch_all($resp, MYSQLI_ASSOC);

        // Create a comma-separated list
        $coveragesList = implode(', ', array_column($coverages, 'name'));

        return $coveragesList;
    }

    /** Función para guardar el Bill Plan
     * 
     * @return array - Respuesta con código de éxito o error y su explicación
     */
    function save()
    {
        global $conn;
        $query = "Insert into Bill_Plans (idBillPlan, idQuote, downPayment, installments, amount, idOption, optionName, term)
        values ('$this->id', $this->idQuote, $this->downPayment, $this->installments, $this->installmentAmount, $this->idOption, '$this->optionName', $this->term)";
        $resp = $conn->query($query);
        if ($resp)
        {
            return json_encode(array('code' => 200, 'message' => 'Bill Plan created successfully'));
        } else
        {
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
        $query = "Select * from Bill_Plans where idBillPlan = '$id' and idQuote = $idQuote order by idQuote ASC";
        $resp = $conn->query($query);
        $billPlan = $resp->fetch_assoc();
        $this->id = $billPlan['idBillPlan'];
        $this->idQuote = $billPlan['idQuote'];
        $this->downPayment = $billPlan['downPayment'];
        $this->installments = $billPlan['installments'];
        $this->installmentAmount = $billPlan['amount'];
        $this->idOption = $billPlan['idOption'];
        $this->optionName = $billPlan['optionName'];
        $this->term = $billPlan['term'];
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
        $query = "Select idBillPlan from Bill_Plans where idQuote = $idQuote order by idOption ASC";
        $resp = $conn->query($query);
        $billPlans = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $billPlans;
    }

}