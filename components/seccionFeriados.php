<?php

include '../models/Dates.php';
include '../models/User.php';

$data = getHolidays($_POST['fecha']);
?>

<p id="listaVacaciones" class="w-100 bg-primary text-white rounded border bg-opacity-50 border-primary p-1 ps-2 shadow mb-2 text-center">Feriado</p>

<?php
if (($data) && ($data['holidayActive'])) { ?>
    <div class="row">
        <p class="fw-bold text-success"><?= $data['holidayName'] ?></p>
        <p><?= $data['holidayDetail'] ?></p>
    </div>
    <?php if (hasPermission(15)) { ?>
        <div class="justify-content-end d-flex pe-0">
            <button type="button" class="btn eliminarFeriado btn-danger d-inline-block me-1" data-searchDate="<?= $_POST['fecha'] ?>">Eliminar Feriado</button>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="">No hay feriado en esta fecha</div>
    <?php if (hasPermission(15)) { ?>
        <div class="justify-content-end d-flex pe-0">
            <button type="button" class="btn asignarFeriado btn-success d-inline-block me-1" data-searchDate="<?= $_POST['fecha'] ?>">Asignar Feriado</button>
        </div>
<?php }
} ?>