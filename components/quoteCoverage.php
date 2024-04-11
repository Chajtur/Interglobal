<?php
include '../models/LoB.php';

$coverage = new LoB();
$coverages = $coverage->getAll();
?>

<!-- Inputs for Coverage and Amount -->
<div class="flex flex-col">
    <label for="coverageSelect">Please Select a Line of Business:</label>
    <select id="coverageSelect" class="" aria-label="Default select example">
        <?php foreach ($coverages as $coverage) { ?>
            <option value="<?= $coverage['id'] ?>"><?= $coverage['name'] ?></option>
        <?php } ?>
    </select>
</div>
<div class="flex flex-col">
    <label for="coverageAmount">Coverage Amount:</label>
    <input type="number" class="form-control rounded" id="coverageAmount" placeholder="0.00">
</div>
<div class="flex flex-col">
    <label for="carrier">Carrier:</label>
    <input type="text" class="form-control rounded" id="carrier" placeholder="Carrier">
</div>
<div class="flex flex-col">
    <label for="basePremium">Base Premium:</label>
    <input type="number" class="form-control rounded" id="basePremium" placeholder="0.00">
</div>
<div class="flex flex-col">
    <label for="taxesFees">Taxes & Fees:</label>
    <input type="number" class="form-control rounded" id="taxesFees" placeholder="0.00">
</div>
<div class="flex flex-col">
    <label for="notes">Notes:</label>
    <textarea rows="3" type="text" class="form-control p-2 rounded border-2" id="notes" placeholder="Write a note..."></textarea>
</div>
<div class="flex flex-col">
    <h3 class="totalPremium mt-3">Total Premium: $<span id="totalPremium">0.00</span></h3>
</div>

<script>
    $(document).ready(function() {
        idOption = "<?= $_POST['idOption'] ?>";
        $('.tableOptions[data-option="' + idOption + '"] tbody tr').each(function() {
            let idCover = $(this).attr('data-coverage');
            let cover = $(this).find('td:eq(1)').text();
            $html = "<li class='p-2 bg-green-600'>" +
                '<div class="form-check">' +
                '<input class="form-check-input border-white" type="checkbox" value="" id="option' + idCover + '" data-coverage="' + idCover + '">' +
                '<label class="form-check-label text-white" for="option' + idCover + '">' +
                cover +
                '</label>' +
                '</div>' +
                '</li>';
            $('#billPlanGroup ul').append($html);
        });
    });

    /* Adds new coverage to the table */
    $('#btnSaveCoverage').click(function() {
        let coverage = $('#coverageSelect').val();
        let coverageName = $('#coverageSelect option:selected').text();
        let amount = parseFloat($('#coverageAmount').val()).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let carrier = $('#carrier').val();
        let basePremium = parseFloat($('#basePremium').val()).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let taxesFees = parseFloat($('#taxesFees').val()).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let notes = $('#notes').val();
        let totalPremium = $('#totalPremium').text();
        if ($('#billPlan').is(':checked')) {
            let downPayment = $('#downPayment').val();
            let installments = $('#installments').val();
            let monthlyInstallment = $('#monthlyInstallment').val();
        }
        $('.tableOptions[data-option]').each(function() {
            let option = $(this).data('option');
            let idOption = "<?= $_POST['idOption'] ?>";
            let coverageRow = `<tr class="coverageRow bg-red-100" data-coverage="${coverage}">
                                <td class="text-center">
                                    <button title="Click to remove Coverage" class="btn-danger btn-sm btnRemoveCoverage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button title="Click to assign Bill Plan" class="btn-success btn-sm btnAddBillPlan">
                                        <i class="fas fa-coins"></i>
                                    </button>
                                </td>
                                <td class="text-start">${coverageName}</td>
                                <td class="text-end">$${amount}</td>
                                <td class="text-start"><button title="Click to edit Carrier Information" class="btn-info btn-sm btnEditCoverage me-3"><i class="fas fa-pencil"></i></button>${(option == idOption ? carrier : 'Carrier')}</td>
                                <td class="text-end">$${(option == idOption ? basePremium : '0.00')}</td>
                                <td class="text-end">$${(option == idOption ? taxesFees : '0.00')}</td>
                                <td class="text-end">$${(option == idOption ? totalPremium : '0.00')}</td>
                                <td class="text-center">${(option == idOption ? notes : 'Notes')}</td>
                            </tr>`;
            $(this).find('tbody').append(coverageRow);
        });

        modalHide('infoModal');
    });

    $(document).on('click', '#billPlan', function() {
        if (!$(this).is(':checked')) {
            $('#billPlanGroup').removeClass('d-none');
        } else {
            $('#billPlanGroup').addClass('d-none');
        }
    });

    $(document).on('input', '#basePremium', function() {
        let basePremium = parseFloat($(this).val() || 0);
        let taxesFees = parseFloat($('#taxesFees').val() || 0);
        let totalPremium = (parseFloat(basePremium) + parseFloat(taxesFees)).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        $('#totalPremium').text(totalPremium);
    });

    $(document).on('input', '#taxesFees', function() {
        let taxesFees = parseFloat($(this).val() || 0);
        let basePremium = parseFloat($('#basePremium').val() || 0);
        let totalPremium = (parseFloat(basePremium) + parseFloat(taxesFees)).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        $('#totalPremium').text(totalPremium);
    });
</script>