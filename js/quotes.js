$('#tableQuotes').on('click', 'tr', function () {
	$id = $(this).data('id');
	$('#tableQuotes tr').removeClass('bg-info text-white');
	$(this).addClass('bg-info text-white');
	$('#quoteDetail').load('../components/clientDetail.php', {
		dot: $id,
	});
});

$('body').on('click', '#btnGenerateProposal', function () {
	$id = $(this).data('id');
	$('#contenido').load('../views/proposalForm.php', {
		client: $(this).data('client'),
		dot: $(this).data('dot')
	});
});

$('body').on('click', '#btnManualProposal', function () {
	$client = $('#manualName').val();
	$dot = $('#manualDot').val();
	$('#contenido').load('../views/proposalForm.php', {
		client: $client,
		dot: $dot,
	});
});

$('body').on('click', '#btnSearchDot', function () {
	$dot = $('#dotSearch').val();
	$('#quoteDetail').load('../components/clientDetail.php', {
		dot: $dot,
	});
});