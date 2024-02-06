<?php

include_once('../models/User.php');
include_once('../controllers/Login.php');

$user = new User();
$user->load($_SESSION['user']['id']);

$year = isset($_POST['year']) ? $_POST['year'] : date("Y");
$month = isset($_POST['month']) ? $_POST['month'] : date("n");
$months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$employee = isset($_POST['employee']) ? $_POST['employee'] : getUser();
$marcaciones = $user->getMonthPunches($year, $month, $employee);

echo "<script>console.log('Procesando marcaciones de $employee para el mes de $month del año $year esta es la lista" . json_encode($marcaciones) . "');</script>";
?>

<div class="row border-bottom border-danger border-4">
    <div class="col">
        <h4><?php echo $months[$month - 1]; ?></h4>
    </div>
    <div class="col">
        <h4><?php echo $year; ?></h4>
    </div>
</div>
<div class="row border-bottom border-2 border-danger shadow pt-2">
    <?php
    $primeraQuincena = 0;
    $segundaQuincena = 0;
    $diasNoMarcados = 0;
    $day = 1;
    $row = 1;
    $totalDays = cal_days_in_month(CAL_GREGORIAN, 10, $year);
    $week = array('LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB', 'DOM');
    $dayOfWeek = 0;
    while ($dayOfWeek <= 6) { ?>
        <div class="col dia">
            <h6><?= $week[$dayOfWeek] ?></h6>
        </div>
    <?php $dayOfWeek++;
    } ?>
</div>
<div class="row text-white">
    <?php
    $day = 1;
    $row = 1;
    //$month = date("n");
    $firstDay = date("N", strtotime($year . "-" . $month . "-1"));
    $contador = 1;
    for ($contador = 1; $contador < $firstDay; $contador++) {
        $bgColor = ($contador >= 6) ? "bg-primary text-white" : "bg-white text-secondary"; ?>
        <div class="p-0 p-md-2 col rounded border border-white dia <?= $bgColor ?>"></div>
    <?php }
    while ($day <= $totalDays) {
        //$entrada = 'N/A';
        $bgColor = ($contador >= 6) ? "bg-primary" : "bg-secondary";
        $entrada = 'No marcó';
        foreach ($marcaciones as $marcacion) {
            //var_dump($marcacion);
            if ($day == $marcacion['Fecha']) {
                $entrada = $marcacion['Entrada'];
            }
        }
        if ($entrada != 'No marcó') {
            if ($entrada > '07:00:00') {
                $bgColor = 'bg-danger';
            } else {
                $bgColor = 'bg-success';
            }
        }
    ?>
        <div class="dia p-0 p-md-2 col rounded border border-white text-white calendarClickable <?= $bgColor ?>" data-searchdate="<?php echo ($year . '-' . $month . '-' . $day)?>">
            <div class="row">
                <span><?= $day ?></span>
            </div>
            <div class="row">
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
<div class='row'>
<?php } ?>
<?php $day++;
        $contador++;
    }
    $contador--;
    while ($contador % 7 <> 0) { ?>
    <div class="col dia p-0 p-md-2 rounded border border-white"></div>
<?php $contador++;
    }
?>
</div>