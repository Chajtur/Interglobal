<?php
require_once '../controllers/Login.php';

startSession();
checkActivity();

?>
<div class="row text-center mt-2">
    <h2>My Portfolio</h2>
</div>
<div class="row px-4 px-md-0" id="policySummary">
</div>
<div class="rounded mt-4 mx-auto col-12 col-lg-11 border-secondary border">
    <div class="p-2 h6 row justify-content-center">
        <div class="my-1 col-md-6 col-lg-2 text-center" id="mesSelectDiv">
            <span for='mesSelect' id="mesSelectSpan">Select Month</span>
            <select class="form-select my-1 pb-1" id='mesSelect'>
                <option value="all">All</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <?php if (hasPermission('listarPolizas')) { ?>
            <div class="my-1 col-md-6 col-lg-2 text-center" id="agenteSelectDiv">
                <span for='agenteSelect' id="agenteSelectSpan">Select Agent</span>
                <select class="form-select my-1 pb-1" id='agenteSelect'>
                    <option value="all">Interglobal US</option>
                    <?php foreach (listInsuranceAgents() as $agent) { ?>
                        <option value="<?= $agent['id'] ?>"><?= $agent['firstName'] . ' ' . $agent['lastName'] ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        <div class="my-1 col-md-6 col-lg-2 text-center" id="typeSelectDiv">
            <span for='typeSelect' id="typeSelectSpan">Select Type</span>
            <select class="form-select my-1 pb-1" id='typeSelect'>
                <option value="all">All</option>
                <option value="NEW BUSINESS">New Business</option>
                <option value="RENEWAL">Renewal</option>
                <option value="CANCELLATION">Cancellation</option>
                <option value="REINSTATEMENT">Reinstatement</option>
                <option value="ADDITIONAL PREMIUM">Additional Premium</option>
                <option value="RETURN PREMIUM">Return Premium</option>
                <option value="OTHER">Other</option>
            </select>
        </div>
        <div class="my-1 col-md-6 col-lg-2 text-center">
            <span for="searchText" id="searchTextSpan">Keyword Search</span>
            <input type="text" class="form-control my-1 pb-1 rounded" id="searchText" placeholder="Insured, Carrier or Policy No.">
        </div>
        <div class="my-1 col-md-6 col-lg-2 text-end my-auto">
            <button class="rounded text-white btn btn-success w-100 mt-2" id="refreshPolicyTable">Search</button>
        </div>
        <div class="my-1 col-md-6 col-lg-2 text-end my-auto">
            <button class="rounded text-white btn btn-primary w-100 mt-2"><span class="fa-solid fa-plus fa-lg p-1"></span>New Transaction</button>
        </div>
    </div>
</div>
<div id="policyTable" class="mt-2 ms-lg-3">
</div>

<script type="text/javascript" src="../js/mypolicies.js"></script>
<link rel="stylesheet" href="../css/mypolicies.css">