<?php

include_once '../models/Quote.php';

$quote = new Quote();
$quotes = $quote->getAll($_SESSION['user']['id']);

?>
<h4>Saved Quotes</h4>
<table class="table table-striped" id="tableQuoted">
    <thead>
        <tr>
            <th>Date</th>
            <th>DOT</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($quotes as $q) { ?>
            <tr data-id= <?= $q['id'] ?>>
                <td><?= $q['date'] ?></td>
                <td><?= $q['dot'] ?></td>
                <td></td>
            </tr>
        <?php } ?>
    </tbody>