<?php
$idQuote = $_POST['id'];
include_once $_SERVER['DOCUMENT_ROOT'] . "/models/Quote.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/models/BillPlan.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/models/Coverage.php";

$quote = new Quote();
$coverage = new Coverage();
$quote->load($idQuote);
$billPlanObject = new BillPlan();
$billPlans = $billPlanObject->listAll($idQuote);
$billPlanDetail = new BillPlan();
$idOption = 0;

?>

<h4>Quote for <?= $quote->owner ?> - <?= $quote->dot ?></h4>
<div class="flex flex-column gap-1">
    <?php
    foreach ($billPlans as $bp)
    {
        $billPlanObject->load($bp['idBillPlan'], $idQuote);
        if ($billPlanObject->idOption != $idOption)
        {
            echo "</table></div>";
            $idOption = $billPlanObject->idOption;
            echo "<div class='flex-column'><h4 class='text-blue-500'>$billPlanObject->optionName</h4>";
        }
        echo "<table class='table w-full'><thead class='bg-green-800 rounded text-white text-end'><th class='text-start'>Carrier</th><th>Coverage</th></th><th>Amount</th><th>Total Premium</th></thead><tbody>";
        $coverages = $coverage->listAll($idQuote, $billPlanObject->id);
        foreach ($coverages as $c)
        {
            $coverage->load($c['idCoverage'], $idQuote, $billPlanObject->id);
            echo "<tr class='text-green-500 text-end'><td class='text-start'>$coverage->carrier</td><td>$coverage->type</td><td>$" . number_format($coverage->amount, 2, '.', ',') . "</td><td>$" . number_format($coverage->totalPremium, 2, '.', ',') . "</td></tr>";
        }
        echo "<tr class='bg-sky-950 text-white text-end'><td class='font-bold'>Down Payment</td><td class='font-bold'>Installments</td><td class='font-bold'>Installment Amount</td><td class='font-bold'>Term</td></tr>";
        echo "<tr class='text-blue-500 text-end'><td>$" . number_format($billPlanObject->downPayment, 2, '.', ',') . "</td><td>$billPlanObject->installments</td><td>$" . number_format($billPlanObject->installmentAmount, 2, '.', ',') . "</td><td>$billPlanObject->term</td></tr>";
    }
    ?>
</div>

<script>
    $("#saveButton").on('click', function() {
        modalShow('spinner');
        $idQuote = <?= $idQuote ?>;
        $('#contenido').load('/views/proposalForm.php', {
            idQuote: $idQuote,
            dot: <?= $quote->dot ?>,
            client: '<?= $quote->owner ?>',
        });
        modalHide('infoModal');
    });

    $(document).ready( function() {
        modalHide('spinner');
    });
</script>