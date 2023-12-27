$('#nombreModulo').text('Indicadores');
$('#nombreModuloM').text('Indicadores');

$(document).ready(function () {
	$.post('../controllers/CallCenter.php', {
		action: 'getStatistics'
	}).done(function (resp) {
		resp = JSON.parse(resp);
		loadGraphs(200, 4000, resp.dailyCalls.count, resp.monthlyCalls.count, 0)
	})
});

function loadGraphs($dailyGoal, $monthlyGoal, $day, $month, $year) {
	chartStatus = Chart.getChart('callsDaily'); // <canvas> id
	if (chartStatus != undefined) {
		chartStatus.destroy();
	}
	var data = {
		value: $day,
		max: $dailyGoal,
		label: 'Meta Diaria',
	};
	var finosGruesos = new Chart($('#callsDaily'), {
		type: 'doughnut',
		data: {
			labels: [data.label],
			datasets: [
				{
					backgroundColor: ['rgb(255, 99, 132)', '#ccc'],
					data: [data.value, data.max - data.value],
					borderWidth: 0,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			cutoutPercentage: 85,
			rotation: -90,
			circumference: 180,
			tooltips: {
				enabled: false,
			},
			legend: {
				display: false,
			},
			animation: {
				animateRotate: true,
				animateScale: false,
			},
			title: {
				display: true,
				text: data.label,
				fontSize: 16,
			},
		},
	});

	chartStatus = Chart.getChart('callsMonthly'); // <canvas> id
	if (chartStatus != undefined) {
		chartStatus.destroy();
	}
	var data = {
		value: $month,
		max: $monthlyGoal,
		label: 'Meta Mensual',
	};
	var config = {
		type: 'doughnut',
		data: {
			labels: [data.label],
			datasets: [
				{
					data: [data.value, data.max - data.value],
					backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(0, 0, 0, 0.1)'],
					borderWidth: 0,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			cutoutPercentage: 85,
			rotation: -90,
			circumference: 180,
			tooltips: {
				enabled: false,
			},
			legend: {
				display: false,
			},
			animation: {
				animateRotate: true,
				animateScale: false,
			},
			title: {
				display: true,
				text: data.label,
				fontSize: 16,
			},
		},
	};

	var chartCtx = document.getElementById('callsMonthly').getContext('2d');
	var callsMonthly = new Chart(chartCtx, config);

	chartStatus = Chart.getChart('callsYearly'); // <canvas> id
	if (chartStatus != undefined) {
		chartStatus.destroy();
	}
	var data = {
		value: $day,
		max: $dailyGoal,
		label: 'Llamadas Mensual',
	};
	var llamadasAnual = new Chart($('#callsYearly'), {
		type: 'bar',
		data: {
			labels: [data.label],
			datasets: [
				{
					backgroundColor: ['rgb(255, 99, 132)', '#ccc'],
					data: [data.value, data.max - data.value],
					borderWidth: 0,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			cutoutPercentage: 85,
			rotation: -90,
			circumference: 180,
			tooltips: {
				enabled: false,
			},
			legend: {
				display: false,
			},
			animation: {
				animateRotate: true,
				animateScale: false,
			},
			title: {
				display: true,
				text: data.label,
				fontSize: 16,
			},
		},
	});
}
