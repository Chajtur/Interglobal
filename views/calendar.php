<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
startSession();
checkActivity();

$user = new User();
?>
<main class="p-2">
    <div class="flex flex-col lg:flex-row text-sky-950">
        <div class="flex-col lg:w-2/3 md:w-full" id='calendarDiv'>
            <?php include ('../components/calendar/calendarHR.php'); ?>
        </div>
        <div class="flex-col lg:w-1/3 md:w-full lg:ms-2">
            <div class="border-b-4 border-red-900">
                <h4>Options</h4>
            </div>
            <form class="form-control p-2">
                <div class="flex flex-col" id="empleadoSelectDiv">
                    <label for="empleadoSelect" class="form-label">Select Employee</label>
                    <select
                        class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        id='empleadoSelect' data-show='<?php echo $user->hasPermission('listarMarcacionesPersonal'); ?>'
                        data-employee='<?php echo $_SESSION['user']['id']; ?>'></select>
                </div>
                <div class="mt-2">
                    <div>
                        <label for="year" class="form-label">Input year</label>
                        <input type="integer"
                            class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                            id="year" placeholder="Input the Year" value="2024">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="month" class="form-label">Select month</label>
                        <select
                            class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                            id='mesSelect'>
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                    </div>
                </div>
                <div class="text-right w-full md:w-2/3 my-1">
                    <button type="button" class="btn-primary" id='generarBtn'>Load</button>
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
            <div>
                <h4 class="w-full border-b-4 border-red-900">Days Off</h4>
                <div id="daysOff">
                    <?php include ('../components/calendar/daysOff.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<link rel="stylesheet" href="../css/calendar.css">

<script>
    $(document).ready(function () {
        modalShow('spinner');
        const d = new Date();
        let month = d.getMonth();
        $('#mesSelect option[value=' + month + ']').attr('selected', 'selected');
        $meses = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $('#generarBtn').click(function () {
            $empleado = $('#empleadoSelect').val();
            $mes = $('#mesSelect').val();
            $year = $('#year').val();
            modalShow('spinner');
            $('#calendarDiv').load(
                '../components/calendar/calendarHR.php', {
                year: $year,
                month: parseInt($mes) + 1,
                employee: $empleado,
            },
                function () {
                    modalHide('spinner');
                }
            );
            $('#daysOff').load('../components/calendar/daysOff.php', {
                user: $empleado
            });
        });

        if ($('#empleadoSelect').data('show')) {
            $.get('../controllers/Login.php', {
                action: 'getEmployeeList'
            })
                .done(function (resp) {
                    $employees = JSON.parse(resp);
                    $($employees).each(function (i, empleado) {
                        $('<option/>').val(empleado.id).text(empleado.fullName).appendTo('#empleadoSelect');
                    });
                })
                .done(function () {
                    $('#empleadoSelect').val($('#empleadoSelect').data('employee')).change();
                    $('#generarBtn').click();
                });
        } else {
            $('<option/>')
                .val($('#empleadoSelect').data('employee'))
                .text('Employee')
                .attr('selected', 'selected')
                .appendTo('#empleadoSelect');
            $('#empleadoSelectDiv').hide();
            $('#generarBtn').click();
        }

    });
</script>