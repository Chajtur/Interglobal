var $html = '';

$('#btnAddCoverage').click(function () {
	var row =
		'<tr class="coverageRow">' +
		"<td class='text-center'>" +
		"<i class='fa fa-trash text-warning removeCoverage'></i>" +
		'</td>' +
		"<td class='text-center'>" +
		$('#coverageSelect option:selected').text() +
		'</td>' +
		"<td class='text-end'>" +
		Number($('#coverageAmount').val()).toLocaleString() +
		'</td>';
	$('#tableCoverage thead .option').each(function () {
		var optionId = $(this).data('id');
		row +=
			"<td class='gap' data-id=" +
			optionId +
			'></td>' +
			'<td data-id=' +
			optionId +
			'><input data-id=' +
			optionId +
			" type='text' class='form-control form-control-sm carrierName' value='Carrier Name' /></td>" +
			'<td data-id=' +
			optionId +
			'><input data-id=' +
			optionId +
			" type='number' class='form-control form-control-sm text-end basePremium' value='0' /></td>" +
			'<td data-id=' +
			optionId +
			'><input data-id=' +
			optionId +
			" type='number' class='form-control form-control-sm text-end taxesFees' value='0' /></td>" +
			'<td data-id=' +
			optionId +
			'><input data-id=' +
			optionId +
			" type='text' class='form-control form-control-sm text-end totalPremiumCoverage' value='0' disabled /></td>" +
			'<td data-id=' +
			optionId +
			'><textarea data-id=' +
			optionId +
			" class='form-control form-control-sm' rows='1'></textarea></td>";
	});
	row += '</tr>';
	$('#tableCoverage tbody').append(row);
});

$('#tableCoverage').on('click', '.removeCoverage', function () {
	$(this).closest('tr').remove();
});

$('#btnAddOption').click(function () {
	var optionCount = $('#tableCoverage thead .option').length;
	var row =
		"<th class='gap' data-id=" +
		(optionCount + 1) +
		'></th>' +
		"<th colspan='5' class='bg-success text-white font-bold option' data-id=" +
		(optionCount + 1) +
		'>' +
		"<i class='fa fa-trash text-warning removeOption'></i><span class='ms-5'>Option " +
		(optionCount + 1) +
		'</span>' +
		'</th>';
	$('#tableCoverage thead tr:first').append(row);
	var row =
		"<td class='gap' data-id=" +
		(optionCount + 1) +
		'></td>' +
		"<th class='bg-success-light' data-id=" +
		(optionCount + 1) +
		'>Carrier</th>' +
		"<th class='bg-success-light text-end' data-id=" +
		(optionCount + 1) +
		'>Base Premium</th>' +
		"<th class='bg-success-light text-end' data-id=" +
		(optionCount + 1) +
		'>Taxes & Fees</th>' +
		"<th class='bg-success-light text-end' data-id=" +
		(optionCount + 1) +
		'>Total Premium</th>' +
		"<th class='bg-success-light' data-id=" +
		(optionCount + 1) +
		'>Notes</th>';
	$('#tableCoverage thead tr:nth-child(2)').append(row);
	$('#tableCoverage tbody tr').each(function () {
		$(this).append(
			"<td class='gap' data-id=" +
				(optionCount + 1) +
				'></td>' +
				'<td data-id=' +
				(optionCount + 1) +
				"><input data-id=" +
				(optionCount + 1) + 
                " type='text' class='form-control form-control-sm carrierName' value='Carrier Name' / ></td>" +
				'<td data-id=' +
				(optionCount + 1) +
				"><input data-id=" +
				(optionCount + 1) + " type='number' class='form-control form-control-sm text-end basePremium' value='0' /></td>" +
				'<td data-id=' +
				(optionCount + 1) +
				"><input data-id=" +
				(optionCount + 1) + " type='number' class='form-control form-control-sm text-end taxesFees' value='0' /></td>" +
				'<td data-id=' +
				(optionCount + 1) +
				"><input data-id=" +
				(optionCount + 1) + " type='text' class='form-control form-control-sm text-end totalPremiumCoverage' value='0' disabled /></td>" +
				'<td data-id=' +
				(optionCount + 1) +
				"><textarea data-id=" +
				(optionCount + 1) + " class='form-control form-control-sm' rows='1'></textarea></td>"
		);
	});
	var row =
		"<td class='gap' data-id=" +
		(optionCount + 1) +
		'></td>' +
		"<td colspan='5' data-id=" +
		(optionCount + 1) +
		" class='bg-success-light text-center font-bold h4 totalPremium' data-id=" +
		(optionCount + 1) +
		'>$0.00</td>';
	$('#tableCoverage tfoot tr:first').append(row);
	var row =
		"<td class='gap' data-id=" +
		(optionCount + 1) +
		'></td>' +
		"<td colspan='5' data-id=" +
		(optionCount + 1) +
		" class='bg-success text-center font-bold h4' data-id=" +
		(optionCount + 1) +
		"><span class='text-white'>$</span><input data-id=" +
		(optionCount + 1) + " class='rounded downPayment' type='number' value='0'></td>";
	$('#tableCoverage tfoot tr:nth-child(2)').append(row);
	var row =
		"<td class='gap' data-id=" +
		(optionCount + 1) +
		'></td>' +
		'<td data-id=' +
		(optionCount + 1) +
		" class='bg-success text-white font-bold h4 text-center' colspan='5'><input data-id=" +
		(optionCount + 1) +
		" class='rounded installments' type='number' value='10' id='installments'/><span> Installments of $</span><input data-id=" +
		(optionCount + 1) +
		" class='rounded installment' type='number' value='0' id='installmentAmount'/></td>";
	$('#tableCoverage tfoot tr:nth-child(3)').append(row);
});

