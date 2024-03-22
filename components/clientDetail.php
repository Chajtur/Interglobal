<?php
include "../models/Quote.php";
include "../controllers/Load.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

$id = $_POST['id'] ?? 0;
$dot = $_POST['dot'] ?? 0;

$quote = new Quote();

if ($id != 0) {
    $quoteDetail = $quote->getQuoteDetail($id);
}

if ($dot != 0) {
    $quoteDetail = queryGeneralDotWeb($dot);
}
?>

<div class="shadow-lg mt-3">
    <div class="bg-info p-4 text-center rounded-top">
        <h4 class="text-white">Client Details</h4>
    </div>
    <div class="p-4 border-start border-end border-bottom border-1 rounded-bottom">
        <div class="border-bottom">DOT : <?= $quoteDetail->dotNumber ?></div>
        <div class="border-bottom">Name : <?= $quoteDetail->legalName ?></div>
        <div class="border-bottom">Address : <?= $quoteDetail->phyStreet ?></div>
        <div class="border-bottom">City : <?= $quoteDetail->phyCity ?></div>
        <div class="border-bottom">State : <?= $quoteDetail->phyState ?></div>
        <div class="border-bottom">Zip : <?= $quoteDetail->phyZipcode ?></div>
        <!-- <div class="border-bottom">Email : <?= '' ?></div>
        <div class="border-bottom">Phone : <?= '' ?></div>
        <div class="border-bottom">Proposed Date : <?= '' ?></div>
        <div class="border-bottom">Driver License : <?= '' ?></div> -->
        <div class="">Status : <?= 'Pending' ?></div>
        <div class="text-end mt-2"><button class="btn btn-primary" id="btnGenerateRFP">Generate RFP</button><button class="btn btn-success ms-2" id="btnGenerateProposal" data-dot=<?= $quoteDetail->dotNumber ?> data-client='<?= $quoteDetail->legalName ?>'>Generate Proposal</button></div>
    </div>
</div>