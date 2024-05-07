<div class="flex-col" id="coverageBillPlan">
    <label for="billPlanDuration" class="flex items-center cursor-pointer">
        <div class="mr-3 text-gray-700 font-medium">
            6 months
        </div>
        <div class="relative">
            <input id="billPlanDuration" type="checkbox" class="sr-only" checked/>
            <div id="billPlanDurationToggle" class="block bg-gray-600 w-14 h-8 rounded-full dotBG"></div>
            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
        </div>
        <div class="ml-3 text-gray-700 font-medium">
            12 months
        </div>
    </label>
    <div class="flex-col mt-1">
        <label for="downPayment">Down Payment:</label>
        <input type="number" class="form-control rounded" id="downPayment" placeholder="0.00">
    </div>
    <div class="flex-col">
        <label for="installments">Installments:</label>
        <input type="number" class="form-control rounded" id="installments" placeholder="10">
    </div>
    <div class="flex-col">
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

    $(document).ready(function() {
        $('#billPlanDurationToggle').click(function() {
            console.log('Bill Plan Duration clicked');
            var currentStatus = $('#billPlanDuration').prop('checked');
            console.log(currentStatus);
            $('#billPlanDuration').prop('checked', !currentStatus);
        });
    });

    $('#btnSaveBillPlan').click(function() {
        let duration = $('#billPlanDuration').is(':checked') ? 12 : 6;
        let downPayment = parseFloat($('#downPayment').val() || 0);
        let idBillPlan = generateRandomCode(8);
        let installments = parseFloat($('#installments').val() || 0);
        let monthlyInstallment = parseFloat($('#monthlyInstallment').val() || 0);
        let billPlanRow = `<tr class="billPlanRow text-center" data-billPlan="${idBillPlan}">
            <td colspan="1">
                <button title="Click to remove Bill Plan" class="btn-danger btn-sm btnRemoveBillPlan">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button title="Click to edit Bill Plan" class="btn-info btn-sm btnEditBillPlan">
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
        $('.tableOptions[data-option="<?= $_POST['idOption'] ?>"] tfoot').removeClass('hidden')
        modalHide('infoModal');
    });
</script>