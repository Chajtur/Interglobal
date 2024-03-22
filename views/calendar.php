<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../models/User.php';
$user = new User();
?>
<main class="p-2">
    <div class="flex flex-col lg:flex-row text-sky-950">
        <div class="flex-col lg:w-2/3 md:w-full" id='calendarDiv'>
            <?php include('../components/calendarHR.php'); ?>
        </div>
        <div class="flex-col lg:w-1/3 md:w-full lg:ms-2">
            <div class="border-b-4 border-red-900">
                <h4>Options</h4>
            </div>
            <form class="form-control border-2 p-3">
                <div class="flex flex-col" id="empleadoSelectDiv">
                    <label for="empleadoSelect" class="form-label">Select Employee</label>
                    <select class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id='empleadoSelect' data-show='<?php echo $user->hasPermission('listarMarcacionesPersonal'); ?>' data-employee='<?php echo $_SESSION['user']['id']; ?>'></select>
                </div>
                <div class="mt-2">
                    <div>
                        <label for="year" class="form-label">Input year</label>
                        <input type="integer" class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="year" placeholder="Input the Year" value="2024">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="month" class="form-label">Select month</label>
                        <select class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id='mesSelect'>
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
                <div class="text-right w-full md:w-2/3 my-1">
                    <button type="button" class="btn-primary" id='generarBtn'>Generate</button>
                </div>
                    <hr class="my-2">
                <div class="flex-col hidden" id="estadisticasDiv">
                    <div class="ps-0 border-b-2 border-red-600">
                        <h2 class="ps-0">Statistics</h2>
                    </div>
                    <div class="ps-0">
                        <h4 class="ps-0 pt-2">Late Minutes</h4>
                    </div>
                    <div class="">
                        <table class="table rounded">
                            <thead>
                                <tr class="text-red-600">
                                    <th>Month Total :</th>
                                    <th id="totalMes" class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-sky-950">
                                    <td>1st Fortnight :</td>
                                    <td id="primeraQuincena" class="text-end"></td>
                                </tr>
                                <tr class="text-sky-950">
                                    <td>2nd Fortnight :</td>
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