<?php

include "../models/Quote.php";
include "../controllers/Load.php";
$id = $_POST['id'] ?? "0";
$client = $_POST['client'] ?? "0";
$dot = $_POST['dot'] ?? "0";
$idQuote = $_POST['idQuote'] ?? "0";

if ($id != "0")
{
    $quoteDetail = queryGeneralDot($id);
}

if ($idQuote != "0")
{
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/Quote.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/BillPlan.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/Coverage.php";

    $quote = new Quote();
    $coverage = new Coverage();
    $quote->load($idQuote);
    $billPlanObject = new BillPlan();
    $billPlans = $billPlanObject->listAll($idQuote);
    $billPlanDetail = new BillPlan();
    $idOption = 0;
}

include $_SERVER['DOCUMENT_ROOT'] . "/models/LoB.php";

$LOB = new LoB();
$coverageList = $LOB->getAll();

?>
<h3 class="text-center text-sky-950" id="clientDiv"
    data-name="<?= $idQuote == 0 ? ($id == 0 ? $client : $quoteDetail->legalName) : $quote->owner ?>">
    Proposal For : <?= $idQuote == 0 ? ($id == 0 ? $client : $quoteDetail->legalName) : $quote->owner ?></h3>
<div class="w-full lg:w-1/3 mx-auto mt-2 flex flex-col p-2">
    <label class="w-full text-center text-sky-950" for="proposalType">Select Proposal Type</label>
    <select class="text-sky-950" id="proposalType">
        <option value="1">New Business</option>
        <option value="2">Renewal</option>
    </select>
</div>
<hr class='border border-gray-400'>
<div class="flex flex-row w-full p-2">
    <div class="w-auto flex items-end">
        <div class="text-end">
            <button title="Click to add a Coverage" class="btn-success" id="btnAddCoverage">Add Coverage</button>
            <button title="Click to add an Option" class="btn-success" id="btnAddOption">Add Option</button>
            <button title="Click to add a Bill Plan" class="btn-success" id="btnAddBillPlan">Add Bill Plan</button>
        </div>
    </div>
