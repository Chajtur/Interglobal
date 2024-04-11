<?php

include_once '../controllers/Login.php';

startSession();
checkActivity();

include '../models/Dates.php';
include_once '../models/User.php';

$user = new User($_SESSION['user']['id']);

$date = new Holiday($_POST['fecha']);

$data = $date->getHolidays();
?>

<h4 id="listaVacaciones" class="w-full bg-sky-950 text-white rounded border border-sky-950 p-1 ps-2 shadow">Holiday</h4>
<div class="mt-2">
<?php
if (($data) && ($data['holidayActive'])) { ?>
    <div class="flex flex-row w-full justify-between">
        <div class="flex flex-col">
            <h4 class="font-bold text-green-800"><?= $data['holidayName'] ?></h4>
            <p><?= $data['holidayDetail'] ?></p>
        </div>
        <?php if ($user->hasPermission('aprobarFeriado')) { ?>
            <div class="justify-content-end flex pe-0">
                <button type="button" class="btn-danger eliminarFeriado  me-1" data-searchDate="<?= $_POST['fecha'] ?>">Remove Holiday</button>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="flex flex-row w-full justify-between">
        <div>No holidays on this date</div>
        <?php if ($user->hasPermission('aprobarFeriado')) { ?>
            <button type="button" class="btn-success asignarFeriado" data-searchDate="<?= $_POST['fecha'] ?>">Set Holiday</button>
    </div>
<?php }
    } ?>
</div>