$('#spinner').modal('show');

$('#btnNewTransaction').on('click', function () {
	if ($('#agenteSelect').val() == 'all') {
		$('#infoModalTitle').text('Error');
		$('#infoModalText').html('Please select an agent to add a new transaction');
		$('#infoModalButtons').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>');
		$('#infoModal').modal('show');
	} else {
		$('#infoModalTitle').text('New Transaction');
		$modalContent = "<div id='newTransaction'></div>";
		$('#infoModalText').html($modalContent);
		$('#newTransaction').load(
			'../components/newTransaction.php',
			{
				agent: $('#agenteSelect').val(),
			},
			function () {
				$('#infoModal').modal('show');
			}
		);
		$modalContent =
			'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveTransaction">Save</button>';
		$('#infoModalButtons').html($modalContent);
	}
});

$(document).ready(function () {
	

	
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
	$('#spinner').modal('show');
	$('#policyTable').load(
		'../components/policyTable.php',
		{
			year: $('#yearSelect').val(),
			mes: $('#mesSelect').val(),
			agente: $('#agenteSelect').val(),
			tipo: $('#typeSelect').val(),
			keyword: $('#searchText').val(),
			page: 1,
		},
		function () {
			modalHide('spinner');
		}
	);
}

loadPolicySummary();
loadPolicyTable();

$('#refreshPolicyTable').on('click', function () {
    var checkedButtonId = $('input[name="quarters"]:checked').attr('id');
    loadPolicySummary(checkedButtonId);
    loadPolicyTable();
});

$('body').on('click', '.btn-check', function () {
	loadPolicySummary($(this).attr('id'));
});

$('#editAgentCommissions').on('click', function () {
	$('#infoModalTitle').text('Edit Agent Commissions');
	$modalContent = "<div id='editCommission'></div>";
	$('#infoModalText').html($modalContent);
	$('#editCommission').load('../components/editAgentCommissions.php', function () {
		$('#infoModal').modal('show');
	});
	$modalContent =
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveCommission">Save</button>';
	$('#infoModalButtons').html($modalContent);
});
