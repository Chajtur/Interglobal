<?php
include_once '../models/Transaction.php';
include_once '../models/User.php';
include_once '../controllers/Login.php';

$id = $_POST['id'] ?? 0;
$agent = $_POST['agent'] ?? getUser();
$user = new User();

if ($id != 0) {
    $transaction = getTransaction($id);
    $date = date_create($transaction['date']);
    $date = date_format($date, 'Y-m-d');
    $insured = $transaction['insured'];
    $carrier = $transaction['carrier'];
    $policyNumber = $transaction['policyNumber'];
    $type = $transactionTypes[$transaction['type']];
    $premium = $transaction['premium'];
    $agent = $transaction['agent'];
    $commission = $transaction['commission'];
} else {
    $date = date('Y-m-d');
    $insured = '';
    $carrier = '';
    $policyNumber = '';
    $type = 1;
    $premium = 0;
    $commission = 10;
}
$agentName = $user->getAgent($agent);
?>

<form id='newTransactionForm' class="text-primary" data-id=<?= $id ?> data-agent=<?= $agent ?>>
    <div class="row">
        <label for="newTransactionAgent">Agent:</label>
        <input type="text" class="form-control input rounded border-primary" id="newTransactionAgent" value="<?php echo $agentName['firstName'] . ' ' . $agentName['lastName']; ?>" disabled data-agent=<?= $agent ?>>
    </div>
    <div class="row">
        <label for="newTransactionDate">Effective Date:</label>
        <input name="date" id="newTransactionDate" class="datepicker form-control rounded border-primary" value=<?= $date ?>>
    </div>
    <div class="row">
        <label for="insured">Insured:</label>
        <input name="insured" type="text" class="form-control input rounded border-primary" id="insured" value="<?= $insured ?>">
    </div>
    <div class="row">
        <label for="carrier">Carrier:</label>
        <input name="carrier" type="text" class="form-control input rounded border-primary" id="carrier" value="<?= $carrier ?>">
    </div>
    <div class="row">
        <label for="policyNumber">Policy Number:</label>
        <input name="policyNumber" type="text" class="form-control input rounded border-primary" id="policyNumber" value="<?= $policyNumber ?>">
    </div>
    <div class="row">
        <label for="transaction">Transaction:</label>
        <select name="type" class="form-select rounded border-primary" id="transactionType" value=<?= $type ?>>
            <?php
            $options = array("NEW BUSINESS", "RENEWAL", "CANCELLATION", "REINSTATEMENT", "ADDITIONAL PREMIUM", "RETURN PREMIUM", "OTHER");
            foreach ($options as $key => $value) {
                $selected = ($type == $key + 1) ? "selected" : "";
                echo "<option value='" . ($value) . "' $selected>$value</option>";
            }
            ?>
        </select>
    </div>
    <div class="row">
        <label for="premium">Premium:</label>
        <input name="premium" type="number" class="form-control input rounded border-primary" id="premium" value=<?= $premium ?>>
    </div>
    <div class="row">
        <label for="commission">Commission:</label>
        <input name="commission" type="number" class="form-control input rounded border-primary" id="commission" value=<?= $commission ?> min="5.0" max="15.0" step="0.5">
    </div>
</form>
<!-- <div class="fixed top-0 hidden">
    <div id="liveToast" class="bg-red-800 rounded w-full" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="5000" data-animation="true">
        <div class="flex items-center">
            <i class="bi-x-square"></i>
            <strong class="ml-auto mr-3">Error</strong>
        </div>
        <div class="p-4">
            Commission must be between 5% and 15%
        </div>
    </div>
</div> -->


<script>
    if (<?= $id ?> != 0) {
        $('#saveButton').attr('id', 'btnSavePolicy');
        console.log('edit');
    } else {
        $('#saveButton').attr('id', 'btnSaveTransaction');
        console.log('new');
    }

    $(function() {
        $("#newTransactionDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst) {
                console.log(dateText);
            }
        });
    });

    $('#btnSaveTransaction').click(function() {
        if ($('#commission').val() < 5 || $('#commission').val() > 15) {
            toast('Commission must be between 5% and 15%', 'error');
            return false;
        }

        $.post('../controllers/Transaction.php', {
            action: 'saveTransaction',
            agent: $('#newTransactionForm').data('agent'),
            insured: $('#insured').val(),
            carrier: $('#carrier').val(),
            policyNumber: $('#policyNumber').val(),
            type: $('#transactionType').val(),
            premium: $('#premium').val(),
            date: $('#newTransactionDate').val(),
            commission: $('#commission').val(),
        }).done(function(resp) {
            if (resp > 0) {
                // success
                modalHide('infoModal');
                $('#infoModalTitle').text('Success');
                $('#infoModalText').parent().removeClass().addClass('modalTitle bg-green-800');
                $('#infoModalText').html('Transaction saved successfully');
                $('#infoModalButtons').html(
                    '<div id="okButton">'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
                loadPolicySummary();
                loadPolicyTable();
            } else {
                modalHide('infoModal');
                $('#infoModalTitle').text('Error');
                $('#infoModalText').parent().removeClass().addClass('modalTitle bg-red-800');
                $('#infoModalText').html('There was an error saving the transaction');
                $('#infoModalButtons').html(
                    '<div id="okButton">'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            }
        });
    });

    $('#btnSavePolicy').click(function() {
        if ($('#commission').val() < 5 || $('#commission').val() > 15) {
            toast('Commission must be between 5% and 15%', 'error');
            return false;
        }
        $.post('../controllers/Transaction.php', {
            action: 'editTransaction',
            agent: $('#newTransactionForm').data('agent'),
            insured: $('#insured').val(),
            carrier: $('#carrier').val(),
            policyNumber: $('#policyNumber').val(),
            premium: $('#premium').val(),
            commission: $('#commission').val(),
            date: $('#newTransactionDate').val(),
            id: $('#newTransactionForm').data('id'),
            type: $('#transactionType').val(),
        }).done(function(resp) {
            console.log(resp);
            if (resp == 1) {
                // success
                modalHide('infoModal');
                $('#infoModalTitle').text('Success');
                $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-green-800');
                $('#infoModalText').html('Transaction updated successfully');
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
                loadPolicySummary();
                loadPolicyTable();
            } else {
                modalHide('infoModal');
                $('#infoModalTitle').text('Error');
                $('#infoModalText').parent().removeClass().addClass('modalTitle bg-red-800');
                $('#infoModalText').html('There was an error updating the Transaction');
                $('#infoModalButtons').html(
                    '<div id="okButton"></div>'
                );
                $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            }
        });
    });

    $(document).ready(function() {
        modalHide('spinner');
    });
</script>