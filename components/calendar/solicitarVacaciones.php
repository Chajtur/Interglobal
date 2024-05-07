<?php
include $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fecha = $_POST['fecha'] ?: date('Y-m-d');

$fecha = date('Y-m-d', strtotime($fecha));

$date = new Vacation();
$nextBusinessDay = $date->getNextBusinessDay($fecha);

?>
<div class="flex flex-col">
    <h4>Start and end dates of Vacation Request</h4>
    <div class="flex flex-col">
        <label class="text-sky-950" for="primerDiaVacaciones">From</label>
        <input class="rounded border-sky-950 p-2 border" id="primerDiaVacaciones" type="date" min=<?= $nextBusinessDay ?>
            value=<?= $nextBusinessDay ?> placeholder="From">
    </div>
    <div class="flex flex-col">
        <label class="text-sky-950" for="ultimoDiaVacaciones">To</label>
        <input class="rounded border-sky-950 p-2 border" id="ultimoDiaVacaciones" type="date" min=<?= $fecha ?>
            placeholder="To">
    </div>
    <div class="flex flex-col">
        <label for="descripcionFeriado">Reason for Request</label>
        <textArea class="rounded h-full p-3 border border-sky-950" id="motivoVacaciones" type="text" maxlength="256"
            rows="5" placeholder="Reason for request"></textArea>
        <span class="float-end px-1 bg-blue-500 rounded text-sm text-white" id="count_message"></span>
    </div>
</div>

<script>
    $('#saveButton').on('click', function () {
        modalShow('spinner');
        $.post('../controllers/Calendar.php', {
            action: 'askDayOff',
            from: $('#primerDiaVacaciones').val(),
            to: $('#ultimoDiaVacaciones').val(),
            reason: $('#motivoVacaciones').val(),
        }).done(function (resp) {
            console.log(resp);
            modalHide('spinner');
            resp = JSON.parse(resp);
            if (resp['status'] == 'success') {
                $('#infoModalTitle').html('Request Sent!!');
                $('#infoModalTitle').parent().removeClass().addClass('bg-green-500 modalTitle');
                $.ajax({
                    url: '../components/calendar/vacationRequest.php',
                    method: 'POST',
                    data: {
                        id: resp['data'],
                    },
                    xhrFields: {
                        responseType: 'blob',
                    },
                    success: function (response) {
                        /*var file = new Blob([response], {
                            type: 'application/pdf'
                        });
                        var fileURL = URL.createObjectURL(file);

                        // Create a new window or iframe and load the PDF into it for preview
                        var previewWindow = window.open('', '_blank');
                        var iframe = previewWindow.document.createElement('iframe');
                        iframe.src = fileURL;
                        iframe.style.width = '100%';
                        iframe.style.height = '100%';
                        previewWindow.document.body.appendChild(iframe);*/
                        
                        modalHide('spinner');
                    }
                });
            } else {
                $('#infoModalTitle').html('Error!!');
                $('#infoModalTitle').parent().removeClass().addClass('bg-red-500 modalTitle');
            }
            $('#infoModalText').html(resp['text']);
            $('#infoModalButtons').html(
                '<div id="okButton"></div>'
            );
            $('#okButton').load('../components/buttons/okButton.php');
        });
    });

</script>