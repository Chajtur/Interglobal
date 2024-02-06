<?php
include '../models/LoB.php';

$coverage = new LoB();
$coverages = $coverage->getAll();
$idCoverage = $_POST['idCoverage'];
$index = array_search($idCoverage, array_column($coverages, 'id'));

?>

<div class="row">
    <h6 class="text-center">Please select a Bill Plan for <?= $coverages[$index]['name'] ?></h6>
</div>
<div class="row">
    <table id="tableBillPlan" class="table bg-warning-light">
        <thead class="bg-primary text-white text-end">
            <tr>
                <th>Duration</th>
                <th>Installments</th>
                <th>Down Payment</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        let idOption = <?= $_POST['idOption'] ?>;

        $('.tableOptions[data-option="' + idOption + '"] tfoot tr:gt(0)').each(function() {
            let duration = $(this).find('td:eq(2)').text();
            let installments = $(this).find('td:eq(3)').text();
            let downPayment = $(this).find('td:eq(4)').text();
            let installmentAmount = $(this).find('td:eq(5)').text();
            let billPlan = $(this).data('billplan');
            $row = "<tr class='text-end' data-billplan='" + billPlan + "'>" +
                "<td>" + duration + " months</td>" +
                "<td>" + installments + "</td>" +
                "<td>" + downPayment + "</td>" +
                "<td>" + installmentAmount + "</td>" +
                "</tr>";
            $('#tableBillPlan tbody').append($row);
        });

        $('#tableBillPlan tbody tr').click(function() {
            $(this).addClass('bg-success').siblings().removeClass('bg-success');
        });
    });

    $('#btnSaveBillPlan').click(function() {
        let idOption = <?= $_POST['idOption'] ?>;
        let idBillPlan = $('#tableBillPlan tbody tr.bg-success').data('billplan');
        let idCoverage = <?= $_POST['idCoverage'] ?>;
        $('.tableOptions[data-option="' + idOption + '"] tbody tr[data-coverage="' + idCoverage + '"]').attr('data-billplan', idBillPlan);
        $('.tableOptions[data-option="' + idOption + '"] tbody tr[data-coverage="' + idCoverage + '"]').addClass('bg-success-light').removeClass('bg-warning-light');
        // Remove coverage from all other bill plans
        $('.tableOptions[data-option=' + idOption + '] tfoot .billPlanRow').each(function() {
            var billPlanText = $(this).find('td:eq(1)').text();
            billPlanSplit = billPlanText.split(',');
            billPlanSplit = billPlanSplit.filter(function(value, index, arr) {
                return value != "<?= $coverages[$index]['name'] ?>";
            });
            $(this).find('td:eq(1)').text(billPlanSplit.join(','));
        });
        // Add coverage to current bill plan
        $('.tableOptions[data-option=' + idOption + '] tfoot .billPlanRow[data-billplan=' + idBillPlan + ']').each(function() {
            var billPlanText = $(this).find('td:eq(1)').text();
            billPlanSplit = billPlanText.split(',');
            billPlanSplit.push("<?= $coverages[$index]['name'] ?>");
            billPlanSplit = billPlanSplit.filter(function(e) {
                return e
            }); // Filter out empty elements
            $(this).find('td:eq(1)').text(billPlanSplit.join(','));
        });
        $('#infoModal').modal('hide');
    });
</script>