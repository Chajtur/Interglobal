<div class="row" id="coverageBillPlan">
    <div class="row">
        <h6>Bill Plan Duration</h6>
        <div class="d-flex">
            <p>6 months</p>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input float-end" type="checkbox" role="switch" id="billPlanDuration" checked>
            </div>
            <p>12 months</p>
        </div>
    </div>
    <div class="row">
        <label for="downPayment">Down Payment:</label>
        <input type="number" class="form-control rounded" id="downPayment" placeholder="0.00">
    </div>
    <div class="row">
        <label for="installments">Installments:</label>
        <input type="number" class="form-control rounded" id="installments" placeholder="10">
    </div>
    <div class="row">
        <label for="monthlyInstallment">Monthly Installment:</label>
        <input type="number" class="form-control rounded" id="monthlyInstallment" placeholder="0.00">
    </div>
</div>

<script>
    function generateRandomCode(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $('#btnSaveBillPlan').click(function() {
        let duration = $('#billPlanDuration').is(':checked') ? 12 : 6;
        let downPayment = parseFloat($('#downPayment').val() || 0);
        let idBillPlan = generateRandomCode(8);
        let installments = parseFloat($('#installments').val() || 0);
        let monthlyInstallment = parseFloat($('#monthlyInstallment').val() || 0);
        let billPlanRow = `<tr class="billPlanRow text-center" data-billPlan="${idBillPlan}">
            <td colspan="1">
                <button title="Click to remove Bill Plan" class="btn btn-danger btn-sm btnRemoveBillPlan">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button title="Click to edit Bill Plan" class="btn btn-info btn-sm btnEditBillPlan">
                    <i class="fas fa-pencil"></i>
                </button>
            </td>
            <td colspan="3"></td>
            <td class="text-end">${duration}</td>
            <td class="text-end">${installments}</td>
            <td class="text-end" data-downPayment="${downPayment}">$${parseFloat(downPayment).toLocaleString(
                'en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )}</td>
            <td class="text-end" data-installment="${monthlyInstallment}">$${parseFloat(monthlyInstallment).toLocaleString(
                'en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )}</td>`
        $('.tableOptions[data-option="<?= $_POST['idOption'] ?>"] tfoot').append(billPlanRow);
        $('.tableOptions[data-option="<?= $_POST['idOption'] ?>"] tfoot').removeClass('d-none')
        $('#infoModal').modal('hide');
    });
</script>