$(document).on('input', '.basePremium', function () {
	var $tr = $(this).closest('tr');
    var id = $(this).data('id');
	var basePremium = parseFloat($(this).val());
	var taxesFees = parseFloat($tr.find('.taxesFees[data-id="' + id + '"]').val());
	var totalPremium = basePremium + taxesFees;
    $tr.find('.totalPremiumCoverage[data-id="' + id + '"]').data('value', totalPremium);
	$tr.find('.totalPremiumCoverage[data-id="' + id + '"]').val(totalPremium.toLocaleString());
	updateTotalPremium(id);
});

$(document).on('input', '.taxesFees', function () {
    var id = $(this).data('id');
	var $tr = $(this).closest('tr');
	var taxesFees = parseFloat($(this).val());
	var basePremium = parseFloat($tr.find('.basePremium[data-id="' + id + '"]').val());
	var totalPremium = basePremium + taxesFees;
	$tr.find('.totalPremiumCoverage[data-id="' + id + '"]').data('value', totalPremium);
	$tr.find('.totalPremiumCoverage[data-id="' + id + '"]').val(totalPremium.toLocaleString());
	updateTotalPremium($(this).data('id'));
});

function updateTotalPremium(id) {
	var totalPremiumCoverage = 0;
	$(`.totalPremiumCoverage[data-id=${id}]`).each(function () {
		totalPremiumCoverage += parseFloat($(this).data('value'));
	});
	totalPremiumCoverage = totalPremiumCoverage.toLocaleString('en-US', {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});
	$(`.totalPremium[data-id=${id}]`).text('$' + totalPremiumCoverage);
}

$('#tableCoverage').on('click', '.removeOption', function () {
	var id = $(this).closest('th').data('id');
	$('#tableCoverage [data-id="' + id + '"]').remove();
});

function printOption($id) {
    if ($id > 1) {
        $html += '<footer class="footer">' +
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
        $html += '<div class="page-break">' +
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
        '    <h3>Option ' + $id + '</h3></div>';
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
			'Insurance Company: ' + carrierName +
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

$('#btnPreviewProposal').click(function () {
	$html =
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
	});
});
