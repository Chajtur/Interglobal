<?php

include_once '../helpers/db.php';

class LoB{
    private $id;
    private $name;
    private $createdBy;
    private $createdDate;
    private $updatedBy;
    private $updatedDate;
    private $status;

    public function __construct($name = null, $createdBy = null, $createdDate = null, $id = null, $updatedBy = null, $updatedDate = null, $status = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdBy = $createdBy;
        $this->createdDate = $createdDate;
        $this->updatedBy = $updatedBy;
        $this->updatedDate = $updatedDate;
        $this->status = $status;
    }

    /**
     * Función que devuelve todas las líneas de negocio
     * 
     * @return array - Lista de líneas de negocio
     */
    function getAll()
    {
        global $conn;
        $query = "Select id, name
        from LoB
        where status <> 0
        order by name asc";
        $resp = $conn->query($query);
        $lob = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $lob;
    }

    /**
     * Función que devuelve una línea de negocio
     * 
     * @id integer - El id de la línea de negocio a buscar
     * 
     * @return array - La línea de negocio
     */
    function get($id)
    {
        global $conn;
        $query = "Select *
        from LoB
        where id = $id";
        $resp = $conn->query($query);
        $lob = mysqli_fetch_assoc($resp);
        return $lob;
    }

    /**
     * Función que crea una línea de negocio
     * 
     * @return integer - El id de la línea de negocio creada
     */
    function create()
    {
        global $conn;
        $query = "Insert into LoB (name, createdBy, createdDate, status)
        values ('$this->name', $this->createdBy, now(), 1)";
        $resp = $conn->query($query);
        return $conn->insert_id;
    }

    /**
     * Función que actualiza una línea de negocio
     * 
     * @return integer - El id de la línea de negocio actualizada
     */
    function update()
    {
        global $conn;
        $query = "Update LoB
        set name = '$this->name', updatedBy = $this->updatedBy, updatedDate = now()
        where id = $this->id";
        $resp = $conn->query($query);
        return $this->id;
    }

    /**
     * Función que elimina una línea de negocio
     * 
     * @return integer - El id de la línea de negocio eliminada
     */
    function delete()
    {
        global $conn;
        $query = "Update LoB
        set status = 0, updatedBy = $this->updatedBy, updatedDate = now()
        where id = $this->id";
        $resp = $conn->query($query);
        return $this->id;
    }

    /**
     * Función que reactiva una línea de negocio
     * 
     * @return integer - El id de la línea de negocio reactivada
     */
    function reactivate()
    {
        global $conn;
        $query = "Update LoB
        set status = 1, updatedBy = $this->updatedBy, updatedDate = now()
        where id = $this->id";
        $resp = $conn->query($query);
        return $this->id;
    }

    /**
     * Función que lista las líneas de negocios desactivadas
     * 
     * @return array - Lista de líneas de negocios desactivadas
     */
    function getInactive()
    {
        global $conn;
        $query = "Select id, name
        from LoB
        where status = 0
        order by name asc";
        $resp = $conn->query($query);
        $lob = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $lob;
    }
}