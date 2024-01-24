$('#tableQuotes').on('click', 'tr', function () {
	$id = $(this).data('id');
	$('#tableQuotes tr').removeClass('bg-info text-white');
	$(this).addClass('bg-info text-white');
	$('#quoteDetail').load('../components/clientDetail.php', {
		id: $id,
	});
});

$('body').on('click', '#btnGenerateProposal', function () {
	$id = $(this).data('id');
	$('#contenido').load('../views/proposalForm.php', {
		id: $id,
	});
});

$('body').on('click', '#btnSearchDot', function () {
	$dot = $('#dotSearch').val();
	$('#quoteDetail').load('../components/clientDetail.php', {
		dot: $dot,
	});
});