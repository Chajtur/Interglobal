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

<div class="flex flex-col">
    <h4 class="text-sky-950">Coverages using this Bill Plan</h4>
    <div><?= $_POST['billPlan'] ?: 'None' ?></div>
</div>
<hr class="my-1">
<div class="flex flex-col">
    <label for="duration" class="my-1">Bill Plan duration</label>
    <label for="billPlanDuration" class="flex items-center cursor-pointer">
        <div class="mr-3 text-gray-700 font-medium">
            6 months
        </div>
        <div class="relative">
            <input id="billPlanDuration" type="checkbox" class="sr-only" <?= $_POST['duration'] > 6 ? 'checked' : '' ?>/>
            <div id="billPlanDurationToggle" class="block bg-gray-600 w-14 h-8 rounded-full dotBG"></div>
            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
        </div>
        <div class="ml-3 text-gray-700 font-medium">
            12 months
        </div>
    </label>
</div>
<div class="flex flex-col">
    <label for="downPayment">Down Payment:</label>
    <input type="number" class="form-control rounded" id="downPayment" placeholder="0.00" value="<?= $downPayment ?>">
</div>
<div class="flex flex-col">
    <label for="installments">Number of Installments:</label>
    <input type="number" class="form-control rounded" id="installments" placeholder="10"
        value="<?= $_POST['installments'] ?>">
</div>
<div class="flex flex-col">
    <label for="monthlyInstallment">Monthly Installment:</label>
    <input type="number" class="form-control rounded" id="monthlyInstallment" placeholder="0.00"
        value="<?= $monthlyInstallment ?>">
</div>

<script>
    $('#btnUpdateBillPlan').click(function () {
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