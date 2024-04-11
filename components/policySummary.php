<?php
include_once '../models/Transaction.php';
include_once '../models/User.php';
include_once '../controllers/Login.php';

$quarter = $_POST['quarter'] ?? 'fullYear';
$agente = $_POST['agente'] ?? getUser();
$year = $_POST['year'] ?? date('Y');
$data = getPolicyStats($year, $agente, $quarter);
$yearToDate = $data['generalStats'];
$monthlyStats = $data['monthlyStats'];
$premium = $yearToDate['premium'];
$class = ($premium >= 0) ? 'text-green-600' : 'text-red-600';
foreach ($monthlyStats as $row) {
    $dataPoints[] = array("label" => date('M', mktime(0, 0, 0, $row['month(date)'], 10)), "y" => $row['premium']);
}
?>
<script>
    $(document).ready(function() {

        var $dataPoints = <?php echo empty($dataPoints) ? '[{ label: "No Transactions Registered", y: 0 }]' : json_encode($dataPoints, JSON_NUMERIC_CHECK) ?>;
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Monthly Premiums"
            },
            data: [{
                type: "spline", //change type to bar, line, area, pie, etc  
                dataPoints: $dataPoints
            }]
        });
        chart.render();

    });

    $('.btn-check').on('click', function() {
        event.stopPropagation();
        loadPolicySummary($(this).attr('id'));
    });
</script>
<div class="border shadow shadow-sky-950 rounded p-4 mt-2 h-44 w-full flex flex-row">
    <div class=" w-full lg:w-1/2">
        <div class="flex flex-row justify-evenly">
            <button class="btn-check border-2 btn-outline-info <?= $quarter == "fullYear" ? 'checked' : '' ?>" name="quarters" id="fullYear">Full Year</button>
            <button class="btn-check border-2 btn-outline-success <?= $quarter == "firstQuarter" ? 'checked' : '' ?>" name="quarters" id="firstQuarter">First Quarter</button>
            <button class="btn-check border-2 btn-outline-warning <?= $quarter == "secondQuarter" ? 'checked' : '' ?>" name="quarters" id="secondQuarter">Second Quarter</button>
            <button class="btn-check border-2 btn-outline-danger <?= $quarter == "thirdQuarter" ? 'checked' : '' ?>" name="quarters" id="thirdQuarter">Third Quarter</button>
            <button class="btn-check border-2 btn-outline-primary <?= $quarter == "fourthQuarter" ? 'checked' : '' ?>" name="quarters" id="fourthQuarter">Fourth Quarter</button>
        </div>
        <div class="flex flex-row mt-2 font-bold">
            <div class="w-1/2">
                <h6>Transactions: <?= $yearToDate['total'] ?></h6>
                <h6 class="<?php echo $class ?>"><span class="text-sky-950">Premium: </span>$<?= str_replace('-', '', number_format($yearToDate['premium'], 2)) ?></h6>
                <h6 class="<?php echo $class ?>"><span class="text-sky-950">Commission: </span>$<?= str_replace('-', '', number_format($yearToDate['commission'], 2)) ?></h6>
            </div>
            <div class="w-1/2">
                <h6>New Business: <?= $yearToDate['newBusiness'] ?></h6>
                <h6>Renewals: <?= $yearToDate['renewal'] ?></h6>
                <h6>Cancellations: <?= $yearToDate['cancellation'] ?></h6>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/2">
        <div class="h-full w-full" id="chartContainer"></div>
    </div>
</div>