<?php
$downPayment = $_POST['downPayment'] ?: 0;
$downPayment = str_replace(',', '', $downPayment);
$downPayment = str_replace('$', '', $downPayment);
//$downPayment = number_format($downPayment, 2);
$monthlyInstallment = $_POST['amount'] ?: 0;
$monthlyInstallment = str_replace(',', '', $monthlyInstallment);
$monthlyInstallment = str_replace('$', '', $monthlyInstallment);
//$monthlyInstallment = number_format($monthlyInstallment, 2);
?>

<div class="row">
    <h5>Coverages using this Bill Plan</h5>
    <div><?= $_POST['billPlan'] ?: 'None' ?></div>
</div>
<hr>
<div class="row">
    <label for="duration">Bill Plan duration</label>
    <div class="d-flex">
        <p>6 months</p>
        <div class="form-check form-switch form-check-inline">
            <input class="form-check-input float-end" type="checkbox" role="switch" id="billPlanDuration" <?= $_POST['duration'] == 12 ? 'checked' : '' ?>>
        </div>
        <p>12 months</p>
    </div>
</div>
<div class="row">
    <label for="downPayment">Down Payment:</label>
    <input type="number" class="form-control rounded" id="downPayment" placeholder="0.00" value="<?= $downPayment ?>">
</div>
<div class="row">
    <label for="installments">Number of Installments:</label>
    <input type="number" class="form-control rounded" id="installments" placeholder="10" value="<?= $_POST['installments'] ?>">
</div>
<div class="row">
    <label for="monthlyInstallment">Monthly Installment:</label>
    <input type="number" class="form-control rounded" id="monthlyInstallment" placeholder="0.00" value="<?= $monthlyInstallment ?>">
</div>

<script>
    $('#btnUpdateBillPlan').click(function() {
        let duration = $('#billPlanDuration').is(':checked') ? 12 : 6;
        let downPayment = $('#downPayment').val();
        downPayment = parseFloat(downPayment).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let installments = $('#installments').val();
        let monthlyInstallment = $('#monthlyInstallment').val();
        monthlyInstallment = parseFloat(monthlyInstallment).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let idOption = "<?= $_POST['idOption'] ?>";
        let idBillPlan = "<?= $_POST['idBillPlan'] ?>";
        console.log(idOption, idBillPlan, duration, downPayment, installments, monthlyInstallment);
        $('.tableOptions[data-option=' + idOption + '] tfoot tr[data-billplan="' + idBillPlan + '"]').find('td:eq(2)').text(duration);
        $('.tableOptions[data-option=' + idOption + '] tfoot tr[data-billplan="' + idBillPlan + '"]').find('td:eq(3)').text(installments);
        $('.tableOptions[data-option=' + idOption + '] tfoot tr[data-billplan="' + idBillPlan + '"]').find('td:eq(4)').text('$' + downPayment);
        $('.tableOptions[data-option=' + idOption + '] tfoot tr[data-billplan="' + idBillPlan + '"]').find('td:eq(5)').text('$' + monthlyInstallment);
        $('#infoModal').modal('hide');
    })
</script>