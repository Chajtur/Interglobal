<script src="../js/rfp.js"></script>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<script>
    $.get('../Controllers/Login.php', {
        action: 'getEmployeeInfo'
    }).done(function (resp) {
        $user = JSON.parse(resp);
        loadRFPs($user.id);
    });
</script>

<div class="row mt-5">
    <div class="col-lg-4">
        <h4>RFP Completas</h4>
        <table class="table table-striped">
            <thead>
                <th>Fecha Llenado</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Premium</th>
            </thead>
            <tbody id="tableQuotes">

            </tbody>
        </table>
    </div>
    <div class="col-lg-4 offset-1">
        <h4>Detalle del RFP</h4>
        <table id="tableDetail" class="table table-striped">

        </table>
    </div>
</div>