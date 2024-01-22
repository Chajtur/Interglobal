<script src="../js/quotes.js"></script>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<h2 class="text-center pt-5">My Quotes</h2>
<div class="row w-100 mt-8">
    <div class="col-auto">
        <?php include_once '../components/pendingQuotes.php'; ?>
    </div>
    <div class="col-auto">
        <?php include_once '../components/quoted.php'; ?>
    </div>
    <div class="col-auto">
        <div id='quoteDetail'></div>
    </div>
</div>