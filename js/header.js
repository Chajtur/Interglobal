$(document).ready(function () {
	$('.navbar-menuToggler').click(function () {
		$('sidebar').removeClass('d-none');
		$('sidebar').addClass('position-absolute');
		$('sidebar').addClass('bg-white');
		$('.overlay').addClass('active');
	});

	$('#contenido').click(function () {
		$('sidebar').addClass('d-none');
		$('.overlay').removeClass('active');
	});

	$(document).click(function (event) {
		if (!$(event.target).closest('sidebar').length && !$(event.target).closest('.navbar-menuToggler').length) {
			$('sidebar').addClass('d-none');
			$('.overlay').removeClass('active');
		}
	});

	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
	const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
	clearInterval(checkUser);
	checkUser = setInterval(checkUser, 30000);
});

function checkUser() {
	console.log('Checking if user is logged in...');
	$.post('../controllers/Login.php', {
		action: 'isLoggedIn',
	}).done(function (resp) {
		console.log(resp);
		if (resp == 0) {
			$('.modal').modal('hide');
			$('#sesionExpirada').modal('show');
			location.reload();
		}
	});
}

$(document).on('hidden.bs.modal', '#sesionExpirada', function () {
	location.reload();
});
