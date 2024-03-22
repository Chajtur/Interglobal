$(document)
	.off()
	.on('click', '.pageNumber', function () {
		$('#spinner').modal('show');
		$('#policyTable').load(
			'../components/policyTable.php',
			{
				page: $(this).html(),
                year: $('#yearSelect').val(),
				mes: $('#mesSelect').val(),
				agente: $('#agenteSelect').val(),
				tipo: $('#typeSelect').val(),
				keyword: $('#searchText').val(),
			},
			function () {
				modalHide('spinner');
			}
		);
	});

$(document).on('click', '.firstPage', function () {
    $('#spinner').modal('show');
    $('#policyTable').load(
        '../components/policyTable.php',
        {
            page: 1,
            year: $('#yearSelect').val(),
            mes: $('#mesSelect').val(),
            agente: $('#agenteSelect').val(),
            tipo: $('#typeSelect').val(),
            keyword: $('#searchText').val(),
        },
        function () {
            modalHide('spinner');
        }
    );
});

$(document).on('click', '.lastPage', function () {
    $('#spinner').modal('show');
    $('#policyTable').load(
        '../components/policyTable.php',
        {
            year: $('#yearSelect').val(),
            page: $(this).data('page'),
            mes: $('#mesSelect').val(),
            agente: $('#agenteSelect').val(),
            tipo: $('#typeSelect').val(),
            keyword: $('#searchText').val(),
        },
        function () {
            modalHide('spinner');
        }
    );
});

$(document).on('click', 'tbody tr', function () {
    $(this).addClass('bg-info-light selected').siblings().removeClass('bg-info-light selected');
});

$(document).on('click', 'td .fa-pencil', function () {
    $id = $(this).closest('tr').data('id');
    $('#infoModalTitle').text('Edit Policy');
    $modalContent = "<div id='editPolicy'></div>";
    $('#infoModalText').html($modalContent);
    $('#editPolicy').load('../components/newTransaction.php', {
        id: $(this).closest('tr').data('id'),
    });
    $modalContent =
        '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button data-id=' + $id + ' type="button" class="btn btn-success" id="btnSavePolicy">Save</button>';
    $('#infoModalButtons').html($modalContent);
    $('#infoModal').modal('show');
});

$(document).on('click', 'td .fa-trash-can', function () {
    $id = $(this).closest('tr').data('id');
    $('#infoModalTitle').text('Delete Policy');
    $('#infoModalText').html('Are you sure you want to delete this policy?');
    $modalContent =
        '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button><button data-id=' + $id + ' type="button" class="btn btn-success" id="btnDeletePolicy">Yes</button>';
    $('#infoModalButtons').html($modalContent);
    $('#infoModal').modal('show');
});

$(document).on('click', '#btnDeletePolicy', function () {
    $.post('../controllers/Transaction.php', {
        action: 'deleteTransaction',
        id: $(this).data('id'),
    }).done(function (resp) {
        resp = JSON.parse(resp);
        if (resp.status == 'true') {
            // success
            $('#infoModal').modal('hide');
            $('#infoModalTitle').text('Success');
            $('#infoModalText').html(resp.message);
            $('#infoModalButtons').html(
                '<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
            );
            $('#infoModal').modal('show');
            loadPolicySummary();
            loadPolicyTable();
        } else {
            $('#infoModal').modal('hide');
            $('#infoModalTitle').text('Error');
            $('#infoModalText').html(resp.message);
            $('#infoModalButtons').html(
                '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
            );
            $('#infoModal').modal('show');
        }
    });
});

$(document).on('click', '#btnExport', function () {
    $('#spinner').modal('show');
    $.post('../controllers/Transaction.php', {
        action: 'exportTransactions',
        mes: $('#mesSelect').val(),
        agente: $('#agenteSelect').val(),
        tipo: $('#typeSelect').val(),
        keyword: $('#searchText').val(),
    }).done(function (resp) {
        resp = JSON.parse(resp);
        if (resp.status == 'true') {
            // success
            var data = $.map(resp.data, function(value, index) {
                return [Object.values(value)];
            });
            var ws = XLSX.utils.aoa_to_sheet(data);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");
        
            var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
            function s2ab(s) { 
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;    
            }
            saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Transactions.xlsx');
            modalHide('spinner');
        } else {
            modalHide('spinner');
            $('#infoModalTitle').text('Error');
            $('#infoModalText').html(resp.message);
            $('#infoModalButtons').html(
                '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
            );
            $('#infoModal').modal('show');
        }
    });
});