<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<main class="container-fluid h-100">
    <div class="row h-100 pb-3 ms-0">
        <div class="col">
            <div id="openTicket"></div>
            <div id="FAQ"></div>
        </div>
        <div class="col-lg-3 col-sm-12 border border-warning border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-warning text-opacity-75" id="">Open Tickets</h3>
            <hr class="bg-warning">
            <div id="openTickets"></div>
        </div>
        <div class="col-lg-3 col-sm-12 border border-success border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-success text-opacity-75" id="">Closed Tickets</h3>
            <hr class="bg-success">
            <div id="closedTickets"></div>
        </div>
    </div>
</main>
<script type="text/javascript" src="../js/eticket.js"></script>
<link rel="stylesheet" href="../css/eticket.css">