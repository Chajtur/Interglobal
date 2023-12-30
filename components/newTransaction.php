<?php
include_once '../models/Transaction.php';
include_once '../models/User.php';

$id = $_POST['id'] ?? 0;
$agent = $_POST['agent'] ?? getUser();

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
} else {
    $date = date('Y-m-d');
    $insured = '';
    $carrier = '';
    $policyNumber = '';
    $type = 1;
    $premium = 0;
}
?>

<form id='newTransactionForm' class="text-primary" data-id=<?= $id ?> data-agent=<?= $agent ?>>
    <?php if (hasPermission('listarPolizas') && $id == 0) { ?>
        <div class="row">
            <label for="newTransactionAgent">Agent:</label>
            <select name="agent" class="form-select rounded border-primary" id="newTransactionAgent">
                <?php foreach (listInsuranceAgents() as $agent) { ?>
                    <option value="<?= $agent['id'] ?>"><?= $agent['firstName'] . ' ' . $agent['lastName'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
    <div class="row">
        <label for="newTransactionDate">Date:</label>
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
</form>


<script>
    $(function() {
        $("#newTransactionDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst) {
                console.log(dateText);
            }
        });
    });
</script>