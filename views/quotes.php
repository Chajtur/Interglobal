<script src="../js/quotes.js"></script>
<?php

if (!isset($_SESSION)) {
    session_start();
}
?>
<h4 class="text-center mt-2">My Quotes</h4>
<div class="flex mt-7 content-center justify-center">
    <div class="w-full lg:w-1/3 flex-col">
        <label class="text-sky-950 font-bold" for="manualName">Please insert the client's name and DOT</label>
        <input type="text" id="manualName" class="mt-2" placeholder="Client's Name">
        <input type="text" id="manualDot" class="mt-2" placeholder="DOT">
        <div class="flex w-full justify-end">
            <button class="btn-primary mt-2" id="btnManualProposal">Create Proposal</button>
        </div>
    </div>
</div>
<div class="flex flex-row w-full justify-evenly mt-5">
    <div class="w-1/3">
        <div class="w-full lg:w-3/4">
            <h4 class="text-sky-950 font-bold">Search for a DOT</h4>
            <input type="text" id="dotSearch" class="rounded" placeholder="DOT">
            <div class="flex w-full justify-end">
                <button class="btn-primary mt-2" id="btnSearchDot">Search</button>
            </div>
            <div id='quoteDetail'></div>
        </div>
    </div>
    <div class="w-1/3">
        <?php include '../components/pendingQuotes.php'; ?>
    </div>
    <div class="w-1/3">
        <?php include '../components/quoted.php'; ?>
    </div>
</div>