<?php
if (!isset($_SESSION))
{
    session_start();
}
?>
<div class="flex flex-row w-full">
    <div class="flex flex-col w-full md:w-3/4 border-2 border-sky-950 p-2 rounded">
        <div class="w-full flex justify-between">
            <div class="w-3/5">
                <div id="businessDetails">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/business/businessDetails.php'; ?>
                </div>
                <hr class="border-2 mt-3">
                <div>
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/business/documentUpload.php'; ?>
                </div>
                <div class="flex flex-row mt-2">
                    <div class="clearfix w-full">
                        <button type="button" class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
            </div>
            <div id="documentViewer" class="w-2/5">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/business/documentViewer.php'; ?>
            </div>
        </div>
    </div>
    <div class="w-full md:w-1/4 px-2">
        <div class="border-t-2 border-b-2 border-sky-950 p-2 h-full" id="businessList">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/components/business/list.php'; ?>
        </div>
    </div>
</div>
<script src="https://unpkg.com/pdfobject"></script>
<script>
    $(document).ready(function () {
        $('#tankerEndorsementToggle').click(function () {
            var currentStatus = $('#tankerEndorsement').prop('checked');
            $('#tankerEndorsement').prop('checked', !currentStatus);
        });
        $('#hazmatToggle').click(function () {
            var currentStatus = $('#hazmat').prop('checked');
            $('#hazmat').prop('checked', !currentStatus);
        });
        $('#twicToggle').click(function () {
            var currentStatus = $('#twic').prop('checked');
            $('#twic').prop('checked', !currentStatus);
        });
    });
</script>