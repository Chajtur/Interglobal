<?php

include_once '../models/Quote.php';

$quote = new Quote();
$quotes = $quote->getAll($_SESSION['user']['id']);

?>
<div class="w-full lg:w-3/4">
    <h4>Saved Quotes</h4>
    <table class="table w-full" id="tableQuoted">
</div>
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
        <tr class="border-b" data-id=<?= $q['id'] ?>>
            <td class="p-2"><?= $q['date'] ?></td>
            <td class='text-center'><?= $q['dot'] ?></td>
            <td></td>
        </tr>
    <?php } ?>
</tbody>