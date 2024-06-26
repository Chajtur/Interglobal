<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/Quote.php';

$quote = new Quote();
$quotes = $quote->getAll($_SESSION['user']['id']);

?>
<div class="w-full lg:w-3/4">
    <h4>Saved Quotes</h4>
    <table class="table w-full" id="tableQuoted">
        <thead>
            <tr class="bg-sky-950 text-white font-bold">
                <th class="p-2 rounded-s text-start">Date</th>
                <th>DOT</th>
                <th class="rounded-e p-2">Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($quotes as $q) { ?>
                <tr class="border-b cursor-pointer" data-id=<?= $q['id'] ?>>
                    <td class="p-2"><?= $q['date'] ?></td>
                    <td class='text-center'><?= $q['dot'] ?></td>
                    <td class='text-center'><?= $q['name'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $("#tableQuoted tbody tr").click(function() {
        modalShow('spinner');
        $(this).addClass('bg-blue-800 text-white').siblings().removeClass('bg-blue-800 text-white');
        let id = $(this).attr('data-id');
        if (id) {
            $("#infoModalTitle").text('Quote Details');
            $("#infoModalTitle").parent().removeClass().addClass('bg-blue-800 modalTitle ');
            $("#infoModalText").load('../components/quotes/previewQuote.php', {
                id: id
            });
            $("#infoModalButtons").html('<div class="flex flex-row gap-1"><div id="cancelButtonDiv"></div><div id="saveButtonDiv"></div></div>');
            $("#cancelButtonDiv").load('../components/buttons/cancelButton.php');
            $("#saveButtonDiv").load('../components/buttons/saveButton.php', function() {
                $('#saveButton').text('Edit');
            });
            modalShow('infoModal');
        }
    });
</script>