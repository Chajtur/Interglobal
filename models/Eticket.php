<?php
include "../helpers/db.php";
include_once '../models/User.php';

class ticket
{
    public $id;
    public $type;
    public $issue;
    public $description;
    public $createdBy;
    public $createdOn;
    public $priority;
    public $status;
    public $assignedTo;
    public $assignedOn;
    public $closedOn;
    public $closedBy;
    public $closedReason;
    public $closedComment;

    public function __construct($id = null, $type = null, $issue = null, $description = null, $createdBy = null, $createdOn = null, $priority = null, $status = null, $assignedTo = null, $assignedOn = null, $closedOn = null, $closedBy = null, $closedReason = null, $closedComment = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->issue = $issue;
        $this->description = $description;
        $this->createdBy = $createdBy;
        $this->createdOn = $createdOn;
        $this->priority = $priority;
        $this->status = $status;
        $this->assignedTo = $assignedTo;
        $this->assignedOn = $assignedOn;
        $this->closedOn = $closedOn;
        $this->closedBy = $closedBy;
        $this->closedReason = $closedReason;
        $this->closedComment = $closedComment;
    }

    /**
     * Función que devuelve todos los tickets que ha creado un usuario
     * 
     * @user integer - El id del usuario a buscar
     * 
     * @return array - Lista de tickets que ha creado el usuario
     */
    function getTickets($user)
    {
        global $conn;
        $query = "Select t.id, t.type, t.issue, t.description, t.createdBy, t.createdOn, t.priority, t.status, t.assignedTo, t.assignedOn, t.closedOn, t.closedBy, t.closedReason, t.closedComment
        from Tickets t
        where t.createdBy = $user
        order by t.createdOn desc";
        $resp = $conn->query($query);
        $tickets = mysqli_fetch_all($resp, MYSQLI_ASSOC);
        return $tickets;
    }

    /** Función que guarda el ticket en la BD
     * $type string - El tipo de ticket
     * $issue string - El asunto del ticket
     * $description string - La descripción del ticket
     * 
     * @return integer - id de la última inserción en la BD
     */
    function save($type, $issue, $description)
    {
        global $conn;
        $user = getUser();
        $query = "INSERT INTO Tickets (type, issue, description, createdBy, createdOn, priority) VALUES (?, ?, ?, ?, NOW(), 3)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $type, $issue, $description, $user);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $stmt->insert_id;
        } else {
            return $conn->error;
        }
    }
}
