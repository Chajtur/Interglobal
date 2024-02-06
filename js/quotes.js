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
	/*$.post('https://mobile.fmcsa.dot.gov/qc/services/carriers/3887916?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79', function (data) {
		console.log(data);
	});*/
	$('#quoteDetail').load('../components/clientDetail.php', {
		dot: $dot,
	});
});