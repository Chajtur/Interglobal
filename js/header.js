$(document).ready(function () {
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
	const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
});

$(document).on('hidden.bs.modal', '#sesionExpirada', function () {
	location.reload();
});