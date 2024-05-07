<?php
$date = isset($_POST['date']) ? $_POST['date']: date('Y-m-d');
?>
<button id="btnRequestVacation" type="button" class="btn-success solicitarVacaciones"
    data-searchDate='<?php echo $date; ?>'>Request
    Vacations</button>

<script>
    $('#btnRequestVacation').on('click', function () {
        modalHide('infoModal');
        modalShow('spinner');
        $('#infoModalTitle').html('Vacation Request');
        $('#infoModalTitle').parent().removeClass().addClass('bg-blue-500 modalTitle');
        $('#infoModalText').load('../components/calendar/solicitarVacaciones.php', {
            fecha: '<?= $date ?>',
        });
        $modalButtons = '<div class="flex flex-row gap-1"><div id="cancelButton"></div><div id="solicitarVacaciones"></div></div>';
        $('#infoModalButtons').html($modalButtons);
        $('#cancelButton').load('../components/buttons/cancelButton.php');
        $('#solicitarVacaciones').load('../components/buttons/saveButton.php');
        modalShow('infoModal');
        modalHide('spinner');
    });
</script>