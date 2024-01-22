<?php
include "../models/Quote.php";
$id = $_POST['id'];
$quote = new Quote();
$quoteDetail = $quote->getQuoteDetail($id);
?>

<div class="shadow-lg">
    <div class="bg-info p-4 text-center rounded-top">
        <h4 class="text-white">Quote Details</h4>
    </div>
    <div class="p-4 border-start border-end border-bottom border-1 rounded-bottom">
        <div class="border-bottom">DOT : <?= $quoteDetail['dot'] ?></div>
        <div class="border-bottom">MC : <?= $quoteDetail['mc'] ?></div>
        <div class="border-bottom">Address : <?= $quoteDetail['address'] ?></div>
        <div class="border-bottom">City : <?= $quoteDetail['city'] ?></div>
        <div class="border-bottom">State : <?= $quoteDetail['state'] ?></div>
        <div class="border-bottom">Zip : <?= $quoteDetail['zip'] ?></div>
        <div class="border-bottom">Email : <?= $quoteDetail['email'] ?></div>
        <div class="border-bottom">Phone : <?= $quoteDetail['phone'] ?></div>
        <div class="border-bottom">Proposed Date : <?= $quoteDetail['proposedDate'] ?></div>
        <div class="border-bottom">Driver License : <?= $quoteDetail['driverLicense'] ?></div>
        <div class="">Status : <?= $quoteDetail['status'] ?></div>
        <div class="text-end mt-2"><button class="btn btn-primary" id="btnGenerateRFP">Generate RFP</button><button class="btn btn-success ms-2" id="btnGenerateProposal" data-id=<?= $id ?>>Generate Proposal</button></div>
    </div>
</div>