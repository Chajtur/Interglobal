<?php

include "../models/Quote.php";
include "../controllers/Load.php";
$id = $_POST['id'] ?? "0";
$client = $_POST['client'] ?? "0";
$dot = $_POST['dot'] ?? "0";

if ($id != "0") {
    $quoteDetail = queryGeneralDotWeb($id);
}

include "../models/LoB.php";

$coverage = new LoB();
$coverages = $coverage->getAll();

?>
<h3 class="text-center" id="clientDiv" data-name="<?= $id == 0 ? $client : $quoteDetail->legalName ?>">Proposal For : <?= $id == 0 ? $client : $quoteDetail->legalName ?></h3>
<div class="col-4 mx-auto">
    <label class="w-100 text-center text-primary" for="proposalType">Select Proposal Type</label>
    <select class="form-select text-primary" id="proposalType">
        <option value="1">New Business</option>
        <option value="2">Renewal</option>
    </select>
</div>
<hr>
<div class="row w-100">
    <div class="col-auto d-flex align-items-end">
        <div class="text-end">
            <button title="Click to add a Coverage" class="btn btn-success" id="btnAddCoverage">Add Coverage</button>
            <button title="Click to add an Option" class="btn btn-success" id="btnAddOption">Add Option</button>
            <button title="Click to add a Bill Plan" class="btn btn-success" id="btnAddBillPlan">Add Bill Plan</button>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="optionsTabs" role="tablist">
        <li class="nav-item" role="presentation" data-option=1>
            <a class="nav-link active text-decoration-none" id="optionTab1" data-bs-toggle="tab" href="#tabOption1" role="tab" aria-controls="coverage" aria-selected="true">
                <i class="fa-solid fa-pencil text-white me-3 optionName"></i><span data-optionName=1>Option 1</span>
            </a>
        </li>
    </ul>
    <!-- Tab Content -->
    <div class="tab-content mt-2" id="optionContent">
        <div data-option=1 id="tabOption1" class="tab-pane active" role="tabpanel" aria-labelledby="table-tab">
            <caption class="text-sm">All Coverages with <span class="bg-warning-light p-1">BACKGROUND</span> are missing a Bill Plan</caption>
            <table class="table tableOptions mt-2" data-option=1>
                <thead class="text-center">
                    <tr>
                        <th class="bg-primary-light"></th>
                        <th class="bg-primary-light text-start">Line of Business</th>
                        <th class="bg-primary-light text-end">Amount</th>
                        <th data-id="1" class="bg-success-light text-start">Carrier</th>
                        <th data-id="1" class="bg-success-light text-end">Base Premium</th>
                        <th data-id="1" class="bg-success-light text-end">Taxes & Fees</th>
                        <th data-id="1" class="bg-success-light text-end">Total Premium</th>
                        <th data-id="1" class="bg-success-light">Notes</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="d-none">
                    <tr class="bg-primary text-white text-center">
                        <th colspan="1"></th>
                        <th colspan="3">Bill Plan for</th>
                        <th class="text-end">Duration</th>
                        <th class="text-end">No. of Installments</th>
                        <th class="text-end">Down Payment</th>
                        <th class="text-end">Installment Amount</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-auto ms-auto">
        <button class="btn btn-primary" id="btnPreviewProposal" data-dot=<?= $quoteDetail->dotNumber ?? $dot ?>>Preview Proposal</button>
        <button class="btn btn-success" id="btnSaveProposal" data-id=<?= $quoteDetail->dotNumber ?? $dot ?>>Save Proposal</button>
    </div>
</div>

<style>
    #optionsTabs .nav-link.active {
        background-color: var(--bs-primary);
        color: white;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="../js/coverage.js"></script>