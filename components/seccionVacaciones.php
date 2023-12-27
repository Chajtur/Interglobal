<?php

include '../models/Dates.php';
include '../models/User.php';

$data = getDaysOff(getUser());

?>
<p id="nombreFeriado" data-bs-toggle='collapse' data-bs-target="#vacacionesContent" class="w-100 bg-primary text-white rounded border border-success p-1 ps-2 shadow text-center ">Vacaciones</p>
<div id="vacacionesContent" class="collapse accordion-collapse show" data-bs-parent='#nombreFeriado'>
    <ul class="nav nav-tabs" id="tabVacaciones" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active border border-1" id="tabMisVacaciones" data-bs-toggle="tab" data-bs-target="#contentMisVacaciones" type="button" role="tab" aria-controls="misVacaciones" aria-selected="true">Mis Vacaciones</button>
        </li>
        <?php if (hasPermission('listarVacaciones')) {
            $dataDate = getApprovedDaysOffbyDay($_POST['fecha']); ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link border border-1" id="tabVacacionesPersonal" data-bs-toggle="tab" data-bs-target="#contentVacacionesPersonal" type="button" role="tab" aria-controls="vacacionesPersonal" aria-selected="false">Staff</button>
            </li>
        <?php }; ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="contentMisVacaciones" role="tabpanel" aria-labelledby="tabMisVacaciones">
            <div class="justify-content-end d-flex pe-0 my-2">
                <button type="button" class="btn btn-success solicitarVacaciones d-inline-block me-1" data-searchDate='<?php $_POST['fecha'] ?>'>Solicitar Vacaciones</button>
            </div>
            <div class="table-responsive">
                <table class="table accordion">
                    <thead>
                        <th>No</th>
                        <th>Fecha</th>
                        <th>Días</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $vacacion) {
                            switch ($vacacion['status']) {
                                case 'Solicitado':
                                    $bgColor = 'bg-info-light';
                                    break;
                                case 'Aprobado':
                                    $bgColor = 'bg-success-light';
                                    break;
                                case 'Denegado':
                                    $bgColor = 'bg-danger-light';
                                    break;
                            } ?>
                            <tr data-bs-toggle='collapse' data-bs-target='#id<?php echo $vacacion['id'] ?>' class='<?php echo $bgColor ?>'>
                                <td><?php echo ++$key ?></td>
                                <td><?php echo $vacacion['dateFrom'] ?></td>
                                <td><?php echo getBusinessDays($vacacion['dateFrom'], $vacacion['dateTo']) ?></td>
                                <td><?php echo $vacacion['status'] ?></td>
                            </tr>
                            <tr class='collapse accordion-collapse' id='id<?php echo $vacacion['id'] ?>' data-bs-parent='.table'>
                                <td colspan='4'>
                                    <div class='row'>
                                        <div class='col'>Fecha de Solicitud</div>
                                        <div class='col'><?php echo $vacacion['requestDate'] ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>Fecha Inicial</div>
                                        <div class='col'><?php echo $vacacion['dateFrom'] ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>Fecha Final</div>
                                        <div class='col'><?php echo $vacacion['dateTo'] ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>Motivo</div>
                                        <div class='col'><?php echo $vacacion['detail'] ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>Revisado Por</div>
                                        <div class='col'><?php echo $vacacion['approvedEmployee'] ?: ''; ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col'>Fecha Revisión</div>
                                        <div class='col'><?php echo $vacacion['approvedDate'] ?: '' ?></div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane" id="contentVacacionesPersonal" role="tabpanel" aria-labelledby="tabVacacionesPersonal">
            <?php if ($dataDate) { ?>
                <div class="table-responsive">
                    <table class="table accordion">
                        <thead>
                            <th>No</th>
                            <th>Fecha</th>
                            <th>Días</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php foreach ($dataDate as $key => $vacacion) {
                                switch ($vacacion['status']) {
                                    case 'Solicitado':
                                        $bgColor = 'bg-info-light';
                                        break;
                                    case 'Aprobado':
                                        $bgColor = 'bg-success-light';
                                        break;
                                    case 'Denegado':
                                        $bgColor = 'bg-danger-light';
                                        break;
                                } ?>
                                <tr data-bs-toggle='collapse' data-bs-target='#id<?php echo $vacacion["id"] ?>' class='<?php echo $bgColor ?>'>
                                    <td><?php echo ++$key ?></td>
                                    <td><?php echo $vacacion['dateFrom'] ?></td>
                                    <td><?php echo getBusinessDays($vacacion['dateFrom'], $vacacion['dateTo']) ?></td>
                                    <td><?php echo $vacacion['status'] ?></td>
                                </tr>
                                <tr class='collapse accordion-collapse' id='id<?php echo $vacacion['id'] ?>' data-bs-parent='.table'>
                                    <td colspan='4'>
                                        <div class='row'>
                                            <div class='col'>Solicitado Por</div>
                                            <div class='col'><?php echo $vacacion['requestEmployee'] ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Fecha de Solicitud</div>
                                            <div class='col'><?php echo $vacacion['requestDate'] ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Fecha Inicial</div>
                                            <div class='col'><?php echo $vacacion['dateFrom'] ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Fecha Final</div>
                                            <div class='col'><?php echo $vacacion['dateTo'] ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Motivo</div>
                                            <div class='col'><?php echo $vacacion['detail'] ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Revisado Por</div>
                                            <div class='col'><?php echo ($vacacion['approvedEmployee'] ?: '') ?></div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>Fecha Revisión</div>
                                            <div class='col'><?php echo ($vacacion['approvedDate'] ?: '') ?></div>
                                        </div>
                                        <hr>
                                        <?php if (hasPermission('aprobarVacaciones')) { ?>
                                            <div class="row">
                                                <div class="justify-content-end d-flex pe-0 my-2">
                                                    <button type="button" class="btn btn-success solicitarVacaciones d-inline-block me-1" data-searchDate='<?php $_POST['fecha'] ?>'>Aprobar</button>
                                                    <button type="button" class="btn btn-danger solicitarVacaciones d-inline-block me-1" data-searchDate='<?php $_POST['fecha'] ?>'>Rechazar</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class='mt-2'>No hay solicitudes de vacaciones para esta fecha</div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
echo "<script>$('#spinner').modal('hide');</script>";
?>