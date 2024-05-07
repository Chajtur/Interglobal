<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';

$user = new User();
$user->load($_SESSION['user']['id']);

$year = isset($_POST['year']) ? $_POST['year'] : date("Y");
$month = isset($_POST['month']) ? $_POST['month'] : date("n");
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$employee = isset($_POST['employee']) ? $_POST['employee'] : getUser();
$marcaciones = $user->getMonthPunches($year, $month, $employee);
?>

<div class="border-b-red-900 border-b-4">
    <div class="w-4/5 justify-between flex flex-row mx-auto">
        <div class="cursor-pointer">
            <i class="fa-solid fa-angles-left fa-2xl"></i>
        </div>
        <div class="">
            <h4><?php echo $months[$month - 1]; ?></h4>
        </div>
        <div class="">
            <h4><?php echo $year; ?></h4>
        </div>
        <div class="cursor-pointer">
            <i class="fa-solid fa-angles-right fa-2xl"></i>
        </div>
    </div>
</div>
<div class="flex flex-row border-b-2 border-b-red-900 shadow pt-2">
    <?php
    $primeraQuincena = 0;
    $segundaQuincena = 0;
    $diasNoMarcados = 0;
    $day = 1;
    $row = 1;
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $week = array('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN');
    $dayOfWeek = 0;
    while ($dayOfWeek <= 6)
    { ?>
        <div class="dia">
            <h6><?= $week[$dayOfWeek] ?></h6>
        </div>
        <?php $dayOfWeek++;
    } ?>
</div>
<div class="flex flex-row text-white lg:min-h-20 mt-1">
    <?php
    $day = 1;
    $row = 1;
    $firstDay = date("N", strtotime($year . "-" . $month . "-1"));
    $contador = 1;
    for ($contador = 1; $contador < $firstDay; $contador++)
    {
        $bgColor = ($contador >= 6) ? "bg-sky-950 text-white" : "bg-white text-gray-400"; ?>
        <div class="p-0 md:p-2 rounded border border-white dia <?= $bgColor ?>"></div>
    <?php }
    while ($day <= $totalDays)
    {
        $bgColor = "bg-gray-400";
        /*$entrada = '';
        foreach ($marcaciones as $marcacion)
        {
            if ($day == $marcacion['Fecha'])
            {
                $entrada = $marcacion['Entrada'];
            }
        }
        if ($entrada != '')
        {
            if ($entrada > '07:00:00')
            {
                $bgColor = 'bg-red-900';
            } else
            {
                $bgColor = 'bg-green-800';
            }
        }*/
        $date = new Holiday($year . '-' . $month . '-' . $day);
        $vacations = new Vacation();
        $requestedDaysOff = $vacations->getDaysOff($employee);
        if ($requestedDaysOff == false)
        {
            $requestedDaysOff = [];
        }
        foreach ($requestedDaysOff as $requestedDayOff)
        {
            $dateToCheck = new DateTime($year . '-' . $month . '-' . $day);
            $dateFrom = new DateTime($requestedDayOff['dateFrom']);
            $dateTo = new DateTime($requestedDayOff['dateTo']);

            if ($dateFrom <= $dateToCheck && $dateToCheck <= $dateTo)
            {
                // The date is within the range
                if ($requestedDayOff['status'] == 'Approved')
                {
                    $bgColor = 'bg-green-800';
                } else if ($requestedDayOff['status'] == 'Denied')
                {
                    $bgColor = 'bg-red-900';
                } else
                {
                    $bgColor = 'bg-yellow-500';
                }
            }
        }
        if ($date->isHoliday())
        {
            $bgColor = 'bg-blue-800';
            $holiday = $date->getHolidays();
        }
        if ($contador >= 6) {
            $bgColor = 'bg-sky-950';
        }
        ?>
        <div class="flex flex-col dia p-0 md:p-2 rounded border border-white text-white <?php if ($contador < 6)
        {
            echo 'calendarClickable';
        } ?> <?= $bgColor ?>" data-searchdate="<?php echo ($year . '-' . $month . '-' . $day) ?>"
            data-day="<?php echo $months[$month - 1] . " " . $day . " " . $year ?>">
            <div class="text-right">
                <span><?= $day ?></span>
            </div>
            <div class="text-center">
                <p>
                    <?php
                    /*if ($contador < 6)
                    {
                        echo $entrada;
                    }*/
                    if ($date->isHoliday())
                    {
                        echo $holiday['holidayName'];
                    }
                    ?>
                </p>
            </div>
        </div>
        <?php
        if ($contador % 7 == 0 && $day < $totalDays)
        {
            $row++;
            $contador = 0; ?>
        </div>
        <div class='flex flex-row lg:min-h-20'>
        <?php } ?>
        <?php $day++;
        $contador++;
    }
    $contador--;
    while ($contador % 7 <> 0)
    { ?>
        <div class="dia p-0 md:p-2 rounded border border-white"></div>
        <?php $contador++;
    }
    ?>
