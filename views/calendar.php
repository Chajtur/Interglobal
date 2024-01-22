<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../models/User.php';
$user = new User();
?>
<main>
    <div class="row">
        <div class="col-xl-8 col-lg-12 my-3" id='calendarDiv'>
            <?php include('../components/calendarHR.php'); ?>
        </div>
        <div class="col-xl-4 col-lg-12 my-1">
            <row class="row border-bottom border-4 border-danger">
                <h3>Opciones</h3>
            </row>
            <form class="form-control">
                <div class="row my-1" id="empleadoSelectDiv">
                    <span for='empleadoSelect' id="empleadoSelectSpan">Seleccione el Empleado</span>
                    <select class="form-select my-1 pb-1" id='empleadoSelect' data-show='<?php echo $user->hasPermission('listarMarcacionesPersonal'); ?>' data-employee='<?php echo $_SESSION['user']['id']; ?>'></select>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label for="year" class="form-label">Introduzca el Año</label>
                        <input type="integer" class="form-control" id="year" placeholder="Introduzca el Año" value="2023">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="month" class="form-label">Seleccione el Mes</label>
                        <select class="form-select" id='mesSelect'>
                            <option value="0">Enero</option>
                            <option value="1">Febrero</option>
                            <option value="2">Marzo</option>
                            <option value="3">Abril</option>
                            <option value="4">Mayo</option>
                            <option value="5">Junio</option>
                            <option value="6">Julio</option>
                            <option value="7">Agosto</option>
                            <option value="8">Septiembre</option>
                            <option value="9">Octubre</option>
                            <option value="10">Noviembre</option>
                            <option value="11">Diciembre</option>
                        </select>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary" id='generarBtn'>Generar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row d-none" id="estadisticasDiv">
                    <div class="row ps-0 border-bottom border-2 border-danger">
                        <h2 class="ps-0">Estadísticas</h2>
                    </div>
                    <div class="row ps-0">
                        <h4 class="ps-0 pt-2">Minutos Tarde</h4>
                    </div>
                    <div class="row">
                        <table class="table rounded">
                            <thead>
                                <tr class="text-danger">
                                    <th>Total Mes :</th>
                                    <th id="totalMes" class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-primary">
                                    <td>1ra Quincena :</td>
                                    <td id="primeraQuincena" class="text-end"></td>
                                </tr>
                                <tr class="text-primary ">
                                    <td>2da Quincena :</td>
                                    <td class="text-end" id="segundaQuincena"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<script type="text/javascript" src="../js/calendar.js"></script>
<link rel="stylesheet" href="../css/calendar.css">