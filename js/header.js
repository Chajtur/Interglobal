$(document).ready(function () {
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
			//$('.modal').modal('hide');
			modalShow('sesionExpirada');
			//$('#sesionExpirada').modal('show');
			location.reload();
		}
	});
}

$(document).on('hidden.bs.modal', '#sesionExpirada', function () {
	location.reload();
});