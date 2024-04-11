<?php
require_once '../controllers/Login.php';
require_once '../models/User.php';

startSession();
checkActivity();

$user = new User();

?>
<div class="flex flex-row items-center text-sky-950 ">
    <?php if ($user->hasPermission('editarComisiones')) { ?>
        <i class="fas fa-gear fa-2xl mt-1 clickable" title="Configure Agent Commissions" id="editAgentCommissions"></i>
    <?php } ?>
    <h4 class="mx-auto">My Portfolio</h4>
</div>
<div class="flex flex-row pe-2 w-full" id="policySummary">
</div>
<div class="flex flex-row pe-2 w-full">
    <div class="border shadow shadow-sky-950 rounded mt-2 w-full">
        <div class="flex p-4 flex-col md:grid md:grid-cols-2 lg:grid lg:grid-cols-6 text-sky-950 text-center font-bold gap-1">
            <div class="flex flex-col" id="yearSelectDiv">
                <span for='yearSelect' id="yearSelectSpan">Select Year</span>
                <select class="p-2 border rounded border-sky-950" id='yearSelect'>
                    <option value="all">All</option>
                    <?php
                    $year = date('Y');
                    for ($i = $year; $i >= 2018; $i--) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="flex flex-col" id="mesSelectDiv">
                <span for='mesSelect' id="mesSelectSpan">Select Month</span>
                <select class="p-2 border rounded border-sky-950" id='mesSelect'>
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
            <?php if ($user->hasPermission('listarPolizas')) { ?>
                <div class="flex flex-col" id="agenteSelectDiv">
                    <span for='agenteSelect' id="agenteSelectSpan">Select Agent</span>
                    <select class="p-2 border rounded border-sky-950" id='agenteSelect'>
                        <option value="all" selected>All</option>
                        <?php foreach ($user->listInsuranceAgents() as $agent) { ?>
                            <option value="<?= $agent['id'] ?>"><?= $agent['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="flex flex-col" id="typeSelectDiv">
                <span for='typeSelect' id="typeSelectSpan">Select Type</span>
                <select class="p-2 border rounded border-sky-950" id='typeSelect'>
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
            <div class="flex flex-col">
                <span for="searchText" id="searchTextSpan">Keyword Search</span>
                <input type="text" class="p-2 border rounded border-sky-950" id="searchText" placeholder="Insured, Carrier or Policy No.">
            </div>
            <div class="flex gap-1 justify-center flex-wrap content-end">
                <button class="rounded text-white btn-success" id="refreshPolicyTable">Search</button>
                <button id="btnNewTransaction" class="rounded text-white btn-primary"><span class="fa-solid fa-plus fa-lg p-1"></span>Transaction</button>
            </div>
        </div>
    </div>
</div>
<div id="policyTable" class="mt-2 ms-lg-3">
</div>

<link rel="stylesheet" href="../css/myPolicies.css">

<script>
    modalShow('spinner');

    $('#btnNewTransaction').on('click', function() {
        if ($('#agenteSelect').val() == 'all') {
            /* $('#infoModalTitle').text('Error');
            $('#infoModalText').html('Please select an agent to add a new transaction');
            $('#infoModalButtons').html('<div id="okButton"></div>');
            $('#cancelButton').load('../components/buttons/okButton.php');
            modalShow('infoModal'); */
            toast('Please select an agent to add a new transaction', 'warning');
        } else {
            $('#infoModalTitle').text('New Transaction');
            $('#infoModalTitle').parent().removeClass();
            $('#infoModalTitle').parent().addClass('modalTitle bg-sky-950');
            $modalContent = "<div id='newTransaction'></div>";
            $('#infoModalText').html($modalContent);
            $modalContent =
                '<div class="flex gap-1 justify-end"><div id="cancelButtonDiv"></div><div id="saveButtonDiv"></div></div>';
            $('#infoModalButtons').html($modalContent);
            $('#cancelButtonDiv').load('../components/buttons/cancelButton.php');
            $('#saveButtonDiv').load('../components/buttons/saveButton.php');
            $('#newTransaction').load(
                '../components/newTransaction.php', {
                    agent: $('#agenteSelect').val(),
                },
                function() {
                    modalShow('infoModal');
                }
            );
        }
    });

    function loadPolicySummary($quarter) {
        $quarter = $quarter || 'fullYear';
        $('#policySummary').load('../components/policySummary.php', {
            year: $('#yearSelect').val(),
            agente: $('#agenteSelect').val(),
            quarter: $quarter,
        });
    }

    function loadPolicyTable() {
        modalShow('spinner');
        $('#policyTable').load(
            '../components/policyTable.php', {
                year: $('#yearSelect').val(),
                mes: $('#mesSelect').val(),
                agente: $('#agenteSelect').val(),
                tipo: $('#typeSelect').val(),
                keyword: $('#searchText').val(),
                page: 1,
            },
            function() {
                modalHide('spinner');
            }
        );
    }

    loadPolicySummary();
    loadPolicyTable();

    $('#refreshPolicyTable').on('click', function() {
        var checkedButtonId = $('input[name="quarters"]:checked').attr('id');
        loadPolicySummary(checkedButtonId);
        loadPolicyTable();
    });

    $('#editAgentCommissions').on('click', function() {
        modalShow('spinner');
        $('#infoModalTitle').text('Edit Agent Commissions');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-sky-950');
        $modalContent = "<div id='editCommission'></div>";
        $('#infoModalText').html($modalContent);
        $('#editCommission').load('../components/editAgentCommissions.php', function() {
            modalShow('infoModal');
        });
        $('#infoModalButtons').html("<div class='flex gap-1'><div id='calcenButtonDiv'></div><div id='btnSaveCommission'></div></div>");
        $('#calcenButtonDiv').load('../components/buttons/cancelButton.php');
        $('#btnSaveCommission').load('../components/buttons/saveButton.php');
    });
</script>