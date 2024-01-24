<script src="../js/quotes.js"></script>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<h2 class="text-center pt-5">My Quotes</h2>
<div class="row">
    <div class="col-auto">
        <label for="dotSearch">Search for a DOT</label>
        <input type="text" id="dotSearch" class="form-control rounded" placeholder="DOT">
        <button class="btn btn-primary mt-3" id="btnSearchDot">Search</button>
    </div>
</div>
<div class="row w-100 mt-8">
    <div class="col-auto">
        <?php include '../components/pendingQuotes.php'; ?>
    </div>
    <div class="col-auto">
        <?php include '../components/quoted.php'; ?>
    </div>
    <div class="col-auto">
        <div id='quoteDetail'></div>
    </div>
</div>