</div>
<hr class='border border-gray-400'>
<div class="flex flex-col mt-2">
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs flex flex-row border-b" id="optionsTabs" role="tablist">
        <?php if ($idQuote == 0)
        { ?>
            <li class="nav-item active" role="presentation" data-option=1>
                <a class="nav-link" id="optionTab1" data-bs-toggle="tab" href="#tabOption1" role="tab"
                    aria-controls="coverage" aria-selected="true">
                    <i class="fa-solid fa-pencil text-white me-3 optionName"></i><span data-optionName=1>Option 1</span>
                </a>
            </li>
        <?php } else
        {
            foreach ($billPlans as $bp)
            {
                $billPlanObject->load($bp['idBillPlan'], $idQuote);
                if ($billPlanObject->idOption != $idOption)
                {
                    $idOption = $billPlanObject->idOption;
                    ?>
                    <li class="nav-item <?php echo $idOption == 1 ? ' active' : ''?>" role="presentation" data-option=<?= $idOption ?>>
                        <a class="nav-link" id="optionTab<?= $idOption ?>" data-bs-toggle="tab" href="#tabOption<?= $idOption ?>" role="tab" aria-controls="coverage" aria-selected="true">
                            <i class="fa-solid fa-pencil text-white me-3 optionName"></i><span data-optionName=<?= $idOption ?>><?= $billPlanObject->optionName ?: 'Option ' . $idOption ?></span><?php if ($idOption <> 1)
                            {
                                echo "<i class='ms-3 fa-solid fa-trash-can text-white removeOption'/i></i>"; 
                                } 
                            ?>
                        </a>
                    </li>
                <?php }
            }
        } ?>
    </ul>
    <!-- Tab Content -->
    <div class="tab-content mt-2" id="optionContent">
        <?php
        if ($idQuote != 0)
        {
            $options = $quote->listOptions();
            foreach ($options as $op)
            {
                $idOption = $op['idOption'];
                $billPlanList = $quote->listBillPlans($idOption);
                ?>
            <div data-option=<?= $idOption ?> id="tabOption<?= $idOption ?>"
                    class="tab-pane <?= $idOption == 1 ? 'active' : '' ?>" role="tabpanel"
                    aria-labelledby="table-tab">
                    <caption class="text-xs">All Coverages with <span class="bg-red-100 p-1">BACKGROUND</span> are missing a
                        Bill Plan</caption>
                    <table class="table tableOptions mt-2 w-full" data-option=<?= $idOption ?>>
                        <thead>
                        <tr class="text-center">
                            <th class="bg-sky-100"></th>
                            <th class="bg-sky-100 text-start">Line of Business</th>
                            <th class="bg-sky-100 text-end">Amount</th>
                            <th data-id="1" class="bg-green-100 text-start">Carrier</th>
                            <th data-id="1" class="bg-green-100 text-end">Base Premium</th>
                            <th data-id="1" class="bg-green-100 text-end">Taxes & Fees</th>
                            <th data-id="1" class="bg-green-100 text-end">Total Premium</th>
                            <th data-id="1" class="bg-green-100">Notes</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($billPlanList as $bp)
                            {
                                $billPlanObject->load($bp['idBillPlan'], $quote->id);
                                $coverages = $coverage->listAll($quote->id, $billPlanObject->id);
                                foreach ($coverages as $c)
                                {
                                    $coverage->load($c['idCoverage'], $quote->id, $billPlanObject->id);
                                    $coverageAmount = $coverage->amount;
                                    ?>
                                    <tr class="coverageRow bg-green-100" data-coverage=<?= $coverage->id ?> data-billplan=<?= $billPlanObject->id ?>>
                                        <td class="text-center">
                                        <button title="Click to remove Coverage" class="btn-danger btn-sm btnRemoveCoverage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button title="Click to assign Bill Plan" class="btn-success btn-sm btnAddBillPlan">
                                        <i class="fas fa-coins"></i>
                                    </button>
                                        </td>
                                        <td class="text-start"><?= $coverage->type ?></td>
                                        <td class="text-end">$<?= number_format($coverageAmount, 2, '.', ',') ?></td>
                                        <td class="text-start">
                                            <button class="btn-info btn-sm btnEditCoverage me-3">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <?= $coverage->carrier ?>
                                        </td>
                                        <td class="text-end">$<?= number_format($coverage->basePremium, 2, '.', ',') ?></td>
                                        <td class="text-end">$<?= number_format($coverage->taxesFees, 2, '.', ',') ?></td>
                                        <td class="text-end totalPremiumCoverage" data-value=<?= $coverage->totalPremium ?>>$<?= number_format($coverage->totalPremium, 2, '.', ',') ?></td>
                                        <td class="text-center">Notes</td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                        <tfoot class="">
                            <tr class="bg-sky-950 text-white text-center">
                                <th colspan="1"></th>
                                <th colspan="3">Bill Plan for</th>
                                <th class="text-end">Duration</th>
                                <th class="text-end">No. of Installments</th>
                                <th class="text-end">Down Payment</th>
                                <th class="text-end">Installment Amount</th>
                            </tr>
                            <?php
                            foreach ($billPlanList as $bp)
                            {
                                $billPlanObject->load($bp['idBillPlan'], $quote->id);
                                ?>
                                <tr class="billPlanRow text-end" data-billplan=<?= $billPlanObject->id ?>>
                                    <td class="text-center">
                                        <button title="Click to remove Bill Plan" class="btn-danger btn-sm btnRemoveBillPlan me-1">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                        <button title="Click to edit Bill Plan" class="btn-info btn-sm btnEditBillPlan">
                                            <i class="fas fa-pencil" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    <td colspan="3" class="text-center"><?= $billPlanObject->listCoverages() ?></td>
                                    <td><?= $billPlanObject->term ?></td>
                                    <td><?= $billPlanObject->installments ?></td>
                                    <td>$<?= number_format($billPlanObject->downPayment, 2, '.', ',') ?></td>
                                    <td>$<?= number_format($billPlanObject->installmentAmount, 2, '.', ',') ?></td>
                                </tr>
                            <?php } ?>
                        </tfoot>
                    </table>
            </div>
        <?php }
        } else { ?>
            <div data-option=1 id="tabOption1" class="tab-pane active" role="tabpanel" aria-labelledby="table-tab">
                <caption class="text-xs">All Coverages with <span class="bg-red-100 p-1">BACKGROUND</span> are missing a
                    Bill Plan</caption>
                <table class="table tableOptions mt-2 w-full" data-option=1>
                    <thead>
                        <tr class="text-center">
                            <th class="bg-sky-100"></th>
                            <th class="bg-sky-100 text-start">Line of Business</th>
                            <th class="bg-sky-100 text-end">Amount</th>
                            <th data-id="1" class="bg-green-100 text-start">Carrier</th>
                            <th data-id="1" class="bg-green-100 text-end">Base Premium</th>
                            <th data-id="1" class="bg-green-100 text-end">Taxes & Fees</th>
                            <th data-id="1" class="bg-green-100 text-end">Total Premium</th>
                            <th data-id="1" class="bg-green-100">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="hidden">
                        <tr class="bg-sky-950 text-white text-center">
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
        <?php } ?>
</div>
<hr>
<div class="flex-row flex mt-2">
    <div class="w-auto ms-auto">
        <button class="btn-primary" id="btnPreviewProposal" data-dot=<?= $quoteDetail->dotNumber ?? $dot ?>>Preview
            Proposal</button>
        <button class="btn-success" id="btnSaveProposal" data-id=<?= $quoteDetail->dotNumber ?? $dot ?>>Save
            Proposal</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('#btnAddCoverage').click(function () {
        $('#infoModalTitle').text('Add Coverage');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-green-600');
        $('#infoModalText').html('<div id="quoteCoverageDiv"></div>');
        $('#quoteCoverageDiv').load('../components/quotes/quoteCoverage.php', {
            idOption: $('#optionsTabs > li.active').data('option'),
        });
        $('#infoModalButtons').html(
            '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="btnSaveCoverage"></div></div>'
        );
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnSaveCoverage').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $('#optionContent').on('click', '.btnRemoveCoverage', function () {
        let coverage = $(this).closest('tr').find('td:eq(1)').text();
        let idOption = $(this).closest('table').data('option');
        $('.tableOptions[data-option=' + idOption + '] tfoot .billPlanRow').each(function () {
            var billPlanText = $(this).find('td:eq(1)').text();
            billPlanSplit = billPlanText.split(',');
            billPlanSplit = billPlanSplit.filter(function (value, index, arr) {
                return value != coverage;
            });
            $(this).find('td:eq(1)').text(billPlanSplit.join(','));
        });
        $(this).closest('tr').remove();
    });

    $('#btnAddBillPlan').click(function () {
        $('#infoModalTitle').text('Add new Bill Plan');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-blue-400');
        $('#infoModalText').html('<div id="billPlanDiv"></div>');
        $('#billPlanDiv').load('../components/quotes/billPlanCoverage.php', {
            idOption: $('#optionsTabs > li.active').data('option'),
        });
        $('#infoModalButtons').html(
            '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="btnSaveBillPlan"></div></div>'
        );
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnSaveBillPlan').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $('#btnAddOption').click(function () {
        var optionCount = $('#optionsTabs > li').length;
        optionCount++;
        $('#optionsTabs > li').removeClass('active');
        $('#optionsTabs').append(
            '<li data-option=' +
            optionCount +
            " class='nav-item active' role='presentation'><a class='nav-link' id='optionTab" +
            optionCount +
            "' data-bs-toggle='tab' href='#tabOption" +
            optionCount +
            "' role='tab' aria-controls='coverage" +
            "' aria-selected='true'>" +
            "<i class='fa-solid fa-pencil text-white me-3 optionName'></i>" +
            "<span data-optionName=" + optionCount + ">Option " + optionCount + "</span>" +
            '<i class="ms-3 fa-solid fa-trash-can text-white removeOption"/i></a></li>'
        );
        $('#optionContent .tab-pane').removeClass('active');
        $('#optionContent').append(
            '<div data-option=' +
            optionCount +
            ' id="tabOption' +
            optionCount +
            '" class="tab-pane active show" role="tabpanel" aria-labelledby="table-tab">' +
            '<caption class="text-sm">All Coverages with <span class="bg-red-100 p-1">BACKGROUND</span> are missing a Bill Plan</caption>' +
            '<table class="table tableOptions mt-2 w-full" data-option=' +
            optionCount +
            '>' +
            '	<thead class="text-center">' +
            '		<tr>' +
            '			<th class="bg-sky-100"></th>' +
            '			<th class="bg-sky-100 text-start">Line of Business</th>' +
            '			<th class="bg-sky-100 text-end">Amount</th>' +
            '			<th data-id="1" class="bg-green-100 text-start">Carrier</th>' +
            '			<th data-id="1" class="bg-green-100 text-end">Base Premium</th>' +
            '			<th data-id="1" class="bg-green-100 text-end">Taxes & Fees</th>' +
            '			<th data-id="1" class="bg-green-100 text-end">Total Premium</th>' +
            '			<th data-id="1" class="bg-green-100">Notes</th>' +
            '		</tr>' +
            '	</thead>' +
            '	<tbody>' +
            '	</tbody>' +
            '	<tfoot class="hidden">' +
            '		<tr class="bg-sky-950 text-white text-center">' +
            '			<th colspan="1"></th>' +
            '			<th colspan="3">Bill Plan for</th>' +
            '			<th class="text-end">Duration</th>' +
            '			<th class="text-end">No. of Installments</th>' +
            '			<th class="text-end">Down Payment</th>' +
            '			<th class="text-end">Installment Amount</th>' +
            '		</tr>' +
            '	</tfoot>' +
            '</table>' +
            '</div>'
        );
        $('.tableOptions[data-option="1"] tbody tr').each(function () {
            var coverage = $(this).find('td:eq(1)').text();
            var coverageId = $(this).data('coverage');
            var coverageAmount = $(this).find('td:eq(2)').text();
            $('.tableOptions[data-option=' + optionCount + '] tbody').append(
                '<tr class="coverageRow bg-red-100" data-coverage="' +
                coverageId +
                '">' +
                '<td class="text-center">' +
                '<button title="Click to remove Coverage" class="btn-danger btn-sm btnRemoveCoverage me-1">' +
                '<i class="fas fa-trash-alt" aria-hidden="true"></i>' +
                '</button>' +
                '<button title="Click to add Bill Plan" class="btn-success btn-sm btnAddBillPlan">' +
                '<i class="fas fa-coins" aria-hidden="true"></i>' +
                '</button>' +
                '</td>' +
                '<td class="text-start">' +
                coverage +
                '</td>' +
                '<td class="text-end">' +
                coverageAmount +
                '</td>' +
                '<td class="text-start" data-id=' +
                optionCount +
                '><button class="btn-info btn-sm btnEditCoverage me-3"><i class="fas fa-pencil"></i></button>Carrier</td>' +
                '<td data-id=' +
                optionCount +
                ' class="text-end">0.00</td>' +
                '<td data-id=' +
                optionCount +
                ' class="text-end">0.00</td>' +
                '<td data-id=' +
                optionCount +
                ' class="text-end">0.00</td>' +
                '<td data-id=' +
                optionCount +
                ' class="text-center">Notes</td>' +
                '</tr>'
            );
        });
    });

    $('#optionsTabs').on('click', '.removeOption', function () {
        var id = $(this).closest('li').data('option');
        $('#optionsTabs [data-option="' + id + '"]').remove();
        $('#optionContent [data-option="' + id + '"]').remove();
    });

    $('#optionsTabs').on('click', '.optionName', function () {
        $('#infoModalTitle').text('Edit Option Name');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-sky-950');
        $('#infoModalText').html('<div id="optionNameDiv"></div>');
        $('#optionNameDiv').load('../components/quotes/editOptionName.php', {
            optionId: $(this).closest('li').data('option'),
            name: $('span[data-optionName="' + $(this).closest('li').data('option') + '"]').text(),
        });
        $('#infoModalButtons').html('<div class="gap-1 flex flex-row"><div id="cancelButton"></div><div id="btnUpdateOptionName"></div></div>');
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnUpdateOptionName').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    function printOption($id) {
        if ($id > 1) {
            $html +=
                '<footer class="footer">' +
                '    <div class="">If you have any questions or doubts about your quote, please do not hesitate contacting me at {phoneNumber} ext. {extension}, {agentName}.</div>' +
                '    <div class="d-flex bg-primary justify-content-center align-items-center w-100 p-2 mt-2 pt-3">' +
                '      <h6 class="text-white text-center">' +
                '        172 NE 23rd Terrace, Homestead, Fl 33033' +
                '        Office: 305-884-4080 / Mobile: 305-742-6203' +
                '      </h6>' +
                '      <h6 class="text-white text-center">' +
                '        Office Hours: Mon - Fri 9:00 a.m. - 6:00 p.m. E.S.T.' +
                '        Saturday from 10 a.m. to 2 p.m / Sunday closed' +
                '      </h6>' +
                '    </div>' +
                '  </footer>';
            $html +=
                '<div class="page-break">' +
                '    <table class="table shadow-lg">' +
                '      <thead>' +
                '        <tr>' +
                '           <th>' +
                '        <a class="navbar-brand align-self-start" href="#" data-config-id="brand">' +
                '          <img class="img-fluid" src="https://interglobalinsurance.com/wp-content/uploads/2021/12/LOGO-INTERGLOBAL-01-1329x800.png" alt="" width="auto">' +
                '        </a>' +
                '      </th>' +
                '      <th>' +
                '        <div class="text-end">' +
                '          <h5>Quote Number: {QuoteNumber}</h5>' +
                '        </div>' +
                '        <div class="text-end">' +
                '          <h5>Quote Date: {Date}</h5>' +
                '        </div>' +
                '      </th>' +
                '    </table>' +
                '    <hr>' +
                '    <h3>Option ' +
                $id +
                '</h3></div>';
        }
        $html += '  <table class="table table-striped">' + '    <tbody>';
        $('.coverageRow').each(function () {
            var carrierName = $(this)
                .find('.carrierName[data-id=' + $id + ']')
                .val();
            var basePremium = parseFloat(
                $(this)
                    .find('.basePremium[data-id=' + $id + ']')
                    .val()
            );
            var taxesFees = parseFloat(
                $(this)
                    .find('.taxesFees[data-id=' + $id + ']')
                    .val()
            );
            var totalPremiumCoverage = parseFloat(
                $(this)
                    .find('.totalPremiumCoverage[data-id=' + $id + ']')
                    .data('value')
            );
            var coverageAmount = $(this).find('td:eq(2)').text();
            var coverage = $(this).find('td:eq(1)').text();
            var notes = $(this)
                .find('textarea[data-id=' + $id + ']')
                .val();

            $html +=
                '      <tr>' +
                '        <td>' +
                '          <h6>' +
                coverage +
                '          </h6>' +
                '          <h6>' +
                'Insurance Company: ' +
                carrierName +
                '          </h6>' +
                '          <h6>' +
                '$' +
                coverageAmount.toLocaleString('en-US') +
                '          </h6>' +
                '          <h6>' +
                notes +
                '        </h6></td>' +
                '        <td><h6 class="text-end">' +
                '          Base Premium: ' +
                '$' +
                basePremium.toLocaleString('en-US') +
                '        </h6></td>' +
                '        <td><h6 class="text-end">' +
                '          Taxes & Fees: ' +
                '$' +
                taxesFees.toLocaleString('en-US') +
                '        </h6></td>' +
                '        <td><h6 class="text-end">' +
                '          Total Premium: ' +
                '$' +
                totalPremiumCoverage.toLocaleString('en-US') +
                '        </h6></td>' +
                '      </tr>';
        });
        var totalPremium = $('.totalPremium[data-id=' + $id + ']').text();
        var installments = $('.installments[data-id=' + $id + ']').val();
        var installmentAmount = parseFloat($('.installment[data-id=' + $id + ']').val());
        var downPayment = parseFloat($('.downPayment[data-id=' + $id + ']').val());
        $html +=
            '    </tbody>' +
            '    <tfoot>' +
            '      <tr>' +
            '        <td colspan="2"></td>' +
            '        <td>' +
            '          <div>' +
            '            BILL PLAN' +
            '          </div>' +
            '          <div>' +
            '            12 Months' +
            '          </div>' +
            '        </td>' +
            '        <td class="text-end">' +
            totalPremium +
            '</td>' +
            '      </tr>' +
            '      <tr>' +
            '        <td colspan="2"></td>' +
            '        <td>Down Payment</td>' +
            '        <td class="text-end">' +
            '$' +
            downPayment.toLocaleString('en-US') +
            '</td>' +
            '      </tr>' +
            '      <tr>' +
            '        <td colspan="2"></td>' +
            '        <td>' +
            installments +
            ' Installments</td>' +
            '        <td class="text-end">' +
            '$' +
            installmentAmount.toLocaleString('en-US') +
            '</td>' +
            '      </tr>' +
            '    </tfoot>' +
            '  </table>';
    }

    $('#optionContent').on('click', '.btnEditCoverage', function () {
        var idCoverage = $(this).closest('tr').data('coverage');
        var idOption = $(this).closest('table').data('option');
        var coverage = $(this).closest('tr').find('td:eq(1)').text();
        var coverageAmount = $(this).closest('tr').find('td:eq(2)').text();
        var carrier = $(this).closest('tr').find('td:eq(3)').text();
        carrier = carrier.replace(/\s/g, '');
        var basePremium = $(this).closest('tr').find('td:eq(4)').text();
        var taxesFees = $(this).closest('tr').find('td:eq(5)').text();
        var notes = $(this).closest('tr').find('td:eq(7)').text();
        coverageAmount = coverageAmount.replace('$', '');
        basePremium = basePremium.replace('$', '');
        taxesFees = taxesFees.replace('$', '');
        coverageAmount = coverageAmount.replace(',', '');
        basePremium = basePremium.replace(',', '');
        taxesFees = taxesFees.replace(',', '');
        $('#infoModalTitle').html('<i class="fa-solid fa-triangle-exclamation fa-beat fa-xl me-2"></i>Edit Coverage');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-yellow-600');
        $('#infoModalText').html('<div id="quoteCoverageDiv"></div>');
        $('#quoteCoverageDiv').load('../components/quotes/editCoverage.php', {
            idCoverage: idCoverage,
            idOption: idOption,
            coverage: coverage,
            coverageAmount: coverageAmount,
            carrier: carrier,
            basePremium: basePremium,
            taxesFees: taxesFees,
            notes: notes,
        });
        $('#infoModalButtons').html(
            '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="btnUpdateCoverage"></div>'
        );
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnUpdateCoverage').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $('#btnPreviewProposal').click(function () {
        $('#infoModalTitle').text('Preview Proposal');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-blue-400');
        $('#infoModalText').html('<div id="previewProposalDiv"></div>');
        $('#previewProposalDiv').load('../components/quotes/previewProposal.php');
        $('#infoModalButtons').html('<div id="okButton"></div>');
        $('#okButton').load('../components/buttons/okButton.php');
        $('#infoModal').addClass('fullscreen-modal');
        modalShow('infoModal');
    });

    $('#optionContent').on('click', '.btnRemoveBillPlan', function () {
        console.log('btnRemoveBillPlan');
        let idOption = $(this).closest('table').data('option');
        let billPlan = $(this).closest('tr').data('billplan');
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').removeClass(
            'bg-green-100 text-white'
        );
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').addClass(
            'bg-red-100'
        );
        $('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').attr('data-billplan', '');
        $(this).closest('tr').remove();
        if ($('.tableOptions[data-option=' + idOption + '] tfoot tr.billPlanRow').length === 0) {
            $('.tableOptions[data-option=' + idOption + '] tfoot').addClass('hidden');
        }
    });

    $('#optionContent').on('click', '.btnEditBillPlan', function () {
        var idBillPlan = $(this).closest('tr').data('billplan');
        var idOption = $(this).closest('table').data('option');
        var billPlan = $(this).closest('tr').find('td:eq(1)').text();
        var billPlanDuration = $(this).closest('tr').find('td:eq(2)').text();
        var billPlanInstallments = $(this).closest('tr').find('td:eq(3)').text();
        var billPlanDownPayment = $(this).closest('tr').find('td:eq(4)').text();
        var billPlanAmount = $(this).closest('tr').find('td:eq(5)').text();
        $('#infoModalTitle').html('<i class="fa-solid fa-triangle-exclamation fa-beat me-2"></i> Edit Bill Plan');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-yellow-600');
        $('#infoModalText').html('<div id="billPlanDiv"></div>');
        $('#billPlanDiv').load('../components/quotes/editBillPlan.php', {
            idBillPlan: idBillPlan,
            idOption: idOption,
            billPlan: billPlan,
            duration: billPlanDuration,
            installments: billPlanInstallments,
            downPayment: billPlanDownPayment,
            amount: billPlanAmount,
        });
        $('#infoModalButtons').html(
            '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="btnUpdateBillPlan"></div></div>'
        );
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnUpdateBillPlan').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $('#optionContent').on('click', '.btnAddBillPlan', function () {
        var idOption = $(this).closest('table').data('option');
        var idCoverage = $(this).closest('tr').data('coverage');
        $('#infoModalTitle').text('Add Coverage to Bill Plan');
        $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-blue-400');
        $('#infoModalText').html('<div id="billPlanDiv"></div>');
        $('#billPlanDiv').load('../components/quotes/addBillPlanCoverage.php', {
            idOption: idOption,
            idCoverage: idCoverage,
        });
        $('#infoModalButtons').html(
            '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="btnSaveBillPlan"></div></div>'
        );
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#btnSaveBillPlan').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
    });

    $('#btnSaveProposal').on('click', function () {
        let $dot = $(this).data('id');
        let $errors = 0;
        let $idQuote = 0;
        $.post('../controllers/Quote.php', {
            action: 'saveQuote',
            dot: $dot,
            idQuote: $(this).data('quote'),
            type: $('#proposalType').val(),
            name: $('#clientDiv').data('name'),
        }).done(function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $idQuote = data.id;
                $('#optionsTabs li').each(function () {
                    let $idOption = $(this).data('option');
                    console.log('Saving Coverages for ' + $idOption);
                    $('.tableOptions[data-option=' + $idOption + '] tbody .coverageRow').each(function () {
                        let $idCoverage = $(this).data('coverage');
                        let $coverageAmount = $(this).find('td:eq(2)').text();
                        let $carrier = $(this).find('td:eq(3)').text();
                        let $basePremium = $(this).find('td:eq(4)').text();
                        let $taxesFees = $(this).find('td:eq(5)').text();
                        let $notes = $(this).find('td:eq(7)').text();
                        let $idBillPlan = $(this).data('billplan');
                        if ($idBillPlan != '' && $idBillPlan != undefined) {
                            $.post('../controllers/Quote.php', {
                                action: 'saveQuoteCoverage',
                                idQuote: $idQuote,
                                idOption: $idOption,
                                idCoverage: $idCoverage,
                                coverageAmount: $coverageAmount,
                                carrier: $carrier,
                                basePremium: $basePremium,
                                taxesFees: $taxesFees,
                                notes: $notes,
                                idBillPlan: $idBillPlan,
                            }).done(function (data) {
                                console.log(data);
                                data = JSON.parse(data);
                                if (data.code == 500) {
                                    $errors++;
                                    $('#infoModalTitle').html('<i class="fa-solid fa-circle-exclamation fa-beat me-2"></i> Error');
                                    $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-600');
                                    $('#infoModalText').text(data.message);
                                    $('#infoModalButtons').html(
                                        '<div id="okButton"></div>'
                                    );
                                    $('#okButton').load('../components/buttons/okButton.php');
                                    modalShow('infoModal');
                                }
                            });
                        }
                    });
                    console.log('Saving Bill Plans for ' + $idOption);
                    $('.tableOptions[data-option=' + $idOption + '] tfoot .billPlanRow').each(function () {
                        let $idBillPlan = $(this).data('billplan');
                        let $term = $(this).find('td:eq(2)').text();
                        let $installments = $(this).find('td:eq(3)').text();
                        let $downPayment = $(this).find('td:eq(4)').text();
                        let $installmentAmount = $(this).find('td:eq(5)').text();
                        $.post('../controllers/Quote.php', {
                            action: 'saveQuoteBillPlan',
                            idBillPlan: $idBillPlan,
                            idOption: $idOption,
                            optionName: $('span[data-optionName="' + $idOption + '"]').text(),
                            term: $term,
                            installments: $installments,
                            downPayment: $downPayment,
                            installmentAmount: $installmentAmount,
                            idQuote: $idQuote,
                        }).done(function (data) {
                            console.log(data);
                            data = JSON.parse(data);
                            if (data.code == 500) {
                                $errors++;
                                $('#infoModalTitle').html('<i class="fa-solid fa-circle-exclamation fa-beat me-2"></i> Error');
                                    $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-600');
                                    $('#infoModalText').text(data.message);
                                    $('#infoModalButtons').html(
                '<div id="okButton"></div>'
            );
            $('#okButton').load('../components/buttons/okButton.php');
                                modalShow('infoModal');
                            }
                        });
                    });
                });
            } else {
                $errors++;
                $('#infoModalTitle').html('<i class="fa-solid fa-circle-exclamation fa-beat me-2"></i> Error');
                                    $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-red-600');
                                    $('#infoModalText').text(data.message);
                                    $('#infoModalButtons').html(
                '<div id="okButton"></div>'
            );
            $('#okButton').load('../components/buttons/okButton.php');
                modalShow('infoModal');
            }
        });
        if ($errors == 0) {
            $('#btnSaveProposal').attr('data-quote', $idQuote);
            $('#infoModalTitle').html('<i class="fa-solid fa-circle-check fa-beat me-2"></i> Success!');
                                    $('#infoModalTitle').parent().removeClass().addClass('modalTitle bg-green-600');
                                    $('#infoModalText').text('Quote saved successfully');
            $('#infoModalButtons').html(
                '<div id="okButton"></div>'
            );
            $('#okButton').load('../components/buttons/okButton.php');
            modalShow('infoModal');
        }
    });

    $('ul').on('click', '.nav-item', function () {
        console.log('nav item clicked');
        $('.nav-item').siblings().removeClass('active');
        $(this).addClass('active');
        $('#optionContent .tab-pane').removeClass('active');
        $optionID = $(this).data('option');
        $('#tabOption' + $optionID).addClass('active');
    });

    $(document).ready(function () {
    <?php if ($idQuote != 0) { ?>
        $('#proposalType').val(<?= json_encode($quote->type) ?>);
    <?php } ?>
    modalHide('spinner');
});
</script>