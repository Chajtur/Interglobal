<!-- Inputs for Coverage and Amount -->
<div class="row">
    <p>Line of Business: <?= $_POST['coverage'] ?></p>
</div>
<div class="row">
    <p>Coverage Amount: <?= $_POST['coverageAmount'] ?></p>
</div>
<div class="row">
    <label for="carrier">Carrier:</label>
    <input type="text" class="form-control rounded" id="carrier" placeholder="Carrier" value="<?= $_POST['carrier'] ?>">
</div>
<div class="row">
    <label for="basePremium">Base Premium:</label>
    <input type="number" class="form-control rounded" id="basePremium" placeholder="0.00" value="<?= $_POST['basePremium'] ?>">
</div>
<div class="row">
    <label for="taxesFees">Taxes & Fees:</label>
    <input type="number" class="form-control rounded" id="taxesFees" placeholder="0.00" value="<?= $_POST['taxesFees'] ?>">
</div>
<div class="row">
    <label for="notes">Notes:</label>
    <textarea rows="3" type="text" class="form-control rounded" id="notes" placeholder="Write a note..."><?= $_POST['notes'] ?></textarea>
</div>
<div class="row">
    <h3 class="totalPremium mt-3">Total Premium: $<span id="totalPremium"><?php echo number_format(($_POST['basePremium'] + $_POST['taxesFees']), 2) ?></span></h3>
</div>

<script>
    $('#btnUpdateCoverage').click(function() {
        let carrier = $('#carrier').val();
        let basePremium = $('#basePremium').val();
        basePremium = parseFloat(basePremium).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let taxesFees = $('#taxesFees').val();
        taxesFees = parseFloat(taxesFees).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        let notes = $('#notes').val();
        let totalPremium = $('#totalPremium').text();
        let idOption = "<?= $_POST['idOption'] ?>";
        let idCoverage = "<?= $_POST['idCoverage'] ?>";
        console.log(idOption, idCoverage, carrier, basePremium, taxesFees, notes, totalPremium);
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-coverage="' + idCoverage + '"]').find('td:eq(3)').html('<button title="Click to edit Carrier Information" class="btn btn-info btn-sm btnEditCoverage me-3"><i class="fas fa-pencil"></i></button>' + carrier);
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-coverage="' + idCoverage + '"]').find('td:eq(4)').text('$' + basePremium);
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-coverage="' + idCoverage + '"]').find('td:eq(5)').text('$' + taxesFees);
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-coverage="' + idCoverage + '"]').find('td:eq(6)').text('$' + totalPremium);
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-coverage="' + idCoverage + '"]').find('td:eq(7)').text(notes);
        $('#infoModal').modal('hide');
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