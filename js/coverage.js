$('#btnAddCoverage').click(function () {
	$('#infoModalTitle').text('Add Coverage');
	$('#infoModalText').html('<div id="quoteCoverageDiv"></div>');
	$('#quoteCoverageDiv').load('../components/quoteCoverage.php', {
		idOption: $('#optionsTabs > li > a.active').closest('li').data('option'),
	});
	$('#infoModalButtons').html(
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveCoverage">Save</button>'
	);
	$('#infoModal').modal('show');
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
	$('#infoModalText').html('<div id="billPlanDiv"></div>');
	$('#billPlanDiv').load('../components/billPlanCoverage.php', {
		idOption: $('#optionsTabs > li > a.active').closest('li').data('option'),
	});
	$('#infoModalButtons').html(
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveBillPlan">Save</button>'
	);
	$('#infoModal').modal('show');
});

$('#btnAddOption').click(function () {
	var optionCount = $('#optionsTabs > li').length;
	optionCount++;
	$('#optionsTabs > li > a').removeClass('active');
	$('#optionsTabs').append(
		'<li data-option=' +
			optionCount +
			" class='nav-item' role='presentation'><a class='nav-link active' id='optionTab" +
			optionCount +
			"' data-bs-toggle='tab' href='#tabOption" +
			optionCount +
			"' role='tab' aria-controls='coverage" +
			"' aria-selected='true'>Option " +
			optionCount +
			'<i class="ms-3 fa-solid fa-trash-can text-white removeOption"/i></a></li>'
	);
	$('#optionContent .tab-pane').removeClass('active');
	$('#optionContent').append(
		'<div data-option=' +
			optionCount +
			' id="tabOption' +
			optionCount +
			'" class="tab-pane active show" role="tabpanel" aria-labelledby="table-tab">' +
			'<caption class="text-sm">All Coverages with <span class="bg-warning-light p-1">BACKGROUND</span> are missing a Bill Plan</caption>' +
			'<table class="table tableOptions mt-2" data-option=' +
			optionCount +
			'>' +
			'	<thead class="text-center">' +
			'		<tr>' +
			'			<th class="bg-primary-light"></th>' +
			'			<th class="bg-primary-light text-start">Line of Business</th>' +
			'			<th class="bg-primary-light text-end">Amount</th>' +
			'			<th data-id="1" class="bg-success-light text-start">Carrier</th>' +
			'			<th data-id="1" class="bg-success-light text-end">Base Premium</th>' +
			'			<th data-id="1" class="bg-success-light text-end">Taxes & Fees</th>' +
			'			<th data-id="1" class="bg-success-light text-end">Total Premium</th>' +
			'			<th data-id="1" class="bg-success-light">Notes</th>' +
			'		</tr>' +
			'	</thead>' +
			'	<tbody>' +
			'	</tbody>' +
			'	<tfoot class="d-none">' +
			'		<tr class="bg-primary text-white text-center">' +
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
			'<tr class="coverageRow bg-warning-light" data-coverage="' +
				coverageId +
				'">' +
				'<td class="text-center">' +
				'<button title="Click to remove Coverage" class="btn btn-danger btn-sm btnRemoveCoverage me-1">' +
				'<i class="fas fa-trash-alt" aria-hidden="true"></i>' +
				'</button>' +
				'<button title="Click to add Bill Plan" class="btn btn-success btn-sm btnAddBillPlan">' +
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
				'><button class="btn btn-info btn-sm btnEditCoverage me-3"><i class="fas fa-pencil"></i></button>Carrier</td>' +
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
	var basePremium = $(this).closest('tr').find('td:eq(4)').text();
	var taxesFees = $(this).closest('tr').find('td:eq(5)').text();
	var notes = $(this).closest('tr').find('td:eq(7)').text();
	basePremium = basePremium.replace('$', '');
	taxesFees = taxesFees.replace('$', '');
	basePremium = basePremium.replace(',', '');
	taxesFees = taxesFees.replace(',', '');
	$('#infoModalTitle').text('Edit Coverage');
	$('#infoModalText').html('<div id="quoteCoverageDiv"></div>');
	$('#quoteCoverageDiv').load('../components/editCoverage.php', {
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
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnUpdateCoverage">Update</button>'
	);
	$('#infoModal').modal('show');
});

$('#btnPreviewProposal').click(function () {
	$('#infoModalTitle').text('Preview Proposal');
	$('#infoModalText').html('<div id="previewProposalDiv"></div>');
	$('#previewProposalDiv').load('../components/previewProposal.php');
	$('#infoModalButtons').html(
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnPrintProposal">Print</button>'
	);
	$('#infoModal').addClass('fullscreen-modal');
	$('#infoModal').modal('show');
	/*$html =
		'<head>' +
		'  <title>' +
		'    INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE' +
		'  </title>' +
		'  <meta name="viewport" content="width=device-width, initial-scale=1">' +
		'  <meta charset="utf-8">' +
		'  <link rel="icon" href="https://interglobalinsurance.com/wp-content/uploads/2021/12/LOGO-INTERGLOBAL-01-1329x800.png">' +
		'</head>' +
		'' +
		'<body class="p-10 text-primary d-flex row justify-content-between">' +
		'  <div>' +
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
		'    <div class="row text-center">' +
		'      <div class="h2 text-primary pt-8">Commercial Quote Proposal</div>' +
		'      <div class="h3">Client: ' +
		$('#clientDiv').data('name') +
		'</div>' +
		'    </div>' +
		'    <div class="mt-5">' +
		'      <p>' +
		'        Interglobal Insurance Company is pleased to offer you the following Insurance Quote:' +
		'      </p>' +
		'    </div>' +
		'  </div>';
	async function processOptions() {
		await Promise.all(
			$('#tableCoverage thead .option')
				.map(async function () {
					await printOption($(this).data('id'));
				})
				.get()
		);
	}
	processOptions().then(() => {
		$html +=
			'  <footer class="footer">' +
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
			'  </footer>' +
			'</body>';
		$.ajax({
			url: '../components/html2pdf.php',
			method: 'POST',
			data: {
				html: $html,
				filename: 'test.pdf',
				dot: $(this).data('dot'),
			},
			xhrFields: {
				responseType: 'blob',
			},
			success: function (response) {
				var file = new Blob([response], { type: 'application/pdf' });
				var fileURL = URL.createObjectURL(file);

				// Create a new window or iframe and load the PDF into it for preview
				var previewWindow = window.open('', '_blank');
				var iframe = previewWindow.document.createElement('iframe');
				iframe.src = fileURL;
				iframe.style.width = '100%';
				iframe.style.height = '100%';
				previewWindow.document.body.appendChild(iframe);
			},
		});
	});*/
});

$('#optionContent').on('click', '.btnRemoveBillPlan', function () {
	console.log('btnRemoveBillPlan');
	let idOption = $(this).closest('table').data('option');
	let billPlan = $(this).closest('tr').data('billplan');
	$('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').removeClass(
		'bg-success-light text-white'
	);
	$('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').addClass(
		'bg-warning-light'
	);
	$('.tableOptions[data-option=' + idOption + '] tbody tr[data-billplan=' + billPlan + ']').attr('data-billplan', '');
	$(this).closest('tr').remove();
	if ($('.tableOptions[data-option=' + idOption + '] tfoot tr.billPlanRow').length === 0) {
		$('.tableOptions[data-option=' + idOption + '] tfoot').addClass('d-none');
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
	$('#infoModalTitle').text('Edit Bill Plan');
	$('#infoModalText').html('<div id="billPlanDiv"></div>');
	$('#billPlanDiv').load('../components/editBillPlan.php', {
		idBillPlan: idBillPlan,
		idOption: idOption,
		billPlan: billPlan,
		duration: billPlanDuration,
		installments: billPlanInstallments,
		downPayment: billPlanDownPayment,
		amount: billPlanAmount,
	});
	$('#infoModalButtons').html(
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnUpdateBillPlan">Update</button>'
	);
	$('#infoModal').modal('show');
});

$('#optionContent').on('click', '.btnAddBillPlan', function () {
	var idOption = $(this).closest('table').data('option');
	var idCoverage = $(this).closest('tr').data('coverage');
	$('#infoModalTitle').text('Add Coverage to Bill Plan');
	$('#infoModalText').html('<div id="billPlanDiv"></div>');
	$('#billPlanDiv').load('../components/addBillPlanCoverage.php', {
		idOption: idOption,
		idCoverage: idCoverage,
	});
	$('#infoModalButtons').html(
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveBillPlan">Save</button>'
	);
	$('#infoModal').modal('show');
});