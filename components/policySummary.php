<?php
include_once '../models/Transaction.php';
include_once '../models/User.php';

$agente = $_POST['agente'] ?? 'all';
$year = date('Y');
$data = getPolicyStats($year, $agente);
$yearToDate = $data['generalStats'];
$monthlyStats = $data['monthlyStats'];
foreach ($monthlyStats as $row) {
    $dataPoints[] = array("label" => date('M', mktime(0, 0, 0, $row['month(date)'], 10)), "y" => $row['premium']);
}
?>
<script>
    $(document).ready(function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Monthly Sales in Premium"
            },
            data: [{
                type: "spline", //change type to bar, line, area, pie, etc  
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    });
</script>
<div class="border shadow rounded p-4 col-md-12 col-lg-8 mt-2 offset-lg-2">
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <h4 class="text-center">Year to Date</h4>
            <h6>Policies Sold: <?= $yearToDate['total'] ?></h6>
            <h6>Premium Sold: $<?= number_format($yearToDate['premium'], 2) ?></h6>
            <h6>Earned Commission: $<?= number_format($yearToDate['commission'], 2) ?></h6>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="h-100 w-100" id="chartContainer"></div>
        </div>
    </div>
</div>