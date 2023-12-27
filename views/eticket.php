<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<main class="container-fluid h-100">
    <div class="row h-100 pb-3 ms-0">
        <div class="col-lg-4 border border-primary border-2 rounded me-2 pt-3 col-sm-12 mb-2">
            <h3 class="text-primary text-opacity-75">Nuevo</h3>
            <hr class="bg-primary">
            <div class="form-floating mb-3">
                <input class="form-control rounded border-primary" id="asuntoEticket" type="text" placeholder="Nombre">
                <label class="text-primary" for="asuntoEticket">Asunto</label>
            </div>
            <div class="form-floating mb-3">
                <textArea class="border-primary form-control rounded h-100" id="detalleEticket" type="text" maxlength="512" rows="8" placeholder="Nombre"></textArea>
                <label class="text-primary" for="detalleEticket">Descripción del Problema</label>
                <span class="float-end my-n5 px-1 bg-primary rounded small text-white" id="count_message"></span>
            </div>
            <div class="w-100">
                <button type="button" class="btn btn-primary float-end">Enviar</button>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12 border border-warning border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-warning text-opacity-75">Pendientes</h3>
            <hr class="bg-warning">
        </div>
        <div class="col-lg-3 col-sm-12 border border-success border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-success text-opacity-75">Cerrados</h3>
            <hr class="bg-success">
        </div>
    </div>
</main>
<script type="text/javascript" src="../js/eticket.js"></script>
<link rel="stylesheet" href="../css/eticket.css">