<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';

startSession();
checkActivity();

include $_SERVER['DOCUMENT_ROOT'] . '/models/Dates.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$user = new User($_SESSION['user']['id']);

$date = new Holiday($_POST['fecha']);

$data = $date->getHolidays();
?>

<h4 id="listaVacaciones" class="w-full bg-sky-950 text-white rounded border border-sky-950 p-1 ps-2 shadow">Holiday</h4>
<div class="mt-2">
    <?php
    if (($data) && ($data['holidayActive']))
    { ?>
        <div class="flex flex-row w-full justify-between">
            <div class="flex flex-col">
                <h4 class="font-bold text-green-800"><?= $data['holidayName'] ?></h4>
                <p><?= $data['holidayDetail'] ?></p>
            </div>
            <?php if ($user->hasPermission('aprobarFeriado'))
            { ?>
                <div class="justify-content-end flex pe-0">
                    <button type="button" class="btn-danger eliminarFeriado  me-1"
                        data-searchDate="<?= $_POST['fecha'] ?>">Remove Holiday</button>
                </div>
            <?php } ?>
        </div>
    <?php } else
    { ?>
        <div class="flex flex-row w-full justify-between">
            <div>No holidays on this date</div>
            <?php if ($user->hasPermission('aprobarFeriado'))
            { ?>
                <button type="button" class="btn-success asignarFeriado" data-searchDate="<?= $_POST['fecha'] ?>">Set
                    Holiday</button>
            </div>
        <?php }
    } ?>
</div>

<script>
    function crearFeriado($fecha) {
        $('#infoModalTitle').text($fechaDisplay);
        $modalContent =
            '<div class="flex flex-col">' +
            '<h4 mt-0>Holiday Creation</h4>' +
            '<label for="nombreFeriado" class="mt-2">Holiday Name</label>' +
            '<input class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" id="nombreFeriado" type="text" placeholder="Name">' +
            '<label for="descripcionFeriado" class="mt-2">Holiday Description</label>' +
            '<textArea class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" id="descripcionFeriado" type="text" maxlength="256" rows="8" placeholder="Nombre"></textArea>' +
            '<span class="float-end my-n5 px-1 bg-info rounded small text-white" id="count_message"></span>' +
            '<span>Shall be given:</span>' +
            '<div id="checkBoxGroup" class="ml-3">' +
            '<div class="form-check">' +
            '<input class="form-check-input" type="radio" name="flexRadioDefault" id="diaCompleto" checked>' +
            '<label class="form-check-label ms-1" for="flexRadioDefault1">Full Day</label>' +
            '</div>' +
            '<div class="form-check">' +
            '<input class="form-check-input" type="radio" name="flexRadioDefault" id="medioDia">' +
            '<label class="form-check-label ms-1" for="flexRadioDefault2">Half a Day</label>' +
            '</div>' +
            '</div>';
        $('#infoModalText').html($modalContent);
        $modalButtons =
            '<button type="button" class="btn-success" id="btnGuardarFeriado" data-date="' +
            $fecha +
            '">Save</button>' +
            '<button type="button" class="btn-danger modalClose mx-2" data-bs-dismiss="modal">Cancel</button>';
        $('#infoModalButtons').html($modalButtons);
        var text_max = 256;
        $('#count_message').html('0/' + text_max);
        $('#descripcionFeriado').on('keyup', function () {
            var text_length = $('#descripcionFeriado').val().length;
            $('#count_message').html(text_length + '/' + text_max);
        });

        $('body').on('click', '.asignarFeriado', function () {
            crearFeriado($(this).data('searchdate'));
        });

        $('body').on('click', '.eliminarFeriado', function () {
            modalShow('spinner');
            $.post('../controllers/Calendar.php', {
                action: 'removeHoliday',
                fecha: $(this).data('searchdate'),
            }).done(function (resp) {
                modalHide('spinner');
                if (resp) {
                    $('#infoModalTitle').html('<i class="fa-solida fa-check"></i> Holiday Deleted!!');
                    $('#infoModalTitle').parent().removeClass().add('bg-green-500 modalTitle');
                    $('#infoModalText').html('The holiday has been deleted successfully!');
                    $('#infoModalButtons').html(
                        '<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
                    );
                } else {
                    $('#infoModalTitle').html('Error!!');
                    $('#infoModalText').html('There was an error deleting the holiday, please try again later');
                    $('#infoModalButtons').html('<button type="button" class="btn-info modalClose">Ok</button>');
                }
            });
        });
    }

    $('body').on('click', '#btnGuardarFeriado', function () {
        modalShow('spinner');
        $.post('../controllers/Calendar.php', {
            action: 'saveHoliday',
            fecha: $(this).data('date'),
            nombre: $('#nombreFeriado').val(),
            detalle: $('#descripcionFeriado').val(),
            diaCompleto: $('#diaCompleto').is(':checked') ? 'true' : 'false',
        }).done(function (resp) {
            modalHide('spinner');
            resp = JSON.parse(resp);
            console.log(resp);
            if (resp.status == 'error') {
                console.log('There was an error saving the holiday');
                $('#infoModalTitle').html('Error!!');
                $('#infoModalTitle').parent().removeClass();
                $('#infoModalTitle').parent().addClass('bg-red-500 modalTitle');
                $('#infoModalText').html(
                    'There was an error saving the holiday, please try again later or contact the system administrator'
                );
                $('#infoModalButtons').html(
                    '<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
                );
            } else {
                console.log('Se guardó feriado con éxito');
                $('#infoModalTitle').html('Holiday Created!!');
                $('#infoModalText').html('The holiday has been created successfully!');
                $('#infoModalButtons').html(
                    '<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
                );
            }
        });
    });



</script>