<?php

include "../models/Quote.php";
$id = $_POST['id'];

$quote = new Quote();
$quoteDetail = $quote->getQuoteDetail($id);


include "../models/LoB.php";

$coverage = new LoB();
$coverages = $coverage->getAll();

?>
<h3 class="text-center" id="clientDiv" data-name="<?= $quoteDetail['name'] ?>">Proposal For : <?= $quoteDetail['name'] ?></h3>
<hr>
<div class="row w-100">
    <div class="col">
        <label for="coverageSelect">Please Select a Line of Business:</label>
        <select id="coverageSelect" class="form-select" aria-label="Default select example">
            <?php foreach ($coverages as $coverage) { ?>
                <option value="<?= $coverage['id'] ?>"><?= $coverage['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col">
        <label for="coverageAmount">Amount:</label>
        <input type="text" class="form-control rounded" id="coverageAmount" placeholder="Amount">
    </div>
    <div class="col-auto d-flex align-items-end">
        <div class="text-end">
            <button class="btn btn-success" id="btnAddCoverage">Add Coverage</button>
            <button class="btn btn-primary" id="btnAddOption">Add Option</button>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <table class="table" id="tableCoverage">
        <thead class="text-center">
            <tr>
                <th colspan="3" class="bg-primary text-white font-bold">Coverage</th>
                <th class="gap"></th>
                <th data-id="1" colspan="5" class="bg-success text-white font-bold option">Option 1</th>
            </tr>
            <tr>
                <th class="bg-primary-light"></th>
                <th class="bg-primary-light">Type</th>
                <th class="bg-primary-light text-end">Amount</th>
                <th class="gap"></th>
                <th data-id="1" class="bg-success-light">Carrier</th>
                <th data-id="1" class="bg-success-light text-end">Base Premium</th>
                <th data-id="1" class="bg-success-light text-end">Taxes & Fees</th>
                <th data-id="1" class="bg-success-light text-end">Total Premium</th>
                <th data-id="1" class="bg-success-light">Notes</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-center bg-primary-light font-bold h4">Total Premium</td>
                <td class="gap"></td>
                <td colspan="5" data-id="1" class="bg-success-light text-center font-bold h4 totalPremium">$0.00</td>
            </tr>
            <tr>
                <td colspan="3" class="text-white text-center bg-primary font-bold h4">Down Payment</td>
                <td class="gap"></td>
                <td data-id="1" class="bg-success text-white font-bold h4 text-center" colspan="5"><span>$</span><input data-id="1" class="rounded downPayment" type="number" value="0"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-white text-center bg-primary font-bold h4">Installments</td>
                <td class="gap"></td>
                <td data-id="1" class="bg-success text-white font-bold h4 text-center" colspan="5"><input data-id="1" class="rounded installments" type="number" value="10"/><span> Installments of $</span><input data-id="1" class="rounded installment" type="number" value="0"/></td>
            </tr>
        </tfoot>
    </table>
</div>
<hr>
<div class="row">
    <div class="col-auto ms-auto">
        <button class="btn btn-primary" id="btnPreviewProposal" data-dot=<?= $quoteDetail['dot'] ?>>Preview Proposal</button>
        <button class="btn btn-success" id="btnSaveProposal" data-id=<?= $id ?>>Save Proposal</button>
    </div>
</div>

<style>
    .gap {
        width: 5px;
        /* Set the width of the gap */
        border: none !important;
        /* Get rid of the border */
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="../js/coverage.js"></script>