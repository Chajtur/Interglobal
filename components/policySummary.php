<?php
include_once '../models/Transaction.php';
include_once '../models/User.php';

$quarter = $_POST['quarter'] ?? 'fullYear';
$agente = $_POST['agente'] ?? getUser();
$year = $_POST['year'] ?? date('Y');
$data = getPolicyStats($year, $agente, $quarter);
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
                text: "Monthly Premiums"
            },
            data: [{
                type: "spline", //change type to bar, line, area, pie, etc  
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    });
</script>
<div class="border shadow rounded p-4 mt-2">
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <input type="radio" class="btn-check" name="quarters" id="fullYear" autocomplete="off" <?= $quarter == "fullYear" ? 'checked' : '' ?>>
            <label for="fullYear" class="btn btn-outline-info">Full Year</label>
            <input type="radio" class="btn-check" name="quarters" id="firstQuarter" autocomplete="off" <?= $quarter == "firstQuarter" ? 'checked' : '' ?>>
            <label for="firstQuarter" class="btn btn-outline-success">First Quarter</label>
            <input type="radio" class="btn-check" name="quarters" id="secondQuarter" autocomplete="off" <?= $quarter == "secondQuarter" ? 'checked' : '' ?>>
            <label for="secondQuarter" class="btn btn-outline-warning">Second Quarter</label>
            <input type="radio" class="btn-check" name="quarters" id="thirdQuarter" autocomplete="off" <?= $quarter == "thirdQuarter" ? 'checked' : '' ?>>
            <label for="thirdQuarter" class="btn btn-outline-danger">Third Quarter</label>
            <input type="radio" class="btn-check" name="quarters" id="fourthQuarter" autocomplete="off" <?= $quarter == "fourthQuarter" ? 'checked' : '' ?>>
            <label for="fourthQuarter" class="btn btn-outline-primary">Fourth Quarter</label>
            <div class="row mt-2">
                <div class="col-6">
                    <h6>Transactions: <?= $yearToDate['total'] ?></h6>
                    <h6>Premium: $<?= number_format($yearToDate['premium'], 2) ?></h6>
                    <h6>Commission: $<?= number_format($yearToDate['commission'], 2) ?></h6>
                </div>
                <div class="col-6">
                    <h6>New Business: <?= $yearToDate['newBusiness'] ?></h6>
                    <h6>Renewals: <?= $yearToDate['renewal'] ?></h6>
                    <h6>Cancellations: <?= $yearToDate['cancellation'] ?></h6>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="h-100 w-100" id="chartContainer"></div>
        </div>
    </div>
</div>
</div>