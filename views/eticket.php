<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!-- <main class="container-fluid h-100">
    <div class="row h-100 pb-3 ms-0">
        <div class="col">
            <div id="openTicket"></div>
            <div id="FAQ"></div>
        </div>
        <div class="col-lg-3 col-sm-12 border border-warning border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-warning text-opacity-75" id="">Open Tickets</h3>
            <hr class="bg-warning">
            <div id="openTickets"></div>
        </div>
        <div class="col-lg-3 col-sm-12 border border-success border-2 rounded me-2 pt-3 mb-2">
            <h3 class="text-success text-opacity-75" id="">Closed Tickets</h3>
            <hr class="bg-success">
            <div id="closedTickets"></div>
        </div>
    </div>
</main> -->
<div class="w-2/5 h-100 bg-gray-300 ms-0">
    All tickets loading right now
</div>

<script>
    $(document).ready(function() {
        $('#openTicket').load('../components/openTicket.php');
        $('#FAQ').load('../components/faq.php');
        $('#openTickets').load('../components/openTickets.php');
        $('#closedTickets').load('../components/closedTickets.php');
        var text_max = 512;
        $('#count_message').html('0/' + text_max);
        $('#detalleEticket').on('keyup', function() {
            var text_length = $('#detalleEticket').val().length;
            var text_remaining = text_max - text_length;
            $('#count_message').html(text_length + '/' + text_max);
        });
    });

    $(document).on('click', '#btnSaveTicket', function() {
        $('#spinner').modal('show');
        $.post(
            '../controllers/Eticket.php', {
                action: 'saveEticket',
                type: $('#tipoEticket').val(),
                issue: $('#asuntoEticket').val(),
                detail: $('#detalleEticket').val(),
            },
            function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == 'true') {
                    // success
                    modalHide('spinner');
                    $('#infoModalTitle').text('Success');
                    $('#infoModalText').html(resp.message);
                    $('#infoModalButtons').html(
                        '<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
                    );
                    $('#infoModal').modal('show');
                    $('#openTicket').load('../components/openTicket.php');
                    $('#openTickets').load('../components/openTickets.php');
                    $('#closedTickets').load('../components/closedTickets.php');
                } else {
                    modalHide('spinner');
                    $('#infoModalTitle').text('Error');
                    $('#infoModalText').html(resp.message);
                    $('#infoModalButtons').html(
                        '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
                    );
                    $('#infoModal').modal('show');
                }

            }
        );
        $modalContent =
            '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveEticket">Save</button>';
        $('#infoModalButtons').html($modalContent);
    });
</script>