</div>
<div>
    <h4 class="mb-2 gap-1">Legend</h4>
    <button class="btn-warning">Requested Day Off</button> <button class="btn-success">Approved Day Off</button> <button
        class="btn-danger">Denied Day Off</button> <button class="btn-secondary">Work Day</button> <button
        class="btn-info">Holiday</button> <button class="btn-primary">Weekend</button>
</div>

<script>
    $('.fa-angles-left').on('click', function () {
        if ($('#mesSelect').val() == 0) {
            $('#mesSelect').val(11);
            $('#year').val($('#year').val() - 1);
        } else {
            $('#mesSelect').val($('#mesSelect').val() - 1);
        }
        $mes = $('#mesSelect').val();
        $year = $('#year').val();
        $empleado = $('#empleadoSelect').val();
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
    });

    $('.fa-angles-right').on('click', function () {
        if ($('#mesSelect').val() == 11) {
            $('#mesSelect').val(0);
            $('#year').val(parseInt($('#year').val()) + 1);
        } else {
            $('#mesSelect').val(parseInt($('#mesSelect').val()) + 1);
        }
        $mes = $('#mesSelect').val();
        $year = $('#year').val();
        $empleado = $('#empleadoSelect').val();
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
    });

    function solicitarPermiso($fecha) {
        $modalContent =
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<h1 class="modal-title fs-5">' +
            'Permit Request for ' +
            $fechaDisplay +
            '</h1>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="row">' +
            '<h4>Select the time for the permit</h4>' +
            '<div class="form-floating mb-3">' +
            '<label class="text-primary" for="horaPermiso">Hour</label>' +
            '<input class="form-control rounded border-primary" id="horaPermiso" type="time" placeholder="Hour">' +
            '</div>' +
            '</div>' + //cerrar body
            '<div class="modal-footer">' + // footer
            '<button type="button" class="btn-success">Save</button>' +
            '<button type="button" class="btn-danger modalClose">Cancel</button>' +
            '</div>' +
            '</div>' + //cerrar content
            '</div>'; //cerrar dialog
        $('#infoModal').html($modalContent);
        modalShow('infoModal');
    }

    function cargarMenu($fechaDisplay, resp) {
        $('#infoModalTitle').html($fechaDisplay);
        $('#infoModalTitle').parent().removeClass().addClass('bg-blue-500 modalTitle');

        /** Cargar data al modal */
        $modalContent =
            "<div id='seccionFeriados'></div><hr class='my-2'><div id='seccionVacaciones'></div><hr class='my-2'><div id='seccionPermisos'></div>";
        $('#infoModalText').html($modalContent);
        $modalContent = '<div id="closeButton"></div>';
        $('#infoModalButtons').html($modalContent);
        $('#closeButton').load('../components/buttons/closeButton.php');
        $('#seccionFeriados').load('../components/calendar/seccionFeriados.php', {
            fecha: $searchDate
        });
        $('#seccionPermisos').load('../components/calendar/seccionPermisos.php', {
            fecha: $searchDate
        });
        $('#seccionVacaciones').load('../components/calendar/seccionVacaciones.php', {
            fecha: $searchDate
        }, function () {
            modalHide('spinner');
            modalShow('infoModal');
        });
    }

        $('.calendarClickable').on('click', function () {
        event.stopImmediatePropagation();
        modalShow('spinner');
        modalHide('infoModal');
        $infoDate = null;
        $searchDate = $(this).data('searchdate');
        $fechaDisplay = $(this).data('day');
        $.post('../controllers/Calendar.php', {
            date: $(this).data('searchdate'),
            action: 'getHoliday',
        }).done(function (resp) {
            cargarMenu($fechaDisplay, resp);
        });
    });

    
    $('body').on('click', '.solicitarPermiso', function () {
        solicitarPermiso($(this).data('day'));
    });


</script>