<script src="../js/quotes.js"></script>
<?php

if (!isset($_SESSION)) {
    session_start();
}
?>
<h2 class="text-center pt-5">My Quotes</h2>
<div class="row mt-7 justify-content-center">
    <div class="col-4">
        <label class="text-primary fw-bold" for="manualName">Please insert the client's name and DOT</label>
        <input type="text" id="manualName" class="form-control rounded" placeholder="Client's Name">
        <input type="text" id="manualDot" class="form-control rounded mt-3" placeholder="DOT">
        <button class="btn btn-primary mt-3" id="btnManualProposal">Create Proposal</button>
    </div>
</div>
<div class="row w-100 mt-5">
    <div class="col-4">
        <label for="dotSearch" class="text-primary fw-bold">Search for a DOT</label>
        <input type="text" id="dotSearch" class="form-control rounded" placeholder="DOT">
        <button class="btn btn-primary mt-3" id="btnSearchDot">Search</button>
        <div id='quoteDetail'></div>
    </div>
    <div class="col-4">
        <?php include '../components/pendingQuotes.php'; ?>
    </div>
    <div class="col-4">
        <?php include '../components/quoted.php'; ?>
    </div>
</div>