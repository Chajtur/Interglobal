<?php
include '../models/Dates.php';

$fecha = $_POST['fecha'];
$fecha = date('Y-m-d', strtotime($fecha));

?>
<div class="flex flex-col">
    <h4>Start and end dates of Vacation Request</h4>
    <div class="flex flex-col">
        <label class="text-sky-950" for="primerDiaVacaciones">From</label>
        <input disabled class="rounded border-sky-950 p-2 border" id="primerDiaVacaciones" type="date" value=<?= $fecha ?> placeholder="From">
    </div>
    <div class="flex flex-col">
        <label class="text-sky-950" for="ultimoDiaVacaciones">To</label>
        <input class="rounded border-sky-950 p-2 border" id="ultimoDiaVacaciones" type="date" min=<?= $fecha ?> placeholder="To">
    </div>
    <div class="flex flex-col">
        <label for="descripcionFeriado">Reason for Request</label>
        <textArea class="rounded h-full p-3 border border-sky-950" id="motivoVacaciones" type="text" maxlength="256" rows="5" placeholder="Reason for request"></textArea>
        <span class="float-end px-1 bg-blue-500 rounded text-sm text-white" id="count_message"></span>
    </div>
</div>