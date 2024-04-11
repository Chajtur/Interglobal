<?php

include_once('../models/User.php');
include_once('../controllers/Login.php');
include_once('../models/Dates.php');

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
    while ($dayOfWeek <= 6) { ?>
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
    for ($contador = 1; $contador < $firstDay; $contador++) {
        $bgColor = ($contador >= 6) ? "bg-sky-950 text-white" : "bg-white text-gray-400"; ?>
        <div class="p-0 md:p-2 rounded border border-white dia <?= $bgColor ?>"></div>
    <?php }
    while ($day <= $totalDays) {
        $bgColor = ($contador >= 6) ? "bg-sky-950" : "bg-gray-400";
        $entrada = '';
        foreach ($marcaciones as $marcacion) {
            if ($day == $marcacion['Fecha']) {
                $entrada = $marcacion['Entrada'];
            }
        }
        if ($entrada != '') {
            if ($entrada > '07:00:00') {
                $bgColor = 'bg-red-900';
            } else {
                $bgColor = 'bg-green-800';
            }
        }
        $date = new Holiday($year . '-' . $month . '-' . $day);
        if ($date->isHoliday()) {
            $bgColor = 'bg-blue-800';
        }
    ?>
        <div class="flex flex-col dia p-0 md:p-2 rounded border border-white text-white <?php if ($contador < 6) {
                                                                                            echo 'calendarClickable';
                                                                                        } ?> <?= $bgColor ?>" data-searchdate="<?php echo ($year . '-' . $month . '-' . $day) ?>" data-day="<?php echo $months[$month - 1] . " " . $day . " " . $year ?>">
            <div class="text-right">
                <span><?= $day ?></span>
            </div>
            <div class="">
                <p>
                    <?php
                    if ($contador < 6) {
                        echo $entrada;
                    }
                    ?>
                </p>
            </div>
        </div>
        <?php
        if ($contador % 7 == 0) {
            $row++;
            $contador = 0; ?>
</div>
<div class='flex flex-row lg:min-h-20'>
<?php } ?>
<?php $day++;
        $contador++;
    }
    $contador--;
    while ($contador % 7 <> 0) { ?>
    <div class="dia p-0 md:p-2 rounded border border-white"></div>
<?php $contador++;
    }
?>
</div>
<div>
    <h4 class="mb-2">Legend</h4>
    <button class="btn-success">On time</button> <button class="btn-danger">Late</button> <button class="btn-secondary">No Punch-In</button> <button class="btn-info">Holiday</button> <button class="btn-primary">Weekend</button>
</div>