$('#spinner').modal('show');

$('#btnNewTransaction').on('click', function () {
	$('#infoModalTitle').text('New Transaction');
	$modalContent = "<div id='newTransaction'></div>";
	$('#infoModalText').html($modalContent);
	$('#newTransaction').load('../components/newTransaction.php');
	$modalContent =
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveTransaction">Save</button>';
	$('#infoModalButtons').html($modalContent);
	$('#infoModal').modal('show');
});

$(document).ready(function () {
	$('body').on('click', '#btnSaveTransaction', function () {
		$.post('../controllers/Transaction.php', {
			action: 'saveTransaction',
			agent: $('#newTransactionAgent').val(),
			insured: $('#insured').val(),
			carrier: $('#carrier').val(),
			policyNumber: $('#policyNumber').val(),
			type: $('#transactionType').val(),
			premium: $('#premium').val(),
			date: $('#newTransactionDate').val(),
		}).done(function (resp) {
			if (resp > 0) {
				// success
				$('#infoModal').modal('hide');
				$('#infoModalTitle').text('Success');
				$('#infoModalText').html('Transaction saved successfully');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
				loadPolicySummary();
				loadPolicyTable();
			} else {
				$('#infoModal').modal('hide');
				$('#infoModalTitle').text('Error');
				$('#infoModalText').html('There was an error saving the transaction');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
			}
		});
	});

	$('body').on('click', '#btnSavePolicy', function () {
		$.post('../controllers/Transaction.php', {
			action: 'editTransaction',
			agent: $("#newTransactionForm").data('agent'),
			insured: $('#insured').val(),
			carrier: $('#carrier').val(),
			policyNumber: $('#policyNumber').val(),
			premium: $('#premium').val(),
			date: $('#newTransactionDate').val(),
			id: $("#newTransactionForm").data('id'),
			type: $('#transactionType').val(),
		}).done(function (resp) {
			console.log(resp);
			if (resp == 1) {
				// success
				$('#infoModal').modal('hide');
				$('#infoModalTitle').text('Success');
				$('#infoModalText').html('Transaction updated successfully');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
				loadPolicySummary();
				loadPolicyTable();
			} else {
				$('#infoModal').modal('hide');
				$('#infoModalTitle').text('Error');
				$('#infoModalText').html('There was an error updating the Transaction');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
			}
		});
	});
});

function loadPolicySummary() {
	$('#policySummary').load('../components/policySummary.php', {
		agente: $('#agenteSelect').val(),
	});
}

function loadPolicyTable() {
	$('#spinner').modal('show');
	$('#policyTable').load(
		'../components/policyTable.php',
		{
			mes: $('#mesSelect').val(),
			agente: $('#agenteSelect').val(),
			tipo: $('#typeSelect').val(),
			keyword: $('#searchText').val(),
			page: 1,
		},
		function () {
			$('#spinner').modal('hide');
		}
	);
}

loadPolicySummary();
loadPolicyTable();

$('#refreshPolicyTable').on('click', function () {
	loadPolicySummary();
	loadPolicyTable();